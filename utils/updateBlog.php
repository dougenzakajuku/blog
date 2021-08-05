<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function updateBlog(int $userId, string $blogTitle, string $content): void
{
	$pdo = pdoInit();

	$sql = "UPDATE blogs SET title = :blogTitle, content = :content WHERE id = :userId";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':blogTitle', $blogTitle, PDO::PARAM_STR);
	$statement->bindValue(':content', $content, PDO::PARAM_STR);
	$statement->bindValue(':userId', $userId, PDO::PARAM_INT);
	$statement->execute();
}
