<?php
// We check if the one accessing the page is an admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: ./?page=home');
    exit; // Stop further script execution after the redirect
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    //Adding the event to the database

    $newOrganizer = $organizationController->createOrganization($name, $phone, $email);
    if (isset($newOrganizer["error"])) {
        $error = $newOrganizer["error"];
    } else {
        $success = "New Organizer <?= $name ?> added Successfully";
        $_SESSION["succesMessage"] = $success;
        header('Location: ./?page=allOrganizers');
        exit;
    }
}
?>

<section class="create-section">
    <h1>Make a new Organizer</h1>
    <?php if (isset($error)): ?>
        <span class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></span>
    <?php endif ?>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Name of the Organizer" required />
        <input type="email" name="email" placeholder="E-mail of the Organizer" required>
        <input type="text" name="phone" placeholder="Phone number" >
        <button class="btn-submit">Add new Organizer</button>
    </form>
</section>