<?php
session_start();
require __DIR__ . '/../utils/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$sql = "SELECT first_name, last_name, user_type, address FROM Users WHERE user_id = ?";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bookings</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/bookings.css">
</head>
<body>
<div class="overlay">
  <div class="container">
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
          <h2>Saved Address</h2>
          <p id="savedAddress"><?= htmlspecialchars($user['address'] ?? 'No address saved.') ?></p>
        </div>
        <div class="card">
          <h2>Payment Method</h2>
          <p id="paymentMethod">Gcash •••••• 7823</p> 
        </div>
      </section>
    </main>
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
