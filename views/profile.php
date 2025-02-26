<?php
include '../views/header.php';
require_once '../config/database.php';
require_once '../models/Appointment.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les rendez-vous de l'utilisateur dès l'affichage de la page
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
                <li class="list-group-item">
                    📅 Rendez-vous prévu le <strong><?= date('d/m/Y H:i', strtotime($appointment['date_heure'])) ?></strong>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="mt-3">Aucun rendez-vous pris.</p>
    <?php endif; ?>
    <a href="../views/calendar.php" class="btn btn-success">Prendre rendez-vous</a>
</div>

<?php include '../views/footer.php'; ?>
