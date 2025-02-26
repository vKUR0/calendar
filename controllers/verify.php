<?php
require_once '../config/database.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("UPDATE users SET email_verifie = 1, activation_token = NULL WHERE activation_token = ?");
    $success = $stmt->execute([$token]);

    if ($success) {
        echo "Votre compte a été activé ! Vous pouvez maintenant vous connecter.";
    } else {
        echo "Lien invalide ou compte déjà activé.";
    }
}
?>
