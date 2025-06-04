  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    .dashboard-section {
      position: relative;
      min-height: 100vh;
      padding: 30px;
      background-image: url('/assets/images/surevice-bg.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      color: #ecedea; 
    }

    .dashboard-section::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background-color: rgba(0, 0, 0, 0.52); 
      z-index: 1;
    }

    .dashboard-section > * {
      position: relative;
      z-index: 2;
    }

    .card-style {
      background-color: rgba(255, 250, 250, 0.97);
      border-radius: 15px;
      padding: 20px;
      text-align: center;
      color:#282828;
    }

    .card-style:hover {
      transform: translateY(-4px);
    }

    .card-style i {
      font-size: 30px;
      margin-bottom: 10px;
      color: #ff8210;
    }

    .table-box {
      background-color: rgba(255, 252, 252, 0.98);
      padding: 20px;
      border-radius: 10px;
      overflow-x: auto;
      color: #282828;
    }

    .dashboard-table {
      width: 100%;
      color: #282828;
    }

    .dashboard-table th, .dashboard-table td {
      padding: 12px;
      border-bottom: 1px solid rgba(40, 40, 40, 0.21);
    }

    .dashboard-table th {
      text-transform: uppercase;
    }

    .badge.bg-warning {
      background-color: #ff6f00 !important; 
      color: #fff !important;               
    }

    .badge.bg-info {
      background-color: #282828 !important;  
      color: #fff !important;                
    }

    .btn-sm {
      margin-right: 5px;
    }
  </style>

<div class="row g-4 mb-4">
  <div class="col-md-3">
    <div class="card-style">
      <i class="bi bi-wallet2"></i>
      <h4>Wallet Balance</h4>
      <h3 class="fw-bold">₱<?= number_format($walletBalance, 2) ?></h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card-style">
      <i class="bi bi-cash-stack"></i>
      <h4>Total Earnings</h4>
      <h3 class="fw-bold">₱<?= number_format($totalEarnings, 2) ?></h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card-style">
      <i class="bi bi-calendar2-week"></i>
      <h4>Monthly Income</h4>
      <h3 class="fw-bold">₱<?= number_format($monthlyIncome, 2) ?></h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card-style">
      <i class="bi bi-clock-history"></i>
      <h4>Pending Amount</h4>
      <h3 class="fw-bold">₱<?= number_format($pendingAmount, 2) ?></h3>
    </div>
  </div>
</div>

<div class="row">
  <div>
    <div class="table-box">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold m-0">Service Requests</h5>
      </div>
      <table class="dashboard-table">
        <thead>
          <tr>
            <th>Date & Time</th>
            <th>Service Type</th>
            <th>Customer</th>
            <th>Address</th>
            <th>Amount</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($charges)): ?>
            <tr>
              <td colspan="7" class="text-center text-muted">No bookings yet.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($charges as $row): ?>
              <tr>
                <td><?= $row['scheduled_for'] ? date_format($row['scheduled_for'], 'M j, Y - h:i A') : '-' ?></td>
                <td><?= htmlspecialchars($row['service_type']) ?></td>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <td style="max-width: 250px; max-height: 60px; overflow-y: auto; white-space: normal;">
                  <?= nl2br(htmlspecialchars($row['address'])) ?>
                </td>
                <td>₱<?= number_format($row['amount'] ?? 0, 2) ?></td>
                <td>
                  <?php if ($row['status'] === 'pending'): ?>
                    <span class="badge bg-warning text-dark"><?= ucfirst($row['status']) ?></span>
                  <?php elseif ($row['status'] === 'in_progress'): ?>
                    <span class="badge bg-info text-dark">In Progress</span>
                  <?php else: ?>
                    <span class="badge"><?= ucfirst($row['status']) ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($row['status'] === 'pending'): ?>
                    <button class="btn btn-sm btn-success booking-action" data-id="<?= $row['booking_id'] ?>" data-action="confirm">Confirm</button>
                    <button class="btn btn-sm btn-danger booking-action" data-id="<?= $row['booking_id'] ?>" data-action="decline">Decline</button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>