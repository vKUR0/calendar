<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/csrf.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Vous devez vous connecter pour accéder à cette page.";
    header("Location: ../views/login.php");
    exit;
}

// Récupération des infos utilisateur
$user_name = $_SESSION['user_name'] ?? "Utilisateur inconnu";
$user_email = $_SESSION['user_email'] ?? "Email inconnu";

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die("Erreur CSRF : Requête invalide !");
    }

    // Nettoyage du message
    $message = trim($_POST['message']);

    if (empty($message)) {
        $error_message = "Le message ne peut pas être vide.";
    } elseif (strlen($message) > 1000) {
        $error_message = "Le message ne doit pas dépasser 1000 caractères.";
    } else {
        // Format du message à enregistrer
        $entry = date("Y-m-d H:i:s") . " - " . $user_name . " (" . $user_email . ") : " . $message . PHP_EOL;

        // Sauvegarde dans un fichier local
        file_put_contents("../msg/messages.txt", $entry, FILE_APPEND | LOCK_EX);

        $success_message = "Votre message a été envoyé avec succès.";
    }
}

// On inclut la vue après exécution du contrôleur
require_once "../views/contact.php";
?>
