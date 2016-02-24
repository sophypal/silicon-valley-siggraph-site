<?php

namespace Entity\Model;

use Component\Persist\Model;
use Entity\User;
use Entity\Role;

class UserModel extends Model
{
	const findByUsernameQuery = <<<EOD
SELECT * FROM user WHERE username = :username
EOD;
	const findRolesForUserQuery = <<<EOD
SELECT r.id, r.name FROM role r JOIN user_role ur on ur.role_id = r.id
JOIN user u on ur.user_id = u.id WHERE u.id = :user_id
EOD;

	public function findByUsername($username)
	{
		$connection = $this->getEntityManager()->getConnection();
		$sth = $connection->prepare(self::findByUsernameQuery);
		$sth->bindValue('username', $username);
		if ($sth->execute())
		{
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
			$user = new User($result);
			$user->setModel($this);
			return $user;
		}
	}
	public function findRolesForUser($userId)
	{
		$sth = $this->getEntityManager()->getConnection()->prepare(self::findRolesForUserQuery);
		$sth->bindValue('user_id', $userId);
		if ($sth->execute())
		{
			$results = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$roles = array();
			foreach ($results as $result)
			{
				$role = new Role($result);
				$roles[] = $role;
			}
			return $roles;
		}
	}
}