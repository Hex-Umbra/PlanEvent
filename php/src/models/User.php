<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create a new user
    public function createUser($name, $password, $email, $role): mixed
    {
        try {
            // Email validation
            $emailCheckReq = "SELECT * FROM user WHERE email = :email";
            $stmt = $this->pdo->prepare($emailCheckReq);
            $stmt->execute([":email" => $email]);
            $result = $stmt->fetch();
            if ($result) {
                return ["error" => "E-mail already in use"];
            }
            // Password Validation
            if (strlen($password) < 8) {
                return ["error" => "Password must be at least 8 characters long"];
            } else {
                //Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            }

            // Insert user into database
            $sqlRequest = "INSERT INTO user (name, email, password, role) VALUES (?,?,?,?)";
            $stmt = $this->pdo->prepare($sqlRequest);
            if ($stmt->execute([$name, $email, $hashedPassword, $role])) {
                return $stmt->rowCount();// Return the number of rows affected
            }
            return ["error" => "Failed to add the new user"]; // Return false if the query failed

        } catch (\Throwable $th) {
            error_log($th->getMessage()); //Error message for debugging
            return ["error" => "Something went wrong when creating the new user"]; // Return false if an error occurs
        }
    }

    public function checkUser($email, $password): mixed
    {
        try {
            // Email validation
            $emailCheckReq = "SELECT * FROM user WHERE email = :email";
            $stmt = $this->pdo->prepare($emailCheckReq);
            $stmt->execute([":email" => $email]);
            $user = $stmt->fetch();

            // We check if the user exists
            if (!$user || !password_verify($password, $user['password'])) {
                return ["error" => "E-mail or password incorrect"];
            }
            unset($user["password"]);
            return $user;

        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return ["error" => "Something went wrong when getting the user"];
        }
    }

    public function getAllUsers(): mixed
    {
        try {
            $sqlRequest = "SELECT * FROM user";
            $stmt = $this->pdo->prepare($sqlRequest);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return ["error" => "Something went wrong when getting all users"];
        }
    }

    public function getUserById($idUser): mixed
    {
        try {
            $sqlRequest = "SELECT * FROM user WHERE id_user = :id_user";
            $stmt = $this->pdo->prepare($sqlRequest);
            $stmt->execute([":id_user" => $idUser]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return ["error" => "Something went wrong when getting the user by id"];
        }
    }

    public function getUserByEmail($email_user){
        try {
            $sqlRequest = "SELECT id_user FROM user WHERE email = :email_user";
            $stmt = $this->pdo->prepare($sqlRequest);
            $stmt->execute([":email_user" => $email_user]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return ["error" => "Something went wrong when getting the user by id"];
        }
    }

    public function updateUser($idUser, $username, $role, $email)
    {
        try {
            //Sanitization of email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ["error" => "Invalid email format"];
            }

            //Checking if the role is valid
            $validRoles = ['admin', 'user'];
            if (!in_array($role, $validRoles)) {
                return ["error" => "Invalid role"];
            }
            //Checking if the username is valid
            if (strlen($username) < 3 || strlen($username) > 20) {
                return ["error" => "Username must be between 3 and 20 characters long"];
            }


            //Sql Request for updating the username, the role or the email
            $sqlRequest =
                "UPDATE user 
                SET name = :username, role = :role, email = :email
                WHERE id_user = :id_user";

            $stmt = $this->pdo->prepare($sqlRequest);
            if (
                $stmt->execute([
                    ":username" => $username,
                    ":role" => $role,
                    ":id_user" => $idUser,
                    ":email" => $email
                ])
            ) {
                return ["success" => "User <?= $username ?> updated successfully"];
            } else {
                return ["error" => "Something went wrong when updating the user"];
            }
            ;

        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return ["error" => "Something went wrong while connecting to the database"];
        }

    }

    public function deleteUser($idUser)
    {
        try{
            $sqlRequest = "DELETE FROM user WHERE id_user = :id_user";
            $stmt = $this->pdo->prepare($sqlRequest);
            return $stmt->execute([":id_user" => $idUser]);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return ["error" => "Something went wrong while deleting the user"];
        }
    }
}