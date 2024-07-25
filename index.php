<!doctype html>
<html lang="es">
<link rel="stylesheet" href="css/styles.css">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Calendario</title>
    <?php
      include_once 'includes/head.php';
      require_once 'includes/events.php';
    ?>
    <!-- Bootstrap CSS v5.2.1 -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.js"></script>

</style>
</head>

<body>
<?php include_once 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
                <h1 class="h2">Calendario</h1>
            </div>
            <div id='calendar'></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es'
    });
    calendar.render();
});
</script>
</body>
</html>