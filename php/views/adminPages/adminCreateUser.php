<?php
// We check if the one accessing the page is an admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: ./?page=home');
    exit; // Stop further script execution after the redirect
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // All fields are required and checked for validation
    $username = htmlspecialchars($_POST["username"] ?? "", ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST["email"] ?? "", FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $role = "user";

    // Add User to the database
    $newUser = $userController->createUser($username, $password, $email, $role);
    if (isset($newUser["error"])){
        $error = $newUser["error"];
    }else{
        $success = "User created successfully";
        $_SESSION["succesMessage"] = $success;
        header('Location: ./?page=allUsers');
        exit;
    }
}
?>

<section class="create-section">
    <h1>Add a new User</h1>
    <?php if (isset($error)): ?>
        <span class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></span>
    <?php endif ?>
    <div class="newUser-card">
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <button class="btn-submit">Sign up</button>
        </form>
    </div>
</section>