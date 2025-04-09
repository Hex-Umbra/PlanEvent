<?php

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: ./?page=home');
    exit; // Stop further script execution after the redirect
}
    ?>
<!-- Fetching data -->
<?php
$allUsers = $userController->getAllUsers();
?>
<!-- Displaying the data -->
<section class="section-body">
    <div class="table-container">
        <h1>All Users <a class="create-button" href="?page=createUser">Add a new User</a></h1>
        
        <?php if (isset($_SESSION["successMessage"])): ?>
                <span class="success-message"><?= $_SESSION["successMessage"] ?></span>
                <?php 
                unset($_SESSION["successMessage"]);
                ?>
        <?php endif ?>
        <table>
            <thead>
                <tr>
                    <th>Id n°</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Associated Events</th>
                    <th>Actions</th>
            </thead>
            <tbody>

                <?php foreach ($allUsers as $user): ?>
                    <tr>
                        <td><?= $user['id_user'] ?></td>
                        <td><?= $user["name"] ?></td>
                        <td><?= $user["email"] ?></td>
                        <td><?= $user["role"] ?></td>
                        <td></td>
                        <td>
                            <a href="?page=deleteUser&id_user=<?= $user["id_user"]?>" class="delete-button">Delete</a>
                            <a href="?page=editUser&id_user=<?= $user["id_user"] ?>" class="edit-button">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

        </table>
    </div>
    <?php if (isset($_SESSION["Message"])): ?>
        <div class="alert alert-success">
            <?= $_SESSION["Message"] ?>
        </div>
    <?php endif; ?>
</section>