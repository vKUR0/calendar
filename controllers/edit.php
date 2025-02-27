<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
require_once '../config/csrf.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupération des informations actuelles de l'utilisateur
$stmt = $pdo->prepare("SELECT nom, prenom, email, adresse, telephone FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die("Erreur CSRF : Requête invalide !");
    }

    if (isset($_POST['delete_account'])) {
        // Suppression des rendez-vous de l'utilisateur
        $stmt = $pdo->prepare("DELETE FROM rendezvous WHERE user_id = ?");
        $stmt->execute([$user_id]);
        
        // Suppression de l'utilisateur
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        
        // Déconnexion et redirection vers la page d'accueil
        session_destroy();
        header("Location: ../views/login.php?account_deleted=success");
        exit();
    }
    
    // Récupération des nouvelles valeurs
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    
    // Vérification si le mot de passe doit être modifié
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET nom = ?, prenom = ?, email = ?, adresse = ?, telephone = ?, mot_de_passe = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $adresse, $telephone, $password, $user_id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET nom = ?, prenom = ?, email = ?, adresse = ?, telephone = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $adresse, $telephone, $user_id]);
    }

    // Mise à jour de la session avec le nouveau nom
    $_SESSION['user_name'] = $prenom . " " . $nom;
    
    // Redirection vers la page de profil
    header("Location: profile.php?update=success");
    exit();
}
?>