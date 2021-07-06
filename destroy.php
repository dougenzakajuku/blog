<?php
session_start();

$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO("mysql:host=localhost; dbname=blog; charset=utf8mb4", $dbUserName, $dbPassword);

$blogId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$sql = "DELETE FROM blogs WHERE id = :id";
try {
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $blogId, PDO::PARAM_INT);
  $statement->execute();
  header("Location: ./mypage.php");
  exit;
} catch (PDOException $e) {
  $_SESSION['errors'][] = 'ブログ記事の削除に失敗しました。';
  header("Location: ./myarticledetail.php?id=" . $blogId);
  exit;
}
