<?php
session_start();
require 'database/db_connect.php';

if (isset($_POST['submit']) && isset($_SESSION['user_id'])) {
    try {
        $user_id = $_SESSION['user_id'];
        $event_id = (int)$_POST['event_id'];
        $quantity = (int)$_POST['quantity'];
        $phone = $_POST['phone']; 

        
        $stmt = $conn->query("SELECT * FROM events WHERE id = $event_id");
        $event = $stmt->fetch();

        if (!$event) {
            throw new Exception("Événement non trouvé");
        }

        // Use prepared statement for insert
        $stmt = $conn->prepare("INSERT INTO reservations (user_id, event_id, quantity, phone) VALUES ($user_id, $event_id, $quantity, '$phone')");
        if ($stmt->execute()) {
            $reservation_id = $conn->lastInsertId();
            header("Location: confirmation.php?reservation_id=" . $reservation_id);
            exit();
        } else {
            throw new Exception("Erreur lors de la réservation");
        }
    } catch (PDOException $e) {
        // Add error message to URL
        header("Location: reservation.php?id=$event_id&error=" . urlencode($e->getMessage()));
        exit();
    } catch (Exception $e) {
        header("Location: reservation.php?id=$event_id&error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Get event info if GET request
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

try {
    $event_id = (int)$_GET['id'];
    $sql = "SELECT * FROM events WHERE id = $event_id";
    $result = $conn->query($sql);
    $event = $result->fetch();

    if (!$event) {
        header("Location: index.php");
        exit();
    }

} catch (PDOException $e) {
    die("Erreur de base de données: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Réservation - <?php echo $event['title']?></title>
    <link rel="stylesheet" href="styles/EventStyle.css">
    <link rel="stylesheet" href="styles/style.css">
    <style>
    /* Bandeau visuel de l'événement (hero) */
    .reservation-hero {
        height: 50%;
        /* Hauteur de la section hero */
        min-height: 300px;
        /* Hauteur minimale pour petits écrans */
        position: relative;
        /* Positionnement pour contenu interne */
        display: flex;
        /* Utilisation du flexbox pour centrer le contenu */
        align-items: center;
        /* Centrage vertical */
        justify-content: center;
        /* Centrage horizontal */
        margin-bottom: 2rem;
        /* Espace sous le hero */
        overflow: hidden;
        /* Cache le débordement de l'image */
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
            url('images/<?php echo($event['image_path']) ?>');
        /* Image de fond avec overlay sombre */
        background-size: cover;
        /* L'image couvre toute la zone */
        background-position: center;
        /* Centre l'image */
    }

    /* Contenu textuel du hero */
    .reservation-hero-content {
        text-align: center;
        /* Texte centré */
        color: white;
        /* Texte en blanc */
        padding: 2rem;
        /* Espacement interne */
        max-width: 800px;
        /* Largeur maximale du contenu */
    }

    /* Titre principal dans le hero */
    .reservation-hero h2 {
        font-size: 2.5rem;
        /* Taille du texte */
        margin-bottom: 1rem;
        /* Espace sous le titre */
    }

    /* Conteneur principal du formulaire de réservation */
    .reservation-container {
        max-width: 600px;
        /* Largeur maximale du conteneur */
        margin: 0 auto;
        /* Centrage horizontal */
        padding: 2rem;
        /* Espacement interne */
        background: var(--gray-color);
        /* Fond gris clair */
        border-radius: var(--border-radius);
        /* Coins arrondis */
        margin-bottom: 3rem;
    }

    /* Informations principales de l'événement (prix, date) */
    .reservation-info {
        display: flex;
        /* Affichage en ligne */
        justify-content: space-between;
        /* Espacement entre les blocs */
        margin-bottom: 1.5rem;
        /* Espace sous le bloc */
        padding-bottom: 1rem;
        /* Espace interne bas */
        border-bottom: 1px solid var(--accent-color);
        /* Ligne de séparation */
    }

    /* Mise en page du formulaire de réservation */
    .reservation-form {
        display: grid;
        /* Utilisation de la grille CSS */
        gap: 1rem;
        /* Espace entre les champs */
    }

    /* Groupe de champs du formulaire */
    .form-group {
        display: flex;
        /* Affichage en colonne */
        flex-direction: column;
        /* Empilement vertical */
    }

    /* Label de chaque champ */
    .form-group label {
        margin-bottom: 0.5rem;
        /* Espace sous le label */
        font-weight: 500;
        /* Texte semi-gras */
    }

    /* Champ de saisie du formulaire */
    .form-group input {
        padding: 0.75rem;
        /* Espacement interne */
        border-radius: var(--border-radius);
        /* Coins arrondis */
        border: 1px solid #ddd;
        /* Bordure grise claire */
    }

    /* Bouton de confirmation de réservation */
    .btn-confirm {
        background: var(--accent-color);
        /* Couleur d'accent */
        color: white;
        /* Texte blanc */
        padding: 1rem;
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
    }

    /* Effet au survol du bouton */
    .btn-confirm:hover {
        background: var(--secondary-color);
        /* Couleur secondaire */
        transform: translateY(-2px);
        /* Légère élévation */
    }
    </style>
</head>

<body>
    <?php include 'includes/Header.php'; ?>

    <div class="reservation-hero" style="background-image: url('images/<?php echo $event['image_path'] ?>');">
        <div class="reservation-hero-content">
            <h2>Réservation: <?php echo $event['title'] ?></h2>
            <p><?php echo $event['venue']?> •
                <?php echo date('d M Y à H:i', strtotime($event['date_event'])) ?></p>
        </div>
    </div>

    <div class="reservation-container">
        <div class="reservation-info">
            <div>
                <p><strong>Prix unitaire:</strong> <?php echo $event['price'] ?> DA</p>
            </div>
            <div>
                <p><strong>Date:</strong> <?php echo date('d/m/y', strtotime($event['date_event'])) ?></p>
            </div>
        </div>

        <form method="POST" action="reservation.php" class="reservation-form">
            <input type="hidden" name="event_id" value="<?php echo $event['id'] ?>">

            <div class="form-group">
                <label for="quantity">Nombre de places:</label>
                <input type="number" id="quantity" name="quantity" min="1" max="10" required>
            </div>

            <div class="form-group">
                <label for="phone">Numéro de téléphone:</label>
                <input type="tel" id="phone" name="phone" pattern="^[0-9 +]{10,15}$" placeholder="06 12 34 56 78"
                    required>
            </div>

            <div class="form-group">
                <label for="card">Numéro de carte:</label>
                <input type="text" id="card" name="card" inputmode="numeric" pattern="^[0-9]{16}$" maxlength="16"
                    placeholder="1234567812345678" required>
            </div>

            <div class="form-group">
                <label for="expiry">Date d'expiration:</label>
                <input type="text" id="expiry" name="expiry" pattern="^(0[1-9]|1[0-2])\/\d{2}$" placeholder="MM/AA"
                    required>
            </div>

            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" inputmode="numeric" pattern="^[0-9]{3}$" maxlength="3"
                    placeholder="123" required>
            </div>

            <button type="submit" name="submit" class="btn-confirm">Confirmer la réservation</button>
        </form>
    </div>

    <?php include 'includes/Footer.php'; ?>
</body>

</html>