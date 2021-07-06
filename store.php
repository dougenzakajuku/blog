<?php
session_start();

$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO("mysql:host=localhost; dbname=blog; charset=utf8mb4", $dbUserName, $dbPassword);

$userId = $_SESSION['id'];
$blogTitle = filter_input(INPUT_POST, 'blog_title', FILTER_SANITIZE_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

$sql = "INSERT INTO blogs(user_id, title, content) VALUES(:userId, :blogTitle, :content)";
try {
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
  $statement->bindValue(':blogTitle', $blogTitle, PDO::PARAM_STR);
  $statement->bindValue(':content', $content, PDO::PARAM_STR);
  $statement->execute();
  header("Location: ./mypage.php");
  exit;
} catch (PDOException $e) {
  $_SESSION['errors'][] = 'ブログ記事の登録に失敗しました。';
  header("Location: ./create.php");
  exit;
}
