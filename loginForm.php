<?php
session_start();
require_once("config/config.php");
require_once("model/User.php");
try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  if($_POST){
    $result = $user->login($_POST);
    if(!empty($result)){
      $_SESSION['User'] = $result;
      header('location: /fluffy/index.php');
      exit;
    } else {
      $message = "ログインできませんでした";
    }
  }
} catch (PDOException $e) {
  echo "エラー: " . $e->getMessage();
}
?>
﻿<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>fluffy</title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/register.css">
<script></script>
</head>
<body>
  <?php require_once( "include/header.php" ); ?>
  <section>
    <h3>ログイン</h3>
    <?php if(isset($message)) echo "<p class='error'>".$message."</p>" ?>
    <form action="" method="post">
      <table>
        <tr>
          <th>ユーザID</th>
          <td><input type="text" class="textlines" name="user_id" size="20"></td>
        </tr>
        <tr>
          <th>パスワード</th>
          <td><input type="password" class="textlines" name="password" size="20"></td>
        </tr>
      </table>
      <p><input type="submit" value="ログイン"></p>
    </form>
  </section>
  <?php require_once( "include/footer.php" ); ?>
</body>
</html>
