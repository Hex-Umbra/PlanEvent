<?php

// We get the user ID from the email that we saved in the session
if (isset($_SESSION["email"])) {
    $user_id = $userController->getUserByEmail($_SESSION["email"]);
}

// We get the event ID from the URL
if (isset($_GET["id_event"])) {
    $id_event = intval($_GET["id_event"]);
    $event = $eventController->getEventById($id_event);
}

//First we check if the user is already linked to that specific event
if (isset($user_id)) {
    $link = $reservationController->checkLink($id_event, $user_id["id_user"]);
}
if (isset($link["success"])) {
    $alreadyLinked = $link['success'];
} else if (isset($link["error"])) {
    $notLinked = $link['error'];
}

// Logic for submitting the form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Logic for submitting the form for participation
    if (isset($_POST["register"])) {
        $result = $reservationController->linkUserToEvent($user_id["id_user"], $id_event);

        // If the user is succesfully linked to the event show some feedback
        if (isset($result['success'])) {
            $successMessage = $result['success'];
            header("Location: ?page=event&id_event=" . $id_event);
            exit();
        } else if (isset($result['error'])) {
            $errorMessage = $result["error"];
        }
        // Store the message in the session to display it
        if (isset($errorMessage)) {
            $_SESSION["errorMessage"] = $errorMessage;
        } else if (isset($successMessage))
            $_SESSION["successMessage"] = $successMessage;
    }

    //Logic for submitting the form for unregistration
    if (isset($_POST["unregister"])) {
        $result = $reservationController->unlinkUserToEvent($id_event, $user_id["id_user"], );
        // If the user is succesfully linked to the event show some feedback
        if (isset($result['success'])) {
            $successMessage = $result['success'];
            $idForRefresh = $id_event;
            header("Location: ?page=event&id_event=" . $idForRefresh);
            exit();
        } else if (isset($result['error'])) {
            $errorMessage = $result["error"];
        }
    }

}
?>

<div class="event-body">
    <div class="event-container">
        <div class="left-side">
            <img src="<?= $event["image_url"] ?>" alt="">
            <h1><?= $event["name"] ?></h1>
            <h2><?= $event["id_org"] ?></h2>
        </div>
        <div class="right-side">
            <div class="description">
                <h3>Description</h3>
                <p><?= $event["description"] ?></p>
            </div>
            <div class="details">
                <p>
                    Date: <span><?= $event["date"] ?></span>
                </p>
                <p>
                    Heure: <span><?= $event["time"] ?></span>
                </p>
                <p>
                    Adresse:<span> <?= $event["location"] ?></span>
                </p>
                <p>
                    Places Restantes: <span><?= $event["places_available"] ?></span>
                </p>
                <p>
                    Prix: <span><?= $event["price"] ?></span>
                </p>
                <!-- This whole container checks if the user is already linked to the event -->
                <div>
                    <!-- First we check if he is connected -->
                    <?php if (!isset($_SESSION["role"])): ?>
                        <p>
                            Si vous voulez participer a cet événement veuillez vous connecter
                        </p>
                        <!-- Second we check if he is already linked to the event, if not then make a button which submit a form -->
                    <?php elseif (isset($notLinked)): ?>
                        <span><?= $notLinked ?></span>
                        <form action="" method="POST">
                            <button name="register" type="submit">Participate</button>
                        </form>
                        <!-- if they are already linked to the event we make another mesage display telling them -->
                    <?php else: ?>
                        <span><?= $alreadyLinked ?></span>
                        <p>Would you like to unparticipate to this event ?</p>
                        <form action="" method="POST">
                            <button name="unregister" type="submit">Unparticipate</button>
                        </form>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

</div>