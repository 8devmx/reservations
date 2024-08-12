<<<<<<< Updated upstream
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Semanal</title>
    <?php
    include_once '../../includes/head.php';
    require_once '../../includes/VistaSemanal.php';

    $events = new Events();
    $clients = $events->getAllClients();
    ?>
    <link rel="stylesheet" href="../../css/Semanal.css">
    <style>
        .current-day {
            background-color: green;
            font-weight: bold;
            color: white;
        }

        /* Estilo adicional para el layout con el sidebar */
        body {
            display: flex;
        }

        #calendar {
            flex: 1;
            padding-left: 250px; /* Ajusta este valor según el ancho del sidebar */
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px; /* Ancho del sidebar */
            height: 100%;
            background-color: #2c3e50; /* Color de fondo del sidebar */
            color: #ecf0f1; /* Color del texto del sidebar */
            padding: 20px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <?php include_once '../../includes/sidebar.php'; ?>

    <div id="calendar">
        <div class="header">
            <button id="prevWeek">&lt;</button>
            <h2 id="currentWeek"></h2>
            <button id="today">Hoy</button>
            <button id="nextWeek">&gt;</button>
        </div>
        <div class="weekdays">
            <div></div> <!-- Empty cell for time labels -->
            <div>Domingo <span class="date"></span></div>
            <div>Lunes <span class="date"></span></div>
            <div>Martes <span class="date"></span></div>
            <div>Miércoles <span class="date"></span></div>
            <div>Jueves <span class="date"></span></div>
            <div>Viernes <span class="date"></span></div>
            <div>Sábado <span class="date"></span></div>
        </div>
        <div class="all-day-row">
            <div class="time-label">todo el día</div>
            <div class="all-day-slot" data-day="Domingo"></div>
            <div class="all-day-slot" data-day="Lunes"></div>
            <div class="all-day-slot" data-day="Martes"></div>
            <div class="all-day-slot" data-day="Miércoles"></div>
            <div class="all-day-slot" data-day="Jueves"></div>
            <div class="all-day-slot" data-day="Viernes"></div>
            <div class="all-day-slot" data-day="Sábado"></div>
        </div>
        <div class="time-slots" id="days">
            <!-- Aquí se rellenarán las horas y los días -->
        </div>
    </div>

    <script src="../../js/generalDash.js"></script>
    <script>
        const clearForm = () => {
            title.value = '';
            start_date.value = '';
            start_hout.value = '';
            end_date.value = '';
            end_hour.value = '';
            client.value = '';
            status.value = 0;
        }

        const getAllData = (clientId = '') => {
            const obj = {
                action: 'showData',
                client_id: clientId
            };
            fetch('../../includes/VistaSemanal.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(obj)
            })
            .then(response => response.json())
            .then(json => {
                let rowTemplate = '';
                json.forEach(row => {
                    rowTemplate += `
                    <tr>
                        <td>${row.title}</td>
                        <td>${row.start_date + " " + row.start_hout}</td>
                        <td>${row.end_date + " " + row.end_hour}</td>
                        <td>${row.client_name}</td>
                        <td>${row.active == 1 ? "Activo" : "Inactivo"}</td>
                    </tr>
                    `;
                });
                document.getElementById('results').innerHTML = rowTemplate;
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const daysContainer = document.getElementById('days');
            const currentWeek = document.getElementById('currentWeek');
            const dateSpans = document.querySelectorAll('.weekdays .date');
            const weekdayHeaders = document.querySelectorAll('.weekdays div');
            let currentDate = new Date(); // Fecha actual

            function renderWeek(date) {
                const startOfWeek = new Date(date.setDate(date.getDate() - date.getDay()));
                const days = [];

                for (let i = 0; i < 7; i++) {
                    days.push(new Date(startOfWeek));
                    startOfWeek.setDate(startOfWeek.getDate() + 1);
                }

                daysContainer.innerHTML = '';
                dateSpans.forEach((span, index) => {
                    span.innerText = days[index].getDate();
                    weekdayHeaders[index + 1].classList.remove('current-day');
                    if (days[index].toDateString() === new Date().toDateString()) {
                        weekdayHeaders[index + 1].classList.add('current-day');
                    }
                });

                for (let hour = 0; hour < 24; hour++) {
                    const hourDiv = document.createElement('div');
                    hourDiv.className = 'time-slot hour';
                    hourDiv.innerText = `${hour}:00`;
                    daysContainer.appendChild(hourDiv);
                    for (let day of days) {
                        const dayDiv = document.createElement('div');
                        dayDiv.className = 'time-slot';
                        dayDiv.dataset.date = day.toISOString().split('T')[0];
                        dayDiv.dataset.hour = hour;
                        daysContainer.appendChild(dayDiv);
                    }
                }

                const options = { year: 'numeric', month: 'long' };
                currentWeek.innerText = `${days[0].toLocaleDateString('es-ES', options)} - ${days[6].toLocaleDateString('es-ES', options)}`;
            }

            document.getElementById('prevWeek').addEventListener('click', () => {
                currentDate.setDate(currentDate.getDate() - 7);
                renderWeek(currentDate);
            });

            document.getElementById('nextWeek').addEventListener('click', () => {
                currentDate.setDate(currentDate.getDate() + 7);
                renderWeek(currentDate);
            });

            document.getElementById('today').addEventListener('click', () => {
                currentDate = new Date(); // Restablecer a la fecha actual
                renderWeek(currentDate);
            });

            renderWeek(currentDate);
        });
    </script>
</body>
</html>

=======
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Incluir CSS Principal -->
    <link rel="stylesheet" href="../../css/styles.css">

    <?php
    include_once '../../includes/head.php';
    require_once '../../includes/events.php';
    ?>

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #calendar {
            max-width: 100%;
            height: 800px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2">
                <?php include_once '../../includes/sidebar.php'; ?>
                <script src="../../js/generalDash.js"></script>

            </div>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4" id="viewData">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Vista Semanal</h1>
                </div>
                <div id='calendar'></div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek', // Establece la vista inicial a la vista semanal
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay' // Solo permite vista semanal y diaria
                },
                views: {
                    timeGrid: {
                        slotLabelFormat: {
                            hour: 'numeric',
                            hour12: true // Usa AM y PM
                        }
                    }
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch('../../includes/events.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                action: 'showData'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            let events = data.map(event => ({
                                id: event.id,
                                title: event.title,
                                start: `${event.start_date}T${event.start_hout}`,
                                end: `${event.end_date}T${event.end_hour}`,
                                description: event.description
                            }));
                            successCallback(events);
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
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
                        title: 'Recuerda que',
                        text: `Tiene una reservación hecha para ${info.event.title} desde ${startTime} hasta ${endTime}.`,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                },
                dateClick: function(info) {
                    Swal.fire({
                        title: 'Agregar Evento',
                        html: `
                            <form id="eventForm">
                                <div class="container" style="max-width: 800px; margin: auto;">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="title">Título:</label>
                                            <input type="text" id="title" name="title" class="form-control swal2-input" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="description">Descripción:</label>
                                            <textarea id="description" name="description" class="form-control swal2-input" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="start_date">Fecha de inicio:</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control swal2-input" value="${info.dateStr}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="end_date">Fecha de fin:</label>
                                            <input type="date" id="end_date" name="end_date" class="form-control swal2-input" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="client">Clientes:</label>
                                            <select name="client" id="client" class="form-control swal2-input">
                                                <option value="" selected>Seleccione una Opción</option>
                                                <?php 
                                                require_once '../../includes/Clients.php';
                                                $clientes = new Clients();
                                                $data = $clientes->getClientsForEvents();
                                                foreach ($data as $value) {
                                                ?> 
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="user">Usuarios:</label>
                                            <select name="user" id="user" class="form-control swal2-input">
                                                <option value="" selected>Seleccione una Opción</option>
                                                <?php 
                                                require_once '../../includes/Users.php';
                                                $usuario = new User();
                                                $data = $usuario->getUserForEvents();
                                                foreach ($data as $value) {
                                                ?> 
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        `,
                        focusConfirm: false,
                        preConfirm: () => {
                            const title = Swal.getPopup().querySelector('#title').value;
                            const description = Swal.getPopup().querySelector('#description').value;
                            const startDate = Swal.getPopup().querySelector('#start_date').value;
                            const endDate = Swal.getPopup().querySelector('#end_date').value;
                            const client_id = Swal.getPopup().querySelector('#client').value;
                            const user_id = Swal.getPopup().querySelector('#user').value;

                            if (!title || !description || !startDate || !endDate || !client_id || !user_id) {
                                Swal.showValidationMessage(`Por favor, completa todos los campos`);
                                return;
                            }

                            return {
                                title,
                                description,
                                startDate,
                                endDate,
                                client_id,
                                user_id
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const {
                                title,
                                description,
                                startDate,
                                endDate,
                                client_id,
                                user_id
                            } = result.value;

                            fetch('../../includes/events.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        action: 'insert',
                                        title: title,
                                        description: description,
                                        start_date: startDate,
                                        start_hout: "00:00:00",
                                        end_date: endDate,
                                        end_hour: "00:00:00",
                                        client_id: client_id,
                                        user_id: user_id,
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
                }
            });
            calendar.render();
        });
    </script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
>>>>>>> Stashed changes
