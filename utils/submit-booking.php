<?php
session_start();
require __DIR__ . '/config.php';  

$customer_id = $_SESSION['user_id'] ?? null;

if (!$customer_id) {
  die("User not logged in.");
}

$service_id = $_POST['service_id'];
$scheduled_for = $_POST['scheduled_for'];
$status = 'pending'; // default
$billing_address = $_POST['billingAddress']; // optionally stored elsewhere
$payment_method = $_POST['payment_method']; // optionally stored elsewhere

$sql = "INSERT INTO Bookings (service_id, customer_id, scheduled_for, status) 
        VALUES (?, ?, ?, ?)";

$params = [$service_id, $customer_id, $scheduled_for, $status];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt) {
  echo "Booking successful!";
  // Redirect or render confirmation
} else {
  echo "Booking failed.";
}
