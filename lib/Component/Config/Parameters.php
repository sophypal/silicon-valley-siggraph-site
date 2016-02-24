<?php

namespace Component\Config;

class Parameters
{
	private $parameters;
	
	public function __construct($file = null)
	{
		$this->parameters = array();
		if (isset($file) && file_exists($file))
		{
			$this->parameters = parse_ini_file($file);
		}
		else if (isset($file))
			throw new \Exception('File not found: ' . $file);
	}
	public function setParameter($name, $value)
	{
		$this->parameters[$name] = $value;
	}
	public function getParameter($name)
	{
		if (array_key_exists($name, $this->parameters))
			return $this->parameters[$name];
	}
	public function getParameters()
	{
		return $this->parameters;
	}
	public function loadParameters($parameters)
	{
		$this->parameters = array_merge($this->parameters, $parameters->getParameters());
	}
}

?>