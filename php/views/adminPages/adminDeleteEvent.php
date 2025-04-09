<?php
// We check if the one accessing the page is an admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: ./?page=home');
    exit; // Stop further script execution after the redirect
}

if (isset($_GET["id_event"])) {
    $id_event = $_GET["id_event"];
} else {
    echo "Error: id_event not found";
}
$event = $eventController->getEventById($id_event);
$numberOfUsers = $reservationController->getUserNumber($id_event);

// Handling the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Handle the Delete Event Form
    if (isset($_POST["delete_event"])) {
        $deletedEvent = $eventController->deleteEvent($id_event);

        if (isset($deletedEvent)) {

            if (isset($deletedEvent['success'])) {
                $successMessage = $deletedEvent['success'];
                $_SESSION["successMessage"] = $successMessage;
                header('Location: ./?page=home');
                exit;

            } else if (isset($deletedEvent["error"])) {
                $errorMessage = $deletedEvent["error"];
            }
        }
    }

    // Handle the Delete all linked users form
    if (isset($_POST["delete_users"])) {
        $deletedUsers = $reservationController->unlinkAllFromEvent($id_event);
        if (isset($deletedUsers)) {
            if (isset($deletedUsers['success'])) {
                $successMessage = $deletedUsers['success'];
                $_SESSION["successMessage"] = $successMessage;
                header('Location: ?page=deleteEvent&id_event=' . $id_event);
                exit;
            } else if (isset($deletedUsers["error"])) {
                $errorMessage = $deletedUsers["error"];
            }
        }
    }
}
?>

<section class="delete-section">
    <h2>Are you sure you want to delete the Event: <span class="delete-warning"><?= $event["name"] ?></span></h2>
    <p>There is still : <?= $event["places_available"] ?> places available for this event and <?= $numberOfUsers ?>
        user(s) have already reserved a place.</p>

    <!-- If there are users linked to the event we display a new block to unlink them first -->
    <?php if ($numberOfUsers > 0): ?>
        <div class="delete-all-users">
            <h3>Unlink all users from this event before deleting it</h3>
            <form action="" method="post">
                <input type="hidden" name="id_event" value="<?= $id_event ?>">
                <button type="submit" name="delete_users" class="delete-button">Unlink all</button>
            </form>
        </div>
    <?php endif ?>


    <div class="delete-choices">
        <form action="" method="POST">
            <button class="delete-buttons" name="delete_event">Yes</button>
        </form>
        <a href="./?page=home">No</a>
    </div>
    <?php if (isset($errorMessage)): ?>
        <p class="error-message"><?= $errorMessage ?></p>
    <?php endif; ?>
</section>