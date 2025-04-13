<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO passengers (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);

    if ($stmt->execute()) {
        header("Location: manage_passengers.php?success=1");
        exit();
    } else {
        $error = "Failed to add passenger.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Passenger</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2>Add New Passenger</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label>Name:</label>
      <input type="text" name="name" required class="form-control">
    </div>
    <div class="mb-3">
      <label>Email:</label>
      <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
      <label>Phone:</label>
      <input type="text" name="phone" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Add Passenger</button>
    <a href="passengers.php" class="btn btn-secondary">Back</a>
  </form>
</div>

</body>
</html>
