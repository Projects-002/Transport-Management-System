<?php
require_once '../includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$car = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plate = $_POST['plate_number'];
    $model = $_POST['model'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $update = $conn->prepare("UPDATE cars SET plate_number=?, model=?, capacity=?, status=? WHERE id=?");
    $update->bind_param("ssisi", $plate, $model, $capacity, $status, $id);

    if ($update->execute()) {
        header("Location: manage_cars.php?updated=1");
        exit();
    } else {
        $error = "Failed to update car.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Car</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Edit Car</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Plate Number:</label>
      <input type="text" name="plate_number" value="<?= $car['plate_number'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Model:</label>
      <input type="text" name="model" value="<?= $car['model'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Capacity:</label>
      <input type="number" name="capacity" value="<?= $car['capacity'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Status:</label>
      <select name="status" class="form-control">
        <option <?= $car['status'] === 'Available' ? 'selected' : '' ?>>Available</option>
        <option <?= $car['status'] === 'On Trip' ? 'selected' : '' ?>>On Trip</option>
        <option <?= $car['status'] === 'Under Maintenance' ? 'selected' : '' ?>>Under Maintenance</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Car</button>
    <a href="cars.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
