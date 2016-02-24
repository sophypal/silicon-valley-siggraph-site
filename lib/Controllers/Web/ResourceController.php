<?php

namespace Controllers\Web;

use Component\Controller\Controller;

class ResourceController extends Controller
{
	public function indexAction()
	{
		return $this->render('resources.tpl', array());
	}
}

?>