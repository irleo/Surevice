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