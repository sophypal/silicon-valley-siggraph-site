<?php

namespace Component\Server;

class Session
{
	private $session;
	
	public function __construct(&$session)
	{
		$this->session =& $session;
	}
	public function has($name)
	{
		if (isset($this->session[$name]))
			return true;
		return false;
	}
	public function get($name)
	{
		if (isset($this->session[$name]))
			return $this->session[$name];
	}
	public function set($name, $value)
	{
		$this->session[$name] = $value;
	}
	public function clear($name)
	{
		unset($this->session[$name]);
	}
}

?>