<?php

// renders a view by invoking the right controller
function smarty_block_render($params, $content, $smarty, &$repeat)
{
	// param must contain a controller and action
	if (isset($params['controller']) && isset($params['action']))
	{
		$c = $smarty->getRegisteredObject('container');
		if ($c)
		{
			$controller = $params['controller'];
			$action = $params['action'];
			$response = $c->callController($controller, $action, $params);
			return $response->getContent();
		}
	}
}

?>