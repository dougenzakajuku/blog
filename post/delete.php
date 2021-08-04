<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/function.php');

session_start();

if (empty($_SESSION['user_id'])) {
  $_SESSION['errors'][] = "ログインしてください";
  redirect('./user/signin.php');
}

$blogId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

try {
  deleteBlog($blogId);
  redirect('../user/mypage.php');
} catch (PDOException $e) {
  $_SESSION['errors'][] = 'ブログ記事の削除に失敗しました。';
  redirect('./myarticledetail.php?id=' . $blogId);
}
