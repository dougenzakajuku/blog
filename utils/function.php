<?php
require_once(__DIR__ . '/../utils/pdoInit.php');

function findBlogInfo(int $blogId): ?array
{
    $pdo = pdoInit();

    $sql = "SELECT * FROM blogs WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $blogId, PDO::PARAM_INT);
    $statement->execute();
    $blogInfo = $statement->fetch(PDO::FETCH_ASSOC);

    return ($blogInfo) ? $blogInfo : null;
}

function findCommentsInfoList(int $blogId): ?array
{
    $pdo = pdoInit();

    $sqlComments = "SELECT * FROM blog.comments WHERE blog_id = $blogId ORDER BY created_at DESC";
    $statementComments = $pdo->prepare($sqlComments);
    $statementComments->execute();
    $commentsInfoList = $statementComments->fetchAll(PDO::FETCH_ASSOC);

    return ($commentsInfoList) ? $commentsInfoList : null;
}

function findUserIdWhereBlogId(int $blogId): int
{
    $pdo = pdoInit();

    $sqlUserId = "SELECT user_id FROM blogs WHERE id = $blogId";
    $statement = $pdo->prepare($sqlUserId);
    $statement->execute();
    $userId = $statement->fetch(PDO::FETCH_COLUMN);

    return $userId;
}

function deleteBlog(int $blogId): void
{
    $pdo = pdoInit();

    $sql = "DELETE FROM blogs WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $blogId, PDO::PARAM_INT);
    $statement->execute();
}

function storeBlog(int $userId, string $blogTitle, string $content): void
{
    $pdo = pdoInit();

    $sql = "INSERT INTO blogs(user_id, title, content) VALUES(:userId, :blogTitle, :content)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statement->bindValue(':blogTitle', $blogTitle, PDO::PARAM_STR);
    $statement->bindValue(':content', $content, PDO::PARAM_STR);
    $statement->execute();
}

function updateBlog(int $userId, string $blogTitle, string $content): void
{
    $pdo = pdoInit();

    $sql = "UPDATE blogs SET title = :blogTitle, content = :content WHERE id = :userId";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':blogTitle', $blogTitle, PDO::PARAM_STR);
    $statement->bindValue(':content', $content, PDO::PARAM_STR);
    $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();
}

function storeComment(int $userId, int $blogId, string $commenterName, string $commentContent): void
{
    $pdo = pdoInit();

    $sql = "INSERT INTO comments(user_id, blog_id, commenter_name, comments)VALUES(:user_id, :blog_id, :commenter_name, :comments)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $statement->bindValue(':blog_id', $blogId, PDO::PARAM_INT);
    $statement->bindValue(':commenter_name', $commenterName, PDO::PARAM_STR);
    $statement->bindValue(':comments', $commentContent, PDO::PARAM_STR);
    $statement->execute();
}
