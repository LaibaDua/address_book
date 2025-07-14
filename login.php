<?php
session_start();
include(__DIR__ . '/includes/db.php');

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Set session for both roles
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_admin'] = $user['is_admin'];

        // Redirect based on role
        if ($user['is_admin'] == 1) {
            header("Location: admin/admin_index.php");
        } else {
            header("Location: user/index.php");
        }
        exit();
    } else {
        $login_error = "Invalid login credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blushé Login</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Blushé General CSS -->
  <link rel="stylesheet" href="assets/css/genral.css" />
</head>
<center
<body class="admin-wrapper">
  

  <div class="register-card">
    <h2 class="text-center">Login to Blushé</h2>

    <?php if ($login_error): ?>
      <div class="alert alert-danger text-center"><?= $login_error ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" id="email" required />
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" required />
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn-blushe w-100">Log In</button>

        <a href="register.php" class="btn btn-link">Don't have an account? Register</a>
      </div>
    </form>
  </div>

</body>

</html>
