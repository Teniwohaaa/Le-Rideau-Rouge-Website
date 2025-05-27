<?php 
try {
    $conn = new PDO('mysql:host=localhost;dbname=rideau_Rouge', 'root', '');
} catch (Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
