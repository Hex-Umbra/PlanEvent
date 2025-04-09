<?php
// We check if the one accessing the page is an admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: ./?page=home');
    exit; // Stop further script execution after the redirect
}


if (isset($_GET["id_org"])) {
    $id_org = $_GET["id_org"];
} else {
    $errorMessage = "Error: id_org not found";
}

$organizer = $organizationController->getOrganizationById($id_org);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST["phone"]));

    $updatedOrganizer = $organizationController->editOrganization($id_org, $name, $email, $phone);

    if (isset($updatedOrganizer["error"])) {
        $errorMessage = $updatedOrganizer["error"];
    } else if (isset($updatedOrganizer["success"])) {
        $_SESSION["successMessage"] = $updatedOrganizer['success'];
        header("Location: ./?page=allOrganizers");
        exit;
    }
}


?>

<section class="edit-section">
    <?php if(isset($errorMessage)): ?>
        <span class="error-message"><?= htmlspecialchars($errorMessage, ENT_QUOTES, "UTF-8") ?></span>
    <?php endif ?>
    <div class="edit-form">
        <form action="" method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($organizer["nom_org"], ENT_QUOTES, "UTF-8") ?>"
                required>
            <input type="text" name="email" value="<?= htmlspecialchars($organizer["email"], ENT_QUOTES, "UTF-8") ?>"
                required>
            <input type="text" name="phone" value="<?= htmlspecialchars($organizer["tel"], ENT_QUOTES, "UTF-8") ?>"
                required>
            <button class="btn-submit">Update</button>
        </form>
    </div>

</section>