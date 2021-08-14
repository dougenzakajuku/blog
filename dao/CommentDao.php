<?php
require_once(__DIR__ . '/../dao/Dao.php');


final class CommentDao extends Dao
{
	const TABLE_NAME = 'comments';

	public function __construct()
	{
		parent::__construct();
	}

	public function findCommentByBlogId(int $blogId): ?array
	{
		$sql = sprintf(
			"select * from %s where blog_id = :id order by created_at DESC",
			self::TABLE_NAME
		);

		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':id', $blogId, PDO::PARAM_INT);
		$statement->execute();
		$commentsInfoList = $statement->fetchAll(PDO::FETCH_ASSOC);

		return ($commentsInfoList) ? $commentsInfoList : null;
	}

	function storeComment(int $userId, int $blogId, string $commenterName, string $commentContent): void
	{
		$sql = sprintf(
			"INSERT INTO %s(user_id, blog_id, commenter_name, comments)VALUES(:user_id, :blog_id, :commenter_name, :comments)",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
		$statement->bindValue(':blog_id', $blogId, PDO::PARAM_INT);
		$statement->bindValue(':commenter_name', $commenterName, PDO::PARAM_STR);
		$statement->bindValue(':comments', $commentContent, PDO::PARAM_STR);
		$statement->execute();
	}
}
