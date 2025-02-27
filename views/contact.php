<?php
require_once '../config/csrf.php';
require_once '../controllers/contactController.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Contact</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { width: 50%; margin: auto; }
        input, textarea { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #28a745; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <?php include '../views/header.php'; ?>
    <div class="container">
        <h2>Contactez-nous</h2>
        <?php if (!empty($success_message)): ?>
            <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="../controllers/contactController.php" method="post">
            <label>Nom :</label>
            <input type="text" value="<?php echo htmlspecialchars($user_name); ?>" disabled>

            <label>Email :</label>
            <input type="email" value="<?php echo htmlspecialchars($user_email); ?>" disabled>

            <label>Message :</label>
            <textarea name="message" rows="5" required></textarea>

            <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

            <button type="submit">Envoyer</button>
        </form>
    </div>
</body>
</html>
