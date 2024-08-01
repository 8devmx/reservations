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
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup .form-group {
            text-align: left !important;
            margin-bottom: 10px;
        }
        #calendar {
            max-width: 100%;
            height: 800px;
            margin: auto;
        }
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

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8O"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9b73iZFl+PH0sBqAzZXO5JJ2cSeF2MiRlz4dA8R0I42B1h8D1mN8rFA"></script>

    <script>
       document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
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
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('includes/events.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ action: 'showData' })
                })
                .then(response => response.json())
                .then(data => {
                    let events = data.map(event => ({
                        id: event.id,
                        title: event.title,
                        start: event.start_date + 'T' + event.start_hout,
                        end: event.end_date + 'T' + event.end_hour,
                        description: event.description,
                        client: event.client,
                        user: event.user 
                    }));
                    successCallback(events);
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                });
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
                            <label for="start_date">Fecha de inicio:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="${info.dateStr}">
                        </div>
                        <div class="form-group">
                            <label for="end_date">Fecha de fin:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                        <div class="form-group">
                            <label for="start_hout">Hora de Inicio:</label>
                            <input type="time" class="form-control" id="start_hout" name="start_hout">
                        </div>
                        <div class="form-group">
                            <label for="end_hour">Hora de Fin:</label>
                            <input type="time" class="form-control" id="end_hour" name="end_hour">
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
                    fetch('includes/events.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            action: 'insert',
                            title: eventData.title,
                            description: eventData.description,
                            start_date: eventData.start_date,
                            end_date: eventData.end_date,
                            start_hout: eventData.start_hout,
                            end_hour: eventData.end_hour,
                            client: eventData.client,
                            user: eventData.user,
                            map: eventData.map,
                            status: 1
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 2) {
                            Swal.fire('Éxito', data.message, 'success');
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'No se pudo registrar el evento', 'error');
                    });
                }
            });
        },
        eventClick: function(info) {
            const startTime = new Date(info.event.start).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            const endTime = new Date(info.event.end).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            Swal.fire({
                title: info.event.title,
                html: `
                    <p><strong>Descripción:</strong> ${info.event.extendedProps.description || 'No disponible'}</p>
                    <p><strong>Cliente:</strong> ${info.event.extendedProps.client || 'No disponible'}</p>
                    <p><strong>Usuario:</strong> ${info.event.extendedProps.user || 'No disponible'}</p>
                    <p><strong>Desde:</strong> ${startTime}</p>
                    <p><strong>Hasta:</strong> ${endTime}</p>
                `,
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    });
    calendar.render();
});

</script>
</body>
</html>

