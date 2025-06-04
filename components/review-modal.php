
<style>
  #reviewModal .modal-content {
    position: relative;
    border-radius: 1rem;
    box-shadow: 0 6px 18px rgba(255, 130, 16, 0.3);
    background-color: rgba(255, 255, 255, 0.95);
    color: #282828;
    font-family: 'Poppins', sans-serif;
    overflow: hidden;
    padding: 0; 
  }

  #reviewModal .modal-content::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: url('/assets/images/surevice-bg.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0.1;
    z-index: 0;
  }

  #reviewModal .modal-header,
  #reviewModal .modal-body,
  #reviewModal .modal-footer {
    position: relative;
    z-index: 1;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
  }

  #reviewModal .modal-header {
    padding-top: 1.25rem;
    padding-bottom: 1.25rem;
  }

  #reviewModal .modal-title {
    font-weight: 600;
    font-size: 1.75rem;
    color: #282828;
    border-bottom: 2px solid #ff8210;
    padding: 5px;
    width: 20%;
  }

  #reviewModal .btn-close {
    filter: invert(20%) sepia(75%) saturate(2000%) hue-rotate(10deg);
  }

  #reviewModal .modal-body .mb-3 {
    display: flex;
    flex-direction: column;
    gap: 0.5rem; 
    margin-bottom: 1.5rem; 
  }

  #reviewModal label.form-label {
    font-weight: 600;
    color: #282828;
  }

  #reviewModal input#rating,
  #reviewModal textarea#comment {
    width: 80%;  
    box-sizing: border-box;
    font-size: 1rem;
    color: #282828;
    border: 1.5px solid #f69432;
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    transition: border-color 0.3s ease;
  }

  #reviewModal textarea.form-control {
    resize: none;
  }

  #reviewModal input#rating:focus,
  #reviewModal textarea#comment:focus {
    border-color: #ff8210;
    box-shadow: 0 0 8px rgba(255, 130, 16, 0.4);
    outline: none;
  }

  #reviewModal .modal-footer {
    padding-top: 1rem;
    padding-bottom: 1rem;
    text-align: right;
    z-index: 1;
  }

  #reviewModal .btn-primary {
    background-color: #ff8210;
    border: none;
    font-weight: 700;
    border-radius: 0.5rem;
    padding: 0.5rem 1.5rem;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }

  #reviewModal .btn-primary:hover,
  #reviewModal .btn-primary:focus {
    background-color: #f69432;
    box-shadow: 0 4px 12px rgba(246, 148, 50, 0.6);
    color: #fff;
  }
</style>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="reviewForm">
        <div class="modal-header">
          <h5 class="modal-title" id="reviewModalLabel">Leave a Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="bookingId" name="booking_id">
          
          <div class="mb-3">
            <label for="rating" class="form-label">Rating (1 to 5):</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
          </div>
          
          <div class="mb-3">
            <label for="comment" class="form-label">Comment (optional):</label>
            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit Review</button>
        </div>
      </form>
    </div>
  </div>
</div>
