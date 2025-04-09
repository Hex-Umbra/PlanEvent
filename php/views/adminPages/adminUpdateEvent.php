<?php
// We check if the one accessing the page is an admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: ./?page=home');
    exit; // Stop further script execution after the redirect
}

if (isset($_GET["id_event"])) {
    $id_event = $_GET["id_event"];
}

$event = $eventController->getEventById($id_event);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // We check if the form has been submitted
    $name = $_POST["name"];
    $description = $_POST["description"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $places_available = $_POST["places_available"];
    $price = $_POST["price"];
    $location = $_POST["location"];
    $image_url = $_POST["image_url"];
    $id_org = $_POST["id_org"];

    $updatedEvent = $eventController->updateEvent($id_event, $name, $description, $date, $time, $places_available, $price, $location, $image_url, $id_org);

    if (isset($updatedEvent["error"])) {
        $error = $updatedEvent["error"];
    } else if (isset($updatedEvent["success"])) {
        $_SESSION["successMessage"] = $updatedEvent["success"];
        header("Location: ./?page=home");
        exit;
    }

}

?>

<section class="edit-section">
    <?php if (isset($error)): ?>
        <span class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></span>
    <?php endif ?>
    <div class="edit-form">
        <h1>Edit event</h1>
        <form action="" method="POST">
            <input type="text" name="name" value="<?= $event["name"] ?>" required />
            <textarea name="description" required cols="50" rows="5"
                maxlength="255"><?= $event["description"] ?></textarea>
            <input type="date" name="date" value="<?= $event["date"] ?>" required />
            <input type="time" name="time" value="<?= $event["time"] ?>" required />
            <input type="text" name="location" value="<?= $event["location"] ?>" required />
            <input type="number" name="price" value="<?= $event["price"] ?>" required />
            <input type="number" name="places_available" value="<?= $event["places_available"] ?>" required>
            <input type="text" name="image_url" value="<?= $event["image_url"] ?>" required />
            <select name="id_org">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <button class="btn-submit">Edit Event</button>
        </form>
    </div>
    <?php if (isset($errorMessage)): ?>
        <div class="error-message">
            <?= $errorMessage ?>
        </div>
    <?php endif ?>

</section>