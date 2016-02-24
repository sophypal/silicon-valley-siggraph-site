<?php 
/**
 * Defines the base controller class
 */

namespace Component\Controller;

use Component\Container\ContainerAware;
use Component\Server\Response;

class ActionException extends \Exception {}
class ActionNotImplException extends ActionException {}

class Controller extends ContainerAware
{
	private $reflector;
	
	public function __construct()
	{
		$this->reflector = new \ReflectionClass($this);
	}
	public function callAction($action, $params = null)
	{
		$actionMethod = $action . 'Action';
		if ($this->reflector->hasMethod($actionMethod))
		{
			$response = $this->{$actionMethod}($params);
			
			if (!$response)
				throw new ActionException("No Response returned");
				
			if (!($response instanceof Response))
				throw new ActionException("Invalid Response not returned");
			
			return $response;
		}
			
		throw new ActionNotImplException("Action not implemented for " . $action);
	}
	public function forward($controller, $action, $params = null)
	{
		return $this->get('container')->callController($controller, $action, $params);
	}
	public function render($tpl, $params)
	{
		return $this->get('view')->render($tpl, $params);
	}
}
?>