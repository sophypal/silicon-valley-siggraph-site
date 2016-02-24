<?php

namespace Component\Persist;

use Component\Container\ContainerAware;

abstract class Model extends ContainerAware
{
	private $entityManager = null;
	
	public function __construct($container)
	{
		$this->setContainer($container);
		$this->entityManager = $container->get('entity_manager');
	}
	public function getEntityManager()
	{
		return $this->entityManager;
	}
	public function log($level, $message)
	{
		$this->get('logger')->log(get_class($this),$level,$message); 
	}
}
?>