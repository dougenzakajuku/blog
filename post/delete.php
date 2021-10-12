<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/Session.php');
require_once(__DIR__ . '/../dao/BlogDao.php');

$session = Session::getInstance();

if (empty($_SESSION["formInputs"]['userId'])) {
  $session->appendError("ログインしてください");
  redirect('../user/signin.php');
}

$blogId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

try {
  $blogDao = new BlogDao();
  $blogDao->deleteBlog($blogId);
  redirect('../user/mypage.php');
} catch (PDOException $e) {
  $session->appendError("ブログ記事の削除に失敗しました。");
  redirect('./myarticledetail.php?id=' . $blogId);
}
