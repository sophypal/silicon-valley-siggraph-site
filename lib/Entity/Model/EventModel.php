<?php

namespace Entity\Model;

use Component\Persist\Model;
use Entity\Event;
use Entity\Place;
use Entity\Photo;

class EventModel extends Model
{
	const getCountFutureEventsPublicQuery = <<<EOD
SELECT COUNT(*) as count FROM event e WHERE e.start_date > UNIX_TIMESTAMP() and e.published = 1
EOD;
	const getCountFutureEventsQuery = <<<EOD
SELECT COUNT(*) as count FROM event e WHERE e.start_date > UNIX_TIMESTAMP()
EOD;
		const getCountPastEventsPublicQuery = <<<EOD
SELECT COUNT(*) as count FROM event e WHERE e.start_date < UNIX_TIMESTAMP() and e.published = 1
EOD;
	const getCountPastEventsQuery = <<<EOD
SELECT COUNT(*) as count FROM event e WHERE e.start_date < UNIX_TIMESTAMP()
EOD;
	const getFutureEventsPublicQuery = <<<EOD
SELECT e.id, e.name, e.start_date, e.end_date, e.excerpt, e.description, e.place_id,
p.name as place_name, p.address, p.city, p.state, p.zip, p.long, p.lat,
ph.path as photo_path
FROM event e
JOIN place p on e.place_id = p.id
JOIN photo ph on e.photo_id = ph.id
WHERE e.start_date > UNIX_TIMESTAMP() AND e.published = 1
ORDER BY e.start_date LIMIT :offset,:limit
EOD;
	const getPastEventsPublicQuery = <<<EOD
SELECT e.id, e.name, e.start_date, e.end_date, e.excerpt, e.description, e.place_id,
p.name as place_name, p.address, p.city, p.state, p.zip, p.long, p.lat,
ph.path as photo_path
FROM event e
JOIN place p on e.place_id = p.id
JOIN photo ph on e.photo_id = ph.id
WHERE e.start_date < UNIX_TIMESTAMP() AND e.published = 1
ORDER BY e.start_date DESC LIMIT :offset,:limit
EOD;
	const getPastEventsQuery = <<<EOD
SELECT e.id, e.name, e.start_date, e.end_date, e.excerpt, e.description, e.place_id,
p.name as place_name, p.address, p.city, p.state, p.zip, p.long, p.lat,
ph.path as photo_path
FROM event e
JOIN place p on e.place_id = p.id
JOIN photo ph on e.photo_id = ph.id
WHERE e.start_date < UNIX_TIMESTAMP()
ORDER BY e.start_date DESC LIMIT :offset,:limit
EOD;
	const getPastEventsFilterPublicQuery = <<<EOD
SELECT e.id, e.name, e.start_date, e.end_date, e.excerpt, e.description, e.place_id,
p.name as place_name, p.address, p.city, p.state, p.zip, p.long, p.lat,
ph.path as photo_path
FROM event e
JOIN place p on e.place_id = p.id
JOIN photo ph on e.photo_id = ph.id
WHERE e.start_date >= :from and e.start_date <= :to AND e.published = 1 
ORDER BY e.start_date
EOD;
	const getPastEventsFilterQuery = <<<EOD
SELECT e.id, e.name, e.start_date, e.end_date, e.excerpt, e.description, e.place_id,
p.name as place_name, p.address, p.city, p.state, p.zip, p.long, p.lat,
ph.path as photo_path
FROM event e
JOIN place p on e.place_id = p.id
JOIN photo ph on e.photo_id = ph.id
WHERE e.start_date >= :from and e.start_date <= :to 
ORDER BY e.start_date
EOD;

	const getFutureEventsQuery = <<<EOD
SELECT e.id, e.name, e.start_date, e.end_date, e.excerpt, e.description, e.place_id,
p.name as place_name, p.address, p.city, p.state, p.zip, p.long, p.lat,
ph.path as photo_path
FROM event e
JOIN place p on e.place_id = p.id
JOIN photo ph on e.photo_id = ph.id
WHERE e.start_date > UNIX_TIMESTAMP()
ORDER BY e.start_date DESC LIMIT :offset,:limit
EOD;

	const getEventQuery = <<<EOD
SELECT e.id, e.place_id, e.photo_id, e.name, e.start_date, e.end_date, e.excerpt, e.description, e.published
FROM event e
WHERE e.id = :event_id
EOD;

	const getPlaceQuery = <<<EOD
SELECT p.id, p.name, p.address, p.city, p.state, p.zip, p.long, p.lat
FROM place p JOIN event e on e.place_id = p.id
WHERE e.id = :event_id
EOD;

	const getPhotoQuery = <<<EOD
SELECT * FROM photo p JOIN event e on p.id=e.photo_id AND e=:event_id
EOD;

	const getPhotosQuery = <<<EOD
SELECT p.* FROM photo p JOIN event_photo e on p.id=e.photo_id AND e.event_id=:event_id
EOD;
	 
	const getLastEvent = <<<EOD
SELECT e.*
FROM event e
ORDER BY e.start_date
LIMIT 1
EOD;
	public function getLastEvent()
	{
		$dbh = $this->getEntityManager()->getConnection();
		
		$sth = $dbh->prepare(self::getLastEvent);
		$e = $sth->execute();
		if ($e)
		{
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
			if ($result)
			{
				return $result;
			}
		}
	}
	public function getFutureEvents($offset = 0, $limit = 5, $all = false)
	{
		$dbh = $this->getEntityManager()->getConnection();
		if ($all)
			$query = $dbh->prepare(self::getFutureEventsQuery);
		else 
			$query = $dbh->prepare(self::getFutureEventsPublicQuery);
			
		$query->bindValue('offset', (int) $offset, \PDO::PARAM_INT);
		$query->bindValue('limit', (int) $limit, \PDO::PARAM_INT);
		$e = $query->execute();
		if ($e)
		{
			$results = $query->fetchAll(\PDO::FETCH_ASSOC);
			return $results;
		}
		else
		{
			$this->log('WARN', 'getFutureEventsQuery failed');
			throw new \Exception("getFutureEventQuery failed");
		}
	}
	public function getCountFutureEvents($all = false)
	{
		$dbh = $this->getEntityManager()->getConnection();
		if ($all)
			$query = $dbh->prepare(self::getCountFutureEventsQuery);
		else 
			$query = $dbh->prepare(self::getCountFutureEventsPublicQuery);
			
		$e = $query->execute();
		if ($e)
		{
			$results = $query->fetchAll(\PDO::FETCH_ASSOC);
			return $results[0]['count'];
		}
	}
	
	public function getPastEvents($offset = 0, $limit = 5, $all = false)
	{
		$dbh = $this->getEntityManager()->getConnection();
		if ($all)
			$query = $dbh->prepare(self::getPastEventsQuery);
		else 
			$query = $dbh->prepare(self::getPastEventsPublicQuery);
			
		$query->bindValue('offset', (int) $offset, \PDO::PARAM_INT);
		$query->bindValue('limit', (int) $limit, \PDO::PARAM_INT);
		$e = $query->execute();
		if ($e)
		{
			$results = $query->fetchAll(\PDO::FETCH_ASSOC);
			
			return $results;
		}
		else
		{
			$this->log('WARN', 'getPastEventsQuery failed');
			throw new \Exception("getPastEventQuery failed");
		}
	}
	public function getPastEventsFilter($from, $to, $all = false)
	{
		$dbh = $this->getEntityManager()->getConnection();
		if ($all)
			$query = $dbh->prepare(self::getPastEventsFilterQuery);
		else 
			$query = $dbh->prepare(self::getPastEventsFilterPublicQuery);
			
		$query->bindValue('from', (int) $from, \PDO::PARAM_INT);
		$query->bindValue('to', (int) $to, \PDO::PARAM_INT);
		$e = $query->execute();
		if ($e)
		{
			$results = $query->fetchAll(\PDO::FETCH_ASSOC);
			
			return $results;
		}
		else
		{
			$this->log('WARN', 'getPastEventsQuery failed');
			throw new \Exception("getPastEventQuery failed");
		}
	}
	public function getCountPastEvents($all = false)
	{
		$dbh = $this->getEntityManager()->getConnection();
		if ($all)
			$query = $dbh->prepare(self::getCountPastEventsQuery);
		else 
			$query = $dbh->prepare(self::getCountPastEventsPublicQuery);
			
		$e = $query->execute();
		if ($e)
		{
			$results = $query->fetchAll(\PDO::FETCH_ASSOC);
			return $results[0]['count'];
		}
	}
	public function getEvent($eventId, $complete = true)
	{
		$dbh = $this->getEntityManager()->getConnection();
		$query = $dbh->prepare(self::getEventQuery);
		$query->bindValue('event_id', $eventId);
		$e = $query->execute();
		if ($e)
		{
			$results = $query->fetch(\PDO::FETCH_ASSOC);
			return $results;
		}
		else
		{
			$this->log('WARN', 'getEventQuery failed');
			throw new \Exception("getEventQuery failed");
		}
	}
	public function findEvent($eventId)
	{
		$result = $this->getEvent($eventId, false);
		if ($result)
		{
			$event = new Event($result);
			$event->setModel($this);
			return $event;
		}
	}
	public function getPlace($eventId)
	{
		$dbh = $this->getEntityManager()->getConnection();
		$query = $dbh->prepare(self::getPlaceQuery);
		$query->bindValue('event_id', $eventId);
		$e = $query->execute();
		if ($e)
		{
			$result = $query->fetchAll(\PDO::FETCH_ASSOC);
			return $result[0];
		}
	}
	public function findPlace($eventId)
	{
		$results = $this->getPlace($eventId);
		if ($results)
			return new Place($results);
	}
	public function getPhoto($eventId)
	{
		$dbh = $this->getEntityManager()->getConnection();
		$query = $dbh->prepare(self::getPhotoQuery);
		$query->bindValue('event_id', $eventId);
		$e = $query->execute();
		if ($e)
		{
			$result = $query->fetchAll(\PDO::FETCH_ASSOC);
			return $result[0];
		}
	}
	public function getPhotoEntity($eventId)
	{
		$results = $this->getPhoto($eventId);
		if ($results)
			return new Photo($results);
	}
	public function getPhotos($eventId)
	{
		$dbh = $this->getEntityManager()->getConnection();
		$query = $dbh->prepare(self::getPhotosQuery);
		$query->bindValue('event_id', $eventId);
		$e = $query->execute();
		if ($e)
		{
			$results = $query->fetchAll(\PDO::FETCH_ASSOC);
			return $results;
		}
	}
	public function getPhotoEntities($eventId)
	{
		$results = $this->getPhotos($eventId);
		$photos = array();
		foreach ($results as $result) {
			$photos[] = new Photo($result);
		}
		return $photos;
	}
}

?>