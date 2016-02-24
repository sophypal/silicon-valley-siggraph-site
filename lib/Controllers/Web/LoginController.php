<?php

namespace Controllers\Web;

use Component\Security\WebAuthenticationProvider;
use Component\Security\svSiggraphUserProvider;
use Component\Controller\Controller;
use Component\Listener\ListenerInterface;
use Component\Server\Response;

class LoginController extends Controller implements ListenerInterface
{
	public function indexAction()
	{
		Response::redirect('index.php');
	}
	public function submitAction()
	{
		$request = $this->get('request');
		$session = $request->getSession();
		
		$username = $request->get('username');
		$password = $request->get('password');
		
		$authProvider = new WebAuthenticationProvider();
		$authProvider->setContainer($this->get('container'));
		$userProvider = new svSiggraphUserProvider();
		$userProvider->setContainer($this->get('container'));
		
		$authProvider->setUserProvider($userProvider);
		$authProvider->addListener($this);
		$authProvider->authenticate($username, $password);
		
		$authenticated = $this->get('request')->getSession()->get('auth.success');
		
		if ($request->get('action') && $authenticated)
		{
			// if re-authenticating, forward to the page they initially requested
			list($controller, $action) = $request->parseAction($request->get('action'));
			
			$session->clear('action');
			if ($controller != 'login' && $action = 'submit')
				return $this->forward($controller, $action, null);
		}
		Response::redirect('index.php');
	}
	public function cancelAction()
	{
		$this->get('security')->revoke();
		Response::redirect('index.php');
	}
	/**
	 * This is called when authentication succeeds
	 * @param unknown_type $user
	 */
	public function process($user)
	{
		$session = $this->get('request')->getSession();
		$session->set('auth.success', true);
	}
}