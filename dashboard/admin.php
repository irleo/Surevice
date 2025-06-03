<?php

session_start();
require __DIR__ . '/../utils/config.php';

// Admin-only access check
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Fetch all users
$sql = "SELECT user_id, first_name, last_name, email, user_type, is_verified, account_status FROM Users WHERE user_type IN ('customer', 'provider')";
$stmt = sqlsrv_query($conn, $sql);
$users = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $users[] = $row;
}

// Fetch all providers with is_verified = 0 and their pending documents
$sql = "
    SELECT u.user_id, u.first_name, u.last_name, d.document_id, d.filename, d.status
    FROM Users u
    LEFT JOIN ProviderDocuments d ON u.user_id = d.user_id AND d.status = 'Pending'
    WHERE u.user_type = 'provider' AND u.is_verified = 0
";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$providers = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $userId = $row['user_id'];
    if (!isset($providers[$userId])) {
        $providers[$userId] = [
            'user_id' => $userId,
            'name' => $row['first_name'] . ' ' . $row['last_name'],
            'documents' => [],
        ];
    }
    if ($row['document_id'] !== null) {
        $providers[$userId]['documents'][] = [
            'document_id' => $row['document_id'],
            'filename' => $row['filename'],
            'status' => $row['status'],
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

  <!-- Sidebar with Logo and Navigation -->
  <div class="sidebar">
    <div class="logo-container">
      <img src="../assets/images/logo.png" alt="Surevice" class="logo">
    </div>
    <h1>Admin Panel</h1>
    <button onclick="showSection('userMgmt')">
      <i class="bi bi-people-fill"></i> User Management
    </button>
    <button onclick="showSection('serviceVerify')">
      <i class="bi bi-person-check-fill"></i> Service Provider Verification
    </button>
    <button onclick="showSection('booking')">
      <i class="bi bi-calendar-check-fill"></i> Booking Oversight
    </button>
    <button onclick="showSection('monitoring')">
      <i class="bi bi-graph-up-arrow"></i> Service Monitoring
    </button>
    <a href="../utils/logout.php" class="logout-btn">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  </div>


  <div class="main">
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search...">
      <button onclick="search()">Search</button>
    </div>

    <div id="userMgmt" class="section active">
      <h2>User Management</h2>
      <p>Approve or suspend user accounts.</p>
      <table>
        <thead>
          <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Status</th>  
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
          <tr>
            <td><?= $user['user_id'] ?></td>
            <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars(ucfirst($user['user_type'])) ?></td>
            <?php
              $statusText = '';
              if ($user['user_type'] === 'provider') {
                if ($user['is_verified'] == 0) {
                  $statusText = 'Pending Verification';
                } else {
                  $statusText = ucfirst($user['account_status']);
                }
              } else {
                $statusText = ucfirst($user['account_status']);
              }
            ?>
            <td><?= $statusText ?></td>
            <td>
              <?php if ($user['account_status'] === 'Pending'): ?>
                <button class="btn approve-btn" data-id="<?= $user['user_id'] ?>">Approve</button>
              <?php endif; ?>
              <?php if ($user['account_status'] === 'Suspended'): ?>
                <button class="btn reactivate-btn" data-id="<?= $user['user_id'] ?>">Reactivate</button>
              <?php elseif ($user['account_status'] === 'Active'): ?>
                <button class="btn suspend-btn" data-id="<?= $user['user_id'] ?>">Suspend</button>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Service Provider Verification -->
    <div id="serviceVerify" class="section">
      <h2>Service Provider Verification</h2>
      <p>Review submitted documents and ID for verification.</p>
                
      <?php if (empty($providers)): ?>
          <p>No providers pending verification.</p>
      <?php else: ?>
          <?php foreach ($providers as $provider): ?>
              <div class="doc-box">
                  <strong>Provider:</strong> <?= htmlspecialchars($provider['name']) ?><br>
            
                  <?php if (count($provider['documents']) === 0): ?>
                      <em>No submitted documents.</em><br>
                  <?php else: ?>
                      <ul>
                          <?php foreach ($provider['documents'] as $doc): ?>
                              <li>
                                  <a href="../assets/documents/<?= htmlspecialchars($doc['filename']) ?>" target="_blank"><?= htmlspecialchars($doc['filename']) ?></a>
                                  <div class="ms-auto">
                                    <button class="btn approve-doc" data-doc-id="<?= $doc['document_id'] ?>">Approve</button>
                                    <button class="btn reject-doc" data-doc-id="<?= $doc['document_id'] ?>">Reject</button>
                                  </div>
                              </li>
                          <?php endforeach; ?>
                      </ul>
                  <?php endif; ?>
              </div>
              <hr>
          <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Service Monitoring -->
    <div id="monitoring" class="section">
      <h2>Service Monitoring</h2>
      <p>Manage or disable inappropriate listings.</p>
      <div class="monitor-box">
        <strong>Listing:</strong> "Premium Massage by Mark" <br>
        <strong>Status:</strong> Reported <br><br>
        <button class="btn">Disable</button>
        <button class="btn">Dismiss Report</button>
      </div>
      </div>
    </div>
  </div>

    <script>
      const serviceChartData = <?= json_encode($serviceData) ?>;
    </script>>

    <script src="../assets/js/admin.js" defer></script>

  </body>
</html>
