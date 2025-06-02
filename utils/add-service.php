<?php
session_start();
require __DIR__ . '/../utils/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'provider') {
    http_response_code(403);
    echo 'Unauthorized';
    exit;
}



$provider_id = $_SESSION['user_id'];
$title = $_POST['serviceTitle'] ?? '';
$description = $_POST['serviceDescription'] ?? '';
$fee = $_POST['amount'] ?? 0;
$primary_index = $_POST['primary_index'] ?? 1;
$categories = $_POST['serviceType'] ?? [];

if (!$title || !$fee || empty($_FILES['images']['name']) || empty($categories)) {
  echo "Missing required fields";
  exit;
}

// Insert into Services table
$sql = "INSERT INTO Services (provider_id, title, description, service_fee) VALUES (?, ?, ?, ?)";
$stmt = sqlsrv_query($conn, $sql, [$provider_id, $title, $description, $fee]);

if (!$stmt) {
  echo "Failed to insert service.";
  exit;
}

// Get the new service_id
$getId = sqlsrv_query($conn, "SELECT @@IDENTITY AS id");
$service_id = sqlsrv_fetch_array($getId, SQLSRV_FETCH_ASSOC)['id'];

// Handle image upload
$upload_dir = '../assets/images/services/';
$image_paths = [];

for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
  $tmp_name = $_FILES['images']['tmp_name'][$i];
  $name = basename($_FILES['images']['name'][$i]);
  $target = $upload_dir . time() . "_" . $name;

  if (move_uploaded_file($tmp_name, $target)) {
    $relative_path = substr($target, strpos($target, 'assets/'));
    $is_primary = ($i + 1 == (int)$primary_index) ? 1 : 0;
    $image_paths[] = [$relative_path, $is_primary];
  }
}

if ((int)$primary_index > count($_FILES['images']['name'])) {
  echo "Primary index exceeds number of uploaded images.";
  exit;
}

// Insert images to ServiceImages
foreach ($image_paths as [$path, $is_primary]) {
  sqlsrv_query($conn, "INSERT INTO ServiceImages (service_id, image_path, is_primary) VALUES (?, ?, ?)", [$service_id, $path, $is_primary]);
}

// Link categories
foreach ($categories as $cat_name) {
  $cat_query = sqlsrv_query($conn, "SELECT category_id FROM Categories WHERE name = ?", [$cat_name]);
  if ($row = sqlsrv_fetch_array($cat_query, SQLSRV_FETCH_ASSOC)) {
    $cat_id = $row['category_id'];
    sqlsrv_query($conn, "INSERT INTO ServiceCategoryLink (service_id, category_id) VALUES (?, ?)", [$service_id, $cat_id]);
  }
}

echo "success";
?>
