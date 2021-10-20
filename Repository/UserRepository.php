<?php

namespace Repository;

use Dao\UserDao;
use Domain\Entity\User;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Email;

final class UserRepository
{
	private $userDao;

	public function __construct()
	{
		$this->userDao = new UserDao();
	}

	/**
	 *アカウント情報をデータベースに保存する処理
	 */
	public function insert(User $user): void
	{
		$name = $user->name();
		$email = $user->email()->value();
		$password = $user->password();
		$this->userDao->insert($name, $email, $password);
	}

	/**
	 * アカウントの取得（by　メールアドレス）
	 */
	public function findByEmail(Email $email): ?User
	{
		$email = $email->value();
		$user = $this->userDao->findByEmail($email);

		return (is_null($user))
			? null
			: new User(
				new UserId($user['id']),
				$user['name'],
				new Email($user['email']),
				$user['password']
			);
	}
}
