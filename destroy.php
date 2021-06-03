<?php
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
$sql = "
    DELETE FROM
      blogs
    WHERE
      id = ?
  ";
$params = array($blog_id);
try {
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    $judgment = true;
} catch (PDOException $e) {
    exit('接続できませんでした。理由：' . $e->getMessage());
}

if ($judgment) {
    $msg = 'ブログ記事を削除しました。';
    $link = '<a href="index.php">戻る</a>';
} else {
    $msg = 'ブログ記事の削除に失敗しました。';
    $link = '<a href="/detail.php?a=<?= $_GET["a"]">戻る</a>';
}
?>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>