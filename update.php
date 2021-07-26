<?php
session_start();

require_once('./pdo.php');

$userId = filter_input(INPUT_POST, 'blog_id', FILTER_VALIDATE_INT);
$blogTitle = filter_input(INPUT_POST, 'blog_title', FILTER_SANITIZE_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

$sql = "UPDATE blogs SET title = :blogTitle, content = :content WHERE id = :userId";
try {
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':blogTitle', $blogTitle, PDO::PARAM_STR);
  $statement->bindValue(':content', $content, PDO::PARAM_STR);
  $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
  $statement->execute();
  header("Location: ./myarticledetail.php?id=" . $userId);
  exit;
} catch (PDOException $e) {
  $_SESSION['errors'][] = 'ブログ記事の編集に失敗しました。';
  header("Location: ./edit.php");
  exit;
}
