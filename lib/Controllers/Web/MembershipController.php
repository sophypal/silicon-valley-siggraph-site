<?php

namespace Controllers\Web;

use Component\Controller\Controller;

class MembershipController extends Controller
{
	public function indexAction()
	{
		return $this->render('membership.tpl', array());
	}
}

?>