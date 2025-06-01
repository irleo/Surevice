<?php
session_start();
require __DIR__ . '/config.php';  

$address = ''; 
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
    $sql = "
        SELECT street, barangay, city, province, postal_code
        FROM Addresses
        WHERE user_id = ? AND is_default = 1
    ";
    $stmt = sqlsrv_query($conn, $sql, array($user_id));
    if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $address = trim("{$row['street']}, {$row['barangay']}, {$row['city']}, {$row['province']} {$row['postal_code']}");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Billing Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/billing.css">
  
</head>
<body>
  <img src="../assets/images/surevice-bg.png" alt="background" id="bg-img">
  <div class="layer"></div>

  <div class="billing-form">
    <fieldset id="billing">
      <legend class="text-center fs-3 mb-2">Billing Information</legend>
    
      <form id="billingForm" method="POST" action="submit-booking.php">
        <input type="hidden" name="service_id" id="serviceId" value="">

        <div class="mb-3">
          <label for="addressOption" class="form-label mb-0">Choose Address</label>
          <select class="form-select" id="addressOption" onchange="toggleAddressInput(this.value)">
            <option value="new" <?= empty($address) ? 'selected' : '' ?>>Enter new address</option>
            <option value="saved" <?= !empty($address) ? 'selected' : '' ?>>Use saved address</option>
          </select>
        </div>

        <div class="mb-3" id="addressField">
          <label for="address" class="form-label mb-0">Complete Address</label>
          <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your address" required>
            <?= htmlspecialchars($address) ?>
          </textarea>
        </div>

        <div class="mb-3">
          <label for="productName" class="form-label mb-0">Service Name</label>
          <input type="text" class="form-control" id="productName" name="productName" placeholder="Chosen Service" readonly disabled>
        </div>

        <div class="mb-3">
          <label for="service_fee" class="form-label mb-0">Service Fee</label>
          <input type="number" class="form-control" id="service_fee" name="service_fee" placeholder="Fee (₱)"? min="0" required disabled>
        </div>

        <div class="mb-3">
          <label for="scheduledFor" class="form-label mb-0">Schedule Date</label>
          <input type="datetime-local" class="form-control" id="scheduledFor" name="scheduled_for" required>
        </div>

        <div class="mb-3">
          <label for="paymentMethod" class="form-label mb-0">Payment Method</label>
          <select class="form-select" id="paymentMethod" name="payment_method" required>
            <option value="" disabled selected>Select a method</option>
            <option value="e-wallet">E-Wallet</option>
            <option value="credit">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="bank">Bank Transfer</option>
          </select>
        </div>

        <div class="d-flex mt-4 align-items-center justify-content-between">
          <a href="../index.php">Go back</a>
          <div class="ms-auto d-flex gap-2">
            <!-- <button type="button" onclick="clearCart()" class="btn btn-danger btn-sm">Clear</button> -->
            <button type="submit" class="btn btn-primary btn-sm">Confirm Booking</button>
          </div>
        </div>
      </form>
    </fieldset>
  </div>

  <script src="../assets/js/billing.js" defer></script>
</body>
</html>
