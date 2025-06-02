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
$gender = $_POST['gender'] ?? '';
$dob = $_POST['dob'] ?? '';
$userType = $_POST['userType'] ?? ''; 
$phone = $_POST['phone'] ?? '';


;
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    header("Location: ../register.php?step=1&error=" . urlencode("Invalid phone number."));
    exit;
}
$full_phone = '+63' . $phone;

$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if ($password !== $confirmPassword) {
    header("Location: ../register.php?step=2&error=" . urlencode("Passwords do not match."));
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../register.php?step=2&error=" . urlencode("Invalid email format."));
    exit;
}


// Check if email already exists
$sqlCheckEmail = "SELECT user_id FROM Users WHERE email = ?";
$paramsEmail = [$email];
$stmtEmail = sqlsrv_query($conn, $sqlCheckEmail, $paramsEmail);
if ($stmtEmail === false) {
    die(print_r(sqlsrv_errors(), true)); // handle query error
}
if (sqlsrv_fetch($stmtEmail)) {
    header("Location: ../register.php?step=2&error=" . urlencode("Email already registered."));
    exit;
}

// Check if phone already exists
$sqlCheckPhone = "SELECT user_id FROM Users WHERE phone = ?";
$paramsPhone = [$full_phone];
$stmtPhone = sqlsrv_query($conn, $sqlCheckPhone, $paramsPhone);
if ($stmtPhone === false) {
    die(print_r(sqlsrv_errors(), true)); // handle query error
}
if (sqlsrv_fetch($stmtPhone)) {
    header("Location: ../register.php?step=1&error=" . urlencode("Phone number already registered."));
    exit;
}


// Hash password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$sqlInsert = "
    INSERT INTO Users (first_name, last_name, email, password_hash, user_type, is_verified, created_at, phone, gender)
    VALUES (?, ?, ?, ?, ?, 0, GETDATE(), ?, ?)
";
$params = [$firstName, $lastName, $email, $passwordHash, $userType, $full_phone, $gender];

$stmtInsert = sqlsrv_query($conn, $sqlInsert, $params);

if ($stmtInsert === false) {
    $errorMsg = "Registration failed.";
    if (($errors = sqlsrv_errors()) != null) {
        foreach ($errors as $error) {
            $errorMsg .= " SQLSTATE: " . $error['SQLSTATE'] . " - Message: " . $error['message'];
        }
    }
    header("Location: ../register.php?step=2&error=" . urlencode($errorMsg));
    exit;
}

header("Location: ../register.php?success=" . urlencode("Registration successful! You may now log in."));
exit;