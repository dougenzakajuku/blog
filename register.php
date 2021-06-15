<?php
session_start();
$user_name = $_POST['user_name'];
$mail = $_POST['mail'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

//データベース接続
$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$db_account_name = "blog";
$db_account_password = "blog";
try {
    $pdo = new PDO($dsn, $db_account_name, $db_account_password);
} catch (PDOException $e) {
    echo "DB接続エラー";
    die;
}
//フォームに入力されたmailがすでに登録されていないかチェック
$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch();
if ($member['mail'] === $mail) {
    $_SESSION['error'] = '同じメールアドレスが存在します。';
    header("Location: ./signup.php");
} else {
    //登録されていなければinsert 
    $sql = "INSERT INTO users(user_name, mail, password) VALUES (:user_name, :mail, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_name', $user_name);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $_SESSION['register'] = '会員登録が完了しました';
    header("Location: ./login_form.php");
}
