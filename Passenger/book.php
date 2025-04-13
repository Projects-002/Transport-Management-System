<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['passenger_id'])) {
    header("Location: login.php");
    exit;
}

$passenger_id = $_SESSION['passenger_id'];

// Handle booking request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['trip_id'])) {
    $trip_id = intval($_POST['trip_id']);

    // Check if already booked
    $check = $conn->prepare("SELECT id FROM bookings WHERE passenger_id = ? AND trip_id = ?");
    $check->bind_param("ii", $passenger_id, $trip_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows == 0) {
        // Insert booking
        $insert = $conn->prepare("INSERT INTO bookings (passenger_id, trip_id) VALUES (?, ?)");
        $insert->bind_param("ii", $passenger_id, $trip_id);
        if ($insert->execute()) {
            $_SESSION['success'] = "Trip booked successfully!";
        } else {
            $_SESSION['error'] = "Failed to book trip.";
        }
    } else {
        $_SESSION['error'] = "You already booked this trip.";
    }
    header("Location: book.php");
    exit;
}

// Fetch available trips (today or later)
$today = date("Y-m-d");
$query = "SELECT * FROM trips WHERE trip_date >= ? ORDER BY trip_date, trip_time";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $today);
$stmt->execute();
$trips = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book a Trip</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
      <h4>Available Trips</h4>
      <a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard</a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if ($trips->num_rows > 0): ?>
      <table class="table table-bordered">
        <thead class="table-secondary">
          <tr>
            <th>#</th>
            <th>Route</th>
            <th>Date</th>
            <th>Time</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while($trip = $trips->fetch_assoc()): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= $trip['route'] ?></td>
              <td><?= $trip['trip_date'] ?></td>
              <td><?= $trip['trip_time'] ?></td>
              <td>
                <form method="POST" style="display:inline;">
                  <input type="hidden" name="trip_id" value="<?= $trip['id'] ?>">
                  <button class="btn btn-sm btn-success">Book</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-info">No upcoming trips available right now.</div>
    <?php endif; ?>
  </div>
</body>
</html>
