<?php
session_start();
require __DIR__ . '/../utils/config.php';

// Provider-only access check
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'provider') {
    header("Location: ../login.php");
    exit;
}

$provider_id = $_SESSION['user_id'];


// Initialize values
$walletBalance = $totalEarnings = $monthlyIncome = $pendingAmount = 0.00;

// Wallet Balance
$sql = "SELECT balance FROM Wallets WHERE provider_id = ?";
$params = array($provider_id);
$wallet_stmt = sqlsrv_query($conn, $sql, $params);
if ($wallet_stmt && $row = sqlsrv_fetch_array($wallet_stmt, SQLSRV_FETCH_ASSOC)) {
    $walletBalance = $row['balance'];
}

// Total Earnings (released only)
$sql = "
    SELECT SUM(p.provider_earnings) AS total
    FROM Payments p
    JOIN Bookings b ON p.booking_id = b.booking_id
    JOIN Services s ON b.service_id = s.service_id
    WHERE s.provider_id = ? AND p.status = 'released'
";
$total_stmt = sqlsrv_query($conn, $sql, array($provider_id));
if ($total_stmt && $row = sqlsrv_fetch_array($total_stmt, SQLSRV_FETCH_ASSOC)) {
    $totalEarnings = $row['total'];
}

// Monthly Income (current month, released)
$sql = "
    SELECT SUM(p.provider_earnings) AS total
    FROM Payments p
    JOIN Bookings b ON p.booking_id = b.booking_id
    JOIN Services s ON b.service_id = s.service_id
    WHERE s.provider_id = ?
      AND p.status = 'released'
      AND MONTH(p.paid_at) = MONTH(GETDATE())
      AND YEAR(p.paid_at) = YEAR(GETDATE())
";
$monthly_stmt = sqlsrv_query($conn, $sql, array($provider_id));
if ($monthly_stmt && $row = sqlsrv_fetch_array($monthly_stmt, SQLSRV_FETCH_ASSOC)) {
    $monthlyIncome = $row['total'];
}

// Pending Amount (held payments)
$sql = "
    SELECT SUM(p.provider_earnings) AS total
    FROM Payments p
    JOIN Bookings b ON p.booking_id = b.booking_id
    JOIN Services s ON b.service_id = s.service_id
    WHERE s.provider_id = ? AND p.status = 'held'
";
$pending_stmt = sqlsrv_query($conn, $sql, array($provider_id));
if ($pending_stmt && $row = sqlsrv_fetch_array($pending_stmt, SQLSRV_FETCH_ASSOC)) {
    $pendingAmount = $row['total'];
}

// Fetch earnings by month (last 12 months)
$earningsByMonth = [];

$sql = "
    SELECT 
        FORMAT(p.paid_at, 'yyyy-MM') AS month,
        SUM(p.provider_earnings) AS total
    FROM Payments p
    JOIN Bookings b ON p.booking_id = b.booking_id
    JOIN Services s ON b.service_id = s.service_id
    WHERE 
        s.provider_id = ? AND 
        p.status = 'released' AND 
        p.paid_at >= DATEADD(MONTH, -11, GETDATE())
    GROUP BY FORMAT(p.paid_at, 'yyyy-MM')
    ORDER BY month
";

$earnings_stmt = sqlsrv_query($conn, $sql, array($provider_id));
if ($earnings_stmt !== false) {
    while ($row = sqlsrv_fetch_array($earnings_stmt, SQLSRV_FETCH_ASSOC)) {
        $earningsByMonth[$row['month']] = $row['total'];
    }
}

// Fill in months with zero if missing
$labels = [];
$data = [];

$current = new DateTime();
$current->modify('-11 months');

for ($i = 0; $i < 12; $i++) {
    $label = $current->format('M Y');
    $key = $current->format('Y-m');
    $labels[] = $label;
    $data[] = isset($earningsByMonth[$key]) ? $earningsByMonth[$key] : 0;
    $current->modify('+1 month');
}

// Recent Transactions
$transactions = [];

$sql = "
    SELECT 
        p.paid_at,
        p.amount,
        p.fee_deducted,
        p.provider_earnings,
        p.status,
        s.title
    FROM Payments p
    JOIN Bookings b ON p.booking_id = b.booking_id
    JOIN Services s ON b.service_id = s.service_id
    WHERE s.provider_id = ?
    ORDER BY p.paid_at DESC
";
$params = array($provider_id);
$transactions_stmt = sqlsrv_query($conn, $sql, $params);

if ($transactions_stmt !== false) {
    while ($row = sqlsrv_fetch_array($transactions_stmt, SQLSRV_FETCH_ASSOC)) {
        $transactions[] = $row;
    }
}

// Fetch service charges 
$charges = [];

$sql = "
    SELECT 
        b.booking_id,
        b.scheduled_for,
        s.title AS service_type,
        CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
        s.service_fee AS amount, -- fallback if no payment yet
        b.status,
        b.address
    FROM Bookings b
    JOIN Users c ON b.customer_id = c.user_id
    JOIN Services s ON b.service_id = s.service_id
    LEFT JOIN Payments p ON b.booking_id = p.booking_id
    WHERE s.provider_id = ? AND b.status IN ('pending', 'in_progress')
    ORDER BY b.scheduled_for DESC
";

$charges_stmt = sqlsrv_query($conn, $sql, array($provider_id));

if ($charges_stmt !== false) {
    while ($row = sqlsrv_fetch_array($charges_stmt, SQLSRV_FETCH_ASSOC)) {
        $charges[] = $row;
    }
}

$sql = "SELECT last_updated FROM Wallets WHERE provider_id = ?";
$params = array($provider_id);
$updated_stmt = sqlsrv_query($conn, $sql, $params);
$lastUpdated = null;

if ($updated_stmt && $row = sqlsrv_fetch_array($updated_stmt, SQLSRV_FETCH_ASSOC)) {
    $lastUpdated = $row['last_updated']; 
}

$categoryData = [];

$sql = "
  SELECT c.name AS category, COUNT(b.booking_id) AS count
  FROM Bookings b
  JOIN Services s ON b.service_id = s.service_id
  JOIN ServiceCategoryLink scl ON s.service_id = scl.service_id
  JOIN Categories c ON scl.category_id = c.category_id
  GROUP BY c.name
  ORDER BY count DESC
";

$cat_stmt = sqlsrv_query($conn, $sql);
if ($cat_stmt !== false) {
    while ($row = sqlsrv_fetch_array($cat_stmt, SQLSRV_FETCH_ASSOC)) {
        $categoryData[$row['category']] = $row['count'];
    }
}

$categoryLabels = json_encode(array_keys($categoryData));
$categoryCounts = json_encode(array_values($categoryData));

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Service Provider Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="../assets/css/service-provider.css" />
</head>

<body>
  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <div class="col-md-2 sidebar">
        <div class="mb-5">
          <img src="../assets/images/logo-go.png" alt="Surevice Logo" style="width: 150px;" />
        </div>
        <a href="#" id="dashboardLink" class="d-block mb-2">Dashboard</a>
        <a href="" id="profileLink" class="d-block mb-2">Profile</a>
        <a href="#" id="servicesLink" class="d-block mb-2">Services</a>
        <a href="#" id="walletLink" class="d-block mb-2">Wallet</a>
        <a href="#" class="d-block mb-2 nav-link disabled text-secondary">Help</a>
        <a href="../utils/logout.php" class="d-block mb-2">Logout</a>
      </div>
      
      <!-- Main Content -->
      <div class="col-md-10 p-4">
        <h2 class="fw-bold mb-4" id="sectionTitle">Service Provider</h2>

        <!-- Dashboard Content -->
        <div id="dashboardContent">
          <div class="row g-4 mb-4">
            <div class="col-md-3">
              <div class="card-style">
                <h5>Wallet Balance</h5>
                <h2 class="fw-bold">₱<?= number_format($walletBalance, 2) ?></h2>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card-style">
                <h5>Total Earnings</h5>
                <h2 class="fw-bold">₱<?= number_format($totalEarnings, 2) ?></h2>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card-style">
                <h5>Monthly Income</h5>
                <h2 class="fw-bold">₱<?= number_format($monthlyIncome, 2) ?></h2>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card-style">
                <h5>Pending Amount</h5>
                <h2 class="fw-bold">₱<?= number_format($pendingAmount, 2) ?></h2>
              </div>
            </div>
          </div>

          <div class="row">
            <div>
              <div class="table-box">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 class="fw-bold m-0">Service Requests</h5>
                </div>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Date & Time</th>
                      <th>Service Type</th>
                      <th>Customer</th>
                      <th>Address</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($charges as $row): ?>
                      <tr>
                        <td><?= $row['scheduled_for'] ? date_format($row['scheduled_for'], 'M j, Y - h:i A') : '-' ?></td>
                        <td><?= htmlspecialchars($row['service_type']) ?></td>
                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                        <td style="max-width: 250px; max-height: 60px; overflow-y: auto; white-space: normal;">
                          <?= nl2br(htmlspecialchars($row['address'])) ?>
                        </td>
                        <td>₱<?= number_format($row['amount'] ?? 0, 2) ?></td>
                        <td>
                          <?php if ($row['status'] === 'pending'): ?>
                            <span class="badge bg-warning text-dark"><?= ucfirst($row['status']) ?></span>
                          <?php elseif ($row['status'] === 'in_progress'): ?>
                            <span class="badge bg-info text-dark">In Progress</span>
                          <?php else: ?>
                            <span class="badge"><?= ucfirst($row['status']) ?></span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if ($row['status'] === 'pending'): ?>
                            <button class="btn btn-sm btn-success booking-action" data-id="<?= $row['booking_id'] ?>" data-action="confirm">Confirm</button>
                            <button class="btn btn-sm btn-danger booking-action" data-id="<?= $row['booking_id'] ?>" data-action="decline">Decline</button>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Profile Content -->
        <div id="profileContent" style="display:none;">
          <p>Profile details go here.</p>
        </div>

        <!-- Services Content -->
          <div id="servicesContent" style="display:none;">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h3 class="fw-bold m-0">Active Services</h3>
              <button class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#addServiceModal" id="addServiceButton">+ Add Service</button>
              </div>
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Title</th>
                    <th>Fee</th>
                    <th>Rating</th>
                    <th>Categories</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Query to get services with provider info
                    $sql = "
                    SELECT 
                        s.service_id,
                        s.title,
                        s.description,
                        s.service_fee,
                        s.average_rating,
                        u.first_name + ' ' + u.last_name AS provider_name,
                        u.email,
                        u.user_id,
                        u.phone,
                        si.image_path
                    FROM Services s
                    JOIN Users u ON s.provider_id = u.user_id
                    LEFT JOIN (
                        SELECT service_id, image_path 
                        FROM ServiceImages 
                        WHERE is_primary = 1
                    ) si ON s.service_id = si.service_id
                    WHERE s.is_active = 1
                    ";

                    $stmt = sqlsrv_query($conn, $sql);
                    if ($stmt === false) {
                        die("Query failed:<br><pre>" . print_r(sqlsrv_errors(), true) . "</pre>");
                    }
                  while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                      $serviceId = $row['service_id'];
                      $title = htmlspecialchars($row['title']);
                      $fee = number_format($row['service_fee'], 2);
                      $rating = $row['average_rating'];
                      $stars = str_repeat("★", floor($rating)) . (fmod($rating, 1) >= 0.5 ? "☆" : "");

                      // Fetch categories
                      $catStmt = sqlsrv_query($conn, "
                          SELECT c.name 
                          FROM ServiceCategoryLink scl 
                          JOIN Categories c ON scl.category_id = c.category_id 
                          WHERE scl.service_id = ?", [$serviceId]);
                      $categoryNames = [];
                      while ($catRow = sqlsrv_fetch_array($catStmt, SQLSRV_FETCH_ASSOC)) {
                          $categoryNames[] = $catRow['name'];
                      }
                      $categoryList = implode(', ', $categoryNames);
                      $description = htmlspecialchars($row['description']);
                      $service_fee = $row['service_fee'];
                      $categoryArray = $categoryNames;

                      // Fetch all images for the service
                      $imageQuery = "SELECT image_path, is_primary FROM ServiceImages WHERE service_id = ?";
                      $imageStmt = sqlsrv_query($conn, $imageQuery, [$serviceId]);

                      $imagePaths = [];
                      $primaryIndex = 1;
                      $index = 1;

                      while ($imgRow = sqlsrv_fetch_array($imageStmt, SQLSRV_FETCH_ASSOC)) {
                          $imagePaths[] = $imgRow['image_path'];
                          if ($imgRow['is_primary']) {
                              $primaryIndex = $index;
                          }
                          $index++;
                      }
                      $encodedCategories = htmlspecialchars(json_encode($categoryNames), ENT_QUOTES);
                      $fullImagePaths = array_map(fn($path) => "/Surevice/" . ltrim($path, "/"), $imagePaths);
                      $encodedImages = htmlspecialchars(json_encode($fullImagePaths));
                      
                      $bookingCheck = sqlsrv_query($conn, "SELECT COUNT(*) AS count FROM Bookings WHERE service_id = ?", [$serviceId]);
                      $count = sqlsrv_fetch_array($bookingCheck, SQLSRV_FETCH_ASSOC)['count'];

                      echo <<<HTML
                      <tr>
                      <td>{$title}</td>
                      <td>₱{$fee}</td>
                      <td>{$stars} ({$rating})</td>
                      <td>{$categoryList}</td>
                      <td>
                        <button class="btn btn-sm btn-warning edit-service-btn"
                          data-id="{$serviceId}"
                          data-title="{$title}"
                          data-description="{$description}"
                          data-fee="{$service_fee}"
                          data-categories='{$encodedCategories}'
                          data-images='{$encodedImages}'
                          data-primary="{$primaryIndex}"
                          data-bs-toggle="modal"
                          data-bs-target="#editServiceModal">
                          Edit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete({$serviceId})">Delete</button>
                      </td>
                    </tr>
          HTML;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>


        <div id="walletContent" style="display:none;">
          <!-- Wallet Balance -->
            <div class="container">
              <div class="row g-4">
                <div class="col-5">
                  <div class="card-style p-4 text-center">
                    <h4 class="fw-bold">Wallet Balance</h4>
                    <h2 class="text-success mt-2">₱<?= number_format($walletBalance, 2) ?></h2>
                    <p class="text-muted">
                      Last updated: <?= $lastUpdated ? $lastUpdated->format("F j, Y, g:i a") : 'N/A' ?>
                    </p>
                    <?php if ($walletBalance >= 0): ?>
                    <form method="POST" action="request_payout.php">
                      <button class="btn btn-orange mt-2">Request Payout</button>
                    </form>
                  <?php endif ?>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="card-style">
                    <canvas id="earningsChart"></canvas>
                  </div>
                </div>
              </div>
              
              <!-- Recent Transactions -->
              <h4 class="fw-bold mt-4">Earnings Overview</h4>
              <div class="card-style">
                <h5 class="fw-bold mb-2">Recent Transactions</h5>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead class="table-light">
                      <tr>
                        <th>Date</th>
                        <th>Service Type</th>
                        <th>Amount</th>
                        <th>Fee</th>
                        <th>Net Earnings</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($transactions as $t): ?>
                        <tr>
                          <td><?= $t['paid_at'] ? $t['paid_at']->format('M j, Y') : '-' ?></td>
                          <td><?= htmlspecialchars($t['title']) ?></td>
                          <td>₱<?= number_format($t['amount'], 2) ?></td>
                          <td>₱<?= isset($t['fee_deducted']) ? number_format($t['fee_deducted'], 2) : '0.00' ?></td>
                          <td>₱<?= number_format($t['provider_earnings'], 2) ?></td>
                          <td>
                            <span class="badge bg-<?=
                              $t['status'] == 'released' ? 'success' :
                              ($t['status'] == 'held' ? 'warning' : 'danger') ?>">
                              <?= ucfirst($t['status']) ?>
                            </span>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>

      </div>
      
    </div>
  </div>

  <!-- Add Service Modal -->
   <?php include '../components/add-service-modal.php'; ?>
   <?php include '../components/edit-service-modal.php'; ?>

  <script>
  const earningsChartData = {
    labels: <?= json_encode($labels) ?>,
    data: <?= json_encode($data) ?>
    };

  const labels = <?= json_encode(array_keys($categoryData)) ?>;
  const data = <?= json_encode(array_values($categoryData)) ?>;

  </script>
  <script src="../assets/js/service-provider-panel.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>