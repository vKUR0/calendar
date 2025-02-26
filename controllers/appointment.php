<?php
require_once '../config/database.php';
require_once '../models/Appointment.php';
require_once '../config/csrf.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

$appointment = new Appointment($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // if (!verifyCsrfToken($_POST['csrf_token'])) {
    //     die("Token CSRF invalide !");
    // }

    if (isset($_POST['book'])) {
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $date_heure = $date . ' ' . $heure . ':00';

        $timestamp = strtotime($date_heure);
        $minutes = date("i", $timestamp);
        if ($minutes % 30 !== 0) {
            die("Erreur : Créneau invalide.");
        }
        if (!$appointment->isSlotAvailable($date_heure)) {
            session_start();
            $_SESSION['error'] = "Ce créneau horaire est déjà pris, veuillez en choisir un autre.";
            header("Location: ../views/calendar.php");
            exit();
        }

        $appointment->bookAppointment($_SESSION['user_id'], $date_heure);
        header("Location: ../views/profile.php");
        exit();
    }

    if (isset($_POST['getUserAppointments'])) {
        $appointments = $appointment->getUserAppointments($_SESSION['user_id']);
        $_SESSION['appointments'] = $appointments;
        header("Location: ../views/profile.php");
        exit();
    }

    if (isset($_POST['cancel']) && isset($_POST['appointment_id'])) {
        $appointment->cancelAppointment($_POST['appointment_id']);
        header("Location: ../views/profile.php");
        exit();
    }
}
?>