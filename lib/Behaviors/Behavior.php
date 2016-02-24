<?php

namespace Behaviors;

use Behaviors\BehaviorInterface;

abstract class Behavior implements BehaviorInterface
{
	protected $owner;
	
	public function setOwner($owner)
	{
		$this->owner = $owner;
	}
	public function getOwner($owner)
	{
		return $this->owner;
	}
}