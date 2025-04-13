<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username exists
    $check = $conn->query("SELECT * FROM staff WHERE username = '$username'");
    if ($check->num_rows > 0) {
        echo "Username already exists!";
    } else {
        $sql = "INSERT INTO staff (fullname, username, password) VALUES ('$fullname', '$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!'); window.location.href='sacco_login.php';</script>";
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!-- /auth/sacco_signup.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sacco Staff Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="col-md-6 offset-md-3">
      <div class="card shadow">
        <div class="card-header text-center bg-primary text-white">
          <h4>Staff Sign Up</h4>
        </div>
        <div class="card-body">
          <form action="signup.php" method="POST">
            <div class="mb-3">
              <label>Full Name</label>
              <input type="text" name="fullname" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
          </form>
          <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
