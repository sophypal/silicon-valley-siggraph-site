<?php

namespace Entity;

use Component\Persist\Entity;

class Event extends Entity
{
	protected $photo;
	protected $photos;
	protected $place;
		
	private $fields = array(
		'id' => 'id',
		'name' => 'name',
		'startDate' => 'start_date',
		'endDate' => 'end_date',
		'excerpt' => 'excerpt',
		'description' => 'description',
		'placeId' => 'place_id',
		'photoId' => 'photo_id',
		'published' => 'published'
	);
	
	public function getFields()
	{
		return $this->fields;
	}
	public function getTableName()
	{
		return 'event';
	}
	public function getPrimaryKey()
	{
		return 'id';
	}
	public function getBusinessKey()
	{
		return 'name';
	}
	public function getPlace()
	{
		if ($this->model && !$this->place)
		{
			$this->place = $this->model->findPlace($this->id);
			return $this->place;
		}
		return $this->place;
	}
	public function getPhoto()
	{
		if ($this->model && !$this->photo)
		{
			$this->photo = $this->model->getPhotoEntity($this->id);
			return $this->photo;
		}
		return $this->photo;
	}
	public function getPhotos()
	{
		if ($this->model && !$this->photos)
		{
			$this->photos = $this->model->getPhotoEntities($this->id);
			return $this->photos;
		}
		return $this->photos;
	}
}
?>