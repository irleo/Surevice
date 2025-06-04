<h2>User Management</h2>
  <p>Approve or suspend user accounts.</p>
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>User Type</th>
        <th>Status</th>  
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
          <tr>
            <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars(ucfirst($user['user_type'])) ?></td>
            <?php
              $statusText = '';
              if ($user['user_type'] === 'provider') {
                if ($user['is_verified'] == 0) {
                  $statusText = 'Pending Verification';
                } else {
                  $statusText = ucfirst($user['account_status']);
                }
              } else {
                $statusText = ucfirst($user['account_status']);
              }
            ?>
            <td><?= $statusText ?></td>
            <td>
              <?php if ($user['account_status'] === 'Pending'): ?>
                <button class="btn approve-btn" data-id="<?= $user['user_id'] ?>">Approve</button>
              <?php endif; ?>
              <?php if ($user['account_status'] === 'Suspended'): ?>
                <button class="btn reactivate-btn" data-id="<?= $user['user_id'] ?>">Reactivate</button>
              <?php elseif ($user['account_status'] === 'Active'): ?>
                <button class="btn suspend-btn" data-id="<?= $user['user_id'] ?>">Suspend</button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-muted">No users yet.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
  <div id="pagination" class="pagination"></div>