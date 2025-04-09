<?php
// We check if the one accessing the page is an admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: ./?page=home');
    exit; // Stop further script execution after the redirect
}
if (isset($_GET["id_user"])) {
    $id_user = $_GET["id_user"];
    //From this id we retrieve the user and unset the password
    $user = $userController->getUserById($id_user);
    unset($user["password"]);
} else {
    echo "User not found";
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $deletedUser = $userController->deleteUser($id_user);
    if(isset($deletedUser["error"])){
        echo $deletedUser["error"];
    }else{
        $successMessage = "User deleted successfully";
        $_SESSION["successMessage"] = $successMessage;
        header('Location: ./?page=allUsers');
        exit;
    }
}

?>
<section class="delete-section">
    <h2>Are you sure you want to delete the user: <span class="delete-warning"><?= $user["name"] ?></span></h2>

    <h4>With the following email: <span class="delete-warning"><?= $user["email"] ?></span></h4>

    <h4>This person is a : <span class="delete-warning"><?= $user["role"] ?></span></h4>

    <div class="delete-choices">
        <form  action="" method="POST">
            <button class="delete-buttons">Yes</button>
        </form>
            <a href="./?page=allUsers">No</a>
    </div>
</section>