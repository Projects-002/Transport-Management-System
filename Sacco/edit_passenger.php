<?php
require_once '../includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM passengers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$passenger = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update = $conn->prepare("UPDATE passengers SET name=?, email=?, phone=? WHERE id=?");
    $update->bind_param("sssi", $name, $email, $phone, $id);

    if ($update->execute()) {
        header("Location: manage_passengers.php?updated=1");
        exit();
    } else {
        $error = "Failed to update passenger.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Passenger</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2>Edit Passenger</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Name:</label>
      <input type="text" name="name" value="<?= htmlspecialchars($passenger['name']) ?>" required class="form-control">
    </div>
    <div class="mb-3">
      <label>Email:</label>
      <input type="email" name="email" value="<?= htmlspecialchars($passenger['email']) ?>" class="form-control">
    </div>
    <div class="mb-3">
      <label>Phone:</label>
      <input type="text" name="phone" value="<?= htmlspecialchars($passenger['phone']) ?>" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update Passenger</button>
    <a href="passengers.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>
