<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../includes/db.php';

$sql = "SELECT * FROM cars";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Cars</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="d-flex justify-content-between mb-3">
    <h2>Manage Cars</h2>
    <a href="add_car.php" class="btn btn-success">+ Add Car</a>
  </div>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Plate Number</th>
        <th>Model</th>
        <th>Capacity</th>
        <th>Status</th>
        <th>Registered At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['plate_number']) ?></td>
            <td><?= htmlspecialchars($row['model']) ?></td>
            <td><?= $row['capacity'] ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= $row['registered_at'] ?></td>
            <td>
              <a href="edit_car.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
              <a href="delete_car.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this car?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7" class="text-center">No cars found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
