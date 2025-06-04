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
        $stmt = $conn->prepare("INSERT INTO reservations (user_id, event_id, quantity, phone) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $event_id, $quantity, $phone])) {
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
    .reservation-hero {
        height: 50vh;
        min-height: 300px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        overflow: hidden;
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
            url('images/<?= htmlspecialchars($event['image_path']) ?>');
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

    .reservation-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem;
        background: var(--gray-color);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .reservation-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--accent-color);
    }

    .reservation-form {
        display: grid;
        gap: 1rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .form-group input {
        padding: 0.75rem;
        border-radius: var(--border-radius);
        border: 1px solid #ddd;
    }

    .btn-confirm {
        background: var(--accent-color);
        color: white;
        padding: 1rem;
        border: none;
        border-radius: var(--border-radius);
        font-size: 1.1rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-confirm:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
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
                <input type="text" id="expiry" name="expiry" pattern="^(0[1-9]|1[0-2])\/\d{2}$ placeholder=" MM/AA"
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