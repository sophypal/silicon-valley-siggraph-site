<?php
 
/**
 * This is the kernel dispatcher.  This reads the request,
 * executes the right controller, and renders a response
 *
 * @author Sophy Pal sophy.pal@gmail.com
 */
 
namespace Component\Server;

use Component\ClassLoader;
use Component\Security;
use Component\Container\Container;
use Component\Controller\Controller;
use Component\Server\HTTPStatusCode;
use Controllers;

class Core extends Container
{
	/**
	 * @var Component\Server\Request
	 */
	protected $request;
	/**
	 * @var Component\Server\Response
	 */
	protected $response;
	/**
	 * @var Component\Server\Session
	 */
	protected $session;
	
	public $debug;
	
	/**
	 * @param Component\Persist\EntityManager
	 * @param Component\Template\View
	 */
	public function __construct($entityManager, $view)
	{
		parent::__construct();
		
		$this->register('entity_manager', $entityManager);
		$this->register('view', $view);
		$this->setParameter('root_dir', __DIR__ . '/../../../');
	}
	public function loadParameters($parameters)
	{
		parent::loadParameters($parameters);
		
		// easy access
		$this->debug = $parameters->getParameter('kernel.debug');
	}
	public function dispatch(Request $req = null)
	{
		// if req is null, use the existing one
		if (isset($req))
			$this->register('request', $req);
		else
		{
			$req = $this->get('request');
			if (!isset($req))
				return $this->get('view')->createError(HTTPStatusCode::BAD_REQUEST, $ex);
		}
		
		$session = $req->getSession();
		$security = $this->register('security', new Security\Access($session));
		$security->setAccess($this->getParameter('root_dir') . $this->getParameter('security.file'));
		
		$path = $req->getAction();
		if (!$security->isActionAllowed($path))
		{
			return $this->callController('Login', 'index');
		}
		
		list($base, $action) = $path;
		
		return $this->callController($base, $action);
	}
	public function callController($controller, $action, $params = null)
	{
		try
		{
			$namespace = 'Controllers\\' . ucfirst($this->getParameter('kernel.handler')) . '\\'. ucfirst($controller) . 'Controller';
			$controller = new $namespace;
			
			if (!$controller instanceof Controller)
				return $this->get('view')->createNotFound();;
			
			$controller->setContainer($this);
		
			// now that we have a valid controller, call the
			// action methods on it to return a valid response
			$response = $controller->callAction($action, $params);
		}
		catch (\Exception $ex)
		{
			if ($this->debug)
				return $this->get('view')->createError(HTTPStatusCode::INTERNAL_ERROR, $ex);
			else
				return $this->get('view')->createNotFound();
		}
		return $response;
	}
	/**
	 * Gives you a model instance
	 * @param string $classname fully-qualified namespace of the class
	 */
	public function getModel($classname)
	{
		$model = new $classname($this);
		return $model;
	}
	
}
?>