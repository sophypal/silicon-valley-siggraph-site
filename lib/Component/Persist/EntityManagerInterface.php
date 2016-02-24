<?php

namespace Component\Persist;

use Component\Persist\EntityInterface;

interface EntityManagerInterface
{
	function save(EntityInterface $entity, $isNew);
	function remove(EntityInterface $entity);
	function getConnection();
	function insertId();
}

?>