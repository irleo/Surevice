<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/index.css">
  <script src="https://kit.fontawesome.com/935365fa89.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <script src="js/index.js" defer></script>
  <title>Surevice</title>
</head>
<body>

  <nav>
    <ul>
      <li class="home-li"><a class="active-link" href="#"><img src="images/logo-nobg.png" id="logo" alt="logo">Surevice</a></li>
      <li><a href="index.html">Home</a></li>
      <li class="popdown">
        <a class="disabled">Categories</a>
        <ul class="popdown-menu">
          <li><a href="#">Car Parts</a></li>
          <li><a href="#">Books</a></li>
          <li><a href="#">Clothing</a></li>
          <li><a href="#">Home</a></li>
          <li><a href="#">Garden</a></li>
          <li><a href="#">Beauty</a></li>
        </ul>
      </li>
      <li class="bill-li"><a href="billing.html">Billing</a></li>
      <li class="search-li">
        <form id="searchForm">
          <input type="text" placeholder="Search..." name="search" class="search-input">
          <button type="submit" class="search-btn"><i class="bi bi-search"></i></button>
        </form>
      </li>
      <li><a class="login-link" href="login.html">Login</a></li>
      <li><a class="accent-link" href="register.html">Register</a></li>
    </ul>
  </nav>

  <main>
    <div class="product-grid">
      <div class="product-card">
        <img src="images/product1.jpg" alt="Product 1">
        <h3>Product 1</h3>
        <p>₱1,299,999.00</p>
        <div class="check-out">
          <button>Add to Cart</button>
          <a href="billing.html?product=Product+1&price=1299999.00&qty=1" class="btn btn-primary">Buy Now</a>
        </div>
      </div>
      <div class="product-card">
        <img src="images/product2.jpg" alt="Product 2">
        <h3>Product 2</h3>
        <p>₱899,000.00</p>
        <div class="check-out">
          <button>Add to Cart</button>
          <a href="billing.html?product=Product+2&price=899000.00&qty=1" class="btn btn-primary">Buy Now</a>
        </div>
      </div>
      <div class="product-card">
        <img src="images/product3.jpg" alt="Product 3">
        <h3>Product 3</h3>
        <p>₱349.99</p>
        <div class="check-out">
          <button>Add to Cart</button>
          <a href="billing.html?product=Product+3&price=349.99&qty=1" class="btn btn-primary">Buy Now</a>
        </div>
      </div>
      <div class="product-card">
        <img src="images/product4.jpg" alt="Product 4">
        <h3>Product 4</h3>
        <p>₱159.99</p>
        <div class="check-out">
          <button>Add to Cart</button>
          <a href="billing.html?product=Product+4&price=159.99&qty=1" class="btn btn-primary">Buy Now</a>
        </div>
      </div>
      <div class="product-card">
        <img src="images/product5.jpg" alt="Product 5">
        <h3>Product 5</h3>
        <p>₱529.99</p>
        <div class="check-out">
          <button>Add to Cart</button>
          <a href="billing.html?product=Product+5&price=529.99&qty=1" class="btn btn-primary">Buy Now</a>
        </div>
      </div>
      <div class="product-card">
        <img src="images/product6.jpg" alt="Product 6">
        <h3>Product 6</h3>
        <p>₱339,000.00</p>
        <div class="check-out">
          <button>Add to Cart</button>
          <a href="billing.html?product=Product+6&price=339000.00&qty=1" class="btn btn-primary">Buy Now</a>
        </div>
      </div>
      <div class="product-card">
        <img src="images/product7.jpg" alt="Product 7">
        <h3>Product 7</h3>
        <p>₱449.99</p>
        <div class="check-out">
          <button>Add to Cart</button>
          <a href="billing.html?product=Product+7&price=449.99&qty=1" class="btn btn-primary">Buy Now</a>
        </div>
      </div>
      <div class="product-card">
        <img src="images/product8.jpg" alt="Product 8">
        <h3>Product 8</h3>
        <p>₱2,519,000.00</p>
        <div class="check-out">
          <button>Add to Cart</button>
          <a href="billing.html?product=Product+8&price=2519000.00&qty=1" class="btn btn-primary">Buy Now</a>
        </div>
      </div>
    </div>
  </main>
  

  <!-- <footer>
    <ul>
      <li><a href="#"><i class="bi bi-facebook"></i>Facebook</a></li>
      <li><a href="#"><i class="bi bi-twitter"></i></i>Twitter</a></li>
      <li>
        <a class="disabled-link">
          © 2025 Surevice. All rights reserved.
        </a>
      </li>
      <li><a href="#"><i class="bi bi-instagram"></i>Instagram</a></li>
      <li><a href="#"><i class="bi bi-google"></i></i>Gmail</a></li>
    </ul>
	</footer> -->
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>  
</body>
</html>