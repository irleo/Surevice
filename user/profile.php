<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../utils/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$errors = [];
$success = '';

$user_id = $_SESSION['user_id'];

// Fetch full user data
$sql = "SELECT first_name, last_name, email, phone, gender, user_type, is_verified, created_at, last_name_change FROM Users WHERE user_id = ?";
$params = [$user_id];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if (!$user) {
    die("User not found.");

}
// Insert pending documents check here 
$hasPendingDocument = false;
$hasRejectedDocument = false;

$sqlDocStatus = "SELECT status, COUNT(*) AS count FROM ProviderDocuments WHERE user_id = ? AND status IN ('Pending', 'Rejected') GROUP BY status";
$paramsDocStatus = [$user_id];
$stmtDocStatus = sqlsrv_query($conn, $sqlDocStatus, $paramsDocStatus);

if ($stmtDocStatus !== false) {
    while ($row = sqlsrv_fetch_array($stmtDocStatus, SQLSRV_FETCH_ASSOC)) {
        if ($row['status'] === 'Pending' && $row['count'] > 0) {
            $hasPendingDocument = true;
        }
        if ($row['status'] === 'Rejected' && $row['count'] > 0) {
            $hasRejectedDocument = true;
        }
    }
}

$now = new DateTime();
$lastChangeRaw = $user['last_name_change'] ?? null;

if ($lastChangeRaw instanceof DateTime) {
    $lastChange = $lastChangeRaw;
} elseif (!empty($lastChangeRaw)) {
    $lastChange = new DateTime($lastChangeRaw);
} else {
    $lastChange = new DateTime('2000-01-01'); // fallback
}

$diff = $now->diff($lastChange);
$interval = $diff->days;
$canEdit = $interval >= 14;

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];

    if (!$canEdit) {
        $_SESSION['errors'][] = "You can only change your name every 2 weeks. Please wait " . (14 - $interval) . " more day(s).";
    } else {
        $updateSql = "
            UPDATE Users
            SET first_name = ?, 
                last_name = ?, 
                phone = ?, 
                gender = ?, 
                last_name_change = GETDATE()
            WHERE user_id = ?
        ";

        $params = [$firstName, $lastName, $phone, $gender, $user_id];
        $stmtUpdate = sqlsrv_query($conn, $updateSql, $params);

        if ($stmtUpdate) {
            $_SESSION['name'] = $firstName . ' ' . $lastName;
            $_SESSION['success'] = "Profile updated successfully.";
            // Update $user array for current page view
            $user['first_name'] = $firstName;
            $user['last_name'] = $lastName;
            $user['phone'] = $phone;
            $user['gender'] = $gender;
            $user['last_name_change'] = $now->format('Y-m-d H:i:s');
        } else {
            $_SESSION['errors'][] = "Failed to update profile.";
        }
    }
    // Redirect to self to prevent form resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if (!empty($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
    unset($_SESSION['success']);
}

if (!empty($_SESSION['errors'])) {
    echo '<div class="alert alert-danger">';
    foreach ($_SESSION['errors'] as $err) {
        echo '<div>' . htmlspecialchars($err) . '</div>';
    }
    echo '</div>';
    unset($_SESSION['errors']);
}


// Handle document submission
if (isset($_SESSION['upload_success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['upload_success'] . '</div>';
    unset($_SESSION['upload_success']);
}
if (isset($_SESSION['upload_errors'])) {
    echo '<div class="alert alert-danger">';
    foreach ($_SESSION['upload_errors'] as $err) {
        echo "<div>$err</div>";
    }
    echo '</div>';
    unset($_SESSION['upload_errors']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
<div class="container-fluid profile-container">

  <?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php elseif ($errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $err) echo "<div>$err</div>"; ?>
    </div>
  <?php endif; ?>

  <!-- Personal Info -->
  <div class="profile-section">
    <h5><i class="bi bi-info-circle-fill me-2"></i>Personal Info</h5>
    <div class="profile-info">
      <p><strong>Name:</strong> <?= htmlspecialchars($user['first_name']) ?> <?= htmlspecialchars($user['last_name']) ?></p>
      <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?></p>
      <p><strong>Account Type:</strong> <?= ucfirst($user['user_type']) ?></p>
      <p><strong>Joined:</strong> <?= $user['created_at']->format('F j, Y') ?></p>
      <p class="mb-0">
        <strong>Verified:</strong>
        <?php if ($user['is_verified']): ?>
          <span class="text-success fw-bold"><i class="bi bi-patch-check-fill me-2"></i>Yes</span>
        <?php else: ?>
          <span class="text-danger fw-bold">No</span>
        <?php endif; ?>
      </p>

      <?php if (!$user['is_verified']): ?>
        <button 
          type="button" 
          class="btn btn-primary btn-sm mt-2" 
          data-bs-toggle="modal" 
          data-bs-target="#verifyDocumentsModal"
          <?= ($hasPendingDocument) ? 'disabled' : '' ?>>
          <i class="bi bi-upload me-1"></i>Verify
        </button>
        <?php if ($hasPendingDocument): ?>
          <span class="text-warning ms-2">(Pending Verification)</span>
        <?php elseif ($hasRejectedDocument): ?>
          <span class="text-danger ms-2">(Your document(s) have been rejected)</span>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- Contact Info -->
  <div class="profile-section">
    <h5><i class="bi bi-envelope-fill me-2"></i>Contact Info</h5>
    <div class="profile-info">
      <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
    </div>
  </div>

  <!-- Status & Actions -->
  <div class="d-flex justify-content-between align-items-center profile-section">
    <?php $lastChange = $user['last_name_change'] ?? null; ?>
    <div>
      <h5><i class="bi bi-person-gear me-2"></i>Status</h5>
      <?php if ($lastChange): ?>
        <p class="text-muted">Last changed on <?= $lastChange->format('F j, Y') ?></p>
      <?php else: ?>  
        <p class="text-muted">You can change your name.</p>
      <?php endif; ?>
    </div>
    <div>
      <button 
        class="btn btn-outline-primary mt-3 <?= !$canEdit ? 'btn-outline-light bg-light text-muted' : '' ?>" 
        data-bs-toggle="modal" 
        data-bs-target="#editProfileModal"
        <?= !$canEdit ? 'disabled' : '' ?>
        >
        <i class="bi bi-pencil-fill me-1"></i>Edit Profile
        </button>

        <?php if (!$canEdit): ?>
        <small class="text-muted d-block mt-1">
            You can edit again in <?= 14 - $interval ?> day(s).
        </small>
        <?php endif; ?>
    </div>
  </div>

  <div class="mt-4 profile-section">
    <a href="../index.php" class="btn btn-link text-decoration-none">
      <i class="bi bi-arrow-left me-1"></i>Back to Home
    </a>
  </div>

</div>


<!-- Edit Profile Modal -->
<?php 
    include '../components/edit-profile-modal.php'; 
    include '../components/submit-documents-modal.php'; 
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

