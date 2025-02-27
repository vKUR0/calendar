<?php
require_once '../config/database.php';
require_once '../config/csrf.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

function bookAppointment($pdo, $user_id, $date_heure) {
    $stmt = $pdo->prepare("INSERT INTO rendezvous (user_id, date_heure) VALUES (?, ?)");
    return $stmt->execute([$user_id, $date_heure]);
}

function getUserAppointments($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT * FROM rendezvous WHERE user_id = ? ORDER BY date_heure ASC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cancelAppointment($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM rendezvous WHERE id = ?");
    return $stmt->execute([$id]);
}

function isSlotAvailable($pdo, $date_heure) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM rendezvous WHERE date_heure = ?");
    $stmt->execute([$date_heure]);
    return $stmt->fetchColumn() == 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du token CSRF avant toute action
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die("Erreur CSRF : Requête invalide !");
    }

    if (isset($_POST['book'])) {
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $date_heure = $date . ' ' . $heure . ':00';

        $timestamp = strtotime($date_heure);
        $minutes = date("i", $timestamp);
        if ($minutes % 30 !== 0) {
            die("Erreur : Créneau invalide.");
        }
        if (!isSlotAvailable($pdo, $date_heure)) {
            $_SESSION['error'] = "Ce créneau horaire est déjà pris, veuillez en choisir un autre.";
            header("Location: ../views/calendar.php");
            exit();
        }

        bookAppointment($pdo, $_SESSION['user_id'], $date_heure);
        header("Location: ../views/profile.php");
        exit();
    }

    if (isset($_POST['getUserAppointments'])) {
        $_SESSION['appointments'] = getUserAppointments($pdo, $_SESSION['user_id']);
        header("Location: ../views/profile.php");
        exit();
    }

    if (isset($_POST['cancel']) && isset($_POST['appointment_id'])) {
        cancelAppointment($pdo, $_POST['appointment_id']);
        header("Location: ../views/profile.php");
        exit();
    }
}
?>
