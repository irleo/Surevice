<!-- Add Service Modal -->
  <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="addServiceModalLabel">Add Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <div class="modal-body">
            <form id="addServiceForm" action="../utils/add-service.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="serviceTitle" class="form-label">Service Title</label>
              <input type="text" id="serviceTitle" name="serviceTitle" class="form-control" required />
            </div>
            <div class="mb-3">
              <label for="serviceDescription" class="form-label">Service Description</label>
              <textarea class="form-control" id="serviceDescription" name="serviceDescription" rows="4" placeholder="Enter a detailed description of your service..." required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Categories</label>
                <div class="row g-2">
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="serviceType[]" id="category1" value="Maintenance & Repair">
                      <label class="form-check-label" for="category1">Maintenance & Repair</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="serviceType[]" id="category2" value="Cleaning Services">
                      <label class="form-check-label" for="category2">Cleaning Services</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="serviceType[]" id="category3" value="Home Improvement">
                      <label class="form-check-label" for="category3">Home Improvement</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="serviceType[]" id="category4" value="Outdoor & Landscaping">
                      <label class="form-check-label" for="category4">Outdoor & Landscaping</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="serviceType[]" id="category5" value="Security & Smart Home">
                      <label class="form-check-label" for="category5">Security & Smart Home</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="serviceType[]" id="category6" value="Other Services">
                      <label class="form-check-label" for="category6">Other Services</label>
                    </div>
                  </div>
                </div>
              </div>
            <div class="mb-3">
              <label for="amount" class="form-label">Amount</label>
              <div class="input-group">
                <span class="input-group-text">₱</span>
                <input type="number" id="amount" class="form-control" name="amount" step="0.01" required />
              </div>
            </div>
            <div class="mb-3">
              <label for="serviceImage" class="form-label">Upload Images</label>
              <input type="file" id="serviceImage" name="images[]" class="form-control" accept="image/*" multiple required />
            </div>
            <div class="mb-3">
              <label for="primaryIndex" class="form-label">Image to Display</label>
              <input type="number" id="primaryIndex" name="primary_index" class="form-control" min="1" required />
            </div>
            <div id="previewContainer" style="display: flex; gap: 10px; margin-top: 10px;"></div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-orange">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>