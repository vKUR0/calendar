<?php 
include '../views/header.php'; 
require_once '../config/csrf.php'; // Assurez-vous que la fonction generateCsrfToken() est bien incluse
?>

<div class="container mt-5">
    <h2>Connexion</h2>
    <form action="../controllers/auth.php" method="POST">
        <!-- Ajout du token CSRF correctement -->
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary">Se connecter</button>
    </form>
</div>

