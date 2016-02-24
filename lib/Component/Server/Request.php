<?php 

namespace Component\Server;

use Component\Container\ContainerAware;

class BadRequestException extends \Exception {}

class Request extends ContainerAware
{
	public $httpRequest;
	private $session;
	private $server;
	
	public function __construct($request, &$session, $server)
	{
		$this->httpRequest = $request;
		$this->session = new Session($session);
		$this->server = new Server($server);
	}
	public function has($name)
	{
		if (isset($this->httpRequest[$name]))
			return true;
		return false;
	}
	public function get($name)
	{
		if (isset($this->httpRequest[$name]))
			return $this->httpRequest[$name];
	}
	public function getPostData()
	{
		// for testing
		if (isset($this->httpRequest['DATA']) && 
			parent::get('container')->getParameter('kernel.debug'))
			return $this->httpRequest['DATA'];
			
		return file_get_contents('php://input');
	}
	public function set($name, $value)
	{
		$this->httpRequest[$name] = $value;
	}
	public function getAction()
	{
		if (isset($this->httpRequest['action']))
		{
			$actionUrl = $this->httpRequest['action'];
			return $this->parseAction($actionUrl);
		}
		else
		{
			return array('Root', 'index');
		}
	}
	public function parseAction($actionUrl)
	{
		if (preg_match('/(\D+)\/(\D+)/', $actionUrl, $matches))
		{
			$controller = $matches[1];
			$action = $matches[2];
			return array(strtolower($controller), strtolower($action));
		}
	}
	public function getSession()
	{
		return $this->session;
	}
	public function getServer()
	{
		return $this->server;
	}
}
?>