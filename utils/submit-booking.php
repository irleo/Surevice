<?php
session_start();
require __DIR__ . '/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get values
$service_id = $_POST['service_id'] ?? '';
$scheduled_for_raw = $_POST['scheduled_for'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$address = trim($_POST['address'] ?? '');

// If no address is provided, fall back to saved address in Users table
if (empty($address)) {
    $query = "SELECT address FROM Users WHERE user_id = ?";
    $stmt = sqlsrv_query($conn, $query, [$user_id]);
    if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $address = $row['address'] ?? '';
    }
}

// Validate required fields
if (empty($service_id) || empty($scheduled_for_raw) || empty($payment_method) || empty($address)) {
    die("Missing required fields. <a href='javascript:history.back()'>Go Back</a>");
}

// Convert scheduled_for to SQL Server datetime format
$date = DateTime::createFromFormat('Y-m-d\TH:i', $scheduled_for_raw);
if (!$date) {
    die("Invalid date format. <a href='javascript:history.back()'>Go Back</a>");
}
$scheduled_for = $date->format('Y-m-d H:i:s');

// Insert into Bookings
$insertBooking = "
    INSERT INTO Bookings (service_id, customer_id, scheduled_for, status)
    OUTPUT INSERTED.booking_id
    VALUES (?, ?, ?, 'pending')
";

$params = [$service_id, $user_id, $scheduled_for];
$stmt = sqlsrv_query($conn, $insertBooking, $params);

if ($stmt === false) {
    die("Booking failed: " . print_r(sqlsrv_errors(), true));
}

// Fetch the inserted booking_id directly from $stmt
$booking_id = null;
if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $booking_id = $row['booking_id'];
}

if (!$booking_id) {
    die("Failed to retrieve booking ID.");
}

// Optional: Log payment info (fake example)
$fee = $_POST['service_fee'] ?? 0;
$fee = floatval($fee);
$fee_deducted = round($fee * 0.10, 2); // e.g., 10% fee
$provider_earnings = $fee - $fee_deducted;

$insertPayment = "
    INSERT INTO Payments (booking_id, amount, fee_deducted, provider_earnings, status)
    VALUES (?, ?, ?, ?, 'held')
";
sqlsrv_query($conn, $insertPayment, [$booking_id, $fee, $fee_deducted, $provider_earnings]);

header("Location: confirmation.php?booking_id=" . $booking_id);
exit;
?>
