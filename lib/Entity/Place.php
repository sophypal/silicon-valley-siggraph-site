<?php

namespace Entity;

use Component\Persist\Entity;

class Place extends Entity
{
	private $fields = array(
		'id' => 'id',
		'name' => 'name',
		'address' => 'address',
		'city' => 'city',
		'state' => 'state',
		'zip' => 'zip',
		'long' => 'long',
		'lat' => 'lat'
	);
	public function getFields()
	{
		return $this->fields;
	}
	public function getTableName()
	{
		return 'place';
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