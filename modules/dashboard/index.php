<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="../../css/styles.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
<<<<<<< Updated upstream
=======
    <link rel="stylesheet" href="../../css/styles.css">
>>>>>>> Stashed changes
    <?php
    include_once '../../includes/head.php';
    require_once '../../includes/dashboard.php';

    $events = new Events();
<<<<<<< Updated upstream
    $clients = $events->getAllClients();
    ?>
</head>
<body>
    <?php include_once '../../includes/header.php'; ?>
=======
    $clients = $events->getClients(); // Obtener solo los clientes activos
    ?>
    <style>
        /* Estilo para la palabra Activo */
        .status-active {
            color: #28a745; /* Verde para el texto Activo */
            font-weight: bold;
        }

        /* Estilo para la palabra Inactivo */
        .status-inactive {
            color: #dc3545; /* Rojo para el texto Inactivo */
            font-weight: bold;
        }

        /* Estilo general para cada tarjeta de reservación */
        .reservation-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8f9fa;
        }

        /* Efecto hover para la tarjeta de reservación */
        .reservation-item:hover {
            transform: translateY(-5px); /* Mueve la tarjeta hacia arriba */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Añade sombra */
            background-color: #e9ecef; /* Cambia ligeramente el color de fondo */
        }
    </style>
</head>
<body>
>>>>>>> Stashed changes
    <div class="container-fluid">
        <div class="row">
            <?php include_once '../../includes/sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light" id="viewData">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<<<<<<< Updated upstream
                    <h1 class="h2">Reservaciones del dia</h1>
                </div>
                <div class="form-group">
                    <label for="client_filter"  class="h6 mb-1">Filtrar por Cliente:</label>
                    <select name="client_filter" id="client_filter" class="form-select w-50 bg-light mb-2">
                        <option value="" selected>Todos</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="table-responsive small">
                    <table class="table table-responsive table-striped table-light">
                        <thead>
                            <tr>
                                <th scope="col">Titulo</th>
                                <th scope="col">Fecha de Inicio</th>
                                <th scope="col">Fecha de Fin</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="results"></tbody>
                    </table>
                </div>
=======
                    <h1 class="h2">Reservaciones del día</h1>
                </div>
                <div class="form-group">
                    <label for="client_filter" class="h6 mb-1">Filtrar por Cliente:</label>
                    <select name="client_filter" id="client_filter" class="form-select w-50 bg-light mb-2">
                        <option value="" selected>Todos</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client->id; ?>"><?php echo $client->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="reservationList" class="reservation-list"></div>
>>>>>>> Stashed changes
            </main>
        </div>
    </div>
    <script src="../../js/generalDash.js"></script>
    <script>
<<<<<<< Updated upstream
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
            fetch('../../includes/dashboard.php', {
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

        // Inicializar con todos los datos
=======
        const getAllData = (clientId = '') => {
            const obj = {
                action: 'showData',
                client_id: clientId
            };
            fetch('../../includes/dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(obj)
            })
            .then(response => response.json())
            .then(json => {
                let listTemplate = '';
                if (json.length > 0) {
                    json.forEach(item => {
                        const statusClass = item.active == 1 ? 'status-active' : 'status-inactive'; // Determinar la clase basada en el estado

                        listTemplate += `
                        <div class="reservation-item mb-3 p-3 shadow-sm">
                            <h4 class="mb-1">${item.title}</h4>
                            <p class="mb-1"><strong>Fecha de Inicio:</strong> ${item.start_date} ${item.start_hout}</p>
                            <p class="mb-1"><strong>Fecha de Fin:</strong> ${item.end_date} ${item.end_hour}</p>
                            <p class="mb-1"><strong>Cliente:</strong> ${item.client}</p>
                            <p class="mb-1"><strong>Status:</strong> <span class="${statusClass}">${item.active == 1 ? "Activo" : "Inactivo"}</span></p>
                        </div>
                        `;
                    });
                } else {
                    listTemplate = '<p>No hay reservaciones para mostrar.</p>';
                }
                document.getElementById('reservationList').innerHTML = listTemplate;
            });
        }

        // Inicializar con todos los datos del día
>>>>>>> Stashed changes
        getAllData();

        // Manejar el cambio en el select de clientes
        document.getElementById('client_filter').addEventListener('change', (e) => {
            const clientId = e.target.value;
            getAllData(clientId);
        });
    </script>
</body>
</html>
