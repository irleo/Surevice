<?php
session_start();
require __DIR__ . '/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$label = $_POST['label'] ?? '';
$street = $_POST['street'] ?? '';
$barangay = $_POST['barangay'] ?? '';
$city = $_POST['city'] ?? '';
$province = $_POST['province'] ?? '';
$postal_code = $_POST['postal_code'] ?? '';
$is_default = isset($_POST['is_default']) ? 1 : 0;

// If setting this as default, unset other defaults
if ($is_default) {
    sqlsrv_query($conn, "UPDATE Addresses SET is_default = 0 WHERE user_id = ?", [$user_id]);
}

$query = "INSERT INTO Addresses (user_id, label, street, barangay, city, province, postal_code, is_default)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$params = [$user_id, $label, $street, $barangay, $city, $province, $postal_code, $is_default];
sqlsrv_query($conn, $query, $params);


header("Location: ../user/bookings.php");
exit;
