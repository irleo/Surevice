 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
 <style>
    body, .modal-content, .modal-content * {
      font-family: 'Poppins', sans-serif;
    }

    .modal-content {
      position: relative;
      border-radius: 12px;
      border: none;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .modal-content::before {
      content: "";
      position: absolute;
      inset: 0;
      background-image: url('/assets/images/surevice-bg.png');
      background-size: cover;
      background-position: center;
      opacity: 0.01; 
      z-index: 0;
    }

    .modal-content > *,
    .modal-body > * {
      position: relative;
      z-index: 1;
    }

    .modal-header {
      background-color: #efae6f;
      border-bottom: 1px solid #dee2e6;
      padding: 0.30rem 0.75rem;
      background-image: url('/assets/images/surevice-bg.png');
      opacity: 0.7;
      text-align: center;
      color:rgb(20, 20, 20);
    }

    .modal-title {
      font-weight: 600;
      font-size: 2.5rem;
      color: #333;
    }

    .btn-close {
      opacity: 0.7;
    }

    .btn-close:hover {
      opacity: 1;
    }

    .modal-body {
      padding: 2rem;
      background-color: rgba(255, 255, 255, 0.95);
      text-align: left;

    }

    .modal-body .form-label {
      font-weight: 500;
      color: #333;
    }

    .modal-body .form-control {
      border-radius: 8px;
      border: 1px solid #ced4da;
      transition: border-color 0.2s;
      text-align: center;
    }

    .modal-body .form-control:focus {
      border-color: #ff8210;
      box-shadow: 0 0 0 0.15rem rgba(255, 130, 16, 0.25);
    }

    .form-check-label {
      font-weight: 500;
      color: #444;
    }

    .modal-footer {
      background-color: rgba(255, 255, 255, 0.9);
      border-top: 1px solid #ff8210;
      padding: 1rem 1.5rem;
    }

    .modal-footer .btn-primary {
      background-color: #ff8210;
      border: none;
      font-weight: 500;
      padding: 0.5rem 1.25rem;
      border-radius: 6px;
      transition: background-color 0.3s;
    }

    .modal-footer .btn-primary:hover {
      background-color: #e66f00;
    }

    .modal-body .col-md-6 {
      margin-bottom: 1.6rem;
    }

    .modal-body .form-check {
      text-align: center;
    }

    .modal-body .col-md-6,
    .modal-body .col-12 {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 0.25rem; 
      margin-bottom: 1.5rem;
    }

    .modal-body .form-label {
      font-weight: 500;
      color: #333;
      text-align: left;
      width: 100%;
      margin-bottom: 0.25rem;
    }

    .modal-body .form-control {
      width: 60%;
      height: 48px;      
      box-sizing: border-box; 
      text-align: left;
      padding: 0.5rem 0.75rem;
      font-size: 1rem;
      border: 1px solid #282828;
    }

    .modal-body .form-check-input {
      width: 1.25rem;
      height: 1.25rem;
      margin-top: 0;
    }

    .modal-body .form-check {
      display: flex;
      align-items: left;
      gap: 0.5rem;
    }
    
    .modal-body .form-check-label {
      text-align: left;
      margin: 0;
    }

    @media (max-width: 576px) {
      .modal-dialog {
        margin: 1rem;
      }

      .modal-body {
        padding: 1.25rem;
      }
    }
  </style>

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