<?php

namespace Component\Container;

class ContainerAware implements ContainerAwareInterface
{
	protected $container;
	
	public function get($name)
	{
		return $this->container->get($name);
	}
	public function getContainer()
	{
		return $this->container;
	}
	public function setContainer($container)
	{
		$this->container = $container;
	}
}

?>