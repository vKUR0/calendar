<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';

// Définir un tableau vide par défaut
$events = [];

// Récupération de tous les rendez-vous
$stmt = $pdo->prepare("SELECT date_heure, user_id FROM rendezvous");
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si des rendez-vous existent
if (!empty($appointments)) {
    foreach ($appointments as $appointment) {
        $events[] = [
            'title' => $appointment['user_id'],
            'start' => $appointment['date_heure']
        ];
    }
}
?>