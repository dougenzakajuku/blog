<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/deleteBlog.php');

session_start();

if (empty($_SESSION['id'])) {
  appendError("ログインしてください");
  redirect('../user/signin.php');
}

$blogId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

try {
  deleteBlog($blogId);
  redirect('../user/mypage.php');
} catch (PDOException $e) {
  appendError("ブログ記事の削除に失敗しました。");
  redirect('./myarticledetail.php?id=' . $blogId);
}
