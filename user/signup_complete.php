<?php
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../dao/UserDao.php');
require_once(__DIR__ . '/../utils/Session.php');

$session = Session::getInstance();

$mail = filter_input(INPUT_POST, 'mail');
$userName = filter_input(INPUT_POST, 'userName');
$password = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

if (empty($password) || empty($confirmPassword)) {
  $session->appendError("パスワードを入力してください");
}
if ($password !== $confirmPassword) {
  $session->appendError("パスワードが一致しません");
}

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

if (!is_null($user)) {
  $session->appendError("すでに登録済みのメールアドレスです");
}

if ($session->existsErrors()) {
  $formInputs = [
    'mail' => $mail,
    'userName' => $userName,
  ];
  $session->setFormInputs($formInputs);
  redirect('/blog/user/signup.php');
}

// ユーザーの保存
$userDao->create($userName, $mail, $password);

$_SESSION['registed'] = "登録できました。";

redirect('/blog/user/signin.php');
