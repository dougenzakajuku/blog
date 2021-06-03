<?php
session_start();
$user_name = $_SESSION['user_name'];

// データベース接続
$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$db_account_name = "blog";
$db_account_password = "blog";
try {
  $pdo = new PDO($dsn, $db_account_name, $db_account_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  exit('接続できませんでした。理由：' . $e->getMessage());
}

$blog_id = @$_GET["a"];
$sql = "SELECT * FROM blogs WHERE id = $blog_id";
$res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
?>

<!-- 編集フォーム -->
<form method="post" action="/update.php">
  <div>
    <label>blog title</label>
    <input type="text" name="blog_title" value="<?php print($res['title']); ?>">
  </div>
  <div>
    <label>content</label>
    <input type="text" name="content" value="<?php print($res['content']); ?>">
  </div>
  <input type="submit" value="変更">
  <input type="hidden" name="blog_id" value="<?php print($res['id']); ?>">
</form>