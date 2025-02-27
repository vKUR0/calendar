

<?php 
include '../views/header.php'; 
require_once '../config/csrf.php';
require_once '../config/database.php';
require_once '../controllers/edit.php';
?>
<div class="container mt-5">
    <h2>Modifier mon profil</h2>
    <form action="edit_profile.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required value="<?php echo htmlspecialchars($user['nom']); ?>">
        </div>
        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" required value="<?php echo htmlspecialchars($user['prenom']); ?>">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($user['email']); ?>">
        </div>
        <div class="mb-3">
            <label>Adresse</label>
            <input type="text" name="adresse" class="form-control" required value="<?php echo htmlspecialchars($user['adresse']); ?>">
        </div>
        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control" required value="<?php echo htmlspecialchars($user['telephone']); ?>">
        </div>
        <div class="mb-3">
            <label>Nouveau mot de passe (laisser vide si inchangé)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
    
    <!-- Bouton de suppression du compte -->
    <form action="edit_profile.php" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer votre compte ? Cette action est irréversible.');">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        <button type="submit" name="delete_account" class="btn btn-danger mt-3">Supprimer mon compte</button>
    </form>
</div>