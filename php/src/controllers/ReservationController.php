<?php

require_once __DIR__ . "/../models/Reservation.php";

class ReservationController
{
    private $reservationModel;

    public function __construct($db)
    {
        $this->reservationModel = new Reservation($db);
    }

    public function linkUserToEvent($id_user, $id_event){
       return $this->reservationModel->linkUserToEvent($id_event, $id_user);
    }

    public function checkLink($id_event, $id_user){
        return $this->reservationModel->checkLink($id_event, $id_user);
    }

    public function unlinkUserToEvent($id_event, $id_user){
        return $this->reservationModel->unlinkUserToEvent($id_event, $id_user);
    }

    public function getReservations($id_user){
        return $this->reservationModel->getLinkedEvents($id_user);
    }

    public function getUserNumber($id_event){
        return $this->reservationModel->getLinkedUsers($id_event);
    }

    public function unlinkAllFromEvent($id_event){
        return $this->reservationModel->unlinkAllFromEvent($id_event);
    }
}