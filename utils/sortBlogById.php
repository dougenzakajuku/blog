<?php
require_once(__DIR__ . '/pdoInit.php');

function sortBlogById(string $direction, string $title, string $content): array
{
	$pdo = pdoinit();
	$sql = "select * from blogs where title like :title or content like :content order by id $direction";
	$statement = $pdo->prepare($sql);
	$statement->bindvalue(':title', $title, PDO::PARAM_STR);
	$statement->bindValue(':content', $content, PDO::PARAM_STR);
	$statement->execute();
	$posts = $statement->fetchAll();
	return $posts;
}
