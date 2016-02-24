<?php

namespace Component\Persist;

use Component\Persist\EntityInterface;
use Component\Persist\Model;

abstract class Entity implements EntityInterface, \Serializable
{
	protected $data = array();
	protected $model = null;
	
	public function __construct($data = array())
	{
		$fields = array_values($this->getFields());
		foreach ($data as $key => $value)
		{
			if (in_array($key, $fields))
				$this->data{$key} = $value;
		}
	}
	public function __get($key)
	{
		$fields = $this->getFields();
		
		if (array_key_exists($key, $fields) && isset($this->data[$fields[$key]]))
			return $this->data[$fields[$key]];
		return null;
	}
	public function __set($key,$value)
	{
		$fields = $this->getFields();
		
		if (array_key_exists($key, $fields))
			$this->data[$fields[$key]] = $value;	
	}
	public function getData()
	{
		return $this->data;
	}
	public function setModel(Model $model)
	{
		$this->model = $model;
	}
	public function serialize()
	{
		return serialize($this->data);
	}
	public function unserialize($str)
	{
		$this->data = unserialize($str);
	}
}

?>