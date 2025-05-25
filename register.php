<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

   <style>
    body {
      position: relative;
      background-color: #f8f9fa;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-image: url('assets/images/surevice-bg.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    body::before {
      content: '';
      position: fixed;  
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4); 
      pointer-events: none; 
      z-index: 0;
    }
    .card {
      width: 100%;
      max-width: 450px;
      padding: 1.4rem 2rem 2rem ;
      transform: scale(1.05); 
      transform-origin: center center; 
    }
    .bi-person-plus {
      font-size: 60px;
      margin: 0 auto;
    }
    .step {
      display: none;
    }
    .step.active {
      display: block;
    }
  </style>
</head>
<body>

  <div class="card shadow-sm">
    <i class="bi bi-person-plus text-center d-block mb-3"></i>
    <h4 class="text-center mb-0">Create an Account</h4>
    <small class="text-center mb-3">Welcome to Surevice</small>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert" id="server-error-alert" style="position: fixed; top: 1rem; right: 1rem; z-index: 1050; min-width: 300px;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong> Warning! </strong> <?= htmlspecialchars($_GET['error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert" id="server-success-alert" style="position: fixed; top: 1rem; right: 1rem; z-index: 1050; min-width: 300px;">
        <strong> Success! </strong> <?= htmlspecialchars($_GET['success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <script>
        setTimeout(() => {
          window.location.href = 'login.php'; 
        }, 3000); 
      </script>
    <?php endif; ?>


    <form method="post" action="utils/process-register.php" onsubmit="return checkPasswords()" autocomplete="off">
      
      <!-- Step 1 -->
      <div class="step active" id="step-1">
        <div class="mb-3">
          <label class="form-label mb-0">First Name</label>
          <input type="text" class="form-control" name="firstName" placeholder="Enter your first name" required>
        </div>
        <div class="mb-3">
          <label class="form-label mb-0">Last Name</label>
          <input type="text" class="form-control" name="lastName" placeholder="Enter your last name" required>
        </div>
        <div class="mb-3">
          <label class="form-label mb-0" for="phone">Mobile Number</label>
          <div class="input-group">
            <span class="input-group-text">+63</span>
            <input
              type="tel"
              class="form-control"
              id="phone"
              name="phone"
              pattern="[0-9]{10}"
              inputmode="numeric"
              maxlength="10"
              placeholder="XXXXXXXXXXX"
              required
            >
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label mb-0 d-block">Gender</label>
          <div>
            <div class="form-check form-check-inline">
              <input class="form-check-input border-dark" type="radio" name="gender" id="male" value="Male" required>
              <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check form-check-inline ms-5">
              <input class="form-check-input border-dark" type="radio" name="gender" id="female" value="Female" required>
              <label class="form-check-label" for="female">Female</label>
            </div>
            <div class="form-check form-check-inline ms-5">
              <input class="form-check-input border-dark" type="radio" name="gender" id="other" value="Other" required>
              <label class="form-check-label" for="other">Other</label>
            </div>
          </div>
        </div>
        <div class="d-grid">
          <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="step" id="step-2">
        <div class="mb-3">
          <label class="form-label mb-0">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
          <label class="form-label mb-0">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Create a password" required>
        </div>
        <div class="mb-3">
          <label class="form-label mb-0">Confirm Password</label>
          <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Re-enter your password" required>
          <div id="password-warning" class="small text-danger mt-1"></div>
        </div>
        
        <div class="mb-3">
          <label class="form-label mb-0">Date of Birth</label>
          <input type="date" class="form-control" id="dob" name="dob" required>
        </div>

        <div class="d-flex justify-content-between">
          <button type="button" class="btn btn-outline-secondary" onclick="prevStep()">Back</button>
          <button type="submit" class="btn btn-primary" name="btnSignup">Sign Up</button>
        </div>
      </div>

      <div class="text-center mt-3">
        <small>Already have an account? <a href="login.php">Login</a></small>
      </div>
    </form>
  </div>

  <script src="assets/js/register.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>  
  
</body>
</html>