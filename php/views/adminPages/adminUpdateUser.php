<?php
// We check if the one accessing the page is an admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: ./?page=home');
    exit; // Stop further script execution after the redirect
}

// We retrieve the id from the url
if (isset($_GET["id_user"])) {
    $id_user = $_GET["id_user"];
    //From this id we retrieve the user and unset the password
    $user = $userController->getUserById($id_user);
    unset($user["password"]);
} else {
    echo "User not found";
    exit;
}

// We check if the form is submitted for changes & if no field is left blank
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Sa
    $name = htmlspecialchars($_POST["username"]);
    $role = $_POST["role"];
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $updatedUser = $userController->updateUser($id_user, $name, $role, $email);

    if (isset($updatedUser["error"])) {
        $errorMessage = $updatedUser["error"];
    } else if (isset($updatedUser["success"])) {
        $_SESSION["successMessage"] = $updatedUser["success"];
        header("Location: ./?page=allUsers");
        exit;
    }
}
?>
<section class="edit-section">
    <div class="edit-form">
        <h1>Edit User</h1>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['name']) ?>" required>
            <label for="role">Role:</label>
            <input type="text" id="role" name="role" value="<?= htmlspecialchars($user['role']) ?>" required>
            <label for="role">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <button class="btn-submit">Submit Changes</button>
        </form>
    </div>
    <!-- Dynamically show error or success message -->
    <?php if (isset($errorMessage)): ?>
        <div class="message">
            <p class="error"><?= $errorMessage ?></p>
        </div>
    <?php endif; ?>

</section>