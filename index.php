<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/index.css">
  <script src="https://kit.fontawesome.com/935365fa89.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <title>Surevice</title>
</head>
<body>

  <?php include 'components/navbar-top.php'; ?>

  <main>
      <div class="row">
        <div class="col-2">
          <div class="side-bar sticky-top">
            <?php include 'components/sidebar.php'; ?>
          </div>
        </div>
        <div class="product-grid col-10">
          <?php include 'components/services.php'; ?>
          <?php include 'components/services-modal.php'; ?>
        </div>
      </div>
  </main>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="assets/js/index.js" defer></script>  
  <script src="assets/js/services-modal.js" defer></script>
</body>
</html>