<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/pdoInit.php');
require_once(__DIR__ . '/../utils/Session.php');

session_start();

$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
if (empty($mail) || empty($password)) {
    $session->appendError("パスワードとメールアドレスを入力してください");
    redirect("./user/signin.php");
}

$pdo = pdoInit();
$sql = "select * from users where mail = :mail";
$statement = $pdo->prepare($sql);
$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
$statement->execute();
$member = $statement->fetch(PDO::FETCH_ASSOC);
$shouldPasswordCheck = (!$member) ? false : true;

if (!password_verify($password, $member["password"])) {
    $session->appendError("メールアドレスまたは<br />パスワードが違います");
    redirect("./signin.php");
}

$_SESSION['id'] = $member['id'];
$_SESSION['user_name'] = $member['user_name'];
redirect("../index.php");
