<?php

namespace Entity\Model;

use Component\Persist\Model;

class PhotoModel extends Model
{
	const getByIdQuery = <<<EOD
SELECT * FROM photo WHERE id=:id
EOD;

	const getAllQuery = <<<EOD
SELECT * FROM photo
EOD;

	public function getById($id)
	{
		$sth = $this->getEntityManager()->getConnection()->prepare(self::getByIdQuery);
		$sth->bindValue('id', $id);
		if ($sth->execute())
		{
			$results = $sth->fetchAll(\PDO::FETCH_ASSOC);
			if (count($results) == 1)
				return $results[0];
			else
				return array();
		}
	}
	public function getAll()
	{
		$sth = $this->getEntityManager()->getConnection()->prepare(self::getAllQuery);
		if ($sth->execute())
		{
			$results = $sth->fetchAll(\PDO::FETCH_ASSOC);
			return $results;
		}
	}

}