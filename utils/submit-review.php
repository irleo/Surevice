<?php
require __DIR__ . '/../utils/config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    http_response_code(403);
    echo "Unauthorized";
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$booking_id = $data['booking_id'] ?? null;
$rating = $data['rating'] ?? null;
$comment = $data['comment'] ?? null;

if (!$booking_id || !$rating || $rating < 1 || $rating > 5) {
    http_response_code(400);
    echo "Invalid input";
    exit;
}

// Optional: Check if this user owns the booking
$checkSql = "SELECT customer_id FROM Bookings WHERE booking_id = ?";
$checkStmt = sqlsrv_query($conn, $checkSql, [$booking_id]);
if (!$checkStmt || ($row = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)) === false || $row['customer_id'] != $_SESSION['user_id']) {
    http_response_code(403);
    echo "Unauthorized booking";
    exit;
}

// Insert review
$sql = "INSERT INTO Reviews (booking_id, rating, comment) VALUES (?, ?, ?)";
$stmt = sqlsrv_query($conn, $sql, [$booking_id, $rating, $comment]);

if ($stmt === false) {
    http_response_code(500);
    echo "Database error";
    exit;
}


header("Location: ../user/profile.php?success=Review submitted successfully");
exit;