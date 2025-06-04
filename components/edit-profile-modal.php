<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
    --dark-gray: #282828;
    --light-gold: #efae6f;
    --bright-orange: #ff8210;
    --medium-orange: #f69432;
    --light-gray: #ecedea;
  }

  body, #editProfileModal {
    font-family: 'Poppins', sans-serif;
  }

  #editProfileModal .modal-header {
    background-color: var(--dark-gray);
    color: var(--light-gold);
    border-bottom: 2px solid var(--bright-orange);
    padding: 10px;
    border-radius: 20px;
  }

  #editProfileModal .modal-title {
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 10px;
    margin-top: 10px;
    text-align: center;
  }

  #editProfileModal .btn-close {
    filter: brightness(0) invert(1);
  }

  #editProfileModal .modal-body {
    position: relative;
    background-color: var(--light-gray);
    border-radius: 0 0 0.3rem 0.3rem;
    overflow: hidden;
    padding: 1.5rem;
    border-radius: 20px;
  }

  #editProfileModal .modal-body::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: url('/assets/images/surevice-bg.png');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    opacity: 0.3;
    pointer-events: none;
    z-index: 0;
  }

  #editProfileModal .modal-body > * {
    position: relative;
    z-index: 1;
  }

  #editProfileModal .form-label {
    font-weight: 600;
    color: var(--dark-gray);
  }

  #editProfileModal .form-control,
  #editProfileModal .form-select {
    border: 1.5px solid var(--bright-orange);
    border-radius: 0.3rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  #editProfileModal .form-control:focus,
  #editProfileModal .form-select:focus {
    border-color: var(--medium-orange);
    box-shadow: 0 0 8px rgba(246, 148, 50, 0.6);
    outline: none;
  }

  #editProfileModal .btn-primary {
    background-color: var(--bright-orange);
    background-color: #ff8210;
    color:rgb(255, 255, 255);
    border-radius: 10px;
    padding: 5px;
    margin-top: 20px;
    font-weight: 700;
    transition: background-color 0.3s ease;
  }

  #editProfileModal .btn-primary:hover {
    background-color: var(--medium-orange);
  }

  @media (max-width: 575.98px) {
    #editProfileModal .modal-dialog {
      max-width: 95%;
      margin: 1.75rem auto;
    }

    #editProfileModal .form-control,
    #editProfileModal .form-select {
      font-size: 1rem;
      padding: 0.5rem 0.75rem;
    }

    #editProfileModal .modal-body {
      padding: 1rem 1rem 1.5rem;
    }

    #editProfileModal .mb-3 {
      margin-bottom: 1rem;
    }
  }

  @media (min-width: 576px) and (max-width: 991.98px) {
    #editProfileModal .modal-dialog {
      max-width: 500px;
    }
  }

  #editProfileModal .form-control,
  #editProfileModal .form-select {
    width: 100%;
    box-sizing: border-box;
  }

  @media (max-width: 575.98px) {
    #editProfileModal .modal-footer .btn {
      width: 100%;
      padding: 0.75rem;
      font-size: 1.1rem;
    }
  }
  </style>

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editFirstName" class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" id="editFirstName" value="<?= htmlspecialchars($user['first_name']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="editLastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" id="editLastName" value="<?= htmlspecialchars($user['last_name']) ?>" required>
          </div>
          <div class="mb-3">
            <label for="editPhone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" id="editPhone" value="<?= htmlspecialchars($user['phone']) ?>">
          </div>
          <div class="mb-3">
            <label for="editGender" class="form-label">Gender</label>
            <select class="form-select" name="gender" id="editGender">
              <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
              <option value="Other" <?= $user['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>