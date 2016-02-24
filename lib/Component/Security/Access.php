<?php 

namespace Component\Security;

use Component\Security\User;
use Component\Server\Session;
use Component\Container\ContainerAware;

class Access extends ContainerAware
{
	const USER_KEY = 'vitraya.user';
	
	protected $accessControl;
	
	private $session;
	private $user;
	
	public function __construct($session)
	{
		$this->session = $session;
		$this->user = $this->getUser();
	}
	public function setAccess($securityFile)
	{
		$params = parse_ini_file($securityFile);
		foreach ($params as $paramKey => $paramValue)
		{
			$this->accessControl[$paramKey] = explode(',', $paramValue);
		}
	}
	public function getUser()
	{
		if (isset($this->user))
			return $this->user;
		
		$user = new User();
		if ($this->session->has(self::USER_KEY))
		{
			$user->unserialize($this->session->get(self::USER_KEY));
			return $user;
		}
		
		return $user;
	}
	public function setUser($user)
	{
		$this->user = $user;
		$this->session->set(
			self::USER_KEY,
			$this->user->serialize());
	}
	public function revoke()
	{
		$this->session->clear(self::USER_KEY);
		if ($this->session->get('auth.method') == 'li')
			$this->get('provider.auth.li')->deauthenticate();
		
		$this->user = null;
		session_unset();
	}
	public function isActionAllowed($path)
	{
		$controller = strtolower($path[0]);
		
		$userRole = array('anonymous');
		
		if (isset($this->user) && $this->user->isAuthenticated() && $this->user->getEntity())
		{
			// yes, we have a separate role for authenticated users
			$userRole[] = 'authenticated';
			if ($roles = $this->user->getRoles())
				$userRole = array_merge($userRole, $roles);
		}
		
		// if we didn't define the acl for this
		// the default is to allow it through
		if (!isset($this->accessControl[$controller]))
			return true;
			
		foreach ($userRole as $role)
		{
			if (in_array($role, $this->accessControl[$controller]))
				return true;
		}
		return false;
	}
}
?>