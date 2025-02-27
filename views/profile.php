<?php
include '../views/header.php';
require_once '../config/database.php';
require_once '../config/csrf.php'; // Inclusion du fichier CSRF

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function getUserAppointments($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT * FROM rendezvous WHERE user_id = ? ORDER BY date_heure ASC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$appointments = getUserAppointments($pdo, $_SESSION['user_id']);
?>

<div class="container mt-5">
    <h2>Mon Profil</h2>
    <p>Bienvenue, <?php echo $_SESSION['user_name'];?></p>

    <!-- Affichage automatique des rendez-vous -->
    <h3 class="mt-4">Mes rendez-vous</h3>
    <?php if (!empty($appointments)): ?>
        <ul class="list-group mt-3">
            <?php foreach ($appointments as $appointment): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    📅 Rendez-vous prévu le <strong><?= date('d/m/Y H:i', strtotime($appointment['date_heure'])) ?></strong>
                    <form action="../controllers/appointment.php" method="POST" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>"> <!-- Ajout du token CSRF -->
                        <input type="hidden" name="appointment_id" value="<?= $appointment['id']; ?>">
                        <button type="submit" name="cancel" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')">Annuler</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="mt-3">Aucun rendez-vous pris.</p>
    <?php endif; ?>
    <a href="calendar.php" class="btn btn-primary mt-3">Prendre un rendez-vous</a>
    <a href="edit_profile.php" class="btn btn-warning mt-3">Modifier mon profil</a>
</div>

