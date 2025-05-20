<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f8f9fa;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      width: 100%;
      max-width: 400px;
      padding: 2rem;
    }
    .bi-person-circle {
      font-size: 60px;
    }
  </style>
</head>

<body>

  <div class="card shadow-sm">
    <i class="bi bi-person-circle text-center d-block mb-3"></i>
    <h4 class="text-center mb-4">Login to Surevice</h4>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger text-center">
        <?php echo htmlspecialchars($_GET['error']); ?>
      </div>
      <script>
        if (window.history.replaceState) {
          const url = new URL(window.location);
          url.searchParams.delete('error');
          window.history.replaceState({}, document.title, url.toString());
        }
      </script>
    <?php endif; ?>


    <form method="post" action="utils/process-login.php" autocomplete="off">
      <div class="mb-2">
        <label class="form-label mb-0" for="email">Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input type="email" class="form-control form-control-lg bg-light fs-6" name="email" id="email" placeholder="Enter email" required>
        </div>
      </div>
      <div class="mb-4">
        <label class="form-label mb-0" for="password">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-key"></i></span>
          <input type="password" class="form-control form-control-lg bg-light fs-6" name="password" id="password" placeholder="Enter password" required>
        </div>
      </div>
      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>

      <div class="text-center">
        <small>Don't have an account? <a href="register.php">Register</a></small>
      </div>
    </form> 
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
