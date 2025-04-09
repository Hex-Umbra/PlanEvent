<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/styles/main.css">
    <link rel="stylesheet" href="./public/styles/adminNavbar.css">
    <link rel="stylesheet" href="./public/styles/adminTables.css">
    <link rel="stylesheet" href="./public/styles/adminUpdate.css">
    <link rel="stylesheet" href="./public/styles/adminDelete.css">
    <link rel="stylesheet" href="./public/styles/adminCreate.css">
    <title>Admin Panel</title>
    <link rel="icon" href="public/assets/images/bird_logo.svg">
</head>

<?php
$active_page = isset($_GET["page"]) ? $_GET["page"] : "home";
?>

<body>
    <nav class="sidebar">
        <h1>Navigation</h1>
        <a href="./?page=allUsers" class='<?php echo $active_page === "allUsers" ? "active1" : "" ?>'> <img src="./public/assets/images/arrow_right.svg">See all users</a>
        <a href="./?page=home" class='<?php echo $active_page === "home" ? "active1" : "" ?>'> <img src="./public/assets/images/arrow_right.svg">See all events</a>
        <a href="./?page=allOrganizers" class='<?php echo $active_page === "allOrganizers" ? "active1" : "" ?>'> <img src="./public/assets/images/arrow_right.svg">See all organizers</a>
        <form class="form-logout" action="./src/auth/logout.php" method="POST">
            <input type="submit" value="Déconnexion">
        </form>
    </nav>
</body>

</html>