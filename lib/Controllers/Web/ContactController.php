<?php

namespace Controllers\Web;

use Component\Controller\Controller;

class ContactController extends Controller
{
	public function indexAction()
	{
		return $this->render('contact.tpl', array());
	}
}

?>