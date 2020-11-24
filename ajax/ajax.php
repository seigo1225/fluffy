<?php
session_start();
require_once("../config/config.php");
require_once("../model/User.php");

// アップロードファイル設定
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
define('THUMBNAIL_WIDTH', 400);
define('IMAGES_DIR', '/Applications/MAMP/htdocs/fluffy/img');
define('THUMBNAIL_DIR', '/Applications/MAMP/htdocs/fluffy/thumb');
//プラグインチェック
if(!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}
// //エスケープ関数
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTH-8');
}

try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  //POSTされた時の処理
  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
      if(!empty($_FILES['image']['tmp_name'])) {
        $result = $user->upload();
      } else {
        $res = $user->post();
        header('content-Type: application/json');
        echo json_encode($res);
        exit;
      }
    } catch (Exception $e) {
      header($_SERVER['SERVER_PROTOCOL'] . '500 Internal Server Error', true, 500);
      echo $e->getMessage();
      exit;
    }
  }
} catch (PDOException $e) {
  echo "エラー: " . $e->getMessage();
}
?>
