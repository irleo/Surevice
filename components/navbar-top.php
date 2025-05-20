
<nav id="nav-top">
    <ul>
        <li class="home-li">
            <a class="active-link" href="#">
                <img src="assets/images/logo-nobg.png" id="logo" alt="logo">Surevice
            </a>
        </li>
        <li><a href="index.php">Home</a></li>
        <li class="popdown">
            <a class="disabled dropdown-toggle align-items-center">Categories</a>
            <ul class="popdown-menu align-items-center">
                <li><a href="#">Maintenance & Repair</a></li>
                <li><a href="#">Home Improvement</a></li>
                <li><a href="#">Security & Smart Home</a></li>
                <li><a href="#">Cleaning Services</a></li>
                <li><a href="#">Outdoor & Landscaping</a></li>
                <li><a href="#">Other Services</a></li>
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
            <li class="nav-item">
                <a class="nav-link accent-link align-items-center" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                    <i class="bi bi-person-circle me-1"></i>
                    <span class="d-none d-md-inline">Profile</span>
                </a>

                <div class="offcanvas offcanvas-end d-flex flex-column offcanvas-orange" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header border-bottom my-1">
                        <h6 class="offcanvas-title ms-2" id="offcanvasExampleLabel">Welcome to Surevice</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body flex-grow-1 d-flex flex-column justify-content-between py-1 px-2">
                        <ul class="nav flex-column w-100">
                            <li class="nav-item">
                                <a class="nav-link w-100 px-4 py-3 border-bottom mt-0" href="user/profile.php">
                                    <i class="bi bi-person-lines-fill me-2"></i> <?php echo htmlspecialchars($userName); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link w-100 px-4 py-3 border-bottom" href="settings.php">
                                    <i class="bi bi-gear me-2"></i> Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link w-100 px-4 py-3 border-bottom" href="user/bookings.php">
                                    <i class="bi bi-card-checklist me-2"></i> Bookings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link w-100 px-4 py-3 border-bottom disabled" href="favorites.php" aria-disabled="true">
                                    <i class="bi bi-heart-fill me-2"></i> Favorites
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link w-100 px-4 py-3 border-bottom disabled" href="notifications.php" aria-disabled="true">
                                    <i class="bi bi-bell-fill me-2"></i> Notifications
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link w-100 px-4 py-3 border-bottom" href="support.php">
                                    <i class="bi bi-question-circle-fill me-2"></i> Help & Support
                                </a>
                            </li>
                        </ul>
                        
                        <div class="w-100">
                            <hr class="m-0">
                            <a class="nav-link text-danger w-100 my-1" href="utils/logout.php">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                            <hr class="mt-0 mb-2">
                            <div class="text-center text-muted small py-2">
                                © 2025 Surevice<br>
                                Built by Hyphomycetes.
                            </div>
                        </div>
                    </div>
                </div>
            </li>

        <?php else: ?>
            <li><a class="accent-link" href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>
