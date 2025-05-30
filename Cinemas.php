<?php
require 'database/db_connect.php';
session_start();
$category = 'cinema';
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
    #on met le resultat dans conn-> query() 
    # puis on fetch le resultat et on me met dans evets, puis on store le nombre des events en utulisants count()
    $sql = "SELECT * FROM events WHERE category='$category'";
    $result = $conn->query($sql); 
    $events = $result->fetchAll();
    $total_events = count($events);
    
     # ici on va afficher la 1er event, dabord enverifie si les nombre d'events depassent 0 ensuite on va 
     # afficher le 1er element 
    if ($total_events > 0) {
        $featured = $events[0];
    ?>
        <div class="event-hero">
            <img src="images/<?php echo $featured['image_path']; ?>" alt="<?php echo $featured['title']; ?>">
            <div class="event-hero-info">
                <h2><?php echo $featured['title']; ?></h2>
                <p><?php echo $featured['venue']; ?><br>
                   <?php echo date('d M à H:i', strtotime($featured['date_event'])); ?></p>
                <a href="reservation.php?id=<?php echo $featured['id']; ?>" class="event-btn">Réserver</a>
                <!-- avant d'aller vers reservation on save le id de l'event en question -->
            </div>
        </div>
        <?php 
        }
        else { ?>
            <div class="event-hero-info">
                <h2><? echo "no featured event";?></h2>
            </div> 
       <?php } ?>
    <section class="events-list">
        <h2 class="events-section-title">Événements à venir</h2>
        <div class="events-grid">
            <?php foreach($events as $event): ?>
                <div class="event-card">
                    <img src="images/<?php echo $event['image_path']; ?>" 
                         alt="<?php echo $event['title']; ?>" 
                         class="event-image">
                    <div class="event-card-info">
                        <h3><?php echo $event['title']; ?></h3>
                        <div class="event-meta">
                            <p><img src="images/location.png" alt="Location" class="icon"> <?php echo $event['venue']; ?></p>
                            <p><img src="images/calendar.png" alt="Date" class="icon"> <?php echo date('d M H:i', strtotime($event['date_event'])); ?></p>
                        </div>
                        <a href="reservation.php?id=<?php echo $event['id']; ?>" 
                           class="event-btn">Réserver</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include 'includes/Footer.php'; ?>
</body>
</html>