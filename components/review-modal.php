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
