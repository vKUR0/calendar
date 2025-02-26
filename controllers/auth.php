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
        $email = $_POST['email'];
        if (!$user->isEmailAvailable($email)) {
            session_start();
            $_SESSION['error'] = "Cette adresse email est déja prise !";
            header("Location: ../views/register.php");
            exit();
        }
        $activation_token = bin2hex(random_bytes(32));

        $activation_link = "http://localhost/calendar/controllers/verify.php?token=" . $activation_token;
        $subject = "Vérification de votre adresse e-mail";
        $message = "Bonjour, cliquez sur ce lien pour activer votre compte : $activation_link";
        $headers = "From: your-email@localhost";

        mail($email, $subject, $message, $headers);

        echo "Un e-mail de confirmation a été envoyé. Vérifiez votre boîte mail.";
    }

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        if (!$user->isEmailVerified($email)) {
            die("Erreur : Votre e-mail n'a pas encore été vérifié. Veuillez vérifier vos e-mails.");
        }
    
        if ($user->login($email, $password)) {
            header("Location: ../views/profile.php");
        } else {
            echo "Identifiants incorrects.";
        }
    }
    
}

if (isset($_GET['logout'])) {
    session_start();
    session_destroy();
    header("Location: ../views/login.php");
    exit();
}
?>
