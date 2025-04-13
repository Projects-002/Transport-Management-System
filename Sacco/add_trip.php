<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $route = $_POST['route'];
    $trip_date = $_POST['trip_date'];
    $trip_time = $_POST['trip_time'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO trips (route, trip_date, trip_time, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $route, $trip_date, $trip_time, $status);

    if ($stmt->execute()) {
        header("Location: manage_trips.php?success=1");
        exit();
    } else {
        $error = "Failed to add trip.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Trip</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Add New Trip</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Route:</label>
      <input type="text" name="route" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Trip Date:</label>
      <input type="date" name="trip_date" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Trip Time:</label>
      <input type="time" name="trip_time" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Status:</label>
      <select name="status" class="form-control">
        <option value="Pending">Pending</option>
        <option value="Completed">Completed</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Add Trip</button>
    <a href="manage_trips.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
