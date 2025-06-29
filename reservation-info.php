<?php
require 'database/db_connect.php';
session_start();
// Démarrage de la session utilisateur

// verifie si l'utulisateur est connecter
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user's reservations
try {
    // On va récupérer l'ID de l'utilisateur connecté
    $user_id = $_SESSION['user_id'];
    // Cette requête SQL permet de récupérer toutes les réservations effectuées par l'utilisateur connecté.
    // Explications détaillées :
    // - On sélectionne toutes les colonnes de la table 'reservations' (r.*) ainsi que certaines colonnes de la table 'events' (titre, lieu, date, prix, image).
    // - La jointure (JOIN) relie chaque réservation à l'événement correspondant grâce à l'identifiant de l'événement (r.event_id = e.id).
    // - On filtre les résultats pour ne garder que les réservations de l'utilisateur actuellement connecté (WHERE r.user_id = $user_id).
    // - Enfin, on trie les réservations par date d'événement décroissante (ORDER BY e.date_event DESC), pour afficher les plus récentes en premier.
    $sql = "SELECT r.*, e.title, e.venue, e.date_event, e.price, e.image_path 
            FROM reservations r
            JOIN events e ON r.event_id = e.id
            WHERE r.user_id = $user_id
            ORDER BY e.date_event DESC";
    // Exécution de la requête SQL
    $result = $conn->query($sql);
    // Récupération de toutes les réservations dans un tableau associatif
    $reservations = $result->fetchAll();
} catch (PDOException $e) {
    // En cas d'erreur lors de la requête, on affiche un message d'erreur
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
    /* Conteneur principal des réservations */
    .reservations-container {
        max-width: 1000px;
        /* Largeur maximale du conteneur */
        margin: 2rem auto;
        /* Marge verticale + centrage */
        padding: 2rem;
        /* Espacement interne */
    }

    /* Style du titre principal de la page */
    .reservations-title {
        text-align: center;
        /* Texte centré */
        margin-bottom: 2rem;
        /* Espace sous le titre */
        color: var(--accent-color);
        /* Utilise la couleur d'accent du thème */
    }

    /* Carte individuelle de réservation */
    .reservation-card {
        background: var(--gray-color);
        /* Fond gris clair */
        border-radius: var(--border-radius);
        /* Coins arrondis */
        padding: 1.5rem;
        /* Espacement interne */
        margin-bottom: 1.5rem;
        /* Espace entre les cartes */
        display: flex;
        /* Disposition horizontale (image + détails) */
        gap: 2rem;
        /* Espace entre l'image et le texte */
    }

    /* Style de l'image de l'événement */
    .reservation-image {
        width: 200px;
        /* Largeur fixe */
        height: 120px;
        /* Hauteur fixe */
        object-fit: cover;
        /* Remplir sans déformation */
        border-radius: var(--border-radius);
        /* Coins arrondis */
    }

    /* Conteneur des détails de l'événement */
    .reservation-details {
        flex: 1;
        /* Prend l'espace restant dans le conteneur flex */
    }

    /* Titre de l'événement dans chaque carte */
    .reservation-details h3 {
        margin-top: 0;
        /* Supprime la marge supérieure par défaut */
        color: var(--accent-color);
        /* Met en valeur avec la couleur d'accent */
    }

    /* Chaque ligne d'information (label + valeur) */
    .detail-row {
        display: flex;
        /* Label et valeur côte à côte */
        margin-bottom: 0.5rem;
        /* Espace entre les lignes */
    }

    /* Style des labels à gauche */
    .detail-label {
        font-weight: bold;
        /* Texte en gras pour l'accentuation */
        width: 150px;
        /* Largeur fixe pour l'alignement */
    }

    /* Message affiché lorsqu'il n'y a aucune réservation */
    .no-reservations {
        text-align: center;
        /* Centre le message */
        padding: 2rem;
        /* Espacement autour du texte */
        background: var(--gray-color);
        /* Fond clair */
        border-radius: var(--border-radius);
        /* Coins arrondis */
    }
    </style>
</head>

<body>
    <?php include 'includes/Header.php'; ?>

    <div class="reservations-container">
        <h1 class="reservations-title">Mes Réservations</h1>
        <!-- on verifi si le nombre de reservations est sup a0 -->
        <?php if (count($reservations) > 0): ?>

        <?php foreach ($reservations as $reservation): 
                    // Calcul du prix total de la réservation car dans la base de donnees on a le prix unitaire mais pas le total
                    $total_price = $reservation['quantity'] * $reservation['price'];
                    $event_date = date('d/m/Y H:i', strtotime($reservation['date_event']));
            ?>
        <div class="reservation-card">
            <!-- on affiche l'image de l'evenment -->
            <img src="images/<?php echo($reservation['image_path']) ?>" alt="<?php echo($reservation['title']) ?>"
                class="reservation-image">
            <div class="reservation-details">
                <!-- ensuite on affiche les details de la reservation -->
                <h3><?php echo($reservation['title']) ?></h3>
                <div class="detail-row">
                    <span class="detail-label">Lieu:</span>
                    <span><?php echo($reservation['venue']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span><?php echo$event_date ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nombre de places:</span>
                    <span><?php echo$reservation['quantity'] ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Prix unitaire:</span>
                    <span><?php echo$reservation['price'] ?> DA</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total:</span>
                    <span><?php echo$total_price ?> DA</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <!-- si aucune reservation n'est trouver alors on affiche un message -->
        <div class="no-reservations">
            <p>Vous n'avez aucune réservation pour le moment.</p>
            <a href="index.php" class="btn">Découvrir nos événements</a>
        </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/Footer.php'; ?>
</body>

</html>