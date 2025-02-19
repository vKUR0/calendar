<?php include '../views/header.php'; ?>
<div class="container mt-5">
    <h2>Prendre un rendez-vous</h2>
    <form action="../controllers/appointment.php" method="POST">
        <!-- <input type="hidden" name="csrf_token" value="= generateCsrfToken(); "> -->
        <div class="mb-3">
            <label>Date et Heure</label>
            <input type="datetime-local" name="date_heure" class="form-control" required>
        </div>
        <button type="submit" name="book" class="btn btn-primary">Réserver</button>
    </form>
</div>
<?php include '../views/footer.php'; ?>
