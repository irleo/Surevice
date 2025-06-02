<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../utils/config.php';

$errors = [];
$success = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-documents'])) {
    $uploadDir = __DIR__ . '/../assets/documents/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES['documents']['tmp_name'] as $index => $tmpPath) {
        $originalName = $_FILES['documents']['name'][$index];
        $safeName = time() . '_' . basename($originalName);
        $destination = $uploadDir . $safeName;

        if (move_uploaded_file($tmpPath, $destination)) {
            $insertSql = "INSERT INTO ProviderDocuments (user_id, filename) VALUES (?, ?)";
            $insertStmt = sqlsrv_query($conn, $insertSql, [$user_id, $safeName]);
            if (!$insertStmt) {
                $errors[] = "Failed to save document: $originalName";
            }
        } else {
            $errors[] = "Failed to upload file: $originalName";
        }
    }

    if (empty($errors)) {
        $_SESSION['upload_success'] = "Documents submitted successfully for verification.";
    } else {
        $_SESSION['upload_errors'] = $errors;
    }
    
    header("Location: ../user/profile.php");
    exit;
}
