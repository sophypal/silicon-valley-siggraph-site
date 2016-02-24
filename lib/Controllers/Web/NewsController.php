<?php

namespace Controllers\Web;

use Component\Controller\Controller;
use Entity\Model\NewsModel;
use Entity\Model\PhotoModel;
use Entity\News;

class NewsController extends Controller
{
	public function viewAction($id)
	{
		$request = $this->get('request');
		$user = $this->get('security')->getUser();
		
		$newsModel = new NewsModel($this->get('container'));
		if ($id)
			$news = $newsModel->getById($id);
		else
			$news = $newsModel->getById($request->get('id'));
		
		
		return $this->render('news.tpl', 
			array('news' => $news));
	}
	public function editAction()
	{
		$request = $this->get('request');
		$user = $this->get('security')->getUser();
		$granted = in_array('SV_OFFICER', $user->getRoles());
		$em = $this->get('entity_manager');
		
		if ($user->isAuthenticated() && $granted)
		{
			if ($newsId = $request->get('id'))
			{
				$newsModel = new NewsModel($this->get('container'));
				$photoModel = new PhotoModel($this->get('container'));
				if ($request->has('submit'))
				{
					$news = new News($newsModel->getById($newsId));
					$news->photoId = $request->get('photo');
					$news->title = addslashes($request->get('title'));
					$news->excerpt = addslashes($request->get('excerpt'));
					$news->article = addslashes($request->get('article'));
					$news->published = ($request->get('published')) ? 1 : 0;
					$em->save($news);
					
					return $this->forward('news', 'view');
				}
				else
				{
					$news = $newsModel->getById($newsId);
					$photos = $photoModel->getAll();
					
					return $this->render('edit_news.tpl', array('news' => $news, 'photos' => $photos));
				}
			}
		}
	}
	public function addAction()
	{
		$request = $this->get('request');
		$user = $this->get('security')->getUser();
		$granted = in_array('SV_OFFICER', $user->getRoles());
		$em = $this->get('entity_manager');
		
		if ($user->isAuthenticated() && $granted)
		{
			$newsModel = new NewsModel($this->get('container'));
			$photoModel = new PhotoModel($this->get('container'));
			$news = new News;
			
			$news->photoId = $request->get('photo');
			$news->title = addslashes($request->get('title'));
			$news->createDate = time();
			$news->excerpt = addslashes($request->get('excerpt'));
            $news->article = addslashes($request->get('article'));
            $news->userId = $user->getEntity()->id;
			$news->published = ($request->get('published')) ? 1 : 0;
			
			if ($request->has('submit'))
			{
				$em->save($news);
				
				return $this->forward('news', 'view', $em->insertId());
			}
			$photos = $photoModel->getAll();
			return $this->render('add_news.tpl', array('news' => $news->getData(), 'photos' => $photos));
		}
	}
}
