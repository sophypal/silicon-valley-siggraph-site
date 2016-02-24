<?php

namespace Entity;

use Component\Persist\Entity;

class EventPhoto extends Entity
{
	private $fields = array(
		'eventId' => 'event_id',
		'photoId' => 'photo_id'
	);
	
	public function getFields()
	{
		return $this->fields;
	}
	public function getTableName()
	{
		return 'event_photo';
	}
	public function getPrimaryKey()
	{
		return 'eventId,photoId';
	}
	public function getBusinessKey()
	{
		return 'eventId,photoId';
	}
}
?>