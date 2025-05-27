<?php
require 'database/db_connect.php';
session_start();

// verifie si l'utulisateur est connecter
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user's reservations
try {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT r.*, e.title, e.venue, e.date_event, e.price, e.image_path 
            FROM reservations r
            JOIN events e ON r.event_id = e.id
            WHERE r.user_id = $user_id
            ORDER BY e.date_event DESC";
    $result = $conn->query($sql);
    $reservations = $result->fetchAll();
} catch (PDOException $e) {
    die("Erreur de base de données: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Réservations - Le Rideau Rouge</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        .reservations-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
        }
        
        .reservations-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--accent-color);
        }
        
        .reservation-card {
            background: var(--gray-color);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
            display: flex;
            gap: 2rem;
        }
        
        .reservation-image {
            width: 200px;
            height: 120px;
            object-fit: cover;
            border-radius: var(--border-radius);
        }
        
        .reservation-details {
            flex: 1;
        }
        
        .reservation-details h3 {
            margin-top: 0;
            color: var(--accent-color);
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 0.5rem;
        }
        
        .detail-label {
            font-weight: bold;
            width: 150px;
        }
        
        .no-reservations {
            text-align: center;
            padding: 2rem;
            background: var(--gray-color);
            border-radius: var(--border-radius);
        }
    </style>
</head>
<body>
    <?php include 'includes/Header.php'; ?>
    
    <div class="reservations-container">
        <h1 class="reservations-title">Mes Réservations</h1>
        
        <?php if (count($reservations) > 0): ?>
            <?php foreach ($reservations as $reservation): 
                $total_price = $reservation['quantity'] * $reservation['price'];
                $event_date = date('d/m/Y H:i', strtotime($reservation['date_event']));
            ?>
                <div class="reservation-card">
                    <img src="images/<?= htmlspecialchars($reservation['image_path']) ?>" alt="<?= htmlspecialchars($reservation['title']) ?>" class="reservation-image">
                    <div class="reservation-details">
                        <h3><?= htmlspecialchars($reservation['title']) ?></h3>
                        <div class="detail-row">
                            <span class="detail-label">Lieu:</span>
                            <span><?= htmlspecialchars($reservation['venue']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Date:</span>
                            <span><?= $event_date ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Nombre de places:</span>
                            <span><?= $reservation['quantity'] ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Prix unitaire:</span>
                            <span><?= $reservation['price'] ?> DA</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Total:</span>
                            <span><?= $total_price ?> DA</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-reservations">
                <p>Vous n'avez aucune réservation pour le moment.</p>
                <a href="index.php" class="btn">Découvrir nos événements</a>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include 'includes/Footer.php'; ?>
</body>
</html>