<?php
session_start();

$_SESSION['mail'] = $_POST['mail'];
$_SESSION['userName'] = $_POST['userName'];
if (empty($_POST['password']) || empty($_POST['confirmPassword'])) $_SESSION['errors'][] = "パスワードを入力してください";
elseif ($_POST['password'] !== $_POST['confirmPassword']) $_SESSION['errors'][] = "パスワードが一致しません";

if (!empty($_SESSION['errors'])) {
  header("Location: ./signup.php");
  exit;
}

$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO("mysql:host=localhost; dbname=blog; charset=utf8mb4", $dbUserName, $dbPassword);

$sql = "select * from users where mail=:mail";
$statement = $pdo->prepare($sql);
$statement->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR);
$statement->execute();
$result = $statement->fetch();

$available = (!$result) ? true : false;

if (!$available) $_SESSION['errors'][] = "すでに登録済みのメールアドレスです";

if (!empty($_SESSION['errors'])) {
  header("Location: ./signup.php");
  exit;
}

$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users(id, user_name, mail, password) VALUES (0, :userName, :mail, :password)";
$statement = $pdo->prepare($sql);
$statement->bindValue(':userName', $_POST['userName'], PDO::PARAM_STR);
$statement->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR);
$statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
$statement->execute();

header("Location: ./regist.php");
exit;
