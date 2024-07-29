<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar</title>
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <!-- Custom CSS -->
    <link href='css/styles.css' rel='stylesheet' />
    <!-- Animate CSS (usando CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- FullCalendar JavaScript -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery UI for modals -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Tooltipster CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tooltipster@4.2.6/dist/css/tooltipster.bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/tooltipster@4.2.6/dist/js/tooltipster.bundle.min.js"></script>
    <!-- SweetAlert2 CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedDate = null;
            const calendarEl = document.querySelector('#calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: '100%',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today addEventButton',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                customButtons: {
                    addEventButton: {
                        text: 'Agregar Evento',
                        click: function() {
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
                                    const start = Swal.getPopup().querySelector('#swal-start').value;
                                    const end = Swal.getPopup().querySelector('#swal-end').value;
                                    if (!title || !start) {
                                        Swal.showValidationMessage('Por favor, ingrese el título y la fecha de inicio');
                                        return false;
                                    }
                                    calendar.addEvent({
                                        id: String(Date.now()),
                                        title: title,
                                        start: start,
                                        end: end || start,
                                    });
                                }
                            });

                            if (selectedDate) {
                                const previousCell = document.querySelector(`[data-date="${selectedDate}"]`);
                                previousCell.style.backgroundColor = '';
                            }
                            selectedDate = info.dateStr;
                            info.dayEl.style.backgroundColor = '#ccffcc';
                        }
                    }
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                views: {
                    dayGridMonth: {
                        buttonText: ''
                    },
                    timeGridWeek: {
                        buttonText: ''
                    },
                    timeGridDay: {
                        buttonText: ''
                    }
                },
                editable: true,
                droppable: true,
                events: [],
                eventDidMount: function(info) {
                    if (info.event.extendedProps.description) {
                        $(info.el).tooltipster({
                            content: $('<span>' + info.event.extendedProps.description + '</span>'),
                            theme: 'tooltipster-light'
                        });
                    }
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
                            const start = Swal.getPopup().querySelector('#swal-start').value;
                            const end = Swal.getPopup().querySelector('#swal-end').value;
                            if (!title || !start) {
                                Swal.showValidationMessage('Por favor, ingrese el título y la fecha de inicio');
                                return false;
                            }
                            calendar.addEvent({
                                id: String(Date.now()),
                                title: title,
                                start: start,
                                end: end || start,
                            });
                        }
                    });

                    if (selectedDate) {
                        const previousCell = document.querySelector(`[data-date="${selectedDate}"]`);
                        previousCell.style.backgroundColor = '';
                    }
                    selectedDate = info.dateStr;
                    info.dayEl.style.backgroundColor = '#ccffcc';
                },
                eventClick: function(info) {
                    $('#event-id').val(info.event.id);
                    $('#event-title').val(info.event.title);
                    $('#event-start').val(info.event.start.toISOString().slice(0, 16));
                    if (info.event.end) {
                        $('#event-end').val(info.event.end.toISOString().slice(0, 16));
                    } else {
                        $('#event-end').val('');
                    }
                    $('#event-description').val(info.event.extendedProps.description);
                    $('#event-color').val(info.event.backgroundColor);
                    $('#event-modal').dialog({
                        modal: true,
                        buttons: {
                            "Save": function() {
                                const id = $('#event-id').val();
                                const title = $('#event-title').val();
                                const start = $('#event-start').val();
                                const end = $('#event-end').val();
                                const description = $('#event-description').val();
                                const color = $('#event-color').val();
                                const event = calendar.getEventById(id);
                                if (event) {
                                    event.setProp('title', title);
                                    event.setDates(start, end);
                                    event.setExtendedProp('description', description);
                                    event.setProp('backgroundColor', color);
                                    event.setProp('borderColor', color);
                                    $(this).dialog("close");
                                }
                            },
                            "Delete": function() {
                                const id = $('#event-id').val();
                                const event = calendar.getEventById(id);
                                if (event) {
                                    event.remove();
                                    $(this).dialog("close");
                                }
                            },
                            "Cancel": function() {
                                $(this).dialog("close");
                            }
                        }
                    });
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>

