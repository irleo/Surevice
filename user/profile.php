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

// Fetch full user data
$sql = "SELECT first_name, last_name, email, phone, gender, user_type, address, is_verified, created_at, last_name_change FROM Users WHERE user_id = ?";
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

    $lastChange = $user['last_name_change'] ?? null;
    $now = new DateTime();

    if (!$lastChange instanceof DateTime) {
        $lastChange = new DateTime('2000-01-01');
    }

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
// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $address = trim($_POST['address']);

    $updateProfileSql = "
        UPDATE Users
        SET first_name = ?, last_name = ?, phone = ?, gender = ?, address = ?
        WHERE user_id = ?
    ";
    $updateParams = [$firstName, $lastName, $phone, $gender, $address, $user_id];

    $stmtUpdate = sqlsrv_query($conn, $updateProfileSql, $updateParams);

    if ($stmtUpdate) {
        $success = "Profile updated successfully.";
        $user['first_name'] = $firstName;
        $user['last_name'] = $lastName;
        $user['phone'] = $phone;
        $user['gender'] = $gender;
        $user['address'] = $address;
    } else {
        $errors[] = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            max-width: 700px;
            margin: 40px auto;
        }
        .profile-section {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .profile-section h5 {
            margin-bottom: 1rem;
            border-bottom: 1px solid #ccc;
            padding-bottom: 0.5rem;
        }
        .profile-info p {
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
<div class="container profile-container">

    <h3 class="mb-4">Your Profile</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif ($errors): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $err) echo "<div>$err</div>"; ?>
        </div>
    <?php endif; ?>

    <!-- Personal Info -->
    <div class="profile-section">
        <h5>Personal Info</h5>
        <div class="profile-info">
            <p><strong>First Name:</strong> <?= htmlspecialchars($user['first_name']) ?></p>
            <p><strong>Last Name:</strong> <?= htmlspecialchars($user['last_name']) ?></p>
            <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?></p>
            <p><strong>Account Type:</strong> <?= ucfirst($user['user_type']) ?></p>
            <p><strong>Joined:</strong> <?= $user['created_at']->format('F j, Y') ?></p>
            <p class="mb-0">
            <strong>Verified:</strong> 
            <?php if ($user['is_verified']): ?>
                <span class="text-success fw-bold">Yes</span>
            <?php else: ?>
                <span class="text-danger fw-bold">No</span>
            <?php endif; ?>
        </p>
        <?php if (!$user['is_verified']): ?>
                <form method="POST" class="d-inline">
                    <button type="submit" name="verify_account" class="btn btn-success btn-sm">Verify Now</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Contact Info -->
    <div class="profile-section">
        <h5>Contact Info</h5>
        <div class="profile-info">
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        </div>
    </div>

    <!-- Address -->
    <div class="profile-section">
        <h5>Addresses</h5>
        <div class="profile-info">
            <p>No saved address.</p> 
        </div>
    </div>

    <!-- Status & Actions -->
    <div class="d-flex justify-content-between align-items-center">
        <?php $lastChange = $user['last_name_change'] ?? null; ?>
        <div>
            <h5>Status</h5>
            <?php if ($lastChange): ?>
                <p class="text-muted">Last changed on <?= $lastChange->format('F j, Y') ?></p>
            <?php else: ?>  
                <p class="text-muted">You can change your name.</p>
            <?php endif; ?>
        </div>
        <div>
            <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                Edit Profile
            </button>
        </div>
    </div>

    <div class="mt-4">
        <a href="../index.php" class="btn btn-link">← Back to Home</a>
    </div>

</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editFirstName" class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" id="editFirstName" value="<?= htmlspecialchars($user['first_name']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="editLastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" id="editLastName" value="<?= htmlspecialchars($user['last_name']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="editPhone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" id="editPhone" value="<?= htmlspecialchars($user['phone']) ?>">
          </div>
          <div class="mb-3">
            <label for="editGender" class="form-label">Gender</label>
            <select class="form-select" name="gender" id="editGender">
              <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
              <option value="Other" <?= $user['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editAddress" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" id="editAddress" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

