<?php

namespace Component\Security;

use Entity;

class User implements \Serializable
{
	private $entityUser;
	private $roles;
	private $authenticated = false;
	
	public function setEntity(Entity\User $user, $roles)
	{
		$this->entityUser = $user;
		$this->roles = $roles;
	}
	public function getEntity()
	{
		return $this->entityUser;
	}
	public function getRoles()
	{
		if ($this->roles)
			return $this->roles;
		return array();
	}
	public function isAuthenticated()
	{
		return $this->authenticated;
	}
	public function setAuthenticated($value)
	{
		$this->authenticated = $value;
	}
	
	// serialize methods
	public function serialize()
	{
		return serialize(array(
			'entity' => serialize($this->entityUser),
			'roles' => serialize($this->roles),
			'authenticated' => serialize($this->authenticated)));
	}
	public function unserialize($data)
	{
		$obj = unserialize($data);
		$this->entityUser = unserialize($obj['entity']);
		$this->roles = unserialize($obj['roles']);
		$this->authenticated = unserialize($obj['authenticated']);
	}
}

?>