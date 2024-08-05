<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Semanal</title>
    <link rel="stylesheet" href="../../css/Semanal.css">
    <style>
        .current-day {
            background-color: green;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>
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
    <script>
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
