<?php include '../views/header.php'; ?>
<div class="container mt-5">
    <h2>Inscription</h2>
    <form action="../controllers/auth.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken(); ?>">
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Date de naissance</label>
            <input type="date" name="date_naissance" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Adresse</label>
            <input type="text" name="adresse" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe" class="form-control" required>
        </div>
        <button type="submit" name="register" class="btn btn-primary">S'inscrire</button>
    </form>
</div>
<?php include '../views/footer.php'; ?>
