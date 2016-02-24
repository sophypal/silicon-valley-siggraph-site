<?php 

namespace Component\Persist;

use Component\Persist\EntityManagerInterface;
use Component\Container\ContainerAware;

class EntityManager extends ContainerAware implements EntityManagerInterface  {
	
	private $connection;
	
	public function __construct($connection){
		$this->connection = $connection;
	}
	
	public function getConnection()
	{
		return $this->connection;
	}
	public function log($level, $message)
	{
		$this->get('logger')->log(get_class($this),$level,$message); 
	}
	
	public function save(EntityInterface $entity, $isNew = false)
	{
		$businessKeys = explode(',',$entity->getBusinessKey());
		$primaryKeys = explode(',', $entity->getPrimaryKey());
			
		if ($isNew)
		{
			$saveQuery = "INSERT INTO " . $entity->getTableName() . " SET ";
		}
		else 
		{
			$keyValues = array();
			$keyColumns = array();
			
			$usePk = true;
			
			$fields = $entity->getFields();
			// check to see if primary key is set and use
			// it instead of bks
			foreach ($primaryKeys as $pk)
			{
				if (!$entity->{$pk})
				{
					$usePk = false;
					break;
				}
				$keyColumns[] = $fields[$pk];
				$keyValues[] = $entity->{$pk};
			}
			if (!$usePk)
			{
				foreach ($businessKeys as $bk)
				{
					$keyColumns[] = $fields[$bk];
					$keyValues[] = $entity->{$bk};
				}
				if (!$usePk && count($keyValues) !== count($keyColumns))
				{
					$this->log('FATAL', 'A business is required to save');
					throw new \Exception(get_class($entity) . ' requires a business key');
				}
			}
			$findQuery = "SELECT count(*) as count from " . $entity->getTableName() . 
			" WHERE " . implode('= ? and ', $keyColumns) . " = ?";
			$sth = $this->connection->prepare($findQuery);
			$sth->execute($keyValues);
			$count = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$bindParams = array();
			if ($count[0]['count'] > 0)
			{
				$saveQuery = "UPDATE " . $entity->getTableName() . " SET ";
			}
			else 
			{
				$saveQuery = "INSERT INTO " . $entity->getTableName() . " SET ";
			}
		}
		
		foreach ($entity->getFields() as $prop => $col)
		{
			// we don't want to insert/update primary keys
			// unless they were also a business key
			if (in_array($prop, $primaryKeys) && !in_array($prop, $businessKeys))
				continue;
				
			$val = $entity->$prop;
			
			if (!isset($val))
			{
				//$saveQuery .= $col . " = null, ";
				continue;
			}
				
			$saveQuery .= $col . " = ?, "; 
			$bindParams[] = $val;
		}
		$saveQuery = rtrim($saveQuery, ', ');
		
		if (!$isNew && $count[0]['count'] > 0)
		{
			$saveQuery .= " WHERE " . implode('= ? and ',$keyColumns) . " = ?";
			$bindParams = array_merge($bindParams, $keyValues);
		}	
		$sth = $this->connection->prepare($saveQuery);
		if ($sth->execute($bindParams))
		{
			$this->log('DEBUG', get_class($entity) . ' saved successfully.');
			$this->log('DEBUG', $this->printQueryDetails($saveQuery, $bindParams));
		}
		else 
		{
			$this->log('WARN', 'Error saving ' . get_class($entity));
			$this->log('DEBUG', $this->printQueryDetails($saveQuery, $bindParams));
			throw new \Exception('Error saving' . get_class($entity));
		}
	}
	// we only allow delete by primary key
	public function remove(EntityInterface $entity)
	{
		$primaryKeys = explode(',', $entity->getPrimaryKey());
		
		// check that all primary keys exist
		$fields = $entity->getFields();
		$keyColumns = array();
		$keyValues = array();
		foreach ($primaryKeys as $key)
		{
			if (!$entity->{$key})
				throw new \InvalidArgumentException("Can't delete without primary key");
			
			$keyColumns[] = $fields[$key];
			$keyValues[] = $entity->{$key};
		}
		$delQuery = "DELETE FROM " . $entity->getTableName() . " WHERE " . implode('= ? and ', $keyColumns) . " = ?";
		$bindParams = $keyValues;
		$sth = $this->connection->prepare($delQuery);
		if ($sth->execute($bindParams))
		{
			$this->log('DEBUG', get_class($entity) . ' deleted successfully.');
			$this->log('DEBUG', $this->printQueryDetails($delQuery, $bindParams));
		}
		else 
		{
			$this->log('WARN', 'Error saving ' . get_class($entity));
			$this->log('DEBUG', $this->printQueryDetails($delQuery, $bindParams));
			throw new \Exception('Error saving' . get_class($entity));
		}
	}
	public function insertId()
	{
		return $this->connection->lastInsertId();
	}
	public function printQueryDetails($qry, $bindVars)
	{
		return "STATEMENT: $qry\nBIND VALUES: " . implode(',', $bindVars);
	}
}

?>
