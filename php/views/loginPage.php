<?php

//Receive data from the form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Filtering data
  $email = filter_var($_POST["email"] ?? "", FILTER_SANITIZE_EMAIL);
  $password = $_POST["password"] ?? "";

  // Validate the data
  $user = $userController->checkUser($email, $password);

  // Check for errors or successful user retrieval
  if (isset($user["error"])) {
    $error = $user["error"];    // If there is an error, store it in a variable to display later
  } elseif (is_array($user)) {
    // If the user exists and the password is correct, we start a session
    $_SESSION['username'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    // Redirect to the home page
    header('Location: ./?page=home');
    exit;
  }
}
?>

<div class="auth-body">
  <div class="card">
    <h2 class="auth-h2">Connection</h2>
    <form action="" method="POST" class="auth-form">
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <!-- Display the error message dynamically if one was caught -->
      <?php if (isset($error)): ?>
        <span class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></span>
      <?php endif ?>
      <button class="btn-submit">Sign in</button>
    </form>
  </div>
</div>