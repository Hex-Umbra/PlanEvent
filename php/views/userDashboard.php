<?php
$id_user = $userController->getUserByEmail($email);
$linkedEventsId = $reservationController->getReservations($id_user["id_user"]);



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_event = $_POST["event_id"];

    $reservationController->unlinkUserToEvent($id_event, $id_user["id_user"]);
    header("Location: ?page=userDashboard");
    exit();
}

?>

<h1>User DashBoard</h1>

<section class="dashboard-body">
    <div class="user-credentials">
        <h2>User credentials</h2>
        <div class="infos">
            <h3>Username: <span><?= $username; ?></span></h3>
            <h3>Email: <span><?= $email; ?></span></h3>
            <h3>Your ID: <span><?= $id_user["id_user"] ?></span></h3>
        </div>
    </div>
    <div class="user-linked-events">
        <h2>Linked Events</h2>
        <div class="events">
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Event Time</th>
                        <th>Event Location</th>
                        <th>Go to Page</th>
                        <th>Unparticipate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($linkedEventsId as $events): ?>
                        <?php $event = $eventController->getEventById($events["id_event"]); ?>
                        <div class="event">
                            <tr>
                                <td><?= $event["name"] ?></td>
                                <td><?= $event["date"] ?></td>
                                <td><?= $event["time"] ?></td>
                                <td><?= $event["location"] ?></td>
                                <td><a href="?page=event&id_event=<?= $event["id_event"] ?>">Click Here</a></td>
                                <td>
                                    <form action="" method="POST">
                                        <input type="hidden" name="event_id" value="<?= $event["id_event"] ?>">
                                        <button type="submit">Unparticipate</button>
                                    </form>
                                </td>
                            </tr>
                        </div>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

    </div>
</section>