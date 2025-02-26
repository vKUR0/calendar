<?php
require_once '../config/database.php';
require_once '../models/User.php';

$user = new User($pdo);

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    if ($user->activateUser($token)) {
        echo "Votre compte a été activé ! Vous pouvez maintenant vous connecter.";
    } else {
        echo "Lien invalide ou compte déjà activé.";
    }
}
?>