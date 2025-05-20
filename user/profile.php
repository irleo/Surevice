<?php
session_start();
require __DIR__ . '/../utils/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$errors = [];
$success = '';

$user_id = $_SESSION['user_id'];

// Fetch current user info
$sql = "SELECT first_name, last_name, is_verified, last_name_change FROM Users WHERE user_id = ?";
$params = [$user_id];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if (!$user) {
    die("User not found.");
}


// Handle name change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_name'])) {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);

    $lastChange = $user['last_name_change'] ?? new DateTime('2000-01-01');
    $now = new DateTime();
    $diff = $now->diff($lastChange);

    if ($diff->days < 14) {
        $errors[] = "You can only change your name every 2 weeks.";
    } else {
        $updateSql = "UPDATE Users SET first_name = ?, last_name = ?, last_name_change = GETDATE() WHERE user_id = ?";
        $updateStmt = sqlsrv_query($conn, $updateSql, [$firstName, $lastName, $user_id]);
        if ($updateStmt) {
            $_SESSION['name'] = $firstName . ' ' . $lastName;
            $success = "Name updated successfully!";
            $user['first_name'] = $firstName;
            $user['last_name'] = $lastName;
            $user['last_name_change'] = $now->format('Y-m-d H:i:s');
        } else {
            $errors[] = "Failed to update name.";
        }
    }
}

// Handle verification request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_account'])) {
    $verifySql = "UPDATE Users SET is_verified = 1 WHERE user_id = ?";
    $verifyStmt = sqlsrv_query($conn, $verifySql, [$user_id]);

    if ($verifyStmt) {
        $user['is_verified'] = 1;
        $success = "Account successfully verified!";
    } else {
        $errors[] = "Verification failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: auto;
            padding-top: 40px;
        }
    </style>
</head>
<body>
<div class="container form-container">
    <h3 class="mb-4">Your Profile</h3>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $err) echo "<div>$err</div>"; ?>
        </div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        </div>

        <button type="submit" name="update_name" class="btn btn-primary w-100">Update Name</button>
    </form>

    <hr class="my-4">

    <h5>Account Status</h5>
    <p>
        Verified: 
        <?php if ($user['is_verified']): ?>
            <span class="text-success fw-bold">Yes</span>
        <?php else: ?>
            <span class="text-danger fw-bold">No</span>
            <form method="POST" class="mt-2">
                <button type="submit" name="verify_account" class="btn btn-outline-success btn-sm">Verify Now</button>
            </form>
        <?php endif; ?>
    </p>
    <a href="../index.php">Go back</a>
</div>
</body>
</html>
