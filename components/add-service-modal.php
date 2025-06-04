<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  .modal-content {
    font-family: 'Poppins', sans-serif;
    border-radius: 20px;
    border: none;
    position: relative;
    padding: 20px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    background-color: rgba(40, 40, 40, 0.9); 
    overflow: hidden; 
  }

  .modal-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('/assets/images/surevice-bg.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0.1; 
    z-index: 0;
  }

  .modal-content > * {
    position: relative;
    z-index: 1;
  }

  .modal-title {
    font-size: 2rem;
    font-weight: 600;
    color: #ff8210;
    border-bottom: 2px solid #ecedea; 
    padding-bottom: 10px;
    margin-bottom: 20px;
    letter-spacing: 1px;
  }

  .form-label {
    color: #ecedea;
    padding: 10px 5px;          
    display: inline-block;      
    font-weight: 500;
    font-size: 1.4rem;
    white-space: nowrap;
    letter-spacing: 1px;      
  }

  .form-check-label {
    color:white;
    font-weight: 500;
    font-size: 1rem;
    border
    padding-bottom: 10px;
  }

  .form-check-input {
    transform: scale(1.2);
    margin-right: 8px;
  }

  .form-control,
  .input-group-text,
  input[type="file"],
  textarea {
    background-color: #f9f9f9;
    color: #000;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 0.95rem;
    padding: 15px 15px;
    font-family: 'Poppins', sans-serif;
  }

  .input-group-text {
    font-weight: 500;
  }

  .form-label {
    display: block;
    margin-bottom: 6px;
  }

  textarea.form-control {
    width: 100%;
    display: block;
    box-sizing: border-box;
  }

  #serviceDescription {
    resize: none;
  }

  .btn-orange {
    background-color: #ff6600;
    border: none;
    color: #fff;
    font-weight: 600;
    padding: 10px 24px;
    border-radius: 10px;
    transition: background-color 0.3s ease;
    font-size: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    font-family: 'Poppins', sans-serif;
  }

  .btn-orange:hover {
    background-color: #e65c00;
  }

  #previewContainer {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
  }

  #previewContainer img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #ccc;
  }

  @media (max-width: 768px) {
    .modal-content {
      padding: 20px;
    }

    .btn-orange {
      width: 100%;
    }

    #previewContainer img {
      width: 60px;
      height: 60px;
    }
  }
</style>
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