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

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/detail.css">
</head>

<body>
    <h1>Blog Detail</h1>
    <div class="blogWrapper">
        <div class="post">
            <h2><?php print($res['title']); ?></h2>
            <p><?php print($res['content']); ?></p>
        </div>
        <div class="btnRight">
            <a href="/update_form.php?a=<?= htmlspecialchars($_GET["a"]) ?>"><button>編集</button></a>
            <a href="(URL)"><button>削除</button></a>
        </div>
    </div>
</body>
<input type="hidden" name="blog_id" value="<?php print($res['id']); ?>">

</html>