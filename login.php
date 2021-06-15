<?php
session_start();
$mail = $_POST['mail'];
$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$db_account_name = "blog";
$db_account_password = "blog";
try {
    $pdo = new PDO($dsn, $db_account_name, $db_account_password);
} catch (PDOException $e) {
    $message = $e->getMessage();
}

$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$member) {
    $_SESSION['error'] = 'メールアドレスもしくはパスワードが間違っています。';
    header("Location: ./login_form.php");
} elseif (password_verify($_POST['password'], $member['password'])) {
    //DBのユーザー情報をセッションに保存
    $_SESSION['id'] = $member['id'];
    $_SESSION['user_name'] = $member['user_name'];
    header("Location: ./");
}
