<?php include '../views/header.php'; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']);?>
<?php endif; ?>
<div class="container mt-5">
    <h2>Prendre un rendez-vous</h2>
    <form action="../controllers/appointment.php" method="POST">
    <!-- <input type="hidden" name="csrf_token" value="= generateCsrfToken(); "> -->
    
    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="date" class="form-control" required min="<?= date('Y-m-d'); ?>">
    </div>

    <div class="mb-3">
        <label>Heure</label>
        <select name="heure" class="form-control" required>
            <?php
            for ($h = 8; $h <= 18; $h++) { // Heures de 08h00 à 18h00
                foreach (["00", "30"] as $min) { // Créneaux : XXh00 et XXh30
                    $heure = sprintf("%02d:%s", $h, $min);
                    echo "<option value='$heure'>$heure</option>";
                }
            }
            ?>
        </select>
    </div>

    <button type="submit" name="book" class="btn btn-primary">Réserver</button>
</form>

</div>
<?php include '../views/footer.php'; ?>
