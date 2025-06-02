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

// Get user_id from the document
$sqlGetUser = "SELECT user_id FROM ProviderDocuments WHERE document_id = ?";
$stmtGetUser = sqlsrv_query($conn, $sqlGetUser, [$documentId]);
$row = sqlsrv_fetch_array($stmtGetUser, SQLSRV_FETCH_ASSOC);
$userId = $row['user_id'] ?? null;

if ($userId) {
    if ($action === 'approve') {
        // Count pending documents
        $sqlPending = "SELECT COUNT(*) as pending_count FROM ProviderDocuments WHERE user_id = ? AND status = 'Pending'";
        $stmtPending = sqlsrv_query($conn, $sqlPending, [$userId]);
        $rowPending = sqlsrv_fetch_array($stmtPending, SQLSRV_FETCH_ASSOC);
        $hasPending = $rowPending['pending_count'] > 0;

        // Count approved documents
        $sqlApproved = "SELECT COUNT(*) as approved_count FROM ProviderDocuments WHERE user_id = ? AND status = 'Approved'";
        $stmtApproved = sqlsrv_query($conn, $sqlApproved, [$userId]);
        $rowApproved = sqlsrv_fetch_array($stmtApproved, SQLSRV_FETCH_ASSOC);
        $hasApproved = $rowApproved['approved_count'] > 0;

        if ($hasApproved && !$hasPending) {
            // Mark user as verified
            $sqlVerifyUser = "UPDATE Users SET is_verified = 1, account_status = 'Active' WHERE user_id = ?";
            sqlsrv_query($conn, $sqlVerifyUser, [$userId]);

            // Create wallet if doesn't exist
            $sqlCheckWallet = "SELECT COUNT(*) AS wallet_exists FROM Wallets WHERE provider_id = ?";
            $stmtCheckWallet = sqlsrv_query($conn, $sqlCheckWallet, [$userId]);
            $walletRow = sqlsrv_fetch_array($stmtCheckWallet, SQLSRV_FETCH_ASSOC);

            if ($walletRow['wallet_exists'] == 0) {
                $sqlCreateWallet = "INSERT INTO Wallets (provider_id, balance) VALUES (?, 0.00)";
                sqlsrv_query($conn, $sqlCreateWallet, [$userId]);
            }
        }
    }

    if ($action === 'reject') {
        // Optional: only reset if no remaining approved docs
        $sqlApproved = "SELECT COUNT(*) AS approved_count FROM ProviderDocuments WHERE user_id = ? AND status = 'Approved'";
        $stmtApproved = sqlsrv_query($conn, $sqlApproved, [$userId]);
        $rowApproved = sqlsrv_fetch_array($stmtApproved, SQLSRV_FETCH_ASSOC);

        if ($rowApproved['approved_count'] == 0) {
            // Reset verification
            $sqlResetUser = "UPDATE Users SET is_verified = 0, account_status = 'Pending' WHERE user_id = ?";
            sqlsrv_query($conn, $sqlResetUser, [$userId]);
        }
    }
}

echo "Success";
exit;
