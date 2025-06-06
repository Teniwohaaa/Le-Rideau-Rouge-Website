<?php
session_start();
require('database/db_connect.php');

# on va vérifier si l'utilisateur est connecté et s'il est admin
if (!isset($_SESSION['email'])) { # isset verifie si la variable existe et n'est pas nulle
    # si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
    header("Location: login.php");
    exit();
}

try {
    $email = $_SESSION['email'];
    $request = $conn->prepare("SELECT id, username, is_admin FROM users WHERE email = '$email'");
    $request->execute();
    $user = $request->fetch();
    if (!$user || !$user['is_admin']) {
        # si l'utilisateur n'est pas admin, on le redirige vers la page d'accueil
        header("Location: index.php");
        exit();
    }

    # laintenan on recup Les stats pour le dashboard
    $reservation_num = $conn->query("SELECT COUNT(*) FROM reservations")->fetchColumn(); # ici on va fetch le nombre de réservations
    $User_number = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $event_num = $conn->query("SELECT COUNT(*) FROM events")->fetchColumn();
    
    # recup les 5 prochains evenements
    $upcoming_events = $conn->query("SELECT * FROM events ORDER BY date_event LIMIT 5")->fetchAll();
} catch (PDOException $e) {
    echo "database error: ". $e->getMessage();
}
?>

<head>
    <title>Tableau de Bord - Le Rideau Rouge</title>
    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
<?php include 'includes/Header.php'; ?>
<div class="dashboard">
    <aside class="sidebar">
        <ul class="sidebar_menu">
            <li><a href="dashboard.php"><img class="sidebar-icon" src="images/dashboard.png" alt="home icon">Tableau de Bord</a></li>
            <li><a href="manage_events.php"><img class="sidebar-icon" src="images/calendar.png" alt="calendar icon">Gérer événment</a></li>
            <li><a href="manage_reservations.php"><img class="sidebar-icon" src="images/ticket.png" alt="ticket icon">Réservations</a></li>
            <li><a href="manage_users.php"><img class="sidebar-icon" src="images/user-circle.png" alt="user-icon">Gérer les utulisateurs</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="dashboard-header">
            <h1>Tableau de Bord</h1>
            <p>Bienvenue, <?php echo $user['username'] ?></p>
        </div>
        
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
        
       
    </main>
</div>

<?php include 'includes/Footer.php'; ?>
</body>
</html>