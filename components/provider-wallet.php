<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
      margin: 2rem 0;
    }

    .container {
      max-width: 900px;
      margin: auto;
      padding: 0 1rem;
    }

    .row {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      align-items: center;
    }

    .col-md-5, .col-md-7 {
      flex: 0 0 auto;
    }

    .col-md-5 {
      flex-basis: 40%;
    }

    .col-md-7 {
      flex-basis: 58%;
    }

    @media (max-width: 768px) {
      .col-md-5, .col-md-7 {
        flex-basis: 100%;
      }
    }

    .card-style {
      position: relative;
      background-color: #fff;
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      padding: 1.5rem;
      transition: transform 0.2s ease-in-out;
      overflow: hidden;
    }

    .card-style:hover {
      transform: translateY(-3px);
    }

    .card-style::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background-image: url('/assets/images/surevice-bg.png');
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      opacity: 0.1;
      border-radius: 1rem;
      z-index: 0;
    }

    .card-style > * {
      position: relative;
      z-index: 1;
    }

    .card-style h4 {
      font-weight: 700;
      color: #282828;
    }

    .card-style h2 {
      font-size: 2.5rem;
      color: #ff8210;
      margin-top: 1rem;
    }

    .card-style p {
      font-size: 0.9rem;
      color: #282828;
    }

    .btn-orange {
      background-color: #efae6f !important;
      border-color: #efae6f !important;
      color: #282828 !important;
      font-weight: 600;
      transition: background-color 0.3s ease;
      border-radius: 0.375rem;
      padding: 0.5rem 1rem;
      cursor: pointer;
      border-style: solid;
      border-width: 1px;
    }

    .btn-orange:hover {
      background-color: #f69432 !important;
      border-color: #f69432 !important;
      color: #ecedea !important;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead {
      background-color: #efae6f;
      font-weight: 700;
      color: #282828;
    }

    th, td {
      vertical-align: middle;
      padding: 0.75rem;
      border-bottom: 1px solid #ddd;
      color: #282828;
      text-align: left;
    }

    .badge {
      display: inline-block;
      padding: 0.25em 0.5em;
      border-radius: 0.375rem;
      font-weight: 600;
      font-size: 0.875rem;
    }

    .bg-success {
      background-color: #ff8210;
      color: #ecedea;
    }

    .bg-warning {
      background-color: #f69432;
      color: #282828;
    }

    .bg-danger {
      background-color: #282828;
      color: #efae6f;
    }
</style>

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
              <div class="table-responsive">
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