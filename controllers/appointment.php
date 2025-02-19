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
        $appointment->bookAppointment($_SESSION['user_id'], $_POST['date_heure']);
        header("Location: ../views/profile.php");
        exit();
    }

    if (isset($_POST['cancel'])) {
        $appointment->cancelAppointment($_POST['id']);
        header("Location: ../views/profile.php");
        exit();
    }
}
?>
