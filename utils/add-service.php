<?php
session_start();
require __DIR__ . '/../utils/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'provider') {
    http_response_code(403);
    echo 'Unauthorized';
    exit;
}

$provider_id = $_SESSION['user_id'];

// Get inputs
$title = $_POST['title'];
$description = $_POST['description'];
$amount = $_POST['amount'];
$categories = $_POST['categories']; // array
$primary_index = intval($_POST['primary_index']) - 1;


// Find or create customer
$sql = "SELECT user_id FROM Users WHERE CONCAT(first_name, ' ', last_name) = ?";
$stmt = sqlsrv_query($conn, $sql, [$customer_name]);
if ($stmt === false) die(print_r(sqlsrv_errors(), true));

if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $customer_id = $row['user_id'];
} else {
    die("Customer not found.");
}

// Insert dummy service (you can adapt this to use an existing one)
$service_sql = "
  INSERT INTO Services (provider_id, title, description, service_fee)
  VALUES (?, ?, ?, ?);
  SELECT SCOPE_IDENTITY() AS service_id;
";
$service_stmt = sqlsrv_query($conn, $service_sql, [$provider_id, $category, '', $amount]);
if ($service_stmt === false) die(print_r(sqlsrv_errors(), true));
$service_id = sqlsrv_fetch_array($service_stmt, SQLSRV_FETCH_ASSOC)['service_id'];

// Insert Booking
$booking_sql = "
  INSERT INTO Bookings (service_id, customer_id, scheduled_for, status)
  VALUES (?, ?, ?, 'pending');
  SELECT SCOPE_IDENTITY() AS booking_id;
";
$booking_stmt = sqlsrv_query($conn, $booking_sql, [$service_id, $customer_id, $datetime]);
if ($booking_stmt === false) die(print_r(sqlsrv_errors(), true));
$booking_id = sqlsrv_fetch_array($booking_stmt, SQLSRV_FETCH_ASSOC)['booking_id'];

// Insert Payment
$payment_sql = "
  INSERT INTO Payments (booking_id, amount, fee_deducted, provider_earnings, status)
  VALUES (?, ?, 0.00, ?, 'held');
";
$payment_stmt = sqlsrv_query($conn, $payment_sql, [$booking_id, $amount, $amount]);
if ($payment_stmt === false) die(print_r(sqlsrv_errors(), true));

// Handle uploaded images
$upload_dir = "../uploads/services/";
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

foreach ($_FILES['images']['tmp_name'] as $index => $tmp_path) {
    $filename = uniqid() . "_" . basename($_FILES['images']['name'][$index]);
    $target_path = $upload_dir . $filename;
    $is_primary = ($index === $primary_index) ? 1 : 0;

    if (move_uploaded_file($tmp_path, $target_path)) {
        $image_sql = "INSERT INTO ServiceImages (service_id, image_path, is_primary) VALUES (?, ?, ?)";
        $image_stmt = sqlsrv_query($conn, $image_sql, [$service_id, $filename, $is_primary]);
        if ($image_stmt === false) die(print_r(sqlsrv_errors(), true));
    }
}

echo "success";
?>
