<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plate = $_POST['plate_number'];
    $model = $_POST['model'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO cars (plate_number, model, capacity, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $plate, $model, $capacity, $status);

    if ($stmt->execute()) {
        header("Location: manage_cars.php?success=1");
        exit();
    } else {
        $error = "Failed to add car.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Car</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Add New Car</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Plate Number:</label>
      <input type="text" name="plate_number" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Model:</label>
      <input type="text" name="model" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Capacity:</label>
      <input type="number" name="capacity" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Status:</label>
      <select name="status" class="form-control">
        <option>Available</option>
        <option>On Trip</option>
        <option>Under Maintenance</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Add Car</button>
    <a href="cars.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
