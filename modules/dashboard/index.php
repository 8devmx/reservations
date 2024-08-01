<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" href="../../css/styles.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      color: #333;
    }
  
    .border-bottom {
      border-bottom: 3px solid #007bff !important;
    }
    .h2 {
      color: #007bff;
      font-weight: 600;
    }
    .list-group {
      margin-top: 20px;
    }
    .list-group-item {
      background-color: #ffffff;
      border: none;
      border-left: 5px solid #007bff;
      margin-bottom: 10px;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .list-group-item:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
      border-left-color: #28a745; /* Cambia el borde izquierdo al verde */
    }
    .list-group-item h5 {
      margin-bottom: 10px;
      color: #343a40;
      font-size: 18px;
    }
    .list-group-item p {
      margin: 5px 0;
      color: #555;
    }
    .list-group-item p strong {
      color: #333;
    }
    .list-group-item .status {
      display: inline-block;
      padding: 5px 10px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
    }
    .status-activo {
      background-color: #28a745; /* Verde para activo */
      color: white;
    }
    .status-inactivo {
      background-color: #dc3545; /* Rojo para inactivo */
      color: white;
    }
  </style>
  <?php
  include_once '../../includes/head.php';
  require_once '../../includes/events.php';
  $events = new Events();
  $clients = $events->getClients();
  ?>
</head>
<body>
  <?php include_once '../../includes/header.php'; ?>
  <div class="container-fluid">
    <div class="row">
      <?php include_once '../../includes/sidebar.php'; ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 animate_animated animate_faster">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Reservaciones</h1>
        </div>
        <div class="list-group" id="results"></div>
      </main>
    </div>
  </div>
  <script src="../../js/generalEvents.js"></script>
  <script>
    const getAllData = (query = '') => {
      const obj = {
        action: 'showData',
        query: query
      }
      fetch('../../includes/events.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(obj)
        })
        .then(response => response.json())
        .then(json => {
          let listTemplate = '';
          json.forEach(row => {
            const statusClass = row.active == 1 ? 'status-activo' : 'status-inactivo';
            const statusText = row.active == 1 ? 'Activo' : 'Inactivo';
            listTemplate += `
            <div class="list-group-item">
              <h5>${row.title}</h5>
              <p><strong>Cliente:</strong> ${row.client}</p>
              <p><strong>Fecha de Inicio:</strong> ${row.start_date + " " + row.start_hout}</p>
              <p><strong>Fecha de Fin:</strong> ${row.end_date + " " + row.end_hour}</p>
              <p><strong>Status:</strong> <span class="status ${statusClass}">${statusText}</span></p>
            </div>
            `;
          });
          results.innerHTML = listTemplate;
        })
    }

    getAllData();
  </script>
</body>
</html>