<?php

namespace Component\Utility;

use Component\Container\ContainerAware;

class StringTable extends ContainerAware
{
	private $data;
	
	public function __construct($messageFile)
	{
		if (file_exists($messageFile))
		{
			$this->data = parse_ini_file($messageFile, true);
		}
		else 
			throw new \Exception('File not found: ' . $messageFile);
	}
	
	public function get($name)
	{
		if (prep_match('/(\D+)\.(\D+)/', $name, $matches))
		{
			$section = $matches[0];
			$key = $matches[1];
			
			if (array_key_exists($this->data[$section]) &&
				array_key_exists($this->data[$section][$key]))
				return $this->data[$section][$key];
		}
	}
}