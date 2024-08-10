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

