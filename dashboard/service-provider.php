<?php
session_start();
require __DIR__ . '/../utils/config.php';

// Provider-only access check
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'provider') {
    header("Location: ../login.php");
    exit;
}

$stmt = sqlsrv_query($conn, "SELECT first_name, last_name, is_verified FROM Users WHERE user_id = ?", [$_SESSION['user_id']]);
if ($stmt === false) {
    die("SQL error: " . print_r(sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if (!$row) {
    die("No user found with user_id: " . $_SESSION['user_id']);
}

$_SESSION['is_verified'] = (bool)$row['is_verified'];
$fullName = $row['first_name'] . ' ' . $row['last_name'];
$userType = $_SESSION['user_type'] ?? 'provider'; 
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

    
  <div class="sidebar">
    <div class="mb-2 logo-container ">
      <img src="../assets/images/logo-go.png" alt="Surevice Logo" class="logo" />
    </div>

    <div class="text-left mb-3 border-bottom pb-2">
      <h4 class="fw-bold"><?= htmlspecialchars($fullName) ?></h4>
      <small class="fw-light fs-6"><?= htmlspecialchars(ucfirst(string: $userType)) ?></small>
    </div>

    <?php if ($_SESSION['is_verified']): ?>
      <a href="#" id="dashboardLink" class="d-block mb-2"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="#" id="profileLink" class="d-block mb-2"><i class="bi bi-person"></i> Profile</a>
      <a href="#" id="servicesLink" class="d-block mb-2"><i class="bi bi-tools"></i> Services</a>
      <a href="#" id="walletLink" class="d-block mb-2"><i class="bi bi-wallet2"></i> Wallet</a>
      <a href="#" class="d-block mb-2 nav-link disabled text-secondary"><i class="bi bi-question-circle"></i> Help</a>
    <?php else: ?>
      <div class="alert alert-warning text-center fs-6">
        Your account is not verified. Please complete your profile and wait for admin approval.
      </div>
      <a href="#" class="d-block mb-2 nav-link disabled text-secondary"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="#" id="profileLink" class="d-block mb-2"><i class="bi bi-person"></i> Profile</a>
      <a href="#" class="d-block mb-2 nav-link disabled text-secondary"><i class="bi bi-tools"></i> Services</a>
      <a href="#" class="d-block mb-2 nav-link disabled text-secondary"><i class="bi bi-wallet2"></i> Wallet</a>
      <a href="#" class="d-block mb-2 nav-link disabled text-secondary"><i class="bi bi-question-circle"></i> Help</a>
    <?php endif; ?>

    <a href="../utils/logout.php" class="d-block mb-2 logout-btn mt-auto"><i class="bi bi-box-arrow-right"></i>Logout</a>
  </div>

  <!-- Main Content -->
  <main>
      <h2 class="fw-bold mb-4 section-title" id="sectionTitle">Service Provider</h2>

      <!-- Dashboard Content -->
      <div id="dashboardContent">
        <?php include '../components/provider-dashboard.php'; ?>
      </div>

      <!-- Profile Content -->
      <div id="profileContent" style="display:none;">
        <?php include '../user/profile.php'; ?>
      </div>
      
      <!-- Services Content -->
      <div id="servicesContent" style="display:none;">
        <?php include '../components/provider-services.php'; ?>
      </div>

      <!-- Wallet Content -->
      <div id="walletContent" style="display:none;">
        <?php include '../components/provider-wallet.php'; ?>
      </div>
    </div>
  </main>
      

  <!-- Add Service Modal -->
<?php 
  include '../components/add-service-modal.php'; 
  include '../components/edit-service-modal.php';                     
?>

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