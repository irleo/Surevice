<?php
session_start();
require __DIR__ . '/config.php';  

// Redirect to homepage if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}


// Sanitize inputs
$firstName = trim($_POST['firstName'] ?? '');
$lastName = trim($_POST['lastName'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';
$gender = $_POST['gender'] ?? '';
$dob = $_POST['dob'] ?? '';
$userType = 'customer'; // Default for registration

// Basic validation
if ($password !== $confirmPassword) {
    header("Location: ../register.php?error=" . urlencode("Passwords do not match."));
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../register.php?error=" . urlencode("Invalid email format."));
    exit;
}

// Check if email already exists
$sqlCheck = "SELECT user_id FROM Users WHERE email = ?";
$stmtCheck = sqlsrv_query($conn, $sqlCheck, [$email]);

if ($stmtCheck && sqlsrv_fetch_array($stmtCheck)) {
    header("Location: ../register.php?error=" . urlencode("Email already registered."));
    exit;
}

// Hash password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$sqlInsert = "
    INSERT INTO Users (first_name, last_name, email, password_hash, user_type, is_verified, created_at, phone)
    VALUES (?, ?, ?, ?, ?, 0, GETDATE(), ?)
";
$params = [$firstName, $lastName, $email, $passwordHash, $userType, $phone];
$stmtInsert = sqlsrv_query($conn, $sqlInsert, $params);

if ($stmtInsert) {
    header("Location: ../login.php?success=" . urlencode("Account created! Please log in."));
    exit;
} else {
    $errorMsg = "Registration failed.";
    if (($errors = sqlsrv_errors()) != null) {
        foreach ($errors as $error) {
            $errorMsg .= " SQLSTATE: " . $error['SQLSTATE'] . " - Message: " . $error['message'];
        }
    }
    header("Location: ../register.php?error=" . urlencode($errorMsg));
    exit;
}
