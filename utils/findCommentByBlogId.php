<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function findCommentByBlogId(int $blogId): ?array
{
	$pdo = pdoInit();

	$sqlComments = "SELECT * FROM blog.comments WHERE blog_id = :id ORDER BY created_at DESC";
	$statementComments = $pdo->prepare($sqlComments);
	$statementComments->bindValue(':id', $blogId, PDO::PARAM_INT);
	$statementComments->execute();
	$commentsInfoList = $statementComments->fetchAll(PDO::FETCH_ASSOC);

	return ($commentsInfoList) ? $commentsInfoList : null;
}
