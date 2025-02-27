<?php
require_once '../config/database.php';
require_once '../controllers/calendar_view.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier des Rendez-vous</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'fr',
                initialView: 'dayGridMonth',
                events: <?php echo isset($events) ? json_encode($events) : '[]'; ?> // Vérification de `$events`
            });
            calendar.render();
        });
    </script>
</head>
<body>
    <?php include '../views/header.php'; ?>
    <div class="container mt-5">
        <h2>Calendrier des Rendez-vous</h2>
        <div id="calendar"></div>
        <a href="profile.php" class="btn btn-primary mt-3">Retour au profil</a>
    </div>
</body>
</html>
