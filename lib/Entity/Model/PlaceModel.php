<?php 
namespace Entity\Model;

use Component\Persist\Model;

class PlaceModel extends Model
{
	const getAllPlacesQuery = <<<EOD
SELECT * FROM place
EOD;
	public function getAllPlaces()
	{
		$dbh = $this->getEntityManager()->getConnection();
		$query = $dbh->prepare(self::getAllPlacesQuery);
		$query->execute();
		return $query->fetchAll(\PDO::FETCH_ASSOC);
	}
}
?>