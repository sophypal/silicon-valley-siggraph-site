<?php

namespace Controllers\Web;

use Component\Controller\Controller;
use Entity\Model\EventModel;
use Entity\Model\PlaceModel;
use Entity\Model\SpeakerModel;
use Entity\Model\PhotoModel;
use Entity\Place;
use Entity\Event;
use Entity\EventPhoto;
use Component\Server\Response;

class EventController extends Controller
{
	protected function previousMonths($lastEventDate)
	{
		if (!$lastEventDate)
			$lastEventDate = time();
			
		$firstYear = (int) (date('Y', $lastEventDate));
		$endYear = (int) (date('Y', time()));
		
		$firstMonth = (int) (date('n', $lastEventDate));
		$endMonth = (int) (date('n', time()));
		
		$months = array();
		if ($firstYear == $endYear)
		{
			for ($i = $firstMonth; $i <= $endMonth; ++$i)
			{
				$date = new \DateTime(($i) . '/1/' . $firstYear);
				$months[] = $date->getTimestamp();
			}
		}
		else
		{
			$endMonth = $endMonth + 12*($endYear - $firstYear);
			for ($i = $firstMonth - 1; $i <= $endMonth; ++$i)
			{
				$year = floor($i/12);

				$month = $i - 12*$year;
					
				$date = new \DateTime(($month) . '/1/' . ($firstYear + $year));
				$months[] = $date->getTimestamp();
				//echo date_format($date, 'm Y') . '<br />';
			}
		}
		
		return $months;
	}
	public function indexAction()
	{
		$user = $this->get('security')->getUser();
		$granted = in_array('SV_OFFICER', $user->getRoles());
		$eventModel = new EventModel($this->get('container'));
		
		$viewAll = false;
		if ($user->isAuthenticated() && $granted)
			$viewAll = true;
		
		$type = ($this->get('request')->get('type')) ?  $this->get('request')->get('type') : 'next';
		$from = $this->get('request')->get('from');
		

		$futureEvents = $eventModel->getFutureEvents(0,3, $viewAll);
		$events = array();
		$lastEvent = $eventModel->getLastEvent();
		$months = $this->previousMonths($lastEvent['start_date']);
		
		if ($type == 'next')
		{
			$events = $futureEvents;
		}
		else 
		{
			if ($from)
			{
				$d = new \DateTime();
				$d->setTimestamp($from);
				$d->modify("+1 month");
				$events = $eventModel->getPastEventsFilter($from, $d->getTimestamp(), $viewAll);
			}
			else
			{
				$events = $eventModel->getPastEvents(0, 3, $viewAll);
			}
		}
		return $this->render('events.tpl', 
			array('events' => ($events) ? $events : null, 'future_events' => $futureEvents, 'months' => $months, 'type' => $type));
		
	}
	/*
	 * This action is called when viewing a single event
	 * @param integer $id, the id of the event passed from another controller
	 */
	public function viewAction($id)
	{
		$request = $this->get('request');
		$user = $this->get('security')->getUser();
		
		$eventModel = new EventModel($this->get('container'));
		if ($id)
			$event = new Event($eventModel->getEvent($id));
		else
			$event = new Event($eventModel->getEvent($request->get('id')));
		
		$event->setModel($eventModel);
		$photos = $event->getPhotos();
		$photo_array = array();
		foreach ($photos as $photo)
		{
			$photo_array[] = $photo->getData();
		}
		$granted = in_array('SV_OFFICER', $user->getRoles());
		
		if ((!$user->isAuthenticated() || !$granted) && !$event->published)
			return $this->get('view')->createNotFound();
		
		$place = $event->getPlace();
		return $this->render('event.tpl', 
			array('event' => $event->getData(), 'place' => $place->getData(), 'photos' => $photo_array));
	}
	public function editAction()
	{
		$request = $this->get('request');
		$user = $this->get('security')->getUser();
		$granted = in_array('SV_OFFICER', $user->getRoles());
		$em = $this->get('entity_manager');
		
		if ($user->isAuthenticated() && $granted)
		{
			if ($eventId = $request->get('id'))
			{
				$eventModel = new EventModel($this->get('container'));
				$placeModel = new PlaceModel($this->get('container'));
				$photoModel = new PhotoModel($this->get('container'));
				
				$event = $eventModel->findEvent($eventId);
				$event_photos = $event->getPhotos();
				$event_photo_map = array();
				
				if ($request->has('submit'))
				{		
					$event->name = $request->get('name');
					$event->startDate = strtotime($request->get('start_date'));
					$event->endDate = strtotime($request->get('end_date'));
					$event->excerpt = addslashes($request->get('excerpt'));
					$event->description = addslashes($request->get('description'));
					$event->published = ($request->get('published')) ? 1 : 0;
					$event->placeId = $request->get('place_id');
					$event->photoId = $request->get('photo');
					$em->save($event);		
					
					$place = $event->getPlace();
					$place->name = $request->get('place_name');
					$place->address = $request->get('address');
					$place->city = $request->get('city');
					$place->zip = $request->get('zip');
					$em->save($place);
					
					$request_event_photos = $request->get('photos');	
					
					// delete
					foreach ($event_photos as $photo)
					{
						$event_photo_map[$photo->id] = $photo;
						if (!$request_event_photos || !in_array($photo->id, $request_event_photos))
						{
							$event_photo = new EventPhoto();
							$event_photo->photoId = $photo->id;
							$event_photo->eventId = $event->id;
							
							$em->remove($event_photo);
						}
					}
					// add
					foreach ($request_event_photos as $rep)
					{
						if (!array_key_exists($rep, $event_photo_map)) 
						{
							$eventPhoto = new EventPhoto();
							$eventPhoto->eventId = $event->id;
							$eventPhoto->photoId = $rep;
							
							$em->save($eventPhoto, true);
						}
					}
		
					return $this->forward('event', 'view');
				}
				else 
				{
					$places = $placeModel->getAllPlaces();
					$place = $event->getPlace();
					$photos = $photoModel->getAll();
					
					foreach ($event_photos as $event_photo)
					{
						$event_photo_map[$event_photo->id] = $event_photo->getData();
					}
					return $this->render('edit_event.tpl',
						array('event' => $event->getData(), 'place' => $place->getData(), 'places' => $places, 'photos' => $photos, 'event_photos' => $event_photo_map));
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
			$eventModel = new EventModel($this->get('container'));
			$placeModel = new PlaceModel($this->get('container'));
			$photoModel = new PhotoModel($this->get('container'));
			
			$eventObj = array();
			$placeObj = array();

			$placeObj['place_id'] = $request->get('place_id');
			$placeObj['name'] = $request->get('place_name');
			$placeObj['address'] = $request->get('address');
			$placeObj['city'] = $request->get('city');
			$placeObj['state'] = $request->get('state');
			$placeObj['zip'] = $request->get('zip');
			
			$eventObj['photo_id'] = $request->get('photo');
			$eventObj['name'] = $request->get('name');
			$eventObj['start_date'] = strtotime($request->get('start_date'));
			$eventObj['end_date'] = strtotime($request->get('end_date'));
			$eventObj['excerpt'] = addslashes($request->get('excerpt'));
			$eventObj['description'] = addslashes($request->get('description'));
			$eventObj['published'] = ($request->get('published')) ? 1 : 0;
			
			$event_photos = $request->get('photos');
			
			if ($request->has('submit'))
			{
				$place = new Place($placeObj);
				if (!$place->id)
				{
					$em->save($place, true);
					$place->id = $em->insertId();
				}
				else
				{
					$em->save($place);
				}
				$event = new Event($eventObj);
				$event->placeId = $place->id;
				$em->save($event, true);
				
				$event_id = $em->insertId();
				if ($event_photos) {
					foreach ($event_photos as $photo)
					{
						$eventPhoto = new EventPhoto(array('event_id'=> $event_id, 'photo_id'=> $photo));
						$em->save($eventPhoto, true);
					}
				}
				
				return $this->forward('event', 'view', $event_id);
			}
			
			$places = $placeModel->getAllPlaces();
			$photos = $photoModel->getAll();
			return $this->render('add_event.tpl', 
				array('places_options' => $places, 'event' => $eventObj, 'place' => $placeObj, 'photos' => $photos));
		}
	}
	
	public function deleteAction()
	{
		$request = $this->get('request');
		$user = $this->get('security')->getUser();
		$granted = in_array('SV_OFFICER', $user->getRoles());
		$em = $this->get('entity_manager');
		
		$eventId = $request->get('id');
		
		if (!$granted || !$user->isAuthenticated())
			Response::redirect('index.php?action=event/view&id=' . $eventId);
		
		$eventModel = new EventModel($this->get('container'));
		$event = $eventModel->findEvent($eventId);
		if ($event)
		{
			$em->remove($event);
		}
		
		Response::redirect('index.php?action=event/index');
	}
}
