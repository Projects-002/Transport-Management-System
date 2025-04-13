<?php
session_start();
require_once '../includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM drivers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$driver = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $license = $_POST['license_number'];
    $phone = $_POST['phone'];
    $route = $_POST['assigned_route'];

    $update = $conn->prepare("UPDATE drivers SET name=?, license_number=?, phone=?, assigned_route=? WHERE id=?");
    $update->bind_param("ssssi", $name, $license, $phone, $route, $id);
    if ($update->execute()) {
        header("Location: manage_drivers.php?updated=1");
        exit();
    } else {
        $error = "Failed to update driver.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Driver</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2>Edit Driver</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Name:</label>
      <input type="text" name="name" value="<?= htmlspecialchars($driver['name']) ?>" required class="form-control">
    </div>
    <div class="mb-3">
      <label>License Number:</label>
      <input type="text" name="license_number" value="<?= htmlspecialchars($driver['license_number']) ?>" required class="form-control">
    </div>
    <div class="mb-3">
      <label>Phone:</label>
      <input type="text" name="phone" value="<?= htmlspecialchars($driver['phone']) ?>" class="form-control">
    </div>
    <div class="mb-3">
      <label>Assigned Route:</label>
      <input type="text" name="assigned_route" value="<?= htmlspecialchars($driver['assigned_route']) ?>" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update Driver</button>
    <a href="drivers.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>
