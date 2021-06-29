<?php
session_start();

$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO($dsn, $dbUserName, $dbPassword);

$user_id = $_SESSION['id'];
$blog_title = $_POST['blog_title'];
$content = $_POST['content'];

$sql = "INSERT INTO blogs(user_id, title, content) VALUES(?,?,?)";
try {
  $statement = $pdo->prepare($sql);
  $statement->bindValue(1, $user_id, PDO::PARAM_INT);
  $statement->bindValue(2, $blog_title, PDO::PARAM_STR);
  $statement->bindValue(3, $content, PDO::PARAM_STR);
  $statement->execute();
  header("Location: ./mypage.php");
  exit;
} catch (PDOException $e) {
  $_SESSION['errors'][] = 'ブログ記事の登録に失敗しました。';
  header("Location: ./create.php");
  exit;
}
