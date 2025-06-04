<?php
if (session_status() === PHP_SESSION_NONE) { # verifie si une session est actif sinon elle commance une
    session_start();
}

$is_admin = 0; 
if (isset($_SESSION['is_admin'])) { # verifi si l'utulisateur est admin, si il ne l'est pas on ne donne pas 1
    #si l'utulisateur l'est alors on lui donne 1    
    if ($_SESSION['is_admin'] == 1) {
        $is_admin = 1;
    }
}
?>

<head>
    <link rel="stylesheet" href="styles/style.css">
</head>
<header class="site-header">

    <div class="header-container">
        <!-- Section du logo -->
        <div class="logo-container">
            <!-- si on interzgie avec le logo il nous dirige vers index.php -->
            <a href="index.php" class="logo-link">
                <img src="images/Brand-Icon.png" alt="Logo Le Rideau Rouge">
                <h1 class="logo-name">Le Rideau Rouge</h1>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="nav-menu">
            <!-- menue de navigation -->
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
                    <!-- username + user icon -->
                    <img src="images/user-circle.png" alt="User" class="icon"> <?php echo $_SESSION['username']; ?>
                    <img src="images/caret-down.png" alt="Expand" class="icon">
                    <!--image de la fleche  -->
                </button>

                <div class="dropdown-content">
                    <?php if ($is_admin == 1): ?>
                    <!-- si l'utulisateur est admin alors le dropdown auras dashboard et logout" -->
                    <a href="dashboard.php">
                        <img src="images/dashboard.png" alt="Dashboard" class="icon"> Dashboard
                    </a>
                    <?php else: ?>
                    <!-- sinon on affiche "mes reservations" et logout -->
                    <a href="reservation-info.php">
                        <img src="images/ticket.png" alt="Ticket" class="icon"> Mes Réservations
                    </a>
                    <?php endif; ?>
                    <a href="logout.php">
                        <img src="images/sign-out.png" alt="Logout" class="icon"> Se déconnecter
                    </a>
                </div>
            </div>
            <?php else: ?>
            <!-- si l'utulisateur n'est pas connecter alors on a "conexion" si on on interagis on se dirige vers login.php  -->
            <a href="login.php" class="user-icon">
                <img src="images/user-circle.png" alt="User" class="icon">
                <span class="login-text">Connexion</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
</header>