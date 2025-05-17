<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="serviceModalLabel">Service Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Carousel for multiple images -->
          <div class="col-md-5">
            <div id="modalImageCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner" id="modalCarouselInner"></div>
              <button class="carousel-control-prev" type="button" data-bs-target="#modalImageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#modalImageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>

          <!-- Details -->
          <div class="col-md-7">
            <h3 id="modalServiceName">Service Name</h3>
            <h4 class="text-success">₱<span id="modalPrice">0.00</span></h4>
            <div class="mb-3">
              <strong>Rating:</strong> <span id="modalReview">★★★★☆ (4.0)</span>
            </div>
            <div>
              <h5>Description</h5>
              <p id="modalDescription">Service description goes here.</p>
            </div>
            <div class="mt-2">
              <div id="modalCategories" class="mb-3"></div>
            </div>
          </div>
        </div>

        <hr>

        <!-- Provider Info -->
        <div class="row">
          <div class="col-2">
            <img src="assets/images/profiles/product2.jpg" alt="profile picture" class="img-fluid rounded">
          </div>
          <div class="col-10">
            <h5>Service Provider</h5>
            <p id="modalProviderProfile">Provider details...</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="#" class="btn btn-primary" id="modalBookNowLink">Book Now</a>
      </div>
    </div>
  </div>
</div>
