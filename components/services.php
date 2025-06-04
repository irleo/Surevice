<?php
include_once 'utils\config.php';

// Debugging lines:
if (!isset($conn)) {
    die("Connection variable \$conn is not set.");
}

if ($conn === false) {
    die("Database connection failed.");
}

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
WHERE s.is_active = 1
";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die("Query failed:<br><pre>" . print_r(sqlsrv_errors(), true) . "</pre>");
}
// Loop through each service
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $serviceId = $row['service_id'];
    $title = htmlspecialchars($row['title']);
    $description = htmlspecialchars($row['description']);
    $service_fee = number_format($row['service_fee'], 2);
    $rawFee = $row['service_fee'];
    $rating = $row['average_rating'];
    $provider = htmlspecialchars($row['provider_name']);
    $email = htmlspecialchars($row['email']);
    $phone = htmlspecialchars($row['phone']);

    // Fetch all images
    $imageSql = "SELECT image_path, is_primary FROM ServiceImages WHERE service_id = ? ORDER BY is_primary DESC, image_id ASC";
    $imageStmt = sqlsrv_query($conn, $imageSql, [$serviceId]);
    $images = [];
    while ($imgRow = sqlsrv_fetch_array($imageStmt, SQLSRV_FETCH_ASSOC)) {
        $images[] = $imgRow['image_path'];
    }
    if (empty($images)) {
        $images[] = 'assets/images/services/placeholder.jpg';
    }
    $dataImages = htmlspecialchars(implode(',', $images));

    // Get categories with colors
    $categorySql = "
        SELECT c.name, c.color 
        FROM ServiceCategoryLink scl 
        JOIN Categories c ON scl.category_id = c.category_id
        WHERE scl.service_id = ?
    ";

    $catStmt = sqlsrv_query($conn, $categorySql, [$serviceId]);
    $categories = [];
    $categoryNames = [];
    while ($catRow = sqlsrv_fetch_array($catStmt, SQLSRV_FETCH_ASSOC)) {
        $categories[] = [
            'name' => $catRow['name'],
            'color' => $catRow['color']
        ];
        $categoryNames[] = $catRow['name'];
    }
    $categoryData = htmlspecialchars(json_encode($categories), ENT_QUOTES, 'UTF-8');
    $categoryList = htmlspecialchars(implode(', ', $categoryNames), ENT_QUOTES, 'UTF-8');
    $ratingStars = str_repeat("★", floor($rating)) . (fmod($rating, 1) >= 0.5 ? "☆" : "");

    echo <<<HTML
    <div class="product-card" data-category="{$categoryList}" data-categories="{$categoryData}">
        <img src="{$images[0]}" alt="{$title}">
        <h3>{$title}</h3>
        <p>₱{$service_fee}</p>
        <div class="view-details">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#serviceModal" 
                data-service-id="{$serviceId}"
                data-images="{$dataImages}" 
                data-title="{$title}" 
                data-fee="{$rawFee}" 
                data-review="{$ratingStars} ({$rating})"
                data-categories="{$categoryData}" 
                data-description="{$description}" 
                data-provider="{$provider}"
                data-email="{$email}"
                data-phone="{$phone}">
                View Details
            </button>
            <a href="utils/billing.php?service_id={$serviceId}&product={$title}&fee={$rawFee}" class="btn btn-primary">Book Now</a>
        </div>
    </div>
HTML;
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
