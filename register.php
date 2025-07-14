<?php
include('includes/db.php');
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $dob      = $_POST['dob'];
    $address  = $_POST['address'];
    $remarks  = $_POST['remarks'];
    $password = $_POST['password'];
    $is_admin = isset($_POST['is_admin']) ? intval($_POST['is_admin']) : 0;

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (name, email, phone, dob, address, remarks, password, is_admin) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssssssi', $name, $email, $phone, $dob, $address, $remarks, $hashed_password, $is_admin);
    mysqli_stmt_execute($stmt);

    // ✅ Redirect after successful registration
    header("Location: login.php?registered=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register – Blushé</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <!-- Admin CSS (Blushé theme) -->
  <link rel="stylesheet" href="assets/css/genral.css" />
</head>
<body class="user-register-wrapper">


 <div class="register-card">

    <h2 class="text-center">Blushé Registration</h2>

    <form method="POST" action="">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" required />
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required />
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="text" class="form-control" id="phone" name="phone" required />
      </div>

      <div class="mb-3">
        <label for="dob" class="form-label">Date of Birth</label>
        <input type="date" class="form-control" id="dob" name="dob" required />
      </div>

      <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea class="form-control" id="address" name="address" required></textarea>
      </div>

      <div class="mb-3">
        <label for="remarks" class="form-label">Remarks</label>
        <textarea class="form-control" id="remarks" name="remarks"></textarea>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required />
      </div>

      <!-- Hidden input to register as USER (not admin) -->
      <input type="hidden" name="is_admin" value="0">

      <div class="d-grid mt-4">
        <button type="submit" class="btn-blushe w-100">Create Account</button>
      </div>
    </form>
  </div>

</body>
</html>
