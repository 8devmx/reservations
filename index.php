<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Calendario</title>
    <?php
      include_once 'includes/head.php';
      require_once 'includes/events.php';
    ?>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.js"></script>
    <!-- SweetAlert2 CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<?php include_once 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <h1 class="h2">Calendario</h1>
    </div>
    <div id='calendar'></div>
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
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día'
        },
        dateClick: function(info) {
            Swal.fire({
                title: 'Agregar Evento',
                html: `
                    <form id="swal-form">
                        <label for="swal-title">Título:</label>
                        <input type="text" id="swal-title" class="swal2-input" required>
                        <label for="swal-start">Fecha de Inicio:</label>
                        <input type="datetime-local" id="swal-start" class="swal2-input" required>
                        <label for="swal-end">Fecha de Fin:</label>
                        <input type="datetime-local" id="swal-end" class="swal2-input">
                    </form>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                preConfirm: () => {
                    const title = Swal.getPopup().querySelector('#swal-title').value;
                    const start_date = Swal.getPopup().querySelector('#swal-start').value;
                    const end_date = Swal.getPopup().querySelector('#swal-end').value;
                    if (!title || !start_date) {
                        Swal.showValidationMessage('Por favor, ingrese el título y la fecha de inicio');
                        return false;
                    }
                    return { title, start_date, end_date };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('includes/events.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            action: 'addEvent',
                            title: result.value.title,
                            start_date: result.value.start_date,
                            end_date: result.value.end_date
                        })
                    })
                    .then(response => response.text())
                    .then(response => {
                        calendar.addEvent({
                            id: String(Date.now()),
                            title: result.value.title,
                            start: result.value.start_date,
                            end: result.value.end_date,
                        });
                        Swal.fire('Guardado!', '', 'success');
                    });
                }
            });
        },
        events: allEvents
    });
    calendar.render();
});
</script>
</body>
</html>


