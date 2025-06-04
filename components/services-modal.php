<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
  #serviceModal .modal-content {
    position: relative;
    font-family: 'Poppins', sans-serif;
    color: #333;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.32);
    border: 2px solid #f69432;
    z-index: 1;
    padding: 10px;
  }

  #serviceModal .modal-content::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: url('/assets/images/surevice-bg.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0.2; 
    z-index: -1;
  }

  #serviceModal .modal-title {
    font-weight: 600;
    font-size: 2rem;
    color: #282828;
    border-bottom: 2px solid #ff8210;
  }

  #serviceModal .btn-close {
    filter: invert(50%) sepia(80%) saturate(600%) hue-rotate(10deg);
  }

  #modalImageCarousel .carousel-item img {
    border-radius: 12px;
    height: 100%;
    object-fit: cover;
    width: 100%;
  }

  #modalImageCarousel {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,0.1);
  }

  #serviceModal .col-md-7 h3#modalServiceName {
    font-size: 1.5rem;
    font-weight: 700;
    color: #282828;
    margin-top: 0.5rem;
  }

  #serviceModal .text-success {
    font-size: 1.5rem;
    color: #282828 !important;
  }

  #serviceModal #modalReview {
    font-size: 1rem;
    color: #ff8210;
    letter-spacing: 0.5px;
  }

  #serviceModal #modalDescription {
    font-size: 1rem;
    color: #555;
    line-height: 1.6;
    margin-top: 0.5rem;
  }

  #modalCategories .badge {
    background-color: #fff0c2;
    color: #a36200;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.4em 0.7em;
    margin-right: 0.5rem;
    border-radius: 50px;
    display: inline-block;
  }

  #serviceModal .modal-body .row:last-child {
    margin-top: 1.5rem;
    background-color:rgb(255, 255, 255);
    padding: 1rem 1rem;
    border-radius: 12px;
  }

  #serviceModal .modal-body .col-2 img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ffcb66;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }

  #serviceModal .modal-body .col-10 h5 {
    color:#282828;
    font-weight: 700;
    margin-bottom: 0.3rem;
  }

  #serviceModal .modal-body .col-10 p {
    font-size: 0.9rem;
    margin-bottom: 0.1rem;
  }

  #serviceModal .modal-footer {
    border-top: 2px solid #ffd47d;
    background-color:rgb(255, 254, 252);
    padding: 1rem 2rem;
    justify-content: flex-start; 
    gap: 1rem;
  }

  #serviceModal .btn-primary {
    background-color: #ff9900;
    border: none;
    font-weight: 600;
    padding: 0.5rem 1.6rem;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(255, 153, 0, 0.3);
    color: white;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
  }

  #serviceModal .btn-primary:hover {
    background-color: #e08600;
    box-shadow: 0 8px 18px rgba(224, 134, 0, 0.45);
  }

  #serviceModal .btn-secondary {
    background-color: #282828;
    border: none;
    font-weight: 600;
    padding: 0.6rem 1.8rem;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(255, 153, 0, 0.3);
    color: white;
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
  }

  #serviceModal .btn-secondary:hover {
    background-color: #ffe6a3;
    color: #3a2900;
  }
</style>

<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg"> 
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
            <h3 id="modalServiceName" class="fw-bold">Service Name</h3>
            <h5 class="text-success fw-semibold">₱<span id="modalFee">0.00</span></h5>
            <div class="mt-2 mb-3">
              <strong>Rating:</strong> <span id="modalReview">★★★★☆ (4.0)</span>
            </div>
            <div>
              <h5 class="mb-0">Description</h5>
              <p id="modalDescription" class="mt-0">Service description goes here.</p>
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
            <img src="/assets/images/logo-go.png" alt="profile picture" class="img-fluid rounded">
          </div>
          <div class="col-10">
            <h5>Service Provider</h5>
            <p id="modalProviderProfile" class="mb-0">Provider details...</p>
            <p id="modalProviderEmail" class="mb-0">Email...</p>
            <p id="modalProviderPhone" class="mb-0">Phone number...</p>
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
