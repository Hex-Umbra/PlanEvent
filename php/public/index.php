<?php
ob_start();
session_start();
require_once "../database/connexion.php";
require_once "../src/controllers/UserController.php";
require_once "../src/controllers/EventsController.php";
require_once "../src/controllers/OrganizationsController.php";
require_once "../src/controllers/ReservationController.php";

$userController = new UserController($pdo);
$eventController = new EventsController($pdo);
$organizationController = new OrganizationsController($pdo);
$reservationController = new ReservationController($pdo);

if (empty($_SESSION)) {
    include "../views/partials/navbar.php"; // Show regular navbar for guests
} else {
    // Check the user's role
    if ($_SESSION["role"] === 'admin') {
        include "../views/partials/adminNavbar.php"; // Show admin navbar for admins
    } else {
        include "../views/partials/navbar.php"; // Show regular navbar for other roles
    }
}

$homePage = "home.php";

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] === "admin") {
        $homePage = "adminPages//adminEvents.php";
    }
}

$myPages = [
    "home" => $homePage,
    "login" => "loginPage.php",
    "register" => "registerPage.php",
    "event" => "eventDetails.php",
    "allUsers" => "adminPages/adminUsers.php",
    "allOrganizers" => "adminPages/adminOrganizers.php",
    "editUser" => "adminPages/adminUpdateUser.php",
    "deleteUser" => "adminPages/adminDeleteUser.php",
    "createUser" => "adminPages/adminCreateUser.php",
    "createEvent" => "adminPages/adminCreateEvent.php",
    "editEvent" => "adminPages/adminUpdateEvent.php",
    "deleteEvent" => "adminPages/adminDeleteEvent.php",
    "createOrg" => "adminPages/adminCreateOrganization.php",
    "editOrg" => "adminPages/adminUpdateOrganizer.php",
    "deleteOrg" => "adminPages/adminDeleteOrganization.php",
    "userDashboard" => "userDashboard.php",
];

$page = $_GET["page"] ?? "home";
if (array_key_exists($page, $myPages)) {

    $filePath = "../views/" . $myPages[$page];

    if (file_exists($filePath)) {
        include $filePath;
    } else {
        include "../views/notFound404.php";
    }
} else {
    include "../views/notFound404.php";
}


if (empty($_SESSION)) {
    include "../views/partials/footer.php"; // Show regular navbar for guests
} else {
    // Check the user's role
    if ($_SESSION["role"] === 'user') {
        include "../views//partials/footer.php";
    }
}
?>

<link rel="stylesheet" href="./public/styles/main.css">

<?php ob_end_flush(); ?>