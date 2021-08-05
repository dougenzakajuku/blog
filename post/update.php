<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/function.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/updateBlog.php');

session_start();

$userId = filter_input(INPUT_POST, 'blog_id', FILTER_VALIDATE_INT);
$blogTitle = filter_input(INPUT_POST, 'blog_title', FILTER_SANITIZE_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

try {
  updateBlog($userId, $blogTitle, $content);
  redirect('../user/mypage.php?id=' . $userId);
} catch (PDOException $e) {
  appendError('ブログ記事の編集に失敗しました。');
  redirect('./edit.php');
}
