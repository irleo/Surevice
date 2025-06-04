<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
  body {
    position: relative;
    min-height: 100vh;
    background-color: #ecedea;
    font-family: 'Poppins', sans-serif;
  }

  body::before {
    content: "";
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: url('/assets/images/surevice-bg.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0.1;
    z-index: 0;
    pointer-events: none;
  }

  .container {
    position: relative;
    z-index: 1;
  }

  /* Color variables */
  :root {
    --main-orange: #ff8210;
    --dark-gray: #282828;
    --light-orange: #efae6f;
    --medium-orange: #f69432;
    --light-bg: #ecedea;
  }
  

  .d-flex.justify-content-between.align-items-center.mb-3 {
    margin-bottom: 1.5rem;
  }

  .d-flex h3.fw-bold {
    color: #282828;
  }

  .d-flex.justify-content-between.align-items-center.mb-3 h3.fw-bold {
    font-weight: 700;
    font-size: 1.75rem;
    color: var(--dark-gray);
    margin: 0;
  }

  .btn.btn-warning#addServiceButton {
    background-color: var(--main-orange);
    border-color: var(--main-orange);
    color: #fff;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    box-shadow: 0 4px 8px rgb(255 130 16 / 0.4);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }

  .btn.btn-warning#addServiceButton:hover,
  .btn.btn-warning#addServiceButton:focus {
    background-color: var(--medium-orange);
    border-color: var(--medium-orange);
    box-shadow: 0 6px 12px rgb(246 148 50 / 0.6);
    color: #fff;
  }

  .table-responsive {
    overflow-x: auto;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgb(0 0 0 / 0.05);
    background-color: #fff;
    padding: 1rem;
  }

  .table.table-hover.align-middle {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 0.75rem;
  }

  .table thead.table-light {
    background-color: var(--light-orange);
    color: var(--dark-gray);
    font-weight: 600;
    border-radius: 1rem;
  }

  .table thead.table-light th {
    border: none;
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 1rem;
    vertical-align: middle;
  }

  .table tbody tr {
    background-color: #fff;
    border-radius: 1rem;
    box-shadow: 0 2px 5px rgb(0 0 0 / 0.05);
    transition: box-shadow 0.2s ease;
  }

  .table tbody tr:hover {
    box-shadow: 0 6px 14px rgb(255 130 16 / 0.25);
  }

  .table tbody td {
    padding: 1rem 1.25rem;
    vertical-align: middle;
    color: var(--dark-gray);
    font-size: 0.95rem;
  }

  .btn.btn-sm.btn-warning.edit-service-btn {
    background-color: var(--light-orange);
    border-color: var(--light-orange);
    color: var(--dark-gray);
    font-weight: 600;
    padding: 0.25rem 0.7rem;
    border-radius: 0.4rem;
    margin-right: 0.4rem;
    transition: background-color 0.3s ease;
  }

  .btn.btn-sm.btn-warning.edit-service-btn:hover,
  .btn.btn-sm.btn-warning.edit-service-btn:focus {
    background-color: var(--medium-orange);
    border-color: var(--medium-orange);
    color: #fff;
  }

  .btn.btn-sm.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
    font-weight: 600;
    padding: 0.25rem 0.7rem;
    border-radius: 0.4rem;
    transition: background-color 0.3s ease;
  }

  .btn.btn-sm.btn-danger:hover,
  .btn.btn-sm.btn-danger:focus {
    background-color: #a62a37;
    border-color: #a62a37;
    color: #fff;
  }

  @media (max-width: 576px) {
    .d-flex.justify-content-between.align-items-center.mb-3 {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.75rem;
    }

    .btn#addServiceButton {
      width: 100%;
      text-align: center;
    }
  }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold m-0">Active Services</h3>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addServiceModal" id="addServiceButton">+ Add Service</button>
            </div>
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Title</th>
                  <th>Fee</th>
                  <th>Rating</th>
                  <th>Categories</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
    
                // Query to get services with provider info
                  $sql = "
                  SELECT
                      s.service_id,
                      s.title,
                      s.description,
                      s.service_fee,
                      s.average_rating,
                      u.first_name + ' ' + u.last_name AS provider_name,
                      u.email,
                      u.user_id,
                      u.phone,
                      si.image_path
                  FROM Services s
                  JOIN Users u ON s.provider_id = u.user_id
                  LEFT JOIN (
                      SELECT service_id, image_path
                      FROM ServiceImages
                      WHERE is_primary = 1
                  ) si ON s.service_id = si.service_id
                  WHERE s.is_active = 1 and u.user_id = ?
                  ";
                  $stmt = sqlsrv_query($conn, $sql, [$provider_id]);
                  if ($stmt === false) {
                      die("Query failed:<br><pre>" . print_r(sqlsrv_errors(), true) . "</pre>");
                  }
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $serviceId = $row['service_id'];
                    $title = htmlspecialchars($row['title']);
                    $fee = number_format($row['service_fee'], 2);
                    if ($row['average_rating'] === null) {
                      $ratingDisplay = 'No reviews yet';
                    } else {
                      $ratingValue = floatval($row['average_rating']);
                      $stars = str_repeat("★", floor($ratingValue)) . (fmod($ratingValue, 1) >= 0.5 ? "☆" : "");
                      $ratingDisplay = number_format($ratingValue, 1) . " " . $stars;
                    }
                    // Fetch categories
                    $catStmt = sqlsrv_query($conn, "
                        SELECT c.name
                        FROM ServiceCategoryLink scl
                        JOIN Categories c ON scl.category_id = c.category_id
                        WHERE scl.service_id = ?", [$serviceId]);
                    $categoryNames = [];
                    while ($catRow = sqlsrv_fetch_array($catStmt, SQLSRV_FETCH_ASSOC)) {
                        $categoryNames[] = $catRow['name'];
                    }
                    $categoryList = implode(', ', $categoryNames);
                    $description = htmlspecialchars($row['description']);
                    $service_fee = $row['service_fee'];
                    $categoryArray = $categoryNames;
                    // Fetch all images for the service
                    $imageQuery = "SELECT image_path, is_primary FROM ServiceImages WHERE service_id = ?";
                    $imageStmt = sqlsrv_query($conn, $imageQuery, [$serviceId]);
                    $imagePaths = [];
                    $primaryIndex = 1;
                    $index = 1;
                    while ($imgRow = sqlsrv_fetch_array($imageStmt, SQLSRV_FETCH_ASSOC)) {
                        $imagePaths[] = $imgRow['image_path'];
                        if ($imgRow['is_primary']) {
                            $primaryIndex = $index;
                        }
                        $index++;
                    }
                    $encodedCategories = htmlspecialchars(json_encode($categoryNames), ENT_QUOTES);
                    $fullImagePaths = array_map(fn($path) => "/Surevice/" . ltrim($path, "/"), $imagePaths);
                    $encodedImages = htmlspecialchars(json_encode($fullImagePaths));
    
                    $bookingCheck = sqlsrv_query($conn, "SELECT COUNT(*) AS count FROM Bookings WHERE service_id = ?", [$serviceId]);
                    $count = sqlsrv_fetch_array($bookingCheck, SQLSRV_FETCH_ASSOC)['count'];
                    echo <<<HTML
                    <tr>
                    <td>{$title}</td>
                    <td>₱{$fee}</td>
                    <td>{$ratingDisplay}</td>
                    <td>{$categoryList}</td>
                    <td>
                      <button class="btn btn-sm btn-warning edit-service-btn"
                        data-id="{$serviceId}"
                        data-title="{$title}"
                        data-description="{$description}"
                        data-fee="{$service_fee}"
                        data-categories='{$encodedCategories}'
                        data-images='{$encodedImages}'
                        data-primary="{$primaryIndex}"
                        data-bs-toggle="modal"
                        data-bs-target="#editServiceModal">
                        Edit
                      </button>
                      <button class="btn btn-sm btn-danger" onclick="confirmDelete({$serviceId})">Delete</button>
                    </td>
                  </tr>
        HTML;
                }
                ?>
              </tbody>
            </table>
          </div>