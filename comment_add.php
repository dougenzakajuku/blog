<?php
session_start();

$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO($dsn, $dbUserName, $dbPassword);

$user_id = $_SESSION['id'];
$blog_id = $_POST['blog_id'];
$commenter_name = $_POST['commenter_name'];
$comment_content = $_POST['comment_content'];

$sql = "INSERT INTO comments(user_id, blog_id, commenter_name, comments)VALUES(?,?,?,?)";
try {
    $statement = $pdo->prepare($sql);
    $statement->bindValue(1, $user_id, PDO::PARAM_INT);
    $statement->bindValue(2, $blog_id, PDO::PARAM_INT);
    $statement->bindValue(3, $commenter_name, PDO::PARAM_STR);
    $statement->bindValue(4, $comment_content, PDO::PARAM_STR);
    $statement->execute();
    header("Location: ./detail.php?id=" . $blog_id);
    exit;
} catch (PDOException $e) {
    $_SESSION['errors'][] = 'コメントの投稿に失敗しました。';
    header("Location: ./detail.php?id=" . $blog_id);
    exit;
}
