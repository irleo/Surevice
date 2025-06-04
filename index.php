<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['user_type'])) {
    switch ($_SESSION['user_type']) {
        case 'provider':
            header("Location: dashboard/service-provider.php");
            exit;
        case 'admin':
            header("Location: dashboard/admin.php");
            exit;
    }
}
$isLoggedIn = true;
$userName = $_SESSION['name'] ?? 'User';

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="https://kit.fontawesome.com/935365fa89.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <title>Surevice</title>
</head>
<body>
  
  <?php include 'components/navbar-top.php'; ?>
  
  <div class="layout d-flex">
    <aside id="sidebar" class="sidebar p-4">
      <?php include 'components/sidebar.php'; ?>
    </aside>
     
    <main>
      <div class="product-grid">
        <?php include 'components/services.php'; ?>
        <?php include 'components/services-modal.php'; ?>
      </div>
    </main>
  </div>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <script src="assets/js/index.js" defer></script>  
  <script src="assets/js/services-modal.js" defer></script>
</body>
</html>