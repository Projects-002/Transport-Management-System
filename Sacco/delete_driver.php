<?php
session_start();
require_once '../includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM drivers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: manage_drivers.php?deleted=1");
exit();
