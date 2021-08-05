<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/storeComment.php');

session_start();

$userId = $_SESSION['id'];
$blogId = filter_input(INPUT_POST, 'blog_id', FILTER_VALIDATE_INT);
$commenterName = filter_input(INPUT_POST, 'commenter_name', FILTER_SANITIZE_SPECIAL_CHARS);
$commentContent = filter_input(INPUT_POST, 'comment_content', FILTER_SANITIZE_SPECIAL_CHARS);

try {
    storeComment($userId, $blogId, $commenterName, $commentContent);
    redirect('../post/detail.php?id=' . $blogId);
} catch (PDOException $e) {
    appendError('コメントの投稿に失敗しました。');
    redirect('../post/detail.php?id=' . $blogId);
}
