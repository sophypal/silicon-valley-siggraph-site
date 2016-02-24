<?php

namespace Controllers\Web;

use Component\Controller\Controller;
use Component\Server\Response;
use Entity\Photo;
use Entity\Model\PhotoModel;

class AdminController extends Controller
{
	public function galleryAction()
	{
		$photoModel = new PhotoModel($this->get('container'));
		$photos = $photoModel->getAll();
		
		return $this->render('gallery.tpl', array(
			'photos' => $photos,
			'gallery_base_url' => $this->get('container')->getParameter('upload.base_url')
		));
	}
	
	public function uploadAction()
	{
		$uploadDir = $this->get('container')->getParameter('upload.dir');
		$absUploadDir = $this->get('container')->getParameter('root_dir') . $uploadDir;

		$em = $this->get('entity_manager');
		$request = $this->get('request');
		
		$file = $_FILES["file"];
		if ($file['type'] == 'image/png' || $file['type'] == 'image/jpeg')
		{
			$photo = new Photo();
			$photo->path = $file['name'];
			$photo->caption = $request->get('caption');
			$em->save($photo, true);
			
			move_uploaded_file($file['tmp_name'], $absUploadDir . $file['name']);
		}
		Response::redirect('index.php?action=Admin/gallery');
	}
	
	public function editPhotoAction()
	{
		$photoModel = new PhotoModel($this->get('container'));
		$request = $this->get('request');
		$photo = $photoModel->getById($request->get('id'));
		$em = $this->get('entity_manager');
		
		if ($request->get('submit')) {
			$photoEntity = new Photo();
			$photoEntity->id = $photo['id'];
			$photoEntity->path = $photo['path'];
			
			if ($photo && $request->get('delete')) {
				$em->remove($photoEntity);
				Response::redirect('index.php?action=Admin/gallery');
				return;
			} else if ($photo) {
				$photoEntity->caption = $request->get('caption');
				
				$em->save($photoEntity);
				Response::redirect('index.php?action=Admin/editPhoto&id='.$photo['id']);
				return;
			}
		}
		
		return $this->render('photo.tpl', array(
			'photo' => $photo,
			'gallery_base_url' => $this->get('container')->getParameter('upload.base_url')
		));
	}
}

?>