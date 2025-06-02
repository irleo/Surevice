<!-- Modal -->
<div class="modal fade" id="verifyDocumentsModal" tabindex="-1" aria-labelledby="verifyDocumentsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data" action="../utils/submit-documents.php">
        <div class="modal-header">
          <h5 class="modal-title" id="verifyDocumentsModalLabel">Submit Verification Documents</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-muted">Please upload the required documents for verification. Any valid ID</p>

          <div class="mb-3">
            <label for="documentFiles" class="form-label">Upload Document(s)</label>
            <input class="form-control" type="file" name="documents[]" id="documentFiles" multiple required accept=".pdf,.jpg,.jpeg,.png">
            <div class="form-text">You can upload multiple files (PDF, JPEG, JPG, PNG).</div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" name="submit-documents" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
