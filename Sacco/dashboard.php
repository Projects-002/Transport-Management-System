<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: ../../auth/sacco_login.php");
    exit();
}

$staffName = $_SESSION['staff_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sacco Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Sacco Dashboard</a>
      <div class="d-flex">
        <a href="../../auth/logout.php" class="btn btn-outline-light">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <h2 class="mb-4">Welcome, <?php echo htmlspecialchars($staffName); ?> 👋</h2>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Manage Drivers</h5>
            <p class="card-text">Add, edit, and view drivers' data.</p>
            <a href="manage_drivers.php" class="btn btn-primary">Go to Drivers</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Manage Passengers</h5>
            <p class="card-text">View and manage registered passengers.</p>
            <a href="manage_passengers.php" class="btn btn-primary">Go to Passengers</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Cars, Routes & Trips</h5>
            <p class="card-text">Assign cars, set routes, and view trip data.</p>
            <a href="manage_cars.php" class="btn btn-primary">Manage</a>
          </div>
        </div>
      </div>
    </div>

  </div>

</body>
</html>
