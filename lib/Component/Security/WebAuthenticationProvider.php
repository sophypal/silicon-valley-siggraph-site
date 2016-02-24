<?php

namespace Component\Security;

use Component\Listener\ListenerInterface;
use Component\Container\ContainerAware;
use Component\Security\User;
use Component\Security\Access;

class WebAuthenticationProvider extends ContainerAware implements AuthenticationProvider
{
	protected $userProvider;
	protected $listeners;
	
	public function authenticate($username, $password)
	{
		$dbPassword = $this->userProvider->getPassword($username);
		if ($dbPassword === sha1($password))
		{
			$this->authenticated($username);
		}
	}
	public function authenticated($token)
	{
		$user = $this->userProvider->getUser($token);
		$roles = $this->userProvider->getRoles($token);
		
		$securityUser = new User();
		$securityUser->setAuthenticated(true);		
		$securityUser->setEntity($user, $roles);
		
		$access = new Access($this->get('request')->getSession());
		$access->setUser($securityUser);
		
		foreach ($this->listeners as $listener)
		{
			$listener->process($securityUser);
		}
	}
	public function deauthenticate()
	{
		
	}
	public function setUserProvider($userProvider)
	{
		$this->userProvider = $userProvider;
	}
	public function addListener(ListenerInterface $listener)
	{
		if (!$this->listeners)
			$this->listeners = array();
			
		$this->listeners[] = $listener;
	}
}

?>