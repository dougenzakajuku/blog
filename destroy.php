<?php
session_start();
require_once('./pdo.php');

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
