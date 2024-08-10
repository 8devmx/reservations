<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="../../css/styles.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php
    include_once '../../includes/head.php';
    require_once '../../includes/dashboard.php';

    $events = new Events();
    $clients = $events->getAllClients();
    ?>
</head>
<body>
    <?php include_once '../../includes/header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include_once '../../includes/sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-light" id="viewData">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
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
            </main>
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
        getAllData();

        // Manejar el cambio en el select de clientes
        document.getElementById('client_filter').addEventListener('change', (e) => {
            const clientId = e.target.value;
            getAllData(clientId);
        });
    </script>
</body>
</html>
