<?php
require __DIR__ . '/config.php';
$serviceId = $_GET['id'] ?? null;

$serviceId = $_GET['id'] ?? 0;
$response = ['hasBookings' => false];

if ($serviceId) {
    $stmt = sqlsrv_query($conn, "SELECT COUNT(*) AS count FROM Bookings WHERE service_id = ?", [$serviceId]);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $response['hasBookings'] = ($row['count'] > 0);
}

header('Content-Type: application/json');
echo json_encode($response);
?>