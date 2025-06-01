<?php
session_start();
require __DIR__ . '/../utils/config.php';

// Check admin auth
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    http_response_code(403);
    echo "Forbidden";
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$documentId = $data['document_id'] ?? null;
$action = $data['action'] ?? null;

if (!$documentId || !in_array($action, ['approve', 'reject'])) {
    http_response_code(400);
    echo "Invalid input";
    exit;
}

$newStatus = ($action === 'approve') ? 'Approved' : 'Rejected';

// Update document status
$sqlUpdateDoc = "UPDATE ProviderDocuments SET status = ? WHERE document_id = ?";
$params = [$newStatus, $documentId];
$stmt = sqlsrv_query($conn, $sqlUpdateDoc, $params);

if ($stmt === false) {
    http_response_code(500);
    echo "Database error";
    exit;
}

if ($action === 'approve') {
    // Check if all documents are approved for this provider, then set is_verified=1 in Users
    $sqlGetUser = "SELECT user_id FROM ProviderDocuments WHERE document_id = ?";
    $stmtGetUser = sqlsrv_query($conn, $sqlGetUser, [$documentId]);
    $row = sqlsrv_fetch_array($stmtGetUser, SQLSRV_FETCH_ASSOC);
    $userId = $row['user_id'] ?? null;
    
    if ($userId) {
        // Check if any pending or rejected docs remain
        $sqlCheckPending = "SELECT COUNT(*) as pending_count FROM ProviderDocuments WHERE user_id = ? AND status IN ('Pending', 'Rejected')";
        $stmtCheckPending = sqlsrv_query($conn, $sqlCheckPending, [$userId]);
        $pendingRow = sqlsrv_fetch_array($stmtCheckPending, SQLSRV_FETCH_ASSOC);
        if ($pendingRow['pending_count'] == 0) {
            // Mark user verified and active
            $sqlVerifyUser = "UPDATE Users SET is_verified = 1, account_status = 'Active' WHERE user_id = ?";
            sqlsrv_query($conn, $sqlVerifyUser, [$userId]);
        }
    }
}

echo "Success";
exit;
