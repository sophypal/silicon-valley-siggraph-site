<?php

namespace Component\Persist;

interface EntityInterface
{
	/* returns the fieldmap of supported fields in the database */
	function getFields();
	function getTableName();
	function getPrimaryKey();
	function getBusinessKey();
	
	function __get($key);
	function __set($key,$value);
}