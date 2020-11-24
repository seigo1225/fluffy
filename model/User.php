<?php
require_once("DB.php");

class User extends DB {
  private $_imageFileName;
  private $_imageType;

  // ログイン認証
  public function login($arr) {
    $sql = 'SELECT * FROM users WHERE user_id = :user_id AND password = :password';
    $stmt = $this->connect->prepare($sql);
    $params = array(':user_id'=>$arr['user_id'], ':password'=>$arr['password']);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }
  public function findAlluser(){
    $sql = 'SELECT * FROM post UNION SELECT * FROM users';
    $userRecord = $this->connect->query($sql);
    return $userRecord;
  }
  //参照post(SELECT)
  public function findAll(){
    $sql = 'SELECT * FROM post order by id desc';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $resultPost = $stmt->fetchAll();
    return $resultPost;
  }
  // 参照（条件付き)SELECT
  public function findById($id) {
    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $resultUser = $stmt->fetch();
    return $resultUser;
  }
  public function findByPost($id) {
    $sql = 'SELECT * FROM post WHERE user_id = :user_id order by id desc';
    $stmt = $this->connect->prepare($sql);
    $params = array(':user_id'=>$id);
    $stmt->execute($params);
    $userPost = $stmt->fetchAll();
    return $userPost;
  }
  public function findByIcon() {
    $sql = 'SELECT icon FROM user_post JOIN users ON users.id = user_post.user_id WHERE user_post.user_id = users.id order by icon desc limit 1';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $images = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  // 登録(INSERT)
  public function add($arr) {
    $sql = "INSERT INTO users(user_id, email, password, role, regist_time) VALUES(:user_id, :email, :password, :role, :regist_time)";
    $stmt = $this->connect->prepare($sql);
    date_default_timezone_set('Asia/Tokyo');
    $params = array(
      ':user_id'=>$arr['user_id'],
      ':email'=>$arr['email'],
      ':password'=>$arr['password'],
      ':role'=>1,
      ':regist_time'=>date('Y-m-d H:i:s')
    );
    $stmt->execute($params);
  }
  public function post() {
    if(!isset($_POST['mode'])) {
      throw new \Exeption('mode not set!');
    }
    switch ($_POST['mode']) {
      case 'update':
       return $this->update();
      case 'create':
       return $this->create();
      case 'delete':
       return $this->delete();
    }
  }
  public function update() {
    if(!isset($_POST['mode'])) {
      throw new \Exeption('[update]id not set!');
    }
    $sql = "UPDATE post SET massage = :massage, edit_time = :edit_time WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    date_default_timezone_set('Asia/Tokyo');
    $params = array(
      ':id'=>$_POST['id'],
      ':massage'=>$_POST['massage'],
      ':edit_time'=>date('Y-m-d H:i:s')
    );
    $stmt->execute($params);
  }
  public function delete() {
    if(!isset($_POST['mode'])) {
      throw new \Exeption('[delete]id not set!');
    }
    $sql = sprintf("DELETE post,user_post FROM post LEFT JOIN user_post ON post.id = user_post.post_id WHERE id = %d", $_POST['id']);
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();

    return [];
  }
  // 投稿の登録
  public function create() {
    if(!isset($_POST['massage']) || $_POST['massage'] === '') {
      throw new \Exeption('[create] post not set!');
    }
    // $this->connect->beginTransaction();

    $sql = "INSERT INTO post (user_id, user_name, massage, post_time) VALUES (:user_id, :user_name, :massage, :post_time)";
    $stmt = $this->connect->prepare($sql);
    date_default_timezone_set('Asia/Tokyo');
    $params = array(
      ':user_id' => $_POST['user_id'],
      ':user_name' => $_POST['user_name'],
      ':massage' => $_POST['massage'],
      ':post_time' => date('Y-m-d H:i:s')
    );
    $stmt->execute($params);

    $postId = $this->connect->lastInsertId();
    //中間テーブルにも登録
    $sql = "INSERT INTO user_post (user_id, post_id, created) VALUES (:user_id, :post_id, :created)";
    $stmt = $this->connect->prepare($sql);
    date_default_timezone_set('Asia/Tokyo');
    $params = array(
      ':user_id' => $_POST['user_id'],
      ':post_id' => $postId,
      ':created' => date('Y-m-d H:i:s'),
    );
    $stmt->execute($params);

    return [
      'id' => $postId,
      'user_name' => $_POST['user_name'],
      'massage' => $_POST['massage'],
      'post_time' => date('Y-m-d H:i:s'),
    ];
    //
    // $this->connect->commit();
  }
  // 編集(UPDATE)
  public function edit($arr) {
    try {
      if(is_uploaded_file($_FILES['image']['tmp_name'])) {
      //error check
      $this->_validateUpload();
      //type check
      $ext = $this->_validateImageType();
      //save
      $this->_userEditfile($ext);
    } else {
      $sql = "UPDATE users SET user_id = :user_id, user_name = :user_name, biography = :biography, edit_time = :edit_time WHERE id = :id";
      $stmt = $this->connect->prepare($sql);
      $params = array(
        ':id'=>$arr['id'],
        ':user_id'=>$arr['user_id'],
        ':user_name'=>$arr['user_name'],
        ':biography'=>$arr['biography'],
        ':edit_time'=>date('Y-m-d H:i:s')
      );
      $stmt->execute($params);
    }
  } catch (\Exeption $e) {
    echo $e->getMassage();
    exit;
  }
  header('location: /fluffy/index.php');
  exit;
  }
  // public function editIcon($arr) {
  //   $content = file_get_contents($_FILES['image']['tmp_name']);
  //   $sql = "UPDATE users SET icon = :icon WHERE id = :id";
  //   $stmt = $this->connect->prepare($sql);
  //   $params = array(
  //     ':icon'=>$content
  //   );
  //   $stmt->execute($params);
  // }

  public function upload() {
    try {
      //error check
      $this->_validateUpload();
      //type check
      $ext = $this->_validateImageType();
      //save
      $this->_save($ext);

    } catch (\Exeption $e) {
      echo $e->getMassage();
      exit;
    }
    //redirect
    header('location: /fluffy/index.php');
    exit;
  }
  private function _save($ext) {
    $this->_imageFileName = sprintf('%s_%s.%s',time(),sha1(uniqid(mt_rand(),true)),$ext);
    $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
    if($res === false) {
      throw new \Exeption('Could not upload!');
    }
    $saveDir = 'img/';
    $filePath = $saveDir . $this->_imageFileName;
    $sql = "INSERT INTO post (user_id, user_name, massage, image, post_time) VALUES (:user_id, :user_name, :massage, :image, :post_time)";
    $stmt = $this->connect->prepare($sql);
    date_default_timezone_set('Asia/Tokyo');
    $params = array(
      ':user_id' => $_POST['user_id'],
      ':user_name' => $_POST['user_name'],
      ':massage' => $_POST['massage'],
      ':image' => $filePath,
      ':post_time' => date('Y-m-d H:i:s')
    );
    $stmt->execute($params);

    $postId = $this->connect->lastInsertId();
    //中間テーブルにも登録
    $sql = "INSERT INTO user_post (user_id, post_id, created) VALUES (:user_id, :post_id, :created)";
    $stmt = $this->connect->prepare($sql);
    date_default_timezone_set('Asia/Tokyo');
    $params = array(
      ':user_id' => $_POST['user_id'],
      ':post_id' => $postId,
      ':created' => date('Y-m-d H:i:s'),
    );
    $stmt->execute($params);

    return [
      'id' => $postId,
      'user_name' => $_POST['user_name'],
      'massage' => $_POST['massage'],
      'image' => $filePath,
      'post_time' => date('Y-m-d H:i:s'),
    ];
  }
  private function _userEditfile($ext){
    $this->_imageFileName = sprintf('%s_%s.%s',time(),sha1(uniqid(mt_rand(),true)),$ext);
    $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
    if($res === false) {
      throw new \Exeption('Could not upload!');
    }
    $saveDir = 'img/';
    $filePath = $saveDir . $this->_imageFileName;
    $sql = "UPDATE users SET user_id = :user_id, user_name = :user_name, icon = :icon, biography = :biography, edit_time = :edit_time WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    date_default_timezone_set('Asia/Tokyo');
    $params = array(
      ':id'=>$_POST['id'],
      ':user_id'=>$_POST['user_id'],
      ':user_name'=>$_POST['user_name'],
      ':icon' => $filePath,
      ':biography'=>$_POST['biography'],
      ':edit_time'=>date('Y-m-d H:i:s')
    );
    $stmt->execute($params);

  }
  private function _validateImageType() {
    $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
       return 'gif';
      case IMAGETYPE_JPEG:
       return 'jpg';
      case IMAGETYPE_PNG:
       return 'png';
      default:
       throw new \Exeption('Could not upload!');
    }
  }

  private function _fileSave($savePath) {

    $sql = "INSERT INTO post (user_id, user_name, massage, image, post_time) VALUES (:user_id, :user_name, :massage, :image, :post_time)";
    $stmt = $this->connect->prepare($sql);
    date_default_timezone_set('Asia/Tokyo');
    $params = array(
      ':user_id' => $_POST['user_id'],
      ':user_name' => $_POST['user_name'],
      ':massage' => $_POST['massage'],
      ':image' => $savePath,
      ':post_time' => date('Y-m-d H:i:s')
    );
    $stmt->execute($params);

    $postId = $this->connect->lastInsertId();
    //中間テーブルにも登録
    $sql = "INSERT INTO user_post (user_id, post_id, created) VALUES (:user_id, :post_id, :created)";
    $stmt = $this->connect->prepare($sql);
    date_default_timezone_set('Asia/Tokyo');
    $params = array(
      ':user_id' => $_POST['user_id'],
      ':post_id' => $postId,
      ':created' => date('Y-m-d H:i:s'),
    );
    $stmt->execute($params);

    return [
      'id' => $postId,
      'user_name' => $_POST['user_name'],
      'massage' => $_POST['massage'],
      'image' => $savePath,
      'post_time' => date('Y-m-d H:i:s'),
    ];
  }

  private function _validateUpload() {
    if(!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
      throw new \Exeption('Upload Error!');
    }
    switch ($_FILES['image']['error']) {
      case UPLOAD_ERR_OK:
       return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
       throw new \Exeption('File too large!');
      default:
       throw new \Exeption('Err: ' . $_FILES['image']['error']);
    }
  }

}

?>
