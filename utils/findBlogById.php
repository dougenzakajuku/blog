<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function findBlogById(int $blogId): ?array
{
	$pdo = pdoInit();

	$sql = "SELECT * FROM blogs WHERE id = :id";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $blogId, PDO::PARAM_INT);
	$statement->execute();
	$blogInfo = $statement->fetch(PDO::FETCH_ASSOC);

	return ($blogInfo) ? $blogInfo : null;
}
