<?php
require 'database/db_connect.php'; // Connexion à la base de données
session_start(); // Démarrage de la session utilisateur

$category = 'cinema'; // Catégorie à afficher
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Cinéma - Le Rideau Rouge</title>
    <link rel="stylesheet" href="styles/EventStyle.css">
</head>

<body>
    <?php include 'includes/Header.php'; ?>
    <?php
    // Requête pour récupérer tous les événements de la catégorie cinéma
    $sql = "SELECT * FROM events WHERE category='$category'";
    $result = $conn->query($sql); // Exécution de la requête
    $events = $result->fetchAll(); // Récupération des résultats sous forme de tableau associatif
    $total_events = count($events); // Nombre total d'événements

    // Affichage de l'événement principal (le premier de la liste)
    if ($total_events > 0) {
        $featured = $events[0]; // Premier événement en vedette
    ?>
    <div class="event-hero">
        <!-- Image et informations de l'événement principal -->
        <img src="images/<?php echo $featured['image_path']; ?>" alt="<?php echo $featured['title']; ?>">
        <div class="event-hero-info">
            <h2><?php echo $featured['title']; ?></h2>
            <p><?php echo $featured['venue']; ?><br>
                <?php echo date('d M à H:i', strtotime($featured['date_event'])); ?></p>
            <!-- Lien pour réserver cet événement -->
            <a href="reservation.php?id=<?php echo $featured['id']; ?>" class="event-btn">Réserver</a>
            <!-- avant d'aller vers reservation on save le id de l'event en question -->
        </div>
    </div>
    <?php 
        }
        else { ?>
    <!-- Message si aucun événement principal n'est disponible -->
    <div class="event-hero-info">
        <h2>
            <?php echo "no featured event";?>
        </h2>
    </div>
    <?php } ?>
    <!-- Liste des autres événements -->
    <section class="events-list">
        <h2 class="events-section-title">Événements à venir</h2>
        <div class="events-grid">
            <?php foreach($events as $event): ?>
            <!-- Parcours de chaque événement du tableau $events -->
            <div class="event-card">
                <!-- Image de l'événement -->
                <img src="images/<?php echo $event['image_path']; ?>" alt="<?php echo $event['title']; ?>"
                    class="event-image">
                <div class="event-card-info">
                    <!-- Titre de l'événement -->
                    <h3><?php echo $event['title']; ?></h3>
                    <div class="event-meta">
                        <!-- Lieu de l'événement -->
                        <p><img src="images/location.png" alt="Location" class="icon"> <?php echo $event['venue']; ?>
                        </p>
                        <!-- Date et heure de l'événement -->
                        <p><img src="images/calendar.png" alt="Date" class="icon">
                            <?php echo date('d M H:i', strtotime($event['date_event'])); ?></p>
                    </div>
                    <!-- Lien pour réserver cet événement -->
                    <a href="reservation.php?id=<?php echo $event['id']; ?>" class="event-btn">Réserver</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include 'includes/Footer.php'; ?>
</body>

</html>