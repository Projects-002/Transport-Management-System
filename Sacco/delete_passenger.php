<?php
require_once '../includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM passengers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: manage_passengers.php?deleted=1");
exit();
