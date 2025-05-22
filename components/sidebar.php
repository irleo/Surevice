<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Service Filter Page</title>
  <link rel="stylesheet" href="/assets/css/sidebar.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!-- Left Panel -->
    <div class="left-panel">
      <div class="intro">
        <h1>Find the Right Home Service for You</h1>
        <p>Explore a wide range of home services tailored to your needs.</p>
      </div>

      <div class="filter">
        <h3>Filter by Category</h3>
        <form id="categoryFilterForm">
          <label><input type="checkbox" value="Cleaning Services" /> Cleaning Services</label>
          <label><input type="checkbox" value="Maintenance & Repair" /> Maintenance & Repair</label>
          <label><input type="checkbox" value="Home Improvement" /> Home Improvement</label>
          <label><input type="checkbox" value="Security & Smart Home" /> Security & Smart Home</label>
          <label><input type="checkbox" value="Outdoor & Landscaping" /> Outdoor & Landscaping</label>
          <label><input type="checkbox" value="Other Services" /> Other Services</label>
          <button type="button" id="clearFilters">Clear All Filters</button>
        </form>
      </div>

      <div class="contact">
        <h3>Contact Us</h3>
        <ul>
          <li><i class="bi bi-facebook"></i> Facebook</li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 6px;">
              <path d="M1.64 0h2.26l3.24 4.74L10.94 0h2.26L9.14 6.26 14.5 14H12.1L8.1 8.84 3.9 14H1.64l5.64-7.4L1.64 0Zm2.13 1l4.23 6.2L3.8 13h.66l4.26-5.57 3.84 5.57h.64l-4.17-6.04L12.4 1h-.66l-4 5.21L4.48 1h-.71Z"/>
            </svg>Twitter</li>
          <li><i class="bi bi-instagram"></i> Instagram</li>
          <li><i class="bi bi-google"></i> Gmail</li>
        </ul>
      </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
      <div class="overlay">
    </div>
  </div>
</body>
