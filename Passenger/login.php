<?php
session_start();
include '../includes/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = trim($_POST['identifier']); // email or phone

    $stmt = $conn->prepare("SELECT * FROM passengers WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $passenger = $result->fetch_assoc();
        $_SESSION['passenger_id'] = $passenger['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "No passenger found with that phone or email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Passenger Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card p-4 shadow-sm mx-auto" style="max-width: 400px;">
      <h4 class="mb-3">Passenger Login</h4>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>
      <form method="POST">
        <div class="mb-3">
          <label>Email or Phone</label>
          <input type="text" name="identifier" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
