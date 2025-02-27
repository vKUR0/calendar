<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';

// Définir un tableau vide par défaut
$events = [];

// Récupération de tous les rendez-vous avec les noms des utilisateurs
$stmt = $pdo->prepare("SELECT r.date_heure, u.nom FROM rendezvous r JOIN users u ON r.user_id = u.id");
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si des rendez-vous existent
if (!empty($appointments)) {
    foreach ($appointments as $appointment) {
        $events[] = [
            'title' => htmlspecialchars($appointment['nom']),
            'start' => $appointment['date_heure']
        ];
    }
}
?>