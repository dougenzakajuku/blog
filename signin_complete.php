<?php

session_start();

$_SESSION['loginStatus'] = false;

$mail = filter_input(INPUT_POST, 'mail');
$_SESSION['mail'] = $mail;
$password = filter_input(INPUT_POST, 'password');

if (empty($password)) {
    $_SESSION['errors'] = "パスワードを入力してください";
    header("Location: ./signin.php");
    exit;
}

require_once('./pdo.php');

$sql = "select * from users where mail = :mail";
$statement = $pdo->prepare($sql);
$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
$statement->execute();
$member = $statement->fetch(PDO::FETCH_ASSOC);
$shouldPasswordCheck = (!$member) ? false : true;

if (password_verify($password, $member["password"])) {
    $_SESSION['loginStatus'] = true;
    $_SESSION['id'] = $member['id'];
    $_SESSION['user_name'] = $member['user_name'];
    header("Location: ./index.php");
    exit;
}

$_SESSION['errors'] = "メールアドレスまたは<br />パスワードが違います";

header("Location: ./signin.php");
exit;
