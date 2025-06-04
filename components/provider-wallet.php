<!-- Wallet Balance -->
<div class="container">
  <div class="row g-4">
    <div class="col-5">
      <div class="card-style p-4 text-center">
        <h4 class="fw-bold">Wallet Balance</h4>
        <h2 class="text-success mt-2">₱<?= number_format($walletBalance, 2) ?></h2>
        <p class="text-muted">
          Last updated: <?= $lastUpdated ? $lastUpdated->format("F j, Y, g:i a") : 'N/A' ?>
        </p>
        <?php if ($walletBalance >= 0): ?>
        <form method="POST" action="../utils/request-payout.php">
          <button class="btn btn-orange btn-outline-warning text-black mt-2">Request Payout</button>
        </form>
      <?php endif ?>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card-style">
        <canvas id="earningsChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Recent Transactions -->
  <h4 class="fw-bold mt-4">Earnings Overview</h4>
  <div class="card-style">
    <h5 class="fw-bold mb-2">Recent Transactions</h5>
    <div class="table-responsive wallet-table">
      <table class="table table-hover">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Service Type</th>
            <th>Amount</th>
            <th>Fee</th>
            <th>Net Earnings</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($transactions as $t): ?>
            <tr>
              <td><?= $t['paid_at'] ? $t['paid_at']->format('M j, Y') : '-' ?></td>
              <td><?= htmlspecialchars($t['title']) ?></td>
              <td>₱<?= number_format($t['amount'], 2) ?></td>
              <td>₱<?= isset($t['fee_deducted']) ? number_format($t['fee_deducted'], 2) : '0.00' ?></td>
              <td>₱<?= number_format($t['provider_earnings'], 2) ?></td>
              <td>
                <span class="badge bg-<?=
                  $t['status'] == 'released' ? 'success' :
                  ($t['status'] == 'held' ? 'warning' : 'danger') ?>">
                  <?= ucfirst($t['status']) ?>
                </span>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>