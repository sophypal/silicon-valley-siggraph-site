<?php

namespace Component\Utility;
use Component\Container\ContainerAware;

class Logger extends ContainerAware
{
	public function __construct($filename, $debug) 
	{
		error_reporting(E_ALL);
		ini_set('error_log', $filename);
		if (!$debug)
			ini_set('display_errors', 0);
		else
			ini_set('display_errors', 1);
	}
	
	public function log($app, $level, $message) {
		if (!$this->get('container')->getParameter('kernel.debug') && strtoupper($level) == 'DEBUG')
			return;
		error_log($app . ' (' . $level .') - ' . $message );
	}
}

?>