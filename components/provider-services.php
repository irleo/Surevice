<div class="d-flex justify-content-between align-items-center mb-3 service-heading">
  <h3>Active Services</h3>
  <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addServiceModal" id="addServiceButton">+ Add Service</button>
</div>

<div class="table-responsive service-table">
  <table class="table table-hover align-middle services-table">
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