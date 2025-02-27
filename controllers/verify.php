<?php
require_once '../config/database.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Vérification que le token existe avant de mettre à jour
    $stmt = $pdo->prepare("SELECT id FROM users WHERE activation_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Met à jour la base de données pour activer le compte
        $stmt = $pdo->prepare("UPDATE users SET email_verifie = 1, activation_token = NULL WHERE activation_token = ?");
        $success = $stmt->execute([$token]);

        if ($success) {
            // Redirection après activation réussie
            header("Location: ../views/login.php?activation=success");
            exit();
        }
    }
}

// Si l'activation échoue
header("Location: ../views/login.php?activation=error");
exit();
?>
