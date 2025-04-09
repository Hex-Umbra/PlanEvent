<?php

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] !== "admin") {
        header('Location: ./?page=home');
    }
}
?>
<!-- Fetching Data -->
<?php
$events = $eventController->getAllEvents();

?>
<!-- Displaying the data -->
<section class="section-body">

    <div class="table-container">

        <h1>All Events <a class="create-button" href="?page=createEvent">Create New Event</a></h1>

        <div>
            <?php if (isset($_SESSION["successMessage"])): ?>
                <span class="success-message"><?= $_SESSION["successMessage"] ?></span>
                <?php
                unset($_SESSION["successMessage"]);
                ?>
            <?php endif ?>
        </div>


        <table>
            <thead>
                <tr>
                    <th>Id n°</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Places Available</th>
                    <th>Price</th>
                    <th>Organizers</th>
                    <th>Actions</th>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo $event["id_event"] ?></td>
                        <td><?php echo $event["name"] ?></td>
                        <td><?php echo $event["location"] ?></td>
                        <td><?php echo $event["date"] ?></td>
                        <td><?php echo $event["time"] ?></td>
                        <td><?php echo $event["places_available"] ?></td>
                        <td><?php echo $event["price"] . "€" ?></td>
                        <td><?php $organizer = $organizationController->getOrganizationById($event["id_org"]);
                        echo $organizer["nom_org"] ?></td>
                        <td>
                            <a href="?page=event&id_event=<?= $event["id_event"] ?>" class="special-button" >Go to Event Page</a>
                            <a href="?page=deleteEvent&id_event=<?= $event["id_event"] ?>" class="delete-button" >Delete</a>
                            <a href="?page=editEvent&id_event=<?= $event["id_event"] ?>" class="edit-button"  >Update</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>