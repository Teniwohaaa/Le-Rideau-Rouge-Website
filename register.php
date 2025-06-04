<?php
require 'database/db_connect.php';
session_start();

// on va initiliser les variables
$message = "";
$ClassMessage = "";

# si le user interagie avec submit alors:
if (isset($_POST['submit'])) {
    # on stock les infos dans des variables
    # ici on a utuliser trim pour enlver les espaces vide que l'utulisateur peur mettre
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    # ici on verifie si tout les champs son completet
    if (empty($username) || empty($email) || empty($password)) {
        $message = "Tous les champs sont obligatoires.";
        $ClassMessage = "alert-warning";
    } else {
        // on verifie si le mail exsiste
        // on stock le resultat apres la requette sql qui va chercher si le mail exsiste deja dans la base de données
        $result = $conn->query("SELECT email FROM users WHERE email = '$email'");
        
        if ($result->rowCount() > 0) { # ici si les collones son superireur a 0 alors on affiche un message d'erreur
            $message = "Cet email existe déjà!";
            $ClassMessage = "alert-warning";
        } else {
            # si le mail n'exsiste pas alors on va inserer les valerus dansla base de données 
            $sql = "INSERT INTO users (username, email, usr_password, is_admin) 
                   VALUES ('$username', '$email', '$password', 0)";
            
            if ($conn->query($sql)) { 
                # si on effectue l'insertions alors on se dirive vers la page d'acceuil
                
                $user_id = $conn->lastInsertId();
                
                // met toutes les variables de session necessaire
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['is_admin'] = 0;
                
                header("Location: index.php");
                exit();
            } else {
                $message = "Erreur lors de la création du compte: ";
                $ClassMessage = "alert-error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Le Rideau Rouge</title>
    <link rel="stylesheet" href="styles/auth-style.css">
</head>

<body>
    <?php include 'includes/Header.php'; ?>

    <main class="auth-container">
        <div class="auth-card">
            <h2>Créer un compte</h2>
            <!-- ce bloque ser a afficher un message d'erreur -->
            <?php if (!empty($message)) : ?>
            <div class="alert <?php echo $ClassMessage ?>">
                <?= $message ?>
            </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="username">Nom Utilisateur</label>
                    <input type="text" id="username" name="username" pattern="^[a-zA-Z0-9.-_]{3,16}$" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" pattern="^[a-zA-Z0-9]{4,30}$" required>
                </div>

                <button type="submit" class="btn-primary" name="submit">S'inscrire</button>
            </form>

            <div class="auth-links">
                <p>Déjà un compte? <a href="login.php">Se connecter</a></p>
            </div>
        </div>
    </main>

    <?php include 'includes/Footer.php'; ?>
</body>

</html>