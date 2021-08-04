<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/function.php');

session_start();

$userId = $_SESSION['id'];
$blogTitle = filter_input(INPUT_POST, 'blog_title', FILTER_SANITIZE_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

try {
  storeBlog($userId, $blogTitle, $content);
  redirect('../user/mypage.php');
} catch (PDOException $e) {
  $_SESSION['errors'][] = 'ブログ記事の登録に失敗しました。';
  redirect('./create.php');
}
