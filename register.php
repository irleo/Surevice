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
      background-color: #f8f9fa;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      width: 100%;
      max-width: 450px;
      padding: 2rem;
    }
    .bi-person-plus {
      font-size: 60px;
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
              placeholder="XXXXXXXXXXX"
              required
            >
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label mb-0 d-block">Gender</label>
          <div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
              <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check form-check-inline ms-1">
              <input class="form-check-input" type="radio" name="gender" id="female" value="Female" required>
              <label class="form-check-label" for="female">Female</label>
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