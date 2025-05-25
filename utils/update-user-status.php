<?php
require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$user_id || !$action) {
        http_response_code(400);
        echo "Missing data.";
        exit;
    }

    switch ($action) {
        case 'approve':
            $sql = "UPDATE Users SET account_status = 'Active' WHERE user_id = ?";
            break;
        case 'suspend':
            $sql = "UPDATE Users SET account_status = 'Suspended' WHERE user_id = ?";
            break;
        case 'reactivate':
            $sql = "UPDATE Users SET account_status = 'Active' WHERE user_id = ?";
            break;
        default:
            http_response_code(400);
            echo "Invalid action.";
            exit;
    }

    $stmt = sqlsrv_query($conn, $sql, [$user_id]);

    if ($stmt) {
      $messages = [
          'approve' => 'User approved successfully.',
          'suspend' => 'User suspended successfully.',
          'reactivate' => 'User reactivated successfully.'
      ];

      echo $messages[$action] ?? 'Action completed successfully.';
    } else {
        http_response_code(500);
        echo "Database error.";
    }

}
?>
