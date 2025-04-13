<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $license = $_POST['license_number'];
    $phone = $_POST['phone'];
    $route = $_POST['assigned_route'];

    $stmt = $conn->prepare("INSERT INTO drivers (name, license_number, phone, assigned_route) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $license, $phone, $route);

    if ($stmt->execute()) {
        header("Location: manage__driver.php?success=1");
        exit();
    } else {
        $error = "Failed to add driver.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Driver</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2>Add New Driver</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Name:</label>
      <input type="text" name="name" required class="form-control">
    </div>
    <div class="mb-3">
      <label>License Number:</label>
      <input type="text" name="license_number" required class="form-control">
    </div>
    <div class="mb-3">
      <label>Phone:</label>
      <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-3">
      <label>Assigned Route:</label>
      <input type="text" name="assigned_route" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Add Driver</button>
    <a href="drivers.php" class="btn btn-secondary">Back</a>
  </form>
</div>

</body>
</html>
