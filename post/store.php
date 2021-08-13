<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/Session.php');
require_once(__DIR__ . '/../dao/BlogDao.php');

$session = Session::getInstance();

$userId = $_SESSION["formInputs"]['userId'];
$blogTitle = filter_input(INPUT_POST, 'blog_title', FILTER_SANITIZE_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

try {
  $blogDao = new BlogDao();
  $blogDao->storeBlog($userId, $blogTitle, $content);
  redirect('../user/mypage.php');
} catch (PDOException $e) {
  appendError('ブログ記事の登録に失敗しました。');
  redirect('./create.php');
}
