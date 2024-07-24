<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar Example</title>
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMUfyATqc6U8UJ0uUphfG1Ry4lRX9eBQXpvh9aw" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link href='css/styles.css' rel='stylesheet' />
    <!-- FullCalendar JavaScript -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery UI for modals -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <div id='calendar'></div>

    <!-- Modal for adding/editing events -->
    <div id="event-modal" title="Add/Edit Event" style="display: none;">
        <form id="event-form">
            <label for="event-title">Event Title:</label>
            <input type="text" id="event-title" name="event-title" required>
            <label for="event-start">Start Date and Time:</label>
            <input type="datetime-local" id="event-start" name="event-start" required>
            <label for="event-end">End Date and Time:</label>
            <input type="datetime-local" id="event-end" name="event-end">
            <label for="event-color">Event Color:</label>
            <input type="color" id="event-color" name="event-color" value="#3788d8">
            <input type="hidden" id="event-id">
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectedDate = null;
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
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
                            $('#event-id').val('');
                            $('#event-title').val('');
                            $('#event-start').val('');
                            $('#event-end').val('');
                            $('#event-color').val('#3788d8');
                            $('#event-modal').dialog({
                                modal: true,
                                buttons: {
                                    "Save": function() {
                                        var title = $('#event-title').val();
                                        var start = $('#event-start').val();
                                        var end = $('#event-end').val();
                                        var color = $('#event-color').val();
                                        if (title && selectedDate) {
                                            calendar.addEvent({
                                                id: String(Date.now()),
                                                title: title,
                                                start: selectedDate,
                                                end: end || selectedDate,
                                                color: color
                                            });
                                            $(this).dialog("close");
                                        } else {
                                            alert("Please select a date.");
                                        }
                                    },
                                    "Cancel": function() {
                                        $(this).dialog("close");
                                    }
                                }
                            });
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
                        buttonText: 'Mes'
                    },
                    timeGridWeek: {
                        buttonText: 'Semana'
                    },
                    timeGridDay: {
                        buttonText: 'Día'
                    }
                },
                editable: true,
                events: [
                    {
                        id: '1',
                        title: 'Evento 1',
                        start: '2024-07-01T10:00:00',
                        end: '2024-07-01T12:00:00',
                        description: 'Descripción del Evento 1',
                        color: '#3788d8'
                    },
                    {
                        id: '2',
                        title: 'Evento 2',
                        start: '2024-07-05T14:00:00',
                        end: '2024-07-07T16:00:00',
                        description: 'Descripción del Evento 2',
                        color: '#3788d8'
                    },
                    {
                        id: '3',
                        title: 'Evento 3',
                        start: '2024-07-09T12:30:00',
                        allDay: false,
                        description: 'Descripción del Evento 3',
                        color: '#3788d8'
                    }
                ],
                eventDidMount: function(info) {
                    if (info.event.extendedProps.description) {
                        $(info.el).attr('title', info.event.extendedProps.description);
                    }
                },
                dateClick: function(info) {
                    if (selectedDate) {
                        var previousCell = document.querySelector(`[data-date="${selectedDate}"]`);
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
                    $('#event-color').val(info.event.backgroundColor);
                    $('#event-modal').dialog({
                        modal: true,
                        buttons: {
                            "Save": function() {
                                var id = $('#event-id').val();
                                var title = $('#event-title').val();
                                var start = $('#event-start').val();
                                var end = $('#event-end').val();
                                var color = $('#event-color').val();
                                var event = calendar.getEventById(id);
                                if (event) {
                                    event.setProp('title', title);
                                    event.setDates(start, end);
                                    event.setProp('backgroundColor', color);
                                    event.setProp('borderColor', color);
                                    $(this).dialog("close");
                                }
                            },
                            "Delete": function() {
                                var id = $('#event-id').val();
                                var event = calendar.getEventById(id);
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


