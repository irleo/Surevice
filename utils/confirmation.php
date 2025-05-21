<?php
session_start();

// Redirect if accessed without booking ID
if (!isset($_GET['booking_id']) || !is_numeric($_GET['booking_id'])) {
    header("Location: index.php");
    exit;
}

$booking_id = (int)$_GET['booking_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Confirmed</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <style>
    body {
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .confirmation-box {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      max-width: 500px;
      text-align: center;
    }
    .checkmark {
      font-size: 3rem;
      color: green;
    }
  </style>
</head>
<body>

  <div class="confirmation-box">
    <div class="checkmark mb-3"><i class="bi bi-check-square-fill"></i></div>
    <h2 class="mb-3">Booking Confirmed!</h2>

    <?php if ($booking_id > 0): ?>
      <p>Your booking has been successfully recorded with Booking ID:</p>
      <h4 class="text-primary mb-4">#<?= $booking_id ?></h4>
    <?php else: ?>
      <p class="text-danger">Invalid booking ID.</p>
    <?php endif; ?>

    <a href="bookings.php" class="btn btn-success me-2">View Bookings</a>
    <a href="../index.php" class="btn btn-secondary">Return Home</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
  
</body>
</html>
