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