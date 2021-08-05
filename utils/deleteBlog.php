<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function deleteBlog(int $blogId): void
{
	$pdo = pdoInit();

	$sql = "DELETE FROM blogs WHERE id = :id";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $blogId, PDO::PARAM_INT);
	$statement->execute();
}
