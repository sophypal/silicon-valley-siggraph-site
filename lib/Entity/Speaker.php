<?php

namespace Entity;

use Component\Persist\Entity;

class Speaker extends Entity
{
	private $fields = array(
		'id' => 'id',
		'firstName' => 'first_name',
		'lastName' => 'last_name',
		'title' => 'title',
		'biography' => 'biography'
	);
	public function getFields()
	{
		return $this->fields;
	}
	public function getTableName()
	{
		return 'speaker';
	}
	public function getPrimaryKey()
	{
		return 'id';
	}
	public function getBusinessKey()
	{
		return 'firstName,lastName';
	}
}
?>