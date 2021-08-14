<?php
require_once(__DIR__ . '/../dao/Dao.php');


final class BlogDao extends Dao
{
	const TABLE_NAME = 'blogs';

	public function __construct()
	{
		parent::__construct();
	}

	public function sortBlogById(string $direction, string $title, string $content): array
	{
		$sql = sprintf(
			"select * from %s where title like :title or content like :content order by id $direction",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindvalue(':title', $title, PDO::PARAM_STR);
		$statement->bindValue(':content', $content, PDO::PARAM_STR);
		$statement->execute();
		$posts = $statement->fetchAll();
		return $posts;
	}

	public function findBlogById(int $blogId): array
	{
		$sql = sprintf(
			"SELECT * FROM %s WHERE id = :id",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':id', $blogId, PDO::PARAM_INT);
		$statement->execute();
		$blogInfo = $statement->fetch(PDO::FETCH_ASSOC);

		return ($blogInfo) ? $blogInfo : null;
	}

	function findBlogByCreatedAt(): array
	{
		$sql = sprintf(
			"SELECT * FROM %s ORDER BY created_at DESC",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
		$blogsInfoList = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $blogsInfoList;
	}

	function storeBlog(int $userId, string $blogTitle, string $content): void
	{
		$sql = sprintf(
			"INSERT INTO %s(user_id, title, content) VALUES(:userId, :blogTitle, :content)",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':userId', $userId, PDO::PARAM_INT);
		$statement->bindValue(':blogTitle', $blogTitle, PDO::PARAM_STR);
		$statement->bindValue(':content', $content, PDO::PARAM_STR);
		$statement->execute();
	}

	function findUserIdByBlogId(int $blogId): int
	{
		$sql = sprintf(
			"SELECT user_id FROM %s WHERE id = $blogId",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->execute();
		$userId = $statement->fetch(PDO::FETCH_COLUMN);

		return $userId;
	}

	function updateBlog(int $userId, string $blogTitle, string $content): void
	{
		$sql = sprintf(
			"UPDATE %s SET title = :blogTitle, content = :content WHERE id = :userId",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':blogTitle', $blogTitle, PDO::PARAM_STR);
		$statement->bindValue(':content', $content, PDO::PARAM_STR);
		$statement->bindValue(':userId', $userId, PDO::PARAM_INT);
		$statement->execute();
	}

	function deleteBlog(int $blogId): void
	{
		$sql = sprintf(
			"DELETE FROM %s WHERE id = :id",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':id', $blogId, PDO::PARAM_INT);
		$statement->execute();
	}
}
