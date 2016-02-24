<?php

/**
 * Service container
 * 
 * @author Sophy Pal sophy.pal@gmail.com
 */

namespace Component\Container;

use Component\Container\ContainerAwareInterface;
use Component\Config\Parameters;

class ServiceNotFound extends \Exception {}

class Container extends ContainerAware
{
	private $parameters;
	
	/**
	 * contains a reference to all services
	 * @var hash
	 */
	private $services;
	
	public function __construct()
	{
		$this->services = array();
		$this->parameters = new Parameters();
		$this->register('container', $this);
	}
	/**
	 * Register a service object
	 * @param string $name
	 * @param object $service
	 */
	public function register($name, $service)
	{
		if ($service instanceof ContainerAwareInterface)
		{
			$this->services[$name] = $service;
			$service->setContainer($this);
			return $service;
		}
		else 
			throw new \Exception(get_class($service) . ' is not container aware ');
	}
	
	public function get($name)
	{
		if (array_key_exists($name, $this->services))
			return $this->services[$name];
		
		throw new ServiceNotFound($name . " is not an available service");
	}
	public function getContainer()
	{
		return $this;
	}

	public function setContainer($container)
	{
		// You can't really call setContainer on a container
	}
	public function getParameter($name)
	{
		return $this->parameters->getParameter($name);
	}
	public function setParameter($name, $value)
	{
		$this->parameters->setParameter($name, $value);
	}
	public function loadParameters($parameters)
	{
		$this->parameters->loadParameters($parameters);
	}
}

?>