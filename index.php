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
    <!-- jQuery UI CSS and JS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div class="container-fluid">
    <div id='calendar'></div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const getAllData = async () => {
        const obj = {
            action: 'showData'
        }
        const response = await fetch('includes/events.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(obj)
        });
        const json = await response.json();
        return json.map(row => ({
            id: row.id,
            start: row.start_date,
            end: row.end_date,
            title: row.title,
            description: row.description,
            client: row.client,
            user: row.user,
            map: row.map,
            status: row.status
        }));
    }
    const getSelectOptions = (action) => {
        return fetch('includes/events.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ action })
        })
        .then(response => response.json());
    }
    const initializeCalendar = (allEvents) => {
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
            height: '100vh',
            contentHeight: 'auto',
            dateClick: async function(info) {
                const clients = await getSelectOptions('getClients');
                const users = await getSelectOptions('getUsers');
                const clientOptions = clients.map(client => `<option value="${client.id}">${client.name}</option>`).join('');
                const userOptions = users.map(user => `<option value="${user.id}">${user.name}</option>`).join('');
                Swal.fire({
                    title: '<h2 style="font-family: Arial, sans-serif; font-weight: bold;">AGREGAR EVENTO</h2>',
                    html: `
                        <form id="swal-form" class="swal-form">
                            <div class="form-group"><label for="swal-title">Título:</label><input type="text" id="swal-title" class="swal2-input" required></div>
                            <div class="form-group"><label for="swal-start">Fecha de inicio:</label><input type="datetime-local" id="swal-start" class="swal2-input" required></div>
                            <div class="form-group"><label for="swal-end">Fecha de fin:</label><input type="datetime-local" id="swal-end" class="swal2-input"></div>
                            <div class="form-group"><label for="swal-description">Descripción:</label><textarea id="swal-description" class="swal2-textarea"></textarea></div>
                            <div class="form-group"><label for="swal-client">Cliente:</label><select id="swal-client" class="swal2-input" required>${clientOptions}</select></div>
                            <div class="form-group"><label for="swal-user">Usuario:</label><select id="swal-user" class="swal2-input" required>${userOptions}</select></div>
                            <div class="form-group"><label for="swal-map">Mapa:</label><input type="text" id="swal-map" class="swal2-input" required></div>
                            <div class="form-group"><label for="swal-status">Estado:</label><select id="swal-status" class="swal2-input" required><option value="1">Activo</option><option value="0">Inactivo</option></select></div>
                        </form>
                    `,
                    customClass: {
                        popup: 'swal2-popup-custom'
                    },
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    showDenyButton: true,
                    denyButtonText: 'Eliminar',
                    didOpen: () => {
                        const swalPopup = Swal.getPopup();
                        $(swalPopup).draggable();
                        $(swalPopup).resizable();
                    },
                    preConfirm: () => {
                        const title = Swal.getPopup().querySelector('#swal-title').value;
                        const start_date = Swal.getPopup().querySelector('#swal-start').value;
                        const end_date = Swal.getPopup().querySelector('#swal-end').value;
                        const description = Swal.getPopup().querySelector('#swal-description').value;
                        const client = Swal.getPopup().querySelector('#swal-client').value;
                        const user = Swal.getPopup().querySelector('#swal-user').value;
                        const map = Swal.getPopup().querySelector('#swal-map').value;
                        const status = Swal.getPopup().querySelector('#swal-status').value;
                        if (!title || !start_date || !client || !user || !map || !status) {
                            Swal.showValidationMessage('Por favor, complete todos los campos obligatorios');
                            return false;
                        }
                        return { title, start_date, end_date, description, client, user, map, status };
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
                                end_date: result.value.end_date,
                                description: result.value.description,
                                client: result.value.client,
                                user: result.value.user,
                                map: result.value.map,
                                status: result.value.status
                            })
                        })
                        .then(response => response.json())
                        .then(response => {
                            calendar.addEvent({
                                id: response.id,
                                title: result.value.title,
                                start: result.value.start_date,
                                end: result.value.end_date,
                                description: result.value.description,
                                client: result.value.client,
                                user: result.value.user,
                                map: result.value.map,
                                status: result.value.status
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'Guardado!',
                                showConfirmButton: true,
                                customClass: {
                                    confirmButton: 'swal-button-centered'
                                }
                            });
                        });
                    } else if (result.isDenied) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Eliminado',
                            showConfirmButton: true,
                            customClass: {
                            confirmButton: 'swal-button-centered'
                            }
                        });
                    }
                });
            },
            eventClick: async function(info) {
                const clients = await getSelectOptions('getClients');
                const users = await getSelectOptions('getUsers');
                const clientOptions = clients.map(client => `<option value="${client.id}" ${client.id == info.event.extendedProps.client ? 'selected' : ''}>${client.name}</option>`).join('');
                const userOptions = users.map(user => `<option value="${user.id}" ${user.id == info.event.extendedProps.user ? 'selected' : ''}>${user.name}</option>`).join('');
                const event = info.event;
                Swal.fire({
                    title: '<h2 style="font-family: Arial, sans-serif; font-weight: bold;">EDITAR EVENTO</h2>',
                    html: `
                        <form id="swal-form" class="swal-form">
                            <div class="form-group"><label for="swal-title">Título:</label><input type="text" id="swal-title" class="swal2-input" value="${event.title}" required></div>
                            <div class="form-group"><label for="swal-start">Fecha de inicio:</label><input type="datetime-local" id="swal-start" class="swal2-input" value="${event.start.toISOString().slice(0, 16)}" required></div>
                            <div class="form-group"><label for="swal-end">Fecha de fin:</label><input type="datetime-local" id="swal-end" class="swal2-input" value="${event.end ? event.end.toISOString().slice(0, 16) : ''}"></div>
                            <div class="form-group"><label for="swal-description">Descripción:</label><textarea id="swal-description" class="swal2-textarea">${event.extendedProps.description}</textarea></div>
                            <div class="form-group"><label for="swal-client">Cliente:</label><select id="swal-client" class="swal2-input" required>${clientOptions}</select></div>
                            <div class="form-group"><label for="swal-user">Usuario:</label><select id="swal-user" class="swal2-input" required>${userOptions}</select></div>
                            <div class="form-group"><label for="swal-map">Mapa:</label><input type="text" id="swal-map" class="swal2-input" value="${event.extendedProps.map}" required></div>
                            <div class="form-group"><label for="swal-status">Estado:</label><select id="swal-status" class="swal2-input" required><option value="1" ${event.extendedProps.status == 1 ? 'selected' : ''}>Activo</option><option value="0" ${event.extendedProps.status == 0 ? 'selected' : ''}>Inactivo</option></select></div>
                        </form>
                    `,
                    customClass: {
                        popup: 'swal2-popup-custom'
                    },
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    showDenyButton: true,
                    denyButtonText: 'Eliminar',
                    didOpen: () => {
                        const swalPopup = Swal.getPopup();
                        $(swalPopup).draggable();
                        $(swalPopup).resizable();
                    },
                    preConfirm: () => {
                        const title = Swal.getPopup().querySelector('#swal-title').value;
                        const start_date = Swal.getPopup().querySelector('#swal-start').value;
                        const end_date = Swal.getPopup().querySelector('#swal-end').value;
                        const description = Swal.getPopup().querySelector('#swal-description').value;
                        const client = Swal.getPopup().querySelector('#swal-client').value;
                        const user = Swal.getPopup().querySelector('#swal-user').value;
                        const map = Swal.getPopup().querySelector('#swal-map').value;
                        const status = Swal.getPopup().querySelector('#swal-status').value;
                        if (!title || !start_date || !client || !user || !map || !status) {
                            Swal.showValidationMessage('Por favor, complete todos los campos obligatorios');
                            return false;
                        }
                        return { title, start_date, end_date, description, client, user, map, status };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('includes/events.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                action: 'update',
                                id: event.id,
                                title: result.value.title,
                                start_date: result.value.start_date,
                                end_date: result.value.end_date,
                                description: result.value.description,
                                client: result.value.client,
                                user: result.value.user,
                                map: result.value.map,
                                status: result.value.status
                            })
                        })
                        .then(response => response.text())
                        .then(response => {
                            event.setProp('title', result.value.title);
                            event.setStart(result.value.start_date);
                            event.setEnd(result.value.end_date);
                            event.setExtendedProp('description', result.value.description);
                            event.setExtendedProp('client', result.value.client);
                            event.setExtendedProp('user', result.value.user);
                            event.setExtendedProp('map', result.value.map);
                            event.setExtendedProp('status', result.value.status);
                            Swal.fire({
                                icon: 'success',
                                title: 'Guardado!',
                                showConfirmButton: true,
                                customClass: {
                                    confirmButton: 'swal-button-centered'
                                }
                            });
                        });
                    } else if (result.isDenied) {
                        fetch('includes/events.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                action: 'delete',
                                id: event.id
                            })
                        })
                        .then(response => response.text())
                        .then(response => {
                            event.remove();
                            Swal.fire({
                                icon: 'info',
                                title: 'Eliminado',
                                showConfirmButton: true,
                                customClass: {
                                    confirmButton: 'swal-button-centered'
                                }
                            });
                        });
                    }
                });
            },
            events: allEvents
        });
        calendar.render();
    };
    getAllData().then(eventsArray => {
        initializeCalendar(eventsArray);
    });
});
</script>
</body>
</html>


