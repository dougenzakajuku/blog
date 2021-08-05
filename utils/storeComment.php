<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function storeComment(int $userId, int $blogId, string $commenterName, string $commentContent): void
{
	$pdo = pdoInit();

	$sql = "INSERT INTO comments(user_id, blog_id, commenter_name, comments)VALUES(:user_id, :blog_id, :commenter_name, :comments)";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
	$statement->bindValue(':blog_id', $blogId, PDO::PARAM_INT);
	$statement->bindValue(':commenter_name', $commenterName, PDO::PARAM_STR);
	$statement->bindValue(':comments', $commentContent, PDO::PARAM_STR);
	$statement->execute();
}
