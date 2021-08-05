<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function findUserIdByBlogId(int $blogId): int
{
    $pdo = pdoInit();

    $sqlUserId = "SELECT user_id FROM blogs WHERE id = $blogId";
    $statement = $pdo->prepare($sqlUserId);
    $statement->execute();
    $userId = $statement->fetch(PDO::FETCH_COLUMN);

    return $userId;
}
