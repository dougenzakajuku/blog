<?php
session_start();

$user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_SPECIAL_CHARS);
$mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
$password = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_DEFAULT);

$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO($dsn, $dbUserName, $dbPassword);

$sql = "SELECT * FROM users WHERE mail = :mail";
$statement = $pdo->prepare($sql);
$statement->bindValue(':mail', $mail);
$statement->execute();
$member = $statement->fetch();
if ($member['mail'] === $mail) {
    $_SESSION['errors'][] = '同じメールアドレスが存在します。';
    header("Location: ./signup.php");
    exit;
} else {
    $sql = "INSERT INTO users(user_name, mail, password) VALUES (:user_name, :mail, :password)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user_name', $user_name);
    $statement->bindValue(':mail', $mail);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $_SESSION['messeages'][] = '新規登録が完了しました';
    header("Location: ./login_form.php");
    exit;
}
