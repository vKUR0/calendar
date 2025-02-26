<?php
include '../views/header.php';
require_once '../config/database.php';
require_once '../models/Appointment.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les rendez-vous de l'utilisateur
$appointment = new Appointment($pdo);
$appointments = $appointment->getUserAppointments($_SESSION['user_id']);
?>

<div class="container mt-5">
    <h2>Mon Profil</h2>
    <p>Bienvenue, <?php echo $_SESSION['user_name']; ?></p>

    <!-- Affichage automatique des rendez-vous -->
    <h3 class="mt-4">Mes rendez-vous</h3>
    <?php if (!empty($appointments)): ?>
        <ul class="list-group mt-3">
            <?php foreach ($appointments as $appointment): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    📅 Rendez-vous prévu le <strong><?= date('d/m/Y H:i', strtotime($appointment['date_heure'])) ?></strong>
                    <form action="../controllers/appointment.php" method="POST" class="d-inline">
                        <input type="hidden" name="appointment_id" value="<?= $appointment['id']; ?>">
                        <!-- <input type="hidden" name="csrf_token" value="= generateCsrfToken(); "> -->
                        <button type="submit" name="cancel" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')">Annuler</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="mt-3">Aucun rendez-vous pris.</p>
    <?php endif; ?>
    <a href="calendar.php" class="btn btn-primary mt-3">Prendre un rendez-vous</a>
</div>

<?php include '../views/footer.php'; ?>
