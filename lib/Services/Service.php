<?php

namespace Services;

use Component\Container\ContainerAware;

class Service extends ContainerAware
{
	private $behaviors = array();
	private $instances = array();
	protected function addBehavior($name,$behaviorClass)
	{
		$this->behaviors[$name] = $behaviorClass;
	}
	public function getBehavior($name)
	{
		if (array_key_exists($name, $this->instances))
			return $this->instances[$name];
			
		return $this->factory($name);
	}
	public function factory($name)
	{
		if (array_key_exists($name, $this->behaviors))
		{
			$behavior = new $this->behaviors[$name];
			$behavior->setOwner($this);
			return $behavior;
		}
		throw new \InvalidArgumentException("No factory for " . $name);
	}
}

?>