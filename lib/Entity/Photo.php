<?php

namespace Entity;

use Component\Persist\Entity;

class Photo extends Entity
{
	private $fields = array(
		'id' => 'id',
		'path' => 'path',
		'caption' => 'caption'
	);
	
	public function getFields()
	{
		return $this->fields;
	}
	public function getTableName()
	{
		return 'photo';
	}
	public function getPrimaryKey()
	{
		return 'id';
	}
	public function getBusinessKey()
	{
		return 'id';
	}
}
?>