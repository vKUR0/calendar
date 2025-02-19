<?php
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../config/csrf.php';

$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // if (!verifyCsrfToken($_POST['csrf_token'])) {
    //     die("Token CSRF invalide !");
    // }

    if (isset($_POST['register'])) {
        $user->register($_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['adresse'], $_POST['telephone'], $_POST['email'], $_POST['mot_de_passe']);
        header("Location: ../views/login.php");
        exit();
    }

    if (isset($_POST['login'])) {
        if ($user->login($_POST['email'], $_POST['password'])) {
            header("Location: ../views/profile.php");
        } else {
            echo "Identifiants incorrects.";
        }
        exit();
    }
}

if (isset($_GET['logout'])) {
    session_start();
    session_destroy();
    header("Location: ../views/login.php");
    exit();
}
?>
