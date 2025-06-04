<h2>Service Provider Verification</h2>
  <p>Review submitted documents and ID for verification.</p>
            
  <?php if (empty($providers)): ?>
      <div class="doc-box">
        <p>No providers pending verification.</p>
      </div>
  <?php else: ?>
      <?php foreach ($providers as $provider): ?>
          <div class="doc-box">
              <strong>Provider:</strong> <?= htmlspecialchars($provider['name']) ?><br>
        
              <?php if (count($provider['documents']) === 0): ?>
                  <em>No submitted documents.</em><br>
              <?php else: ?>
                  <ul>
                      <?php foreach ($provider['documents'] as $doc): ?>
                          <li>
                              <a href="../assets/documents/<?= htmlspecialchars($doc['filename']) ?>" target="_blank"><?= htmlspecialchars($doc['filename']) ?></a>
                              <div class="ms-auto">
                                <button class="btn approve-doc" data-doc-id="<?= $doc['document_id'] ?>">Approve</button>
                                <button class="btn reject-doc" data-doc-id="<?= $doc['document_id'] ?>">Reject</button>
                              </div>
                          </li>
                      <?php endforeach; ?>
                  </ul>
              <?php endif; ?>
          </div>
          <hr>
      <?php endforeach; ?>
  <?php endif; ?>