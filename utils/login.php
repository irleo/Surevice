<?php
session_start();
require 'config.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    header("Location: login.html?error=" . urlencode("All fields are required"));
    exit;
}

$sql = "SELECT * FROM Users WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_type'] = $user['user_type'];

    // Redirect based on user type
    switch ($user['user_type']) {
        case 'customer':
            header("Location: dashboard/customer.php");
            break;
        case 'provider':
            header("Location: dashboard/provider.php");
            break;
        case 'admin':
            header("Location: dashboard/admin.php");
            break;
        default:
            header("Location: login.html?error=" . urlencode("Unknown user type"));
    }
    exit;
} else {
    header("Location: login.html?error=" . urlencode("Invalid email or password"));
    exit;
}
?>
