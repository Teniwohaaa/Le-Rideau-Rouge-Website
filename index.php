<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Rideau Rouge - Accueil</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/EventStyle.css"> <!-- Fix typo in 'styles' -->
</head>
<body>
    <?php include 'includes/Header.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-image"></div>
        <div class="hero-content">
            <h1>Bienvenue au <span>Rideau Rouge</span></h1>
            <p>Découvrez les meilleurs événements culturels près de chez vous</p>
            <div class="hero-buttons">
                <a href="#categories" class="btn">Explorer</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="categories-section">
        <h2 class="section-title">Nos Catégories</h2>
        <p class="section-subtitle">Choisissez votre expérience culturelle</p>
        
        <div class="categories-grid">
            <div class="category-card">
                <img src="images/cinema.png" alt="Cinéma" class="category-image">
                <div class="category-content">
                    <h3>Cinéma</h3>
                    <p>Découvrez les dernières sorties et classiques du grand écran</p>
                    <a href="Cinemas.php" class="btn">Voir les films</a>
                </div>
            </div>
            
            <div class="category-card">
                <img src="images/theatre.jpg" alt="Théâtre" class="category-image">
                <div class="category-content">
                    <h3>Théâtre</h3>
                    <p>Vivez la magie des pièces classiques et contemporaines</p>
                    <a href="Theatres.php" class="btn">Voir les pièces</a>
                </div>
            </div>
            
            <div class="category-card">
                <img src="images/opera.jpg" alt="Opéra" class="category-image">
                <div class="category-content">
                    <h3>Opéra</h3>
                    <p>Laissez-vous emporter par la puissance de la musique lyrique</p>
                    <a href="Opera.php" class="btn">Voir les opéras</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Events -->
    <section class="featured-events">
    <h2 class="section-title">Événements à l'affiche</h2>
    <p class="section-subtitle">Découvrez nos sélections du moment</p>
    
    <div class="events-grid">
        <!-- Événement de Cinéma -->
        <div class="event-card">
            <img src="images/until.jpg" alt="Until Dawn" class="event-image">
            <div class="event-card-info">
                <h3>Until Dawn</h3>
                <div class="event-meta">
                    <p><img src="images/location.png" alt="Location" class="icon"> Cinéma Cosmos Beta à Alger</p>
                    <p><img src="images/calendar.png" alt="Date" class="icon"> 16 May 13:00</p>
                </div>
                <a href="reservation.php?id=1" class="event-btn">Réserver</a>
            </div>
        </div>
        
        <!-- Événement de Théâtre -->
        <div class="event-card">
            <img src="images/arloukan.jpg" alt="Arlouken" class="event-image">
            <div class="event-card-info">
                <h3>Arlouken</h3>
                <div class="event-meta">
                    <p><img src="images/location.png" alt="Location" class="icon"> Cinéma Cosmos Beta à Alger</p>
                    <p><img src="images/calendar.png" alt="Date" class="icon"> 16 May 13:00</p>
                </div>
                <a href="reservation.php?id=8" class="event-btn">Réserver</a>
            </div>
        </div>
        
        <!-- Événement d'Opéra -->
        <div class="event-card">
            <img src="images/sahrat.jpg" alt="Sahrat El Madina" class="event-image">
            <div class="event-card-info">
                <h3>Sahrat El Madina</h3>
                <div class="event-meta">
                    <p><img src="images/location.png" alt="Location" class="icon"> Cinéma Cosmos Beta à Alger</p>
                    <p><img src="images/calendar.png" alt="Date" class="icon"> 16 May 13:00</p>
                </div>
                <a href="reservation.php?id=10" class="event-btn">Réserver</a>
            </div>
        </div>
    </div>
</section>

    <?php include 'includes/Footer.php'; ?>
</body>
</html>