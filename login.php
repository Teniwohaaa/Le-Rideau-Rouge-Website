<?php
require 'database/db_connect.php';
# we check if the session started already or not
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = "";
$ClassMessage = "";

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    # ici on va verifier si kle mot de pass est correct et si oui on verifie si son password l'est
    # si un des deux n'exsiste pas alors c'est erreur sinon on va simplement se connecter 

    # on verifi si tout les champs on etais remplie 
    if (empty($email) || empty($password)) {
        # empty a etais utuliser pour determiner si une variable est vide
        $message = "Tous les champs sont obligatoires.";
        $ClassMessage = "alert-warning";
    }
    else {
        $result = $conn->query("SELECT `id`, `username`, `email`, `usr_password`, `is_admin` FROM `users` WHERE email = '$email'");

        if ($result->rowCount() > 0) {
            # si les collones son superieur a 0 alors on se connect 
            # Récupérer la première ligne du résultat sous forme de tableau associatif
            $row = $result->fetch();

            if ($password == $row['usr_password']) {
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['id']; 
                $_SESSION['is_admin'] = $row['is_admin']; 
                header("Location: index.php");
                exit();
            }
            else {
                $message = "Le mot de passe n'est pas correct.";
                $ClassMessage = "alert-warning";
            }
        }
        else {
            $message = "L'email n'existe pas."; 
            $ClassMessage = "alert-warning";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Le Rideau Rouge</title>
    <link rel="stylesheet" href="styles/auth-style.css">
</head>

<body>
    <?php include 'includes/Header.php'; ?>

    <main class="auth-container">
        <div class="auth-card">
            <h2>Connexion</h2>
            <?php if (!empty($message)): ?>
             <div class="alert <?php echo $ClassMessage ?>">
             <?php echo $message; ?>
            </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn-primary" name="submit">Se connecter</button>
            </form>

            <div class="auth-links">
                <a href="register.php">Créer un compte</a>
                <a href="forgot-password.php">Mot de passe oublié?</a>
            </div>
        </div>
    </main>

    <?php include 'includes/Footer.php'; ?>
</body>
</html>
