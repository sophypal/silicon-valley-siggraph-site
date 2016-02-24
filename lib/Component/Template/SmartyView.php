<?php

namespace Component\Template;

use Component\Server\HTTPStatusCode;
use Component\Server\Response;

class SmartyView extends View
{
	public function __construct($engine)
	{		
		parent::__construct($engine);
	}
	/**
	 * For use in rendering from inside the template
	 */
	public function setContainer($container)
	{
		parent::setContainer($container);
		$this->engine->registerObject('container', $container);
	}
	public function render($tpl, $parameters = null, $errorCode = HttpStatusCode::OK)
	{
		if (isset($parameters))
		{
			foreach ($parameters as $param => $val)
			{
				$this->engine->assign($param, $val);
			}
		}
		return new Response($this->engine->fetch($tpl), $errorCode);
	}
	public function createNotFound($tpl = 'not_found.tpl')
	{
		return $this->render($tpl, null, HTTPStatusCode::NOT_FOUND);
	}
	public function createAccessDenied($tpl = 'access_denied.tpl')
	{
		return $this->render($tpl, null, HTTPStatusCode::FORBIDDEN);
	}
	public function createError($errorCode, $errorMessage)
	{
		return $this->render('exception.tpl', array('exception' => $errorMessage), $errorCode);
	}
}