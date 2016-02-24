<?php

namespace Controllers\Web;

use Component\Controller\Controller;
use Entity\Model\EventModel;
use Entity\Model\NewsModel;

class RootController extends Controller
{
	public function indexAction()
	{
		$user = $this->get('security')->getUser();
		$username = null;
		$roles = array();
		if ($user && $user->isAuthenticated())
		{
			$username = $user->getEntity()->username;
			$roles = $user->getRoles();
		}
			
		$eventModel = new EventModel($this->get('container'));
		$newsModel = new NewsModel($this->get('container'));
		
		$futureEvents = $eventModel->getFutureEvents(0, 3);
		$recentNews = $newsModel->getRecentNews(0, 3);
		
		return $this->render('home.tpl', 
			array('events' => $futureEvents, 'news' => $recentNews, 'user_roles' => $roles));
	}
}

?>