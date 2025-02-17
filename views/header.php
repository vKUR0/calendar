<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résevation en ligne</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css" >
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="../public/index.php">Réservation</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="../views/profile.php">Profil</a></li>
                        <li class="nav-item"><a class="nav-link" href="../controllers/auth.php?logout=true">Déconnexion</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="../views/login.php">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link" href="../views/register.php">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
