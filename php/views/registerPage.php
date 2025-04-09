<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // All fields are required and checked for validation
  $username = htmlspecialchars($_POST["username"] ?? "", ENT_QUOTES, 'UTF-8');
  $email = filter_var($_POST["email"] ?? "", FILTER_SANITIZE_EMAIL);
  $password = $_POST["password"];
  $role = "user";

  // Add User to the database
  $newUser = $userController->createUser($username, $password, $email, $role);

  //If the controller catches an error, display it
  if (!$newUser["error"]) {
    $_SESSION["username"] = $username;
    $_SESSION["email"] = $email;
    $_SESSION["role"] = $role;
    header("Location: ./?page=home");
    exit;
  } else {
    $error = $newUser["error"];
    // If user is successfully added, add his credentials to the session
  }
}
?>


<div class="auth-body">
  <?php if (isset($error)): ?>
      <span class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></span>
  <?php endif ?>
  <div class="card">
    <h2 class="auth-h2">Create an account</h2>
    <form action="" method="POST" class="auth-form">
      <input type="text" name="username" placeholder="Username" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button class="btn-submit">Sign up</button>
    </form>
  </div>
</div>