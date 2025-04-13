<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php");
    exit;
}

$driver_id = $_SESSION['driver_id'];
$stmt = $conn->prepare("SELECT assigned_route FROM drivers WHERE id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
$driver = $result->fetch_assoc();

$route = $driver['assigned_route'];

$trip_stmt = $conn->prepare("SELECT * FROM trips WHERE route = ? ORDER BY trip_date, trip_time");
$trip_stmt->bind_param("s", $route);
$trip_stmt->execute();
$trips_result = $trip_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Trips</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="mb-4">Trips for Route: <?php echo htmlspecialchars($route); ?></h3>

    <?php if ($trips_result->num_rows > 0): ?>
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 1;
          while ($trip = $trips_result->fetch_assoc()):
          ?>
            <tr>
              <td><?= $count++ ?></td>
              <td><?= htmlspecialchars($trip['trip_date']) ?></td>
              <td><?= htmlspecialchars($trip['trip_time']) ?></td>
              <td>
                <span class="badge bg-<?php echo $trip['status'] == 'Completed' ? 'success' : 'warning'; ?>">
                  <?= $trip['status'] ?>
                </span>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-info">No trips assigned yet for this route.</div>
    <?php endif; ?>

    
  </div>
</body>
</html>
