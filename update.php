<?php
session_start();

$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO($dsn, $dbUserName, $dbPassword);

$user_id = filter_input(INPUT_POST, 'blog_id', FILTER_VALIDATE_INT);
$blog_title = filter_input(INPUT_POST, 'blog_title', FILTER_SANITIZE_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

$sql = "UPDATE blogs SET title = ?, content = ? WHERE id = ?";
try {
  $statement = $pdo->prepare($sql);
  $statement->bindValue(1, $blog_title, PDO::PARAM_STR);
  $statement->bindValue(2, $content, PDO::PARAM_STR);
  $statement->bindValue(3, $user_id, PDO::PARAM_INT);
  $statement->execute();
  header("Location: ./myarticledetail.php?id=" . $user_id);
  exit;
} catch (PDOException $e) {
  $_SESSION['errors'][] = 'ブログ記事の編集に失敗しました。';
  header("Location: ./edit.php");
  exit;
}
