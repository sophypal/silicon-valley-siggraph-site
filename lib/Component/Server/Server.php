<?php

namespace Component\Server;

class Server
{
	private $server;
	
	public function __construct($server)
	{
		$this->server = $server;
	}
	public function has($name)
	{
		if (isset($this->server[$name]))
			return true;
		return false;
	}
	public function get($name)
	{
		if (isset($this->server[$name]))
			return $this->server[$name];
	}
	public function set($name, $value)
	{
		$this->server[$name] = $value;
	}
	public function getPrefix()
	{
		if (isset($this->server['HTTPS'])) {
        	return 'https://' . $this->server['SERVER_NAME'] . (($this->server['SERVER_PORT'] == 80 || $this->server['SERVER_PORT'] == 443 ) ? '' : ':' . $this->server['SERVER_PORT']);
		} else {
        	return 'http://' . $this->server['SERVER_NAME'] . (($this->server['SERVER_PORT'] == 80) ? '' : ':' . $this->server['SERVER_PORT']);
		}
	}
}

?>