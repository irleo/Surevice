<?php
$sql = "
SELECT 
    b.booking_id,
    CONCAT(p.first_name, ' ', p.last_name) AS provider_name,
    CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
    b.booking_date,
    b.status,
    b.address,
    ISNULL(pay.status, 'No Payment') AS payment_status,
    ISNULL(pay.amount, 0) AS payment_amount
FROM Bookings b
JOIN Services s ON b.service_id = s.service_id
JOIN Users p ON s.provider_id = p.user_id
JOIN Users c ON b.customer_id = c.user_id
LEFT JOIN Payments pay ON b.booking_id = pay.booking_id
ORDER BY b.booking_date DESC
";

$stmt = sqlsrv_query($conn, $sql);
if (!$stmt) {
    die(print_r(sqlsrv_errors(), true));
}

$hasBookings = false;

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $hasBookings = true;

    $id = $row['booking_id'];
    $provider = htmlspecialchars($row['provider_name']);
    $customer = htmlspecialchars($row['customer_name']);
    $date = $row['booking_date']->format('Y-m-d');
    $status = ucfirst($row['status']);
    $payment = ucfirst($row['payment_status']);
    $amount = number_format($row['payment_amount'], 2);

    echo "
    <div class='booking-box'>
        <strong>Booking ID:</strong> {$id} <br>
        <strong>Provider:</strong> {$provider} <br>
        <strong>Customer:</strong> {$customer} <br>
        <strong>Date:</strong> {$date} <br>
        <strong>Status:</strong> {$status} <br>
        <strong>Payment:</strong> {$payment} ({$amount})<br><br>
        <button class='btn'>View Details</button>
        <button class='btn'>Cancel Booking</button>
    </div>
    ";
}

if (!$hasBookings) {
    echo "<p class='text-muted text-center booking-box'>No bookings yet.</p>";
}
?>
