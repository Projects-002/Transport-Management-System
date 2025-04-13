<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM staff WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['staff_id'] = $row['id'];
            $_SESSION['staff_name'] = $row['fullname'];
            header("Location: ../sacco/dashboard.php");
            exit();
        } else {
            echo "Wrong password!";
        }
    } else {
        echo "User not found!";
    }
}
?>

<!-- /auth/sacco_login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sacco Staff Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="col-md-6 offset-md-3">
      <div class="card shadow">
        <div class="card-header text-center bg-success text-white">
          <h4>Staff Login</h4>
        </div>
        <div class="card-body">
          <form action="login.php" method="POST">
            <div class="mb-3">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-success">Login</button>
            </div>
          </form>
          <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign up here</a></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
