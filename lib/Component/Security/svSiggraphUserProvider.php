<?php

namespace Component\Security;

use Component\Container\ContainerAware;
use Component\Security\UserProviderInterface;
use Entity\Model\UserModel;

class svSiggraphUserProvider extends ContainerAware implements UserProviderInterface
{
	private $user;
	private $roles;
	
	public function getUser($username)
	{
		$this->initialize($username);
		
		if ($this->user)
			return $this->user;
	}
	public function getPassword($username)
	{
		$this->initialize($username);
		
		if ($this->user)
			return $this->user->password;
	}
	public function getRoles($username)
	{
		$this->initialize($username);
		
		if ($this->roles)
			return $this->roles;
	}
	public function initialize($broker)
	{
		if ($this->user)
			return;

		$username = $broker;
		$userModel = new UserModel($this->get('container'));
		$user = $userModel->findByUsername($username);
		if ($user)
		{
			$this->user = $user;
			$roles = $user->getRoles();
			$this->roles = array();
			
			if ($roles)
				foreach ($roles as $role)
				{
					$this->roles[] = $role->name;
				}
		}
	}
}