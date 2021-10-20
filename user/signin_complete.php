<?php
require_once(__DIR__ . '/../dao/UserDao.php');
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/Session.php');
require_once(__DIR__ . '/../utils/SessionKey.php');
require('../vendor/autoload.php');

use Repository\UserRepository;
use Domain\ValueObject\Email;

$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
if (empty($mail) || empty($password)) {
    $session->appendError("パスワードとメールアドレスを入力してください");
    redirect("./user/signin.php");
}

$userRepository = new UserRepository();
$user = $userRepository->findByEmail(new Email($email));

if (is_null($user)) {
    $session = Session::getInstance();
    $session->appendError('メールアドレスまたはパスワードが間違っています');
    Redirect::handler('../view/signin.php');
}

if (!password_verify($password, $user->password())) {
    $session = Session::getInstance();
    $session->appendError("メールアドレスまたはパスワードが違います");
    redirect("./signin.php");
}

$formInputs = [
    'userId' => $member['id'],
    'userName' => $member['user_name']
];
$formInputsKey = new SessionKey(SessionKey::FORM_INPUTS_KEY);
$session->set($formInputsKey, $formInputs);
redirect("../index.php");
