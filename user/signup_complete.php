<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/findUserByMail.php');
require_once(__DIR__ . '/../utils/createUser.php');
require_once(__DIR__ . '/../utils/session.php');

$session = Session::getInstance();

$mail = filter_input(INPUT_POST, 'mail');
$userName = filter_input(INPUT_POST, 'userName');
$password = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

if (empty($password) || empty($confirmPassword)) appendError("パスワードを入力してください");
if ($password !== $confirmPassword)  appendError("パスワードが一致しません");

if ($session->existsErrors()) {
  $formInputs = [
    'mail' => $mail,
    'userName' => $userName,
  ];
  $session->setFormInputs($formInputs);
  redirect('/blog/user/signin.php');
}

$userDao = new UserDao();
// メールアドレスに一致するユーザーの取得
$user = $userDao->findByMail($mail);

if (!is_null($user)) appendError("すでに登録済みのメールアドレスです");

if (!empty($_SESSION['errors'])) redirect('/blog/user/signup.php');

// ユーザーの保存
$userDao->create($userName, $mail, $password);

$_SESSION['registed'] = "登録できました。";

redirect('/blog/user/signin.php');
