<?php
class Organizations
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllOrganizers()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM organisation");
            $stmt->execute();
            $organizations = $stmt->fetchAll();
            return $organizations;
        } catch (\Throwable $th) {
            return ["error" => "There was an issue fetching the organizers from the database"];
        }
    }
    public function getOrganizerById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM organisation WHERE id_org = :id ");
            $stmt->execute(["id" => $id]);
            $organizer = $stmt->fetch();
            return $organizer;
        } catch (\Throwable $th) {
            return ["error" => "There was an issue fetching the organizer from the database"];
        }
    }

    public function createOrganizer($name, $email, $number)
    {
        try {
            //Sanitization of email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ["error" => "Invalid email format"];
            }
            $stmt = $this->pdo->prepare("INSERT INTO organisation (nom_org, tel, email) VALUES (?,?,?) ");
            $stmt->execute([$name, $number, $email]);
            return ["success" => "Organizer created successfully"];
        } catch (\Throwable $th) {
            return ["error" => "There was an issue adding the organizer in the database"];
        }
    }

    public function deleteOrganizer($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM organisation WHERE id_org = :id ");
            $stmt->execute(["id" => $id]);
            return ["success" => "Organizer deleted successfully"];
        } catch (\Throwable $th) {
            return ["error" => $th->getMessage()];
        }
    }

    public function updateOrganizer($id, $name, $email, $number)
    {
        try {
            //Sanitization of email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ["error" => "Invalid email format"];
            }
            $sqlRequest = "UPDATE organisation SET nom_org = :name, email = :email, tel = :number WHERE id_org = :id";
            $stmt = $this->pdo->prepare($sqlRequest);

            if (
                $stmt->execute([
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                    "number" => $number
                ])
            ) {
                return ["success" => "Organizer updated successfully"];

            } else {
                return ["error" => "There was an issue updating the organizer"];
            }

        } catch (\Throwable $th) {
            return ["error" => $th];
        }
    }

    public function getNumberOfEvents($id_org)
    {
        try {
            $sqlRequest = "SELECT COUNT(id_event) AS event_count FROM events WHERE id_org = :id_org";
            $stmt = $this->pdo->prepare($sqlRequest);
            $stmt->execute(["id_org" => $id_org]);
            if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $eventCount = $result["event_count"];
                return $eventCount;
            }
        } catch (\Throwable $th) {
            return ["error" => $th->getMessage()];
        }
    }
}