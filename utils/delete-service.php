<?php
session_start();
require __DIR__ . '/config.php';

$serviceId = $_GET['id'] ?? null;

if (!$serviceId) {
    echo "Missing service ID.";
    exit;
}

// Start a transaction (optional but safer)
sqlsrv_begin_transaction($conn);

// Delete linked categories
sqlsrv_query($conn, "DELETE FROM ServiceCategoryLink WHERE service_id = ?", [$serviceId]);

// Delete linked images
sqlsrv_query($conn, "DELETE FROM ServiceImages WHERE service_id = ?", [$serviceId]);

// Now delete the service
$sql = "DELETE FROM Services WHERE service_id = ?";
$params = [$serviceId];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt) {
    sqlsrv_commit($conn);  // commit transaction
    echo "Service deleted successfully.";
} else {
    sqlsrv_rollback($conn); // rollback transaction
    $errors = sqlsrv_errors();
    echo "Error deleting service: <pre>" . print_r($errors, true) . "</pre>";
}
?>
