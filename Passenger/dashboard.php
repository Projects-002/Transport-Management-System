<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['passenger_id'])) {
    header("Location: login.php");
    exit;
}

$passenger_id = $_SESSION['passenger_id'];

// Fetch passenger info
$psg = $conn->prepare("SELECT name FROM passengers WHERE id = ?");
$psg->bind_param("i", $passenger_id);
$psg->execute();
$psg_result = $psg->get_result();
$passenger = $psg_result->fetch_assoc();

// Fetch bookings
$query = "
SELECT b.id AS booking_id, t.route, t.trip_date, t.trip_time, b.status 
FROM bookings b 
JOIN trips t ON b.trip_id = t.id 
WHERE b.passenger_id = ? 
ORDER BY t.trip_date, t.trip_time
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $passenger_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Passenger Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4>Welcome, <?= htmlspecialchars($passenger['name']) ?>!</h4>
      <div>
        <a href="book.php" class="btn btn-primary btn-sm">Book a Trip</a>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
      </div>
    </div>

    <h5>Your Booked Trips</h5>

    <?php if ($result->num_rows > 0): ?>
      <table class="table table-bordered">
        <thead class="table-secondary">
          <tr>
            <th>#</th>
            <th>Route</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= $row['route'] ?></td>
              <td><?= $row['trip_date'] ?></td>
              <td><?= $row['trip_time'] ?></td>
              <td><span class="badge bg-<?= $row['status'] == 'Booked' ? 'success' : 'secondary' ?>"><?= $row['status'] ?></span></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-info">You haven’t booked any trips yet.</div>
    <?php endif; ?>
  </div>
</body>
</html>
