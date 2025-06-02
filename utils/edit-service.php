<?php
session_start();
require __DIR__ . '/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceId = $_POST['service_id'] ?? null;
    $title = trim($_POST['editServiceTitle'] ?? '');
    $description = trim($_POST['editServiceDescription'] ?? '');
    $fee = floatval($_POST['editAmount'] ?? 0);
    $categoryNames = $_POST['serviceType'] ?? [];


    if (!$serviceId || !$title || $fee <= 0) {
        echo "Missing or invalid required fields.";
        exit;
    }

    // Update the service info
    $sql = "UPDATE Services SET title = ?, description = ?, service_fee = ? WHERE service_id = ?";
    $params = [$title, $description, $fee, $serviceId];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if (!$stmt) {
        echo "Failed to update service.<br>";
        print_r(sqlsrv_errors());
        exit;
    }

    // Remove existing category links
    $delete = "DELETE FROM ServiceCategoryLink WHERE service_id = ?";
    sqlsrv_query($conn, $delete, [$serviceId]);

    // Re-insert selected categories
    foreach ($categoryNames as $catName) {
        // Get category_id from category name
        $catQuery = "SELECT category_id FROM Categories WHERE name = ?";
        $catStmt = sqlsrv_query($conn, $catQuery, [$catName]);
        $catRow = sqlsrv_fetch_array($catStmt, SQLSRV_FETCH_ASSOC);

        if ($catRow) {
            $catId = $catRow['category_id'];
            $insert = "INSERT INTO ServiceCategoryLink (service_id, category_id) VALUES (?, ?)";
            sqlsrv_query($conn, $insert, [$serviceId, $catId]);
        }
    }

    echo "Service updated successfully.";
    header("Location: ../dashboard/service-provider.php");
    
    
}
?>
