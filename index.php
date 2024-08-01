<!doctype html>
<html lang="en">
<link rel="stylesheet" href="css/styles.css">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php
    include_once 'includes/head.php';
    require_once 'includes/events.php';
    ?>
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Incluir SweetAlert -->

    <style>
        #calendar {
            max-width: 100%;
            height: 800px;
            margin: auto;
        }
    </style>
</head>

<body>
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
<<<<<<< Updated upstream
                            hour12: true // Esta opción asegura que se usen AM y PM
=======
>>>>>>> Stashed changes
                        }
                    }
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch('includes/events.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
<<<<<<< Updated upstream
                            body: JSON.stringify({ action: 'showData' })
=======
                            body: JSON.stringify({
                                action: 'showData'
                            })
>>>>>>> Stashed changes
                        })
                        .then(response => response.json())
                        .then(data => {
                            let events = data.map(event => ({
                                id: event.id,
                                title: event.title,
                                start: event.start_date + 'T' + event.start_hout,
                                end: event.end_date + 'T' + event.end_hour,
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
<<<<<<< Updated upstream
                    Swal.fire({
                        title: 'Agregar Evento',
                        html: `
                            <form id="eventForm">
                                <label for="title">Título:</label>
                                <input type="text" id="title" name="title" class="swal2-input" required>
                                <label for="start_date">Fecha de inicio:</label>
                                <input type="date" id="start_date" name="start_date" class="swal2-input" value="${info.dateStr}" required>
                                <label for="end_date">Fecha de fin:</label>
                                <input type="date" id="end_date" name="end_date" class="swal2-input" required>
                            </form>
                        `,
                        focusConfirm: false,
                        preConfirm: () => {
                            const title = Swal.getPopup().querySelector('#title').value;
                            const startDate = Swal.getPopup().querySelector('#start_date').value;
                            const endDate = Swal.getPopup().querySelector('#end_date').value;

                            if (!title || !startDate || !endDate) {
=======
                    function loadClients() {
                        return fetch('includes/events.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ action: 'getClients' })
                        })
                        .then(response => response.json())
                        .then(clients => {
                            let clientOptions = clients.map(client => `<option value="${client.id}">${client.name}</option>`);
                            document.getElementById('client_id').innerHTML = clientOptions.join('');
                        })
                        .catch(error => console.error('Error fetching clients:', error));
                    }

                    function loadUsers() {
                        return fetch('includes/events.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ action: 'getUsers' })
                        })
                        .then(response => response.json())
                        .then(users => {
                            let userOptions = users.map(user => `<option value="${user.id}">${user.name}</option>`);
                            document.getElementById('user_id').innerHTML = userOptions.join('');
                        })
                        .catch(error => console.error('Error fetching users:', error));
                    }

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
                        <label for="client_id">Clientes:</label>
                        <select name="client" id="client" class="form-control swal2-input">
                            <option value="" selected>Seleccione una Opción</option>
                            <?php 
                            require_once "includes/Clients.php";
                            $clientes = new Clients();
                            $data = $clientes->getClientsForEvents();
                            foreach ($data as $key => $value) {
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
                        <label for="user_id">Usuarios:</label>
                        <select name="user" id="user" class="form-control swal2-input">
                            <option value="" selected>Seleccione una Opción</option>
                            <?php 
                            require_once "includes/Users.php";
                            $usuario = new User();
                            $data = $usuario->getUserForEvents();
                            foreach ($data as $key => $value) {
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
                        didOpen: () => {
                            // Cargar clientes y usuarios después de abrir el modal
                            loadClients();
                            loadUsers();
                        },
                        preConfirm: () => {
                            const title = Swal.getPopup().querySelector('#title').value;
                            const description = Swal.getPopup().querySelector('#description').value;
                            const startDate = Swal.getPopup().querySelector('#start_date').value;
                            const endDate = Swal.getPopup().querySelector('#end_date').value;
                            const client_id = Swal.getPopup().querySelector('#client').value;
                            const user_id = Swal.getPopup().querySelector('#user').value;

                            if (!title || !description || !startDate || !endDate || !client_id || !user_id) {
>>>>>>> Stashed changes
                                Swal.showValidationMessage(`Por favor, completa todos los campos`);
                                return;
                            }

<<<<<<< Updated upstream
                            return { title, startDate, endDate };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const { title, startDate, endDate } = result.value;
                            
                            fetch('includes/events.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    action: 'insert',
                                    title: title,
                                    start_date: startDate,
                                    end_date: endDate
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
=======
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

                            fetch('includes/events.php', {
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
>>>>>>> Stashed changes
                        }
                    });
                }
            });
            calendar.render();
        });
    </script>
    <?php include_once 'includes/header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4" id="viewData">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                <div id='calendar'></div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
<<<<<<< Updated upstream
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8O"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9b73iZFl+PH0sBqAzZXO5JJ2cSeF2MiRlz4dA8R0I42B1h8D1mN8rFA"></script>
</body>

=======
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
>>>>>>> Stashed changes
</html>
