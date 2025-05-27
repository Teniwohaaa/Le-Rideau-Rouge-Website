<?php
// Configuration et vérifications initiales
require 'database/db_connect.php';  // Connexion à la base de données
session_start();  // Démarrage de la session utilisateur

// Vérification de la présence d'un ID de réservation
if (!isset($_GET['reservation_id'])) {
    header("Location: index.php");
    exit();
}

// Gestion de la validation de la réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validate_reservation'])) {
    header("Location: index.php");
    exit();
}

try {
    $reservation_id = $_GET['reservation_id'];
    $user_id = $_SESSION['user_id'] ?? 0;
    
    $sql = "SELECT r.*, e.title, e.venue, e.date_event, e.price, e.image_path 
            FROM reservations r
            JOIN events e ON r.event_id = e.id
            WHERE r.id = $reservation_id AND r.user_id = $user_id";
    $result = $conn->query($sql);
    $reservation = $result->fetch();
    
    if (!$reservation) {
        throw new Exception("Réservation non trouvée");
    }
    
    $total_price = $reservation['quantity'] * $reservation['price'];
    
} catch (Exception $e) {
    die("Erreur: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation - <?php echo $reservation['title']?></title>
    <link rel="stylesheet" href="styles/EventStyle.css">
    <link rel="stylesheet" href="styles/style.css">
    <style>
        /* Confirmation Specific Styles */
        .confirmation-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--gray-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            text-align: center;
        }
        
        .confirmation-container h1 {
            color: var(--accent-color);
            margin-bottom: 1.5rem;
        }
        
        .confirmation-details {
            background: var(--dark-color);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--footer-border);
        }
        
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .detail-label {
            font-weight: bold;
            color: var(--accent-color);
        }
        
        .btn-validate {
            background: var(--accent-color);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
        }
        
        .btn-validate:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .success-message {
            color: #28a745;
            font-weight: bold;
            margin-top: 1rem;
        }
        
        /* Hero styles from reservation.php */
        .reservation-hero {
            height: 50vh;
            min-height: 300px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            overflow: hidden;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('images/<?php echo $reservation['image_path']?>');
            background-size: cover;
            background-position: center;
        }
        
        .reservation-hero-content {
            text-align: center;
            color: white;
            padding: 2rem;
            max-width: 800px;
        }
        
        .reservation-hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include 'includes/Header.php'; ?>
    
    <div class="reservation-hero">
        <div class="reservation-hero-content">
            <h2>Confirmation: <?php echo $reservation['title']?></h2>
            <p><?php echo $reservation['venue'] ?> • <?php echo date('d M Y à H:i', strtotime($reservation['date_event'])) ?></p>
        </div>
    </div>
    
    <div class="confirmation-container">
        <h1>Votre réservation est confirmée!</h1>
        
        <div class="confirmation-details">
            <div class="detail-row">
                <span class="detail-label">Événement:</span>
                <span><?php echo $reservation['title']?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Lieu:</span>
                <span><?php echo $reservation['venue']?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date:</span>
                <span><?php echo date('d/m/Y H:i', strtotime($reservation['date_event']))?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nombre de places:</span>
                <span><?php echo $reservation['quantity']?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Prix unitaire:</span>
                <span><?php echo $reservation['price']?> DA</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total:</span>
                <span><?php echo $total_price?> DA</span>
            </div>
        </div>
        
            <form method="POST">
                <button type="submit" name="validate_reservation" class="btn-validate">Valider la réservation</button>
            </form>
        
    </div>
    
    <?php include 'includes/Footer.php'; ?>
</body>
</html>