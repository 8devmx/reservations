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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    const getAllData = () => {
      const obj = {
        action: 'showData'
      }

      fetch('includes/events.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(obj)
        })
        .then(response => response.json())
        .then(json => {
           let eventsArray = []
          json.forEach((row, index) => {
            const event = {
                id: row.id,
                start: row.start_date,
                end: row.end_date,
                title: row.title,
                description: row.description,
                // backgroundColor: colors[index]
            }
            eventsArray.push(event)
          })
          sessionStorage.setItem('events', JSON.stringify(eventsArray))
        })
    }

    getAllData()
    const allEvents = JSON.parse(sessionStorage.getItem('events'))
    console.log(allEvents) 
    const calendarEl = document.querySelector('#calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        dateClick: function(info) {
            Swal.fire({
                title: "<strong>Agregar Evento</strong>",
                icon: "info",
                html: `
                    <form id="event-form">
                        <label for="event-title">Título:</label>
                        <input type="text" id="event-title" class="swal2-input" placeholder="Título del evento">
                        <label for="start-date">Fecha de inicio:</label>
                        <input type="date" id="start-date" class="swal2-input" value="${info.start_date}">
                        <label for="end-date">Fecha de fin:</label>
                        <input type="date" id="end-date" class="swal2-input" value="${info.end_date}">
                    </form>
                `,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: 'Guardar',
                cancelButtonTextred: 'Cancelar',
            });
            console.log(info);
        },
        eventClick: function(info) {
            const endDate = info.event.end ? info.event.end.toISOString().slice(0, 10) : info.event.start.toISOString().slice(0, 10);
            Swal.fire({
                title: `<strong>${info.event.title}</strong>`,
                icon: "success",
                html: `
                    <b>Fecha de inicio:</b> ${info.event.start.toISOString().slice(0, 10)}<br>
                    <b>Fecha de fin:</b> ${endDate}<br>
                    <b>Descripción:</b> ${info.event.extendedProps.description || 'N/A'}
                `,
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: 'Cerrar'
            });
        },
        events: allEvents

    });
    calendar.render();
});
</script>
</body>
</html>
