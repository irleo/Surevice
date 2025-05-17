<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['first_name'] ?? 'User'; // Customize this based on your session
?>

<nav id="nav-top">
    <ul>
        <li class="home-li">
            <a class="active-link" href="#">
                <img src="assets/images/logo-nobg.png" id="logo" alt="logo">Surevice
            </a>
        </li>
        <li><a href="index.html">Home</a></li>
        <li class="popdown">
            <a class="disabled">Categories</a>
            <ul class="popdown-menu">
                <li><a href="#">Cleaning</a></li>
                <li><a href="#">Repairs</a></li>
                <li><a href="#">Gardening</a></li>
                <li><a href="#">Computer Assistance</a></li>
                <li><a href="#">Training</a></li>
                <li><a href="#">Man for Hire</a></li>
            </ul>
        </li>
        <li class="bill-li"><a href="billing.html">Billing</a></li>
        <li class="search-li">
            <form id="searchForm">
                <input type="text" placeholder="Search..." name="search" class="search-input">
                <button type="submit" class="search-btn"><i class="bi bi-search"></i></button>
            </form>
        </li>

        <?php if ($isLoggedIn): ?>
            <!-- Dropdown User Profile -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($userName); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                </ul>
            </li>
        <?php else: ?>
            <li><a class="login-link" href="login.php">Login</a></li>
            <li><a class="accent-link" href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>
