<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/Session.php');
require_once(__DIR__ . '/../dao/BlogDao.php');
require_once(__DIR__ . '/../dao/CommentDao.php');

$session = Session::getInstance();

$userId = $_SESSION["formInputs"]['userId'];
$blogId = filter_input(INPUT_POST, 'blog_id', FILTER_VALIDATE_INT);
$commenterName = filter_input(INPUT_POST, 'commenter_name', FILTER_SANITIZE_SPECIAL_CHARS);
$commentContent = filter_input(INPUT_POST, 'comment_content', FILTER_SANITIZE_SPECIAL_CHARS);

try {
    $commentDao = new CommentDao();
    $commentDao->storeComment($userId, $blogId, $commenterName, $commentContent);
    $successCommentMessage = "コメント投稿できました。";
    $message = new SessionKey(SessionKey::MESSAGE_KEY);
    $session->setMessage($message, $successCommentMessage);
    redirect('../post/detail.php?id=' . $blogId);
} catch (PDOException $e) {
    $session->appendError('コメントの投稿に失敗しました。');
    redirect('../post/detail.php?id=' . $blogId);
}
