<?php
include '../views/header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<div class="container mt-5">
    <h2>Mon Profil</h2>
    <p>Bienvenue, <?php echo $_SESSION['user_name']; ?></p>
    <a href="../views/calendar.php" class="btn btn-success">Voir mes rendez-vous</a>
</div>
<?php include '../views/footer.php'; ?>
