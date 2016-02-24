<?php 

namespace Component\Container;

interface ContainerAwareInterface
{
	/**
	 * Gets the service on behalf of the container
	 * @param string $name
	 */
	public function get($name);
	
	/**
	 * Gets the container
	 */
	public function getContainer();
	
	/**
	 * Sets the container
	 * @param Container $container
	 */
	public function setContainer($container);
}

?>