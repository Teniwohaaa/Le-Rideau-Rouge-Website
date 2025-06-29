<?php
session_start(); // Démarrage de la session utilisateur
require('database/db_connect.php'); // Connexion à la base de données

# Vérification si l'utilisateur est connecté via son email
if (!isset($_SESSION['email'])) { // Vérifie si la variable de session 'email' existe
    // Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
    header("Location: login.php");
    exit();
}

try {
    $email = $_SESSION['email']; // Récupère l'email de l'utilisateur connecté
    // Prépare et exécute la requête pour récupérer les infos de l'utilisateur
    $request = $conn->prepare("SELECT id, username, is_admin FROM users WHERE email = '$email'");
    $request->execute();
    $user = $request->fetch(); // Récupère les données utilisateur

    // Vérifie si l'utilisateur existe et s'il est admin
    if (!$user || !$user['is_admin']) {
        // Si l'utilisateur n'est pas admin, redirection vers l'accueil
        header("Location: index.php");
        exit();
    }

    // Récupération des statistiques pour le dashboard
    $reservation_num = $conn->query("SELECT COUNT(*) FROM reservations")->fetchColumn(); // Nombre total de réservations
    $User_number = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn(); // Nombre total d'utilisateurs
    $event_num = $conn->query("SELECT COUNT(*) FROM events")->fetchColumn(); // Nombre total d'événements
    
    // Récupère les 5 prochains événements (par date)
    $upcoming_events = $conn->query("SELECT * FROM events ORDER BY date_event LIMIT 5")->fetchAll();
} catch (PDOException $e) {
    // Affiche une erreur si la connexion ou la requête échoue
    echo "database error: ". $e->getMessage();
}
?>

<head>
    <title>Tableau de Bord - Le Rideau Rouge</title>
    <style>

    .dashboard {
        display: flex;
        flex: 1;
    }

    .sidebar {
        width: 200px;
        background-color: #333;
        color: white;
        padding: 20px 0;
    }

    .sidebar_menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar_menu li a {
        display: flex;
        align-items: center;
        color: white;
        text-decoration: none;
        padding: 10px 15px;
    }

    .sidebar_menu li a:hover {
        background-color: #555;
    }

    .sidebar-icon {
        width: 20px;
        margin-right: 10px;
    }

    .main-content {
        flex: 1;
        padding: 20px;
    }

    .stats-section {
        display: flex; /* Affichage en ligne des cartes de stats */
        gap: 20px; /* Espace entre les cartes */
        margin-top: 20px; /* Espace au-dessus de la section */
    }

    .stat-card {
        border: 1px solid #ddd; /* Bordure grise claire */
        padding: 15px; /* Espacement interne */
        border-radius: 5px; /* Coins arrondis */
        flex: 1; /* Prend la même largeur que les autres cartes */
    }
    </style>
</head>

<body>
    <?php include 'includes/Header.php'; ?>
    <div class="dashboard">
        <aside class="sidebar">
            <!-- Menu latéral de navigation admin -->
            <ul class="sidebar_menu">
                <li><a href="dashboard.php"><img class="sidebar-icon" src="images/dashboard.png" alt="home icon">Tableau
                        de Bord</a></li>
                <li><a href="manage_events.php"><img class="sidebar-icon" src="images/calendar.png"
                            alt="calendar icon">Gérer événment</a></li>
                <li><a href="manage_reservations.php"><img class="sidebar-icon" src="images/ticket.png"
                            alt="ticket icon">Réservations</a></li>
                <li><a href="manage_users.php"><img class="sidebar-icon" src="images/user-circle.png"
                            alt="user-icon">Gérer les utulisateurs</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <!-- En-tête du dashboard -->
            <div class="dashboard-header">
                <h1>Tableau de Bord</h1>
                <p>Bienvenue, <?php echo $user['username'] ?></p>
            </div>

            <!-- Section des statistiques principales -->
            <div class="stats-section">
                <div class="stat-card">
                    <h3>Nombre De reservations</h3>
                    <div class="value"><?php echo $reservation_num ?></div>
                    <a href="manage_reservations.php">Voir les réservations</a>
                </div>

                <div class="stat-card">
                    <h3>Nombre utulisateurs</h3>
                    <div class="value"><?php echo $User_number ?></div>
                    <a href="#">Liste Des utulisateurs</a>
                </div>

                <div class="stat-card">
                    <h3>Nombre D'événements</h3>
                    <div class="value"><?php echo $event_num ?></div>
                    <a href="manage_events.php">Liste Des événements</a>
                </div>
            </div>
            <!-- Fin section stats -->
        </main>
    </div>

    <?php include 'includes/Footer.php'; ?>
</body>

</html>