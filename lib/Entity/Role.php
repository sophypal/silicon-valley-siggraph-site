<?php

namespace Entity;

use Component\Persist\Entity;

class Role extends Entity
{
	protected $fields = array(
		'id' => 'id',
		'name' => 'name'
	);
	public function getFields()
	{
		return $this->fields;
	}
	public function getTableName()
	{
		return 'role';
	}
	public function getPrimaryKey()
	{
		return 'id';
	}
	public function getBusinessKey()
	{
		return 'name';
	}
}
?>