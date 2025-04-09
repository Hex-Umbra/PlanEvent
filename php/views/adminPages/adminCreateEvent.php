<?php
// We check if the one accessing the page is an admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: ./?page=home');
    exit; // Stop further script execution after the redirect
}

$organizers = $organizationController->getOrganizations();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $location = $_POST["location"];
    $price = $_POST["price"];
    $places_available = $_POST["places_available"];
    $image_url = $_POST["image_url"];
    $id_org = $_POST["id_org"];

    //Adding the event to the database
    $newEvent = $eventController->createEvent($name, $description, $date, $time, $places_available, $price, $location, $image_url, $id_org);
    if (isset($newEvent["error"])) {
        $error = $newEvent["error"];
    } else {
        $success = "New Event added Successfully";
        $_SESSION["succesMessage"] = $success;
        header('Location: ./?page=home');
    }
}
?>

<section class="create-section">
    <h1>Make a new Event</h1>
    <?php if (isset($error)): ?>
        <span class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></span>
    <?php endif ?>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Name of the event" required />
        <textarea name="description" placeholder="Give the Event a brief description" autocomplete="off" required
            cols="50" rows="5"></textarea>
        <input type="date" name="date" required />
        <input type="time" name="time" min="00:00:00" max="24:00:00" required />
        <input type="text" name="location" placeholder="Location of the event" required />
        <input type="number" name="price" placeholder="Price of the event" required />
        <input type="number" name="places_available" placeholder="Number of places available" required>
        <input type="text" name="image_url" placeholder="Image URL" required />
        <select name="id_org">
            <?php foreach($organizers as $organizer):?>
                <option value="<?= $organizer["id_org"] ?>"><?= $organizer["nom_org"] ?></option>

            <?php endforeach ?>    
        </select>
        <button class="btn-submit">Add new Event</button>
    </form>
</section>