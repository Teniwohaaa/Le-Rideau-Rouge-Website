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
    $confirm_pass = $_POST['confirm_password'];

    if (empty($email) || empty($password) || empty($confirm_pass)) {
        $message = "Tous les champs sont obligatoires.";
        $ClassMessage = "alert-warning";
    } else {
        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
        
        if ($result->rowCount() > 0) {
            if ($password == $confirm_pass) {
                $update = $conn->query("UPDATE users SET usr_password = '$password' WHERE email = '$email'");
                
                if ($update) {
                    # on fetch les donnes du user
                    $user = $result->fetch();
                    
                    # pour pouvoir le connecter
                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['is_admin'] = $user['is_admin'];
                    
                    $message = "Mot de passe mis à jour avec succès.";
                    $ClassMessage = "alert-success";
                    
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "Erreur lors de la mise à jour du mot de passe.";
                    $ClassMessage = "alert-error";
                }
            } else {
                $message = "Les mots de passe ne sont pas identiques.";
                $ClassMessage = "alert-warning";
            }
        } else {
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
    <title>Nouvau Mot De Pass - Le Rideau Rouge</title>
    <link rel="stylesheet" href="styles/auth-style.css">
</head>

<body>
    <?php include 'includes/Header.php'; ?>

    <main class="auth-container">
        <div class="auth-card">
            <h2>Réinitialiser le mot de passe</h2>

            <?php if (!empty($message)): ?>
            <div class="alert <?php echo $ClassMessage; ?>">
                <?php echo $message; ?>
            </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" name="submit" class="btn-primary">Confirmer</button>
            </form>

            <div class="auth-links">
                <p>Déjà un compte? <a href="login.php">Se connecter</a></p>
                <p>Pas encore de compte? <a href="register.php">S'inscrire</a></p>
            </div>
        </div>
    </main>

    <?php include 'includes/Footer.php'; ?>
</body>

</html>