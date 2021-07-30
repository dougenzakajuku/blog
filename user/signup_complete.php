<?php
session_start();

$_SESSION['mail'] = $_POST['mail'];
$_SESSION['userName'] = $_POST['userName'];
if (empty($_POST['password']) || empty($_POST['confirmPassword'])) $_SESSION['errors'][] = "パスワードを入力してください";
if ($_POST['password'] !== $_POST['confirmPassword']) $_SESSION['errors'][] = "パスワードが一致しません";

if (!empty($_SESSION['errors'])) {
  header("Location: ./signup.php");
  exit;
}

require_once('../utils/pdo.php');

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

$_SESSION['registed'] = "登録できました。";
header("Location: ./signin.php");
exit;
