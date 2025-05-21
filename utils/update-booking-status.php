<?php
require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? null;
    $status = $_POST['status'] ?? null;

    $valid_statuses = ['completed', 'cancelled'];

    if ($booking_id && in_array($status, $valid_statuses)) {
        $sql = "UPDATE Bookings SET status = ? WHERE booking_id = ?";
        $stmt = sqlsrv_query($conn, $sql, [$status, $booking_id]);

        if ($stmt) {
            echo "Booking updated to $status.";
        } else {
            echo "Error updating booking.";
        }
    } else {
        echo "Invalid request.";
    }
}
?>
