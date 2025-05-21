<?php
session_start();
require __DIR__ . '/../utils/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$sql = "
SELECT u.first_name, u.last_name, u.user_type,
       a.label, a.street, a.barangay, a.city, a.province, a.postal_code
FROM Users u
LEFT JOIN Addresses a ON u.user_id = a.user_id AND a.is_default = 1
WHERE u.user_id = ?";

$user_stmt = sqlsrv_query($conn, $sql, [$user_id]);
$user = sqlsrv_fetch_array($user_stmt, SQLSRV_FETCH_ASSOC);

// Fetch current bookings
$current_sql = "
SELECT s.title, b.scheduled_for, b.status
FROM Bookings b
JOIN Services s ON s.service_id = b.service_id
WHERE b.customer_id = ? AND b.status IN ('pending', 'in_progress')
";
$current_stmt = sqlsrv_query($conn, $current_sql, [$user_id]);
$current_bookings = [];
while ($row = sqlsrv_fetch_array($current_stmt, SQLSRV_FETCH_ASSOC)) {
    $current_bookings[] = $row;
}

// Fetch past transactions
$past_sql = "
SELECT s.title, b.scheduled_for, b.status, p.amount
FROM Bookings b
JOIN Services s ON s.service_id = b.service_id
JOIN Payments p ON p.booking_id = b.booking_id
WHERE b.customer_id = ? AND b.status = 'completed'
";
$past_stmt = sqlsrv_query($conn, $past_sql, [$user_id]);
$past_transactions = [];
while ($row = sqlsrv_fetch_array($past_stmt, SQLSRV_FETCH_ASSOC)) {
    $past_transactions[] = $row;
}

// Fetch saved address
$addr_sql = "SELECT * FROM Addresses WHERE user_id = ? AND is_default = 1";
$addr_stmt = sqlsrv_query($conn, $addr_sql, [$user_id]);
$address = sqlsrv_fetch_array($addr_stmt, SQLSRV_FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bookings</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/bookings.css">
</head>
<body>
<div class="overlay">
  <div class="container-fluid d-flex">
    <aside class="sidebar">
      <div class="brand">
        <img src="../assets/images/logo-go.png" alt="Surevice Logo" class="logo" />
      </div>
      <div class="profile">
        <h2><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h2>
        <p><?= htmlspecialchars(ucfirst($user['user_type'])) ?></p>
      </div>
      <nav class="menu">
        <a href="../index.php">Home</a>
        <a href="#" class="active">Bookings</a>
        <a href="../utils/logout.php">Logout</a>
      </nav>
    </aside>
    <main class="main-content">
      <h1>Bookings</h1>

      <section class="card">
        <h2>Current Bookings</h2>
        <div id="currentBookings" class="booking-list">
          
        </div>
      </section>

      <section class="card">
        <h2>Past Transactions</h2>
        <table>
          <thead>
            <tr>
              <th>Service</th>
              <th>Date</th>
              <th>Status</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody id="pastTransactions">
            
          </tbody>
        </table>
      </section>

      <section class="grid address-payment-grid">
        <div class="card">
          <div class="d-flex justify-content-between align-items-center">
            <h2>Saved Address</h2>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addressModal">Edit</button>
          </div>
          <p id="savedAddress">
            <?php if ($user['street']): ?>
              <?= htmlspecialchars("{$user['label']} - {$user['street']}, {$user['barangay']}, {$user['city']}, {$user['province']} {$user['postal_code']}") ?>
            <?php else: ?>
              <em>No address saved.</em>
            <?php endif; ?>
          </p>
        </div>
        <div class="card">
          <h2>Payment Method</h2>
          <p id="paymentMethod">Gcash •••••• 7823</p> 
        </div>
      </section>
    </main>
  </div>
</div>

<!-- Edit Address -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="../utils/save-address.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addressModalLabel">Edit Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body row g-3 p-4">
        <div class="col-md-6">
          <label for="label" class="form-label">Label</label>
          <input type="text" class="form-control" id="label" name="label" placeholder="e.g., Home, Work"
                 value="<?= htmlspecialchars($address['label'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label for="street" class="form-label">Street</label>
          <input type="text" class="form-control" id="street" name="street" required
                 value="<?= htmlspecialchars($address['street'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label for="barangay" class="form-label">Barangay</label>
          <input type="text" class="form-control" id="barangay" name="barangay" required
                 value="<?= htmlspecialchars($address['barangay'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label for="city" class="form-label">City</label>
          <input type="text" class="form-control" id="city" name="city" required
                 value="<?= htmlspecialchars($address['city'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label for="province" class="form-label">Province</label>
          <input type="text" class="form-control" id="province" name="province" required
                 value="<?= htmlspecialchars($address['province'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label for="postal_code" class="form-label">Postal Code</label>
          <input type="text" class="form-control" id="postal_code" name="postal_code"
                 value="<?= htmlspecialchars($address['postal_code'] ?? '') ?>">
        </div>
        <div class="col-12 form-check mt-3 ms-2">
          <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1"
                 <?= (isset($address['is_default']) && $address['is_default']) ? 'checked' : '' ?>>
          <label class="form-check-label" for="is_default">Set as default</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Address</button>
      </div>
    </form>
  </div>
</div>


  <script>
    const currentBookings = <?= json_encode(array_map(function($b) {
      return [
        'service' => $b['title'],
        'date' => $b['scheduled_for']->format('F j, Y - g:i A'),
        'status' => $b['status']
      ];
    }, $current_bookings), JSON_HEX_TAG); ?>;

    const pastTransactions = <?= json_encode(array_map(function($t) {
      return [
        'service' => $t['title'],
        'date' => date('F j, Y', strtotime($t['scheduled_for'])),
        'status' => $t['status'],
        'amount' => "₱" . number_format($t['amount'], 2)
      ];
    }, $past_transactions), JSON_HEX_TAG); ?>;
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <script src="../assets/js/bookings.js" defer></script>
</body>
</html>
