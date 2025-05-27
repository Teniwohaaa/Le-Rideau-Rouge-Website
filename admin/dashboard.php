<?php
// session_start();
// require 'database/db_connect.php';

// // Check if user is logged in and is admin
// if (!isset($_SESSION['email'])) {
//     header("Location: login.php");
//     exit();
// }

// try {
//     // Get user info using PDO
//     $stmt = $conn->prepare("SELECT id, username, is_admin FROM users WHERE email = ?");
//     $stmt->execute([$_SESSION['email']]);
//     $user = $stmt->fetch(PDO::FETCH_ASSOC);

//     if (!$user || !$user['is_admin']) {
//         header("Location: index.php");
//         exit();
//     }

//     // Get stats for dashboard
//     $upcoming_events = $conn->query("SELECT COUNT(*) FROM events WHERE date_event > NOW()")->fetchColumn();
//     $total_reservations = $conn->query("SELECT COUNT(*) FROM reservations")->fetchColumn();
//     $new_messages = 0; // Placeholder for future message system

//     // Get recent events
//     $recent_events = $conn->query("SELECT e.*, COUNT(r.id) as reservation_count 
//                                   FROM events e 
//                                   LEFT JOIN reservations r ON e.id = r.event_id 
//                                   WHERE e.date_event > NOW()
//                                   GROUP BY e.id 
//                                   ORDER BY e.date_event ASC 
//                                   LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// } catch (PDOException $e) {
//     die("Database error: " . $e->getMessage());
// }
?>  
<head>
    <title>Tableau de Bord - Le Rideau Rouge</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
<?php include 'includes/Header.php'; ?>
<div class="dashboard">
    <aside class="sidebar">
        <ul class="sidebar_menu">
            <li><a href="dashboard.php"><img class="sidebar-icon" src="" alt="home icon">Tableau de Bord</a></li>
            <li><a href="manage-events.php"><img class="sidebar-icon src="" alt="calendar icon">Gérer événment</a></li>
            <li><a href="manage_reservations.php"><img class="sidebar-icon src="" alt="ticket icon">Réservations</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="dashboard-header">
            <h1>Tableau de Bord</h1>
            <p>Bienvenue, <?= htmlspecialchars($user['username']) ?></p>
        <h1>Bienvenue,<? echo $user['username']?></h1>

        <a href="manage_events.php" class="btn">+ Ajouter un Événement</a>
        </div>
        <div class="Stats-station">
            <div class="stat-card">
                <h3>Nombre De reservations</h3>
                <div class="value"><?php echo $reservation_num ?></div>
                <a href="manage_events.php">Liste Des utulisateurs</a>
            </div>

            <div class="stat-card">
                <h3>Nombre utulisateurs</h3>
                <div class="value"><?php echo $User_number ?></div>
                <a href="manage_reservation.php">Liste Des utulisateurs</a>
            </div>

            <div class="Starts-card">
                <h3>Nombre D'événements</h3>
                <div class="value"><?php echo $event_num ?></div>
                <a href="manage_events.php">Liste Des événements</a>
            </div>
        </div>
        <div class="recent-events">
            <h2>Prochains Événements</h2>
            <div>

            </div>

        </div>
    </main>
</div>

<?php include 'includes/Footer.php'; ?>
</body>
</html>