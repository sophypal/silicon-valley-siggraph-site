<?php

namespace Entity;

use Component\Persist\Entity;

class News extends Entity
{
	private $fields = array(
		'id' => 'id',
		'title' => 'title',
		'userId' => 'user_id',
		'createDate' => 'create_date',
		'excerpt' => 'excerpt',
		'article' => 'article',
		'published' => 'published',
		'photoId' => 'photo_id'
	);
	public function getFields()
	{
		return $this->fields;
	}
	public function getTableName()
	{
		return 'news';
	}
	public function getPrimaryKey()
	{
		return 'id';
	}
	public function getBusinessKey()
	{
		return 'title';
	}
}
?>