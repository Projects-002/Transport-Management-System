<!-- driver/login.php -->
<?php
session_start();
include '../includes/db.php'; // adjust if different path

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $license = $_POST['license_number'];

    $stmt = $conn->prepare("SELECT * FROM drivers WHERE license_number = ?");
    $stmt->bind_param("s", $license);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $driver = $result->fetch_assoc();
        $_SESSION['driver_id'] = $driver['id'];
        $_SESSION['driver_name'] = $driver['name'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid license number";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Driver Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="col-md-4 offset-md-4">
      <h3 class="text-center mb-4">Driver Login</h3>
      <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">License Number</label>
          <input type="text" name="license_number" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
