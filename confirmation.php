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
    // Vérification de l'ID de réservation et de l'utilisateur connecté
    $reservation_id = $_GET['reservation_id'];
    // si il ya une session utilisateur, on récupère son ID sinon on met 0
    $user_id = $_SESSION['user_id'] ?? 0;
    
    // Requête SQL pour récupérer les détails de la réservation
    $sql = "SELECT r.*, e.title, e.venue, e.date_event, e.price, e.image_path 
            FROM reservations r
            JOIN events e ON r.event_id = e.id
            WHERE r.id = $reservation_id AND r.user_id = $user_id";
    // Cette requête sélectionne toutes les colonnes de la table reservations (r.*)
    // ainsi que le titre, le lieu, la date, le prix et l'image de l'événement associé (e.title, e.venue, e.date_event, e.price, e.image_path)
    // Elle fait une jointure entre reservations et events sur l'identifiant de l'événement
    // et filtre sur l'identifiant de la réservation et de l'utilisateur connecté

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
    /* Conteneur principal de la confirmation */
    .confirmation-container {
        max-width: 600px;
        /* Largeur maximale du conteneur */
        margin: 2rem auto;
        /* Marge verticale + centrage horizontal */
        padding: 2rem;
        /* Espacement interne */
        background: var(--gray-color);
        /* Fond gris clair */
        border-radius: var(--border-radius);
        /* Coins arrondis */
        text-align: center;
        /* Texte centré */
    }

    /* Titre principal de la confirmation */
    .confirmation-container h1 {
        color: var(--accent-color);
        /* Couleur d'accent */
        margin-bottom: 1.5rem;
        /* Espace sous le titre */
    }

    /* Bloc des détails de la réservation */
    .confirmation-details {
        background: var(--dark-color);
        /* Fond sombre */
        padding: 1.5rem;
        /* Espacement interne */
        border-radius: var(--border-radius);
        /* Coins arrondis */
        margin-bottom: 2rem;
        /* Espace sous le bloc */
    }

    /* Ligne de détail (label + valeur) */
    .detail-row {
        display: flex;
        /* Disposition en ligne */
        justify-content: space-between;
        /* Espacement entre label et valeur */
        margin-bottom: 1rem;
        /* Espace sous la ligne */
        padding-bottom: 1rem;
        /* Espace interne bas */
    }

    /* Dernière ligne sans bordure ni marge */
    .detail-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    /* Style du label à gauche */
    .detail-label {
        font-weight: bold;
        /* Texte en gras */
        color: var(--accent-color);
        /* Couleur d'accent */
    }

    /* Bouton de validation */
    .btn-validate {
        background: var(--accent-color);
        /* Couleur d'accent */
        color: white;
        /* Texte blanc */
        padding: 1rem 2rem;
        /* Espacement interne */
        border: none;
        /* Pas de bordure */
        border-radius: var(--border-radius);
        /* Coins arrondis */
        font-size: 1.1rem;
        /* Taille du texte */
        cursor: pointer;
        /* Curseur pointeur */
        transition: var(--transition);
        /* Animation fluide */
        margin-top: 1rem;
        /* Espace au-dessus */
    }

    /* Effet au survol du bouton */
    .btn-validate:hover {
        background: var(--secondary-color);
        /* Couleur secondaire */
        transform: translateY(-2px);
        /* Légère élévation */
    }

    /* Bandeau visuel de l'événement (hero) */
    .reservation-hero {
        height: 50%;
        /* Hauteur de la section */
        min-height: 300px;
        /* Hauteur minimale */
        position: relative;
        /* Position relative pour le contenu pour pouvoir positinner des element au dessu */
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        /* Espace sous le hero */
        overflow: hidden;
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
            url('images/<?php echo $reservation['image_path']?>');
        /* Image de fond avec overlay sombre */
        background-size: cover;
        /* Recouvre toute la zone */
        background-position: center;
        /* Centre l'image */
    }

    /* Contenu du hero */
    .reservation-hero-content {
        text-align: center;
        /* Texte centré */
        color: white;
        /* Texte blanc */
        padding: 2rem;
        /* Espacement interne */
        max-width: 800px;
        /* Largeur maximale */
    }

    /* Titre dans le hero */
    .reservation-hero h2 {
        font-size: 2.5rem;
        /* Taille du texte */
        margin-bottom: 1rem;
        /* Espace sous le titre */
    }
    </style>
</head>

<body>
    <?php include 'includes/Header.php'; ?>

    <div class="reservation-hero">
        <div class="reservation-hero-content">
            <h2>Confirmation: <?php echo $reservation['title']?></h2>
            <p><?php echo $reservation['venue'] ?> •
                <?php echo date('d M Y à H:i', strtotime($reservation['date_event'])) ?></p>
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