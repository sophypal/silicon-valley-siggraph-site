<?php

use Entity\Model\PhotoModel;

function smarty_function_info($params, $smarty)
{
	$c = $smarty->getRegisteredObject('container');
	if ($c)
	{
		$model = $params['model'];
		
		switch ($model)
		{
			case 'user':
				$user = $c->get('security')->getUser();
				if ($user && $user->getEntity())
				{
					$granted = in_array('SV_OFFICER', $user->getRoles());
					$smarty->assign($params['assign'], $user->getEntity()->username);
					$smarty->assign('granted', $granted);
				}
				break;
			case 'gallery':
				$photoModel = new PhotoModel($c);
				$photos = $photoModel->getAll();
				$smarty->assign($params['assign'], $photos);
				break;
			default:
				break;
		}
	}
}