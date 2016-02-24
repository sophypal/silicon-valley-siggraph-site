<?php 
namespace Entity\Model;

use Component\Persist\Model;

class SpeakerModel extends Model
{
	const getAllSpeakersQuery = <<<EOD
SELECT * FROM speaker
EOD;
	public function getAllSpeakers()
	{
		$dbh = $this->getEntityManager()->getConnection();
		$query = $dbh->prepare(self::getAllSpeakersQuery);
		$query->execute();
		return $query->fetchAll(\PDO::FETCH_ASSOC);
	}
}
?>