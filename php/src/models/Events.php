<?php
class Events
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createEvent($name, $description, $date, $time, $places_available, $price, $location, $image_url, $id_org)
    {
        try {
            //Input Validations
            if (empty($name) || empty($description) || empty($date) || empty($time) || !is_numeric($places_available) || !is_numeric($price) || empty($location) || empty($image_url) || empty($id_org)) {
                return ["error" => "All fields are required and must be valid."];
            }

            $sqlRequest = "INSERT INTO events (name, description, date, time, places_available, price, location, image_url, id_org) VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $this->pdo->prepare($sqlRequest);
            if ($stmt->execute([$name, $description, $date, $time, $places_available, $price, $location, $image_url, $id_org])) {
                return ["success" => "Event created successfully"];
            }
            return ["error" => "Error creating event"];
        } catch (\Throwable $th) {
            error_log($th->getMessage()); //Error message for debugging
            return ["error" => "Something went wrong when creating the new event"]; // Return false if an error occurs
        }
    }

    public function getAllEvents()
    {
        try {
            $sqlRequest = "SELECT * FROM events";
            $stmt = $this->pdo->prepare($sqlRequest);
            $stmt->execute();
            $events = $stmt->fetchAll();
            return $events;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getAllEventsByDate()
    {
        try {
            $req =
                "SELECT events.*, organisation.nom_org AS org_name FROM events 
      JOIN organisation 
      ON events.id_org = organisation.id_org
      ORDER BY events.date ASC";
            $stmt = $this->pdo->prepare($req);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $events;
        } catch (\Throwable $th) {
            return ["error" => $th->getMessage()];
        }
    }
    public function getEventById($id_event)
    {
        try {
            $sqlRequest = "SELECT * FROM events WHERE id_event = :id_event";
            $stmt = $this->pdo->prepare($sqlRequest);
            $stmt->execute(["id_event" => $id_event]);
            $event = $stmt->fetch();
            return $event;
        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    public function deleteEvent($id_event)
    {
        try {
            $sqlRequest = "DELETE FROM events WHERE id_event = :id_event";
            $stmt = $this->pdo->prepare($sqlRequest);
            if ($stmt->execute(["id_event" => $id_event])) {
                return ["success" => "Event deleted successfully"];
            }
        } catch (\Throwable $th) {
            return ["error" => $th->getMessage()];
        }
    }

    public function editEvent($id_event, $name, $description, $date, $time, $places_available, $price, $location, $image_url, $id_org)
    {
        try {
            $sqlRequest = "UPDATE events 
            SET name = :name, 
            description = :description, 
            date = :date, time = :time, 
            places_available = :places_available, 
            price = :price, location = :location, 
            image_url = :image_url, id_org =  :id_org 
            WHERE id_event = :id_event";
            $stmt = $this->pdo->prepare($sqlRequest);
            if (
                $stmt->execute([
                    "id_event" => $id_event,
                    "name" => $name,
                    "description" => $description,
                    "date" => $date,
                    "time" => $time,
                    "places_available" => $places_available,
                    "price" => $price,
                    "location" => $location,
                    "image_url" => $image_url,
                    "id_org" => $id_org
                ])
            ) {
                return ["success" => "Event updated successfully"];
            }
            ;
        } catch (\Throwable $th) {
            return ["error" => "Database Access Error"];
        }
    }

    public function getEventsFromOrganizer($id_org)
    {
        try {
            $sqlRequest = "SELECT * FROM events WHERE id_org = :id_org";
            $stmt = $this->pdo->prepare($sqlRequest);
            $stmt->execute(["id_org" => $id_org]);
            $events = $stmt->fetchAll();
            return $events;
        } catch (\Throwable $th) {
            return ["error" => $th->getMessage()];
        }
    }

    public function deleteEventsFromOrganizer($id_org)
    {
        try {
            $sqlRequest = "DELETE FROM events WHERE id_org = :id_org";
            $stmt = $this->pdo->prepare($sqlRequest);
            if ($stmt->execute(["id_org" => $id_org])) {
                return ["success" => "Events deleted successfully"];
            }
        } catch (\Throwable $th) {
            return ["error" => $th->getMessage()];
        }
    }
}