<!doctype html>
<html lang="en">
<link rel="stylesheet" href="css/styles.css">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <?php
      include_once 'includes/head.php';
      require_once 'includes/events.php';
    ?>
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.js"></script>

    <style>
    #calendar {
      max-width: 100%; /* Ajusta este valor según el tamaño deseado */
      height: 800px; /* Altura fija */
      margin: auto;
    }
</style>
</head>

<body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        views: {
            timeGrid: {
                slotLabelFormat: {
                    hour: 'numeric',
                    hour12: true // Esta opción asegura que se usen AM y PM
                }
            }
        }
    });
    calendar.render();
});
</script>
<?php include_once 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
                <h1 class="h2">Calendario</h1>
            </div>
            <div id='calendar'></div>
        </main>  
    </div>
</div>


<!-- Bootstrap JavaScript Libraries -->
<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8O"></script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-QJHtvGhmr9b73iZFl+PH0sBqAzZXO5JJ2cSeF2MiRlz4dA8R0I42B1h8D1mN8rFA"></script>
</body>
</html>
