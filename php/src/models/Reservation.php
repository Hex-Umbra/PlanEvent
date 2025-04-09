<?php

class Reservation
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function linkUserToEvent($id_event, $id_user)
    {
        if (!is_numeric($id_event) || !is_numeric($id_user)) {
            return ["error" => "Invalid input. Event ID and User ID must be numeric."];
        }


        try {
            //First we check if there are still places available in the event
            $checkPlaces =
                "SELECT events.places_available
                FROM events
                 WHERE events.id_event = :id_event";
            $stmt = $this->pdo->prepare($checkPlaces);
            $stmt->execute([":id_event" => $id_event]);
            $places = $stmt->fetchColumn();
            if ($places <= 0) {
                return ["error" => "Sorry but it seems like there are no places available"];
            } else {
                // We insert the user and the event he is participating into
                $sqlRequest = "INSERT INTO inscrire (id_user, id_event) VALUES (?,?)";
                $stmt = $this->pdo->prepare($sqlRequest);
                if ($stmt->execute([$id_user, $id_event])) {
                    //We reduce the number of places available for the event
                    $reducePlaceRequest =
                        "UPDATE events 
                        SET places_available = places_available - 1
                        WHERE id_event = :id_event";
                    $stmt = $this->pdo->prepare($reducePlaceRequest);
                    $stmt->execute(["id_event" => $id_event]);
                    return ["success" => "You have successfully reserved a place to the event"];
                } else
                    return ["error" => "An error occurred while trying to reserve a place"];
            }
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return ["error" => $th->getMessage()];
        }

    }

    public function checkLink($id_event, $id_user)
    {
        try {
            $checkLink = "SELECT * FROM inscrire WHERE id_event = :id_event AND id_user = :id_user ";
            $stmt = $this->pdo->prepare($checkLink);
            $stmt->execute([":id_event" => $id_event, ":id_user" => $id_user]);
            $result = $stmt->fetch();
            if ($result) {
                return ["success" => "You are already linked to this event"];
            } else {
                return ["error" => "You are not linked to this event would you like to do it?"];
            }
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return ["error" => "An unexpected error occurred. Please try again later."];
        }
    }

    public function unlinkUserToEvent($id_event, $id_user)
    {
        try {
            $sqlRequest = "DELETE FROM inscrire WHERE id_event = :id_event AND id_user = :id_user ";
            $stmt = $this->pdo->prepare($sqlRequest);
            if ($stmt->execute([":id_event" => $id_event, ":id_user" => $id_user])) {
                $reducePlaceRequest =
                    "UPDATE events 
                    SET places_available = places_available + 1
                    WHERE id_event = :id_event";
                $stmt = $this->pdo->prepare($reducePlaceRequest);
                $stmt->execute(["id_event" => $id_event]);

            }

            return ["success" => "You have successfully unlinked from the event"];
        } catch (\Throwable $th) {
            return ["error" => $th->getMessage()];
        }
    }

    public function getLinkedEvents($id_user)
    {
        try {
            $sqlRequest = "SELECT id_event FROM inscrire WHERE id_user = :id_user";
            $stmt = $this->pdo->prepare($sqlRequest);
            $stmt->execute(["id_user" => $id_user]);
            $result = $stmt->fetchAll();
            return $result;
        } catch (\Throwable $th) {
            return ["error" => $th->getMessage()];
        }
    }

    public function getLinkedUsers($id_event)
    {
        try {
            $sqlRequest = "SELECT COUNT(id_user) AS user_count FROM inscrire WHERE id_event = :id_event";
            $stmt = $this->pdo->prepare($sqlRequest);
            $stmt->execute(["id_event" => $id_event]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $userCount = $result["user_count"];
            return $userCount;
        } catch (\Throwable $th) {
            return ["error" => $th->getMessage()];
        }
    }

    public function unlinkAllFromEvent($id_event){
        try {
            $sqlRequest = "DELETE FROM inscrire WHERE id_event = :id_event";
            $stmt = $this->pdo->prepare($sqlRequest);
            $stmt->execute(["id_event" => $id_event]);
            return ["success" => "You have successfully unlinked all users from the event"];
        } catch (\Throwable $th) {
            return ["error" => $th->getMessage()];
        }
    }
}