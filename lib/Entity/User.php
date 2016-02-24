<?php

namespace Entity;

use Component\Persist\Entity;

class User extends Entity
{
	protected $roles;
	
	protected $fields = array(
		'id' => 'id',
		'username' => 'username',
		'firstName' => 'first_name',
		'lastName' => 'last_name',
		'email' => 'email',
		'password' => 'password'
	);
	
	public function getFields()
	{
		return $this->fields;
	}
	public function getTableName()
	{
		return 'user';
	}
	public function getPrimaryKey()
	{
		return 'id';
	}
	public function getBusinessKey()
	{
		return 'username';
	}
	public function getRoles()
	{
		if ($this->model && !$this->roles)
		{	
			$this->roles = $this->model->findRolesForUser($this->id);
		}
		return $this->roles;
	}
}

?>