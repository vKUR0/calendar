<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
require_once '../config/csrf.php';

function isEmailAvailable($pdo, $email) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() == 0;
}

function registerUser($pdo, $nom, $prenom, $date_naissance, $adresse, $telephone, $email, $mot_de_passe) {
    $hashed_password = password_hash($mot_de_passe, PASSWORD_BCRYPT);
    $activation_token = bin2hex(random_bytes(32));
    
    $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, date_naissance, adresse, telephone, email, mot_de_passe, activation_token, email_verifie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
    if ($stmt->execute([$nom, $prenom, $date_naissance, $adresse, $telephone, $email, $hashed_password, $activation_token])) {
        $activation_link = "http://localhost/calendar/controllers/verify.php?token=" . $activation_token;
        mail($email, "Vérification de votre adresse e-mail", "Bonjour, cliquez sur ce lien pour activer votre compte : $activation_link", "From: your-email@localhost");
        return true;
    }
    return false;
}

function isEmailVerified($pdo, $email) {
    $stmt = $pdo->prepare("SELECT email_verifie FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() == 1;
}

function loginUser($pdo, $email, $mot_de_passe) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['prenom'] . " " . $user['nom'];
        return true;
    }
    return false;
}

function deleteUser($pdo, $user_id) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$user_id]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du token CSRF avant toute action sensible
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die("Erreur CSRF : Requête invalide !");
    }

    if (isset($_POST['register'])) {
        $email = $_POST['email'];
        if (!isEmailAvailable($pdo, $email)) {
            $_SESSION['error'] = "Cette adresse email est déjà prise !";
            header("Location: ../views/register.php");
            exit();
        }
        
        if (registerUser($pdo, $_POST['nom'], $_POST['prenom'], $_POST['date_naissance'], $_POST['adresse'], $_POST['telephone'], $email, $_POST['password'])) {
            echo "Un e-mail de confirmation a été envoyé. Vérifiez votre boîte mail.";
        }
    }

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if (!isEmailVerified($pdo, $email)) {
            die("Erreur : Votre e-mail n'a pas encore été vérifié. Veuillez vérifier vos e-mails.");
        }
        
        if (loginUser($pdo, $email, $password)) {
            header("Location: ../views/profile.php");
        } else {
            echo "Identifiants incorrects.";
        }
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../views/login.php");
    exit();
}
?>
