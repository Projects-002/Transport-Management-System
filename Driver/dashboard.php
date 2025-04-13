<!-- driver/dashboard.php -->
<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php");
    exit;
}

$driver_id = $_SESSION['driver_id'];
$stmt = $conn->prepare("SELECT * FROM drivers WHERE id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
$driver = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Driver Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Driver Dashboard</a>
      <div class="d-flex">
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title mb-3">Welcome, <?php echo htmlspecialchars($driver['name']); ?> 👋</h4>
        <p><strong>License Number:</strong> <?php echo htmlspecialchars($driver['license_number']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($driver['phone']); ?></p>
        <p><strong>Assigned Route:</strong> <?php echo htmlspecialchars($driver['assigned_route']); ?></p>
        <hr>
        <a href="trips.php" class="btn btn-primary">View My Trips</a>
      </div>
    </div>
  </div>
</body>
</html>
