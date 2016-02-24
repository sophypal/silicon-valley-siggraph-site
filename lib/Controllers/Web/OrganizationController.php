<?php

namespace Controllers\Web;

use Component\Controller\Controller;

class OrganizationController extends Controller
{
	public function indexAction()
	{
		return $this->render('organizations.tpl', array());
	}
}

?>