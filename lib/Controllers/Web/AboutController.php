<?php

namespace Controllers\Web;

use Component\Controller\Controller;

class AboutController extends Controller
{
	public function indexAction()
	{
		return $this->render('about.tpl', array());
	}
}

?>