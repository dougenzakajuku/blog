<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function storeBlog(int $userId, string $blogTitle, string $content): void
{
	$pdo = pdoInit();

	$sql = "INSERT INTO blogs(user_id, title, content) VALUES(:userId, :blogTitle, :content)";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':userId', $userId, PDO::PARAM_INT);
	$statement->bindValue(':blogTitle', $blogTitle, PDO::PARAM_STR);
	$statement->bindValue(':content', $content, PDO::PARAM_STR);
	$statement->execute();
}
