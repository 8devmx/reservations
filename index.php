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
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.js"></script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
<?php include_once 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <h1 class="h2">Calendario</h1>
    </div>
    <div id='calendar'></div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            let eventsArray = [];
            json.forEach((row, index) => {
                const event = {
                    id: row.id,
                    start: row.start_date,
                    end: row.end_date,
                    title: row.title,
                }
                eventsArray.push(event);
            });
            sessionStorage.setItem('events', JSON.stringify(eventsArray));
        });
    }

    getAllData();
    const allEvents = JSON.parse(sessionStorage.getItem('events'));
    console.log(allEvents);
    const calendarEl = document.querySelector('#calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                views: {
                    timeGrid: {
                        slotLabelFormat: {
                            hour: 'numeric',
                            hour12: true 
                        }
                    }
                },
        dateClick: function(info) {
            Swal.fire({
                title: 'Crear Nuevo Evento',
                html: `
                    <form id="eventForm">
                        <div class="form-group">
                            <label for="title">Titulo:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Ingresa el Titulo">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción:</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Descripción del evento"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_time">Hora de Inicio:</label>
                            <input type="time" class="form-control" id="start_time" name="start_time">
                        </div>
                        <div class="form-group">
                            <label for="end_time">Hora de Fin:</label>
                            <input type="time" class="form-control" id="end_time" name="end_time">
                        </div>
                        <div class="form-group">
                            <label for="client">Cliente:</label>
                            <select class="form-control" id="client" name="client">
                                <?php
                                require_once 'includes/Clients.php';
                                $clientes = new Clients();
                                $data = $clientes->getClientsForEvents();
                                foreach ($data as $key => $value) {
                                ?>
                                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user">Usuario:</label>
                            <select class="form-control" id="user" name="user">
                                <?php
                                require_once 'includes/Users.php';
                                $usuarios = new User();
                                $data = $usuarios->getUserForEvents();
                                foreach ($data as $key => $value) {
                                ?>
                                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="map">URL del Mapa:</label>
                            <input type="url" class="form-control" id="map" name="map" placeholder="Lugar del Evento en Formato URL">
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const form = Swal.getPopup().querySelector('#eventForm');
                    const formData = new FormData(form);
                    const eventData = {};
                    formData.forEach((value, key) => {
                        eventData[key] = value;
                    });
                    return eventData;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const eventData = result.value;
                    console.log(eventData);
                }
            });
            console.log(info);
        },
        events: allEvents
    });
    calendar.render();
});
</script>
</body>
</html>