<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// check if user is admin (beginner version)
$is_admin = 0;
if (isset($_SESSION['is_admin'])) {
    if ($_SESSION['is_admin'] == 1) {
        $is_admin = 1;
    }
}
?>
<head>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<header class="site-header">
    <div class="header-container">
        <!-- Logo Section -->
        <div class="logo-container">
            <a href="index.php" class="logo-link">
                <img src="images/Brand-Icon.png" alt="Logo Le Rideau Rouge">
                <h1 class="logo-name">Le Rideau Rouge</h1>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="nav-menu">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="Cinemas.php">Cinémas</a></li>
                <li><a href="Theatres.php">Théâtres</a></li>
                <li><a href="Opera.php">Opéras</a></li>
            </ul>
        </nav>

        <!-- User Actions -->
        <div class="user-actions">
            <?php if (isset($_SESSION['username'])): ?>
                <div class="user-dropdown">
                    <button class="dropbtn">
                        <i class="fas fa-user-circle"></i> <?php echo $_SESSION['username']; ?>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <?php if ($is_admin == 1): ?>
                            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        <?php else: ?>
                            <a href="reservation-info.php"><i class="fas fa-ticket-alt"></i> Mes Réservations</a>
                        <?php endif; ?>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="user-icon">
                    <i class="fas fa-user-circle"></i>
                    <span class="login-text">Connexion</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>