<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function findBlogByCreatedAt(): array
{
	$pdo = pdoInit();

	$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
	$statement = $pdo->prepare($sql);
	$statement->execute();
	$blogsInfoList = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $blogsInfoList;
}
