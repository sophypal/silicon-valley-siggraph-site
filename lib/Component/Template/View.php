<?php

namespace Component\Template;

use Component\Server\Response;
use Component\Container\ContainerAware;

abstract class View extends ContainerAware
{
	protected $engine;
	
	public function __construct($engine)
	{
		$this->engine = $engine;
	}
	public abstract function render($tpl, $parameters);
	public abstract function createNotFound();
	public abstract function createAccessDenied();
	public abstract function createError($errorCode, $errorMessage);
}
?>