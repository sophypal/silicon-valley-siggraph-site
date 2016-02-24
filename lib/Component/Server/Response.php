<?php

namespace Component\Server;

use Component\Server\HTTPStatusCode;

class ContentType
{
	const HTML = 'text/html';
}
class Response
{
	private $content;
	private $statusCode;
	private $type;
	
	public function __construct($content, $code = HTTPStatusCode::OK, $type = ContentType::HTML)
	{
		$this->content = $content;
		$this->statusCode = $code;
		$this->type = $type;
	}
	public function getContent()
	{
		return $this->content;
	}
	public function send()
	{
		if ($this->statusCode !== HTTPStatusCode::OK)
		{
			header('HTTP/1.0 ' . $this->statusCode);
			print $this->content;
		}
		else
		{
			header('Content-type: ' . $this->type);
			print $this->content;
		}
	}
	public static function redirect($url)
	{
		header('Location: ' . $url);
		exit;
	}
}
?>