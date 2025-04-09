<?php

require_once __DIR__ . "/../models/Events.php";

class EventsController
{

    private $eventModel;

    public function __construct($db)
    {
        $this->eventModel = new Events($db);
    }

    public function createEvent($name, $description, $date, $time, $places_available, $price, $location, $image_url, $id_org)
    {
        return $this->eventModel->createEvent($name, $description, $date, $time, $places_available, $price, $location, $image_url, $id_org);
    }

    public function getAllEvents()
    {
        return $this->eventModel->getAllEvents();
    }

    public function getAllEventsByDate(): array
    {
        return $this->eventModel->getAllEventsByDate();
    }

    public function getEventById($id){
        return $this->eventModel->getEventById($id);
    }

    public function deleteEvent($id){
        return $this->eventModel->deleteEvent($id);
    }

    public function updateEvent($id, $name, $description, $date, $time, $places_available , $price, $location, $image_url, $id_org){
        return $this->eventModel->editEvent($id, $name, $description, $date, $time, $places_available, $price, $location, $image_url, $id_org);
    }

    public function getEventsByOrg($id_org){
        return $this->eventModel->getEventsFromOrganizer($id_org);
    }

    public function deleteEventsFromOrganizer($id_org){
        return $this->eventModel->deleteEventsFromOrganizer($id_org);
    }
}