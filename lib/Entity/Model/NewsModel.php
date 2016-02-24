<?php

namespace Entity\Model;

use Component\Persist\Model;
use Entity\News;

class NewsModel extends Model
{
	const getRecentNewsQuery = <<<EOD
SELECT n.id, n.title, n.create_date, n.excerpt, n.article,
u.first_name, u.last_name, u.username,
p.path as photo_path
FROM news n JOIN user u on n.user_id=u.id
LEFT JOIN photo p on n.photo_id = p.id
WHERE n.create_date < UNIX_TIMESTAMP()
ORDER BY n.create_date DESC
LIMIT :offset,:limit
EOD;
	
	const getByIdQuery = <<<EOD
SELECT n.*, u.username from news n
JOIN user u on n.user_id=u.id
WHERE n.id = :id
EOD;

	public function getRecentNews($offset = 0, $limit = 5)
	{
		$dbh = $this->getEntityManager()->getConnection();
		$query = $dbh->prepare(self::getRecentNewsQuery);
		$query->bindValue('offset', (int) $offset, \PDO::PARAM_INT);
		$query->bindValue('limit', (int) $limit, \PDO::PARAM_INT);
		$e = $query->execute();
		if ($e)
			return $query->fetchAll(\PDO::FETCH_ASSOC);
		else
			$this->log('WARN', 'getRecentNewsQuery failed');
			
		return null;
	}
	public function getById($id)
	{
		$dbh = $this->getEntityManager()->getConnection();
		$query = $dbh->prepare(self::getByIdQuery);
		$query->bindValue('id', $id, \PDO::PARAM_INT);
		
		$e = $query->execute();
		
		if ($e)
		{
			$result = $query->fetchAll(\PDO::FETCH_ASSOC);
			
			return $result[0];
		}
		else
		{
			$this->log('WARN', 'getById query failed');
		}
		
		return null;
	}
}

?>