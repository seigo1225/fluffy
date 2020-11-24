<?php
session_start();

require_once("config/config.php");
require_once("model/User.php");
require_once("upfiles.php");

// アップロードファイル設定
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
define('THUMBNAIL_WIDTH', 400);
define('IMAGES_DIR', __DIR__ . '/img');
define('THUMBNAIL_DIR', __DIR__ . '/thumb');
//プラグインチェック
if(!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}
// //エスケープ関数
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTH-8');
}
//　ログアウト処理
if(isset($_GET['logout'])){
  // セッション破棄
  $_SESSION = array();
}
// ログインフォームを経由しているか確認
if(!isset($_SESSION['User'])){
  header('location: /jisaku/loginForm.php');
  exit;
}
try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();
  //編集処理
  if(isset($_POST['editBtn'])) {
    if(isset($_POST)) {
      $user->edit($_POST);
      if(isset($_FILES)) {
        $user->upload();
      }
    }
  }
  $resultUser['User'] = $user->findById($_GET['user']);
  $userPost['Post'] = $user->findByPost($_GET['user']);

} catch (PDOException $e) {
  echo "エラー: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>fluffy</title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" href="css/modaal.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/modaal.min.js" type="text/javascript"></script>
<script src="ajax/post.js"></script>
<script src="ajax/modal.js"></script>
</head>
<body>
  <header class="page-header wrapper">
    <h1><a href="index.php"><img class="logo" src="img/ウサギのシルエット.png" alt="fluffy"></a></h1>
    <h2>fluffy</h2>
    <nav>
      <ul class="main-nav">
        <li class="logout"><a href="?logout=1"><img src="img/logout.png"></a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="inner">
      <div class="postWrap">
        <div class="postBlock sideArea">
          <div class="userBox">
            <?php foreach($resultUser as $row): ?>
            <div class="userIcon">
              <img class="avatar sq200px" src="<?=$row['icon']?>" alt="アバター画像">
            </div>
            <div class="userName"><?=$row['user_name']?></div>
            <div class="userId"><?=$row['user_id']?></div>
            <div class="userBio"><?=$row['biography']?></div>
            <?php endforeach; ?>
            <?php require_once("include/modal.php"); ?>
          </div>
        </div>
        <div class="postBlock mainArea">
          <h2 class="postAll"><?php echo $resultUser['User']['user_name']; ?>の投稿</h2>
          <div class="result"></div>
          <div id="posts">
            <?php foreach($userPost['Post'] as $row): ?>
            <div id="postList_<?=$row['id'];?>" data-id="<?=$row['id'];?>">
              <div class="postBox">
                <div class="iconWrap">
                  <!-- <a href="">
                    <img class="sq50px" src="" alt="">
                  </a> -->
                </div>
                <div class="postContent">
                  <div class="postBody">
                    <div class="postText"><?=$row['massage']?></div>
                    <?php if(!empty($row['image'])): ?>
                    <div class="postImg"><img src="<?=$row['image']?>" alt=""></div>
                  <?php endif; ?>
                  </div>
                  <div class="postFooter">
                    <div class="postMeta">
                      <a class="name"><?=$row['user_name']?></a>
                      <span class="time"><?=$row['post_time']?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <!-- <p id="load" style="display:none;">もっと読む</p>
          <input type="button" id="more" value="もっと読む"> -->
          <!-- <script>
          $(function() {
            $('#more').click(function() {
              $('#load').show();

            });

          });
          </script> -->
        </div>
      </div>
    </div>
  </main>
</body>
</html>
