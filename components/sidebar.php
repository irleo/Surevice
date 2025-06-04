<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>

<style>
  body {
    font-family: 'Poppins', sans-serif;
    padding: 20px;
  }

  .mb-3 {
  text-align: center;
  border-top: 2.3px solid #ff8210;
  padding-bottom: 10px;
  background-color: #efae6f;
  border-radius: 10px;
  padding-bottom: 10px;
  }

  .mb-4.border-top {
    position: relative; 
    overflow: hidden;
    border-radius: 10px;
    border-width: 2px !important;
    padding: 2rem;

  }

  .mb-4.border-top::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: url('/assets/images/surevice-bg.png');
    background-size: cover;
    background-position: center;
    opacity: 0.9; /* increased from 0.1 */
    z-index: 0;
  }

  .mb-4.border-top > *,
  .mb-4.border-top form > * {
    position: relative;
    z-index: 1;
  }

  .mb-4.border-top h3.fs-5 {
    color:rgb(255, 255, 255); 
  }

  .border-top.p-1 {
    position: relative;
    border-radius: 10px;
    padding: 1.5rem;
    overflow: hidden;
    color:rgb(255, 255, 255);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    max-width: 400px;
    margin: auto;
    border-width: 2px !important;
    border-bottom: 2.3px solid #ff8210;
  }

  .border-top.p-1::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: url('/assets/images/surevice-bg.png');
    background-size: cover;
    background-position: center;
    opacity: 0.08;
    border-radius: 10px;
    z-index: 0;
  }

  .border-top.p-1 > *,
  .border-top.p-1 ul > * {
    position: relative;
    z-index: 1;
  }

  h3.fs-5 {
    font-weight: 600;
  }

  h1.fs-4 {
    color:rgb(255, 255, 255);
    margin-bottom: 0.25rem;
    font-size: 2rem;
  }

  h3.fs-5 {
    color:rgb(255, 255, 255);
    margin-bottom: 1rem;
    margin-top: 1rem;
  }
  .text-muted {
    color:rgb(255, 255, 255) !important;
  }

  .form-check {
    font-weight: 500;
    color: #444;
  }

  #clearFilters {
    align-self: flex-start;
  }


  .border-top.p-1 ul {
    margin: 0;
    padding: 0;
    list-style: none;
  }

  .border-top.p-1 ul li {
    margin-bottom: 0.75rem;
  }

  .border-top.p-1 a {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: #282828;
    text-decoration: none;
    transition: color 0.2s ease, transform 0.2s ease;
  }

  .border-top.p-1 a:hover {
    color: #ff8210;
    transform: translateX(4px);
  }

  .border-top.p-1 i {
    font-size: 1.2rem;
    color:#282828;
    transition: color 0.2s ease;
  }

  @media (max-width: 480px) {
    .border-top.p-1 {
      max-width: 100%;
      padding: 1rem;
    }

    .border-top.p-1 h3 {
      font-size: 1.1rem;
    }

    .border-top.p-1 i {
      font-size: 1rem;
    }
  }
</style>

  <div class="mb-3">
    <h1 class="fs-4 fw-bold mb-1">Find the Right Service for You</h1>
    <p class="text-muted mb-0">Explore a wide range of services tailored to your needs.</p>
  </div>


  <!-- Category Filter Section -->
  <div class="mb-4 border-top border-2 p-1">
    <h3 class="fs-5 fw-bold mb-3 mt-3">Filter by Category <i class="bi bi-filter"></i></h3>
    <form id="categoryFilterForm" class="d-flex flex-column gap-2">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="Cleaning Services" id="cat-cleaning">
        <label class="form-check-label" for="cat-cleaning">Cleaning Services</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="Maintenance & Repair" id="cat-maintenance">
        <label class="form-check-label" for="cat-maintenance">Maintenance & Repair</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="Home Improvement" id="cat-home">
        <label class="form-check-label" for="cat-home">Home Improvement</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="Security & Smart Home" id="cat-security">
        <label class="form-check-label" for="cat-security">Security & Smart Home</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="Outdoor & Landscaping" id="cat-outdoor">
        <label class="form-check-label" for="cat-outdoor">Outdoor & Landscaping</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="Other Services" id="cat-other">
        <label class="form-check-label" for="cat-other">Other Services</label>
      </div>

      <button type="button" id="clearFilters" class="btn btn-outline-secondary btn-sm mt-2">Clear All Filters</button>
    </form>
  </div>

  <!-- Contact Section -->
  <div class="border-top border-2 p-1">
    <h3 class="fs-5 fw-bold mb-3 mt-3">Contact Us</h3>
        <ul class="list-unstyled">
      <li class="mb-2">
        <a href="#" class="text-decoration-none text-dark">
          <i class="bi bi-facebook me-2"></i> Facebook
        </a>
      </li>
        </a>
      </li>
      <li class="mb-2">
        <a href="#" class="text-decoration-none text-dark">
          <i class="bi bi-instagram me-2"></i> Instagram
        </a>
      </li>
      <li class="mb-2">
        <a href="mailto:example@gmail.com" class="text-decoration-none text-dark">
          <i class="bi bi-envelope-fill me-2"></i> Gmail
        </a>
      </li>
    </ul>
  </div>

