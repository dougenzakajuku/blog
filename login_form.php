<?php
session_start();
if (isset($_SESSION['register'])) {
  echo $_SESSION['register'];
  $_SESSION['register'] = "";
}
?>

<h1>ログインページ</h1>
<form action="./login.php" method="post">
  <div>
    <label>メールアドレス：<label>
        <input type="text" name="mail" required>
  </div>
  <div>
    <label>パスワード：<label>
        <input type="password" name="password" required>
  </div>
  <input type="submit" value="ログイン">
</form>
<a href="./signup.php">サインアップ</a>