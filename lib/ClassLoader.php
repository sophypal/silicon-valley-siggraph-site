<?php

class AutoloadException extends Exception {}

class ClassLoader
{
	public function __construct()
	{
		spl_autoload_register('ClassLoader::loader');
	}
	public static function loader($className)
	{
		// hard coded for now
		$srcDir = array(__DIR__ . '/', __DIR__ . '/../vendor/');
		
		foreach ($srcDir as $dir)
		{
			$absPath = $dir . str_replace("\\", "/", $className) . '.php';
		
			if (file_exists($absPath)) 
			{
				require_once $absPath;
				return;
			} 
		}
	}
}