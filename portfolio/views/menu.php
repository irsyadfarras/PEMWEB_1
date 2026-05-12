<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-lg">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="index.php">
            <i class="fas fa-code me-2 text-info"></i>MyPortfolio
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_GET['page'] ?? 'home') == 'home' ? 'active' : ''; ?>" href="index.php?page=home">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_GET['page'] ?? '') == 'about' ? 'active' : ''; ?>" href="index.php?page=about">
                        <i class="fas fa-user me-1"></i>About Me
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_GET['page'] ?? '') == 'contact' ? 'active' : ''; ?>" href="index.php?page=contact">
                        <i class="fas fa-envelope me-1"></i>Contact Me
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo in_array($_GET['page'] ?? '', ['level', 'studies']) ? 'active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-graduation-cap me-1"></i>My Studies
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?page=level">
                            <i class="fas fa-layer-group me-2 text-primary"></i>Education Levels
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?page=studies">
                            <i class="fas fa-book me-2 text-success"></i>My Education History
                        </a></li>
                    </ul>
                </li>
                <?php if(!isLoggedIn()): ?>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-light px-3 ms-2 rounded-pill" href="login.php">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1 fs-5"></i>
                        <?php echo htmlspecialchars($_SESSION['name']); ?>
                        <span class="badge bg-primary ms-1"><?php echo $_SESSION['role']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">
                            <i class="fas fa-user me-2"></i>Profile
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>