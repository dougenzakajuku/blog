<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function findUserByMail(string $mail): ?array
{
	$pdo = pdoInit();

	$sql = "SELECT * FROM users WHERE mail = :mail";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
	$statement->execute();
	$user = $statement->fetch(PDO::FETCH_ASSOC);

	return ($user) ? $user : null;
}
