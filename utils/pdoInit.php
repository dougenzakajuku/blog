<?php

function pdoInit(): PDO
{
	$dbUserName = "root";
	$dbPassword = "root";
	$pdo = new PDO("mysql:host=localhost; dbname=blog; charset=utf8mb4", $dbUserName, $dbPassword);
	return $pdo;
}
