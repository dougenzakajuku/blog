<?php
session_start();
$_SESSION['registed'] = "登録できました。";

header("Location: ./signin.php");
exit;
