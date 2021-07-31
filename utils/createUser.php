<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function createUser(string $userName, string $mail, string $password): void
{
	$pdo = pdoInit();

	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	$sql = "INSERT INTO users(user_name, mail, password) VALUES (:userName, :mail, :password)";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':userName', $userName, PDO::PARAM_STR);
	$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
	$statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
	$statement->execute();
}
