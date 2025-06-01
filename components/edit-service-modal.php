<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editServiceForm" action="../utils/edit-service.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="service_id" id="serviceId" />

          <div class="mb-3">
            <label for="editServiceTitle" class="form-label">Service Title</label>
            <input type="text" id="editServiceTitle" name="editServiceTitle" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="editServiceDescription" class="form-label">Service Description</label>
            <textarea class="form-control" id="editServiceDescription" name="editServiceDescription" rows="4" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Categories</label>
            <div class="row g-2">
              <div class="col-md-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="serviceType[]" id="editCategory1" value="Maintenance & Repair" />
                  <label class="form-check-label" for="editCategory1">Maintenance & Repair</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="serviceType[]" id="editCategory2" value="Cleaning Services" />
                  <label class="form-check-label" for="editCategory2">Cleaning Services</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="serviceType[]" id="editCategory3" value="Home Improvement" />
                  <label class="form-check-label" for="editCategory3">Home Improvement</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="serviceType[]" id="editCategory4" value="Outdoor & Landscaping" />
                  <label class="form-check-label" for="editCategory4">Outdoor & Landscaping</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="serviceType[]" id="editCategory5" value="Security & Smart Home" />
                  <label class="form-check-label" for="editCategory5">Security & Smart Home</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="serviceType[]" id="editCategory6" value="Other Services" />
                  <label class="form-check-label" for="editCategory6">Other Services</label>
                </div>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <div class="input-group">
              <span class="input-group-text">₱</span>
              <input type="number" id="editAmount" class="form-control" name="editAmount" step="0.01" required />
            </div>
          </div>
          <div class="mb-3">
            <label for="editServiceImage" class="form-label">Upload Images</label>
            <input type="file" id="editServiceImage" name="images[]" class="form-control" accept="image/*" multiple />
          </div>
          <div class="mb-3">
            <label for="editPrimaryIndex" class="form-label">Image to Display</label>
            <input type="number" id="editPrimaryIndex" name="primary_index" class="form-control" min="1" required />
          </div>
          <div id="editPreviewContainer" style="display: flex; gap: 10px; margin-top: 10px; margin-bottom: 10px;"></div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-orange">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>