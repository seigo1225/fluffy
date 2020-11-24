<?php
require_once("config/config.php");
require_once("model/User.php");
try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  if($_POST) {
    $user->add($_POST);
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
    <h3>新規登録</h3>
    <form action="register.php" method="post">
      <table>
        <tr>
          <th>ユーザーID</th>
          <td><input type="text" class="textlines" name="user_id" size="20" placeholder="半角英数字またはアンダーバー"></td>
        </tr>
        <tr>
          <th>メールアドレス</th>
          <td><input type="text" class="textlines" name="email" size="20"></td>
        </tr>
        <tr>
          <th>パスワード</th>
          <td><input type="password" class="textlines" name="password" size="20"></td>
        </tr>
      </table>
      <p><input type="submit" value="登 録"></p>
    </form>
  </section>
  <?php require_once( "include/footer.php" ); ?>
</body>
</html>
