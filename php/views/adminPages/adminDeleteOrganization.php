<?php
// We check if the one accessing the page is an admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: ./?page=home');
    exit; // Stop further script execution after the redirect
}

if (isset($_GET["id_org"])) {
    $id_org = $_GET["id_org"];
} else {
    echo "Error: id_org not found";
}
$organizer = $organizationController->getOrganizationById($id_org);
$numberOfEvents = $organizationController->getNumberOfEvents($id_org);
$linkedEvents = $eventController->getEventsByOrg($id_org);
$numberUserForEvents = [];
foreach ($linkedEvents as $event) {
    $numberUserForEvents[$event["id_event"]] = $reservationController->getUserNumber($event["id_event"]);
}
var_dump($numberUserForEvents);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Form handler for organizer Deletion
    if (isset($_POST["delete_organizer"])) {
        $deletedOrganizer = $organizationController->deleteOrganization($id_org);
        if (isset($deletedOrganizer)) {
            if (isset($deletedOrganizer["success"])) {
                $successMessage = $deletedOrganizer["success"];
                $_SESSION["successMessage"] = $successMessage;
                header('Location: ./?page=allOrganizers');
                exit;
            } else if ($deletedOrganizer) {
                $errorMessage = $deletedOrganizer["error"];
            }
        }
    }
    if (isset($_POST["delete_events"])) {
        $deletedEvents = $eventController->deleteEventsFromOrganizer($id_org);
        if (isset($deletedEvents)) {
            if (isset($deletedEvents["success"])) {
                $successMessage = $deletedEvents["success"];
                $_SESSION["successMessage"] = $successMessage;
                header('Location: ?page=deleteOrg&id_event=' . $id_org);
                exit;
            } else if ($deletedEvents) {
                $errorMessage = $deletedEvents["error"];
            }
        }
    }

}
?>

<section class="delete-section">
    <h2>Are you sure you want to delete the Organizer: <div class="delete-warning"><?= $organizer["nom_org"] ?></>
    </h2>
    <?php if (isset($linkedEvents)): ?>
        <p>This organizer still has <?= $numberOfEvents ?> events linked to it:</p>
        <ul>

            <?php foreach ($linkedEvents as $event): ?>
                <?php
                $numberUserForEvents[$event["id_event"]] = $reservationController->getUserNumber($event["id_event"]);
                ?>
                <li class="info-events">
                    <span><?= $event["name"] ?></span> has
                    <span><?= $numberUserForEvents[$event["id_event"]] ?></span> users.
                    <a href="?page=deleteEvent&id_event=<?= $event["id_event"] ?>">Go to delete page</a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <div class="delete-choices">

        <!-- Warning if there are still events linked to the organizer -->
        <?php if ($numberOfEvents === 0): ?>
            <span>You can safely delete this organizer</span>
            <!-- Form that handles the deletion of the organizer -->
            <form action="" method="POST">
                <button class="delete-buttons" name="delete_organizer">Yes</button>
            </form>
        <?php elseif ($numberOfEvents > 0): ?>
            <span class="warning">You cannot delete this Organizer unless you delete the related events first</span>
            <!-- Form that handles the deletion of the events related to the organizer -->
            <form action="" method="post">
                <input type="hidden" value="<?= $id_org ?>" name="id_org">
                <button class="delete-buttons" name="delete_events">Delete Linked Events</button>
            </form>
        <?php endif; ?>
        <div>
            <a href="./?page=allOrganizers">No</a>
        </div>
    </div>
    <?php if (isset($errorMessage)): ?>
        <div class="error-message">
            <?= "You cannot delete these events here while one of them still has users registered. Please delete the specific event first." ?>
        </div>
    <?php endif; ?>
</section>