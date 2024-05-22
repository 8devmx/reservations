<!doctype html>
<html lang="en">

<head>
  <?php
  include_once '../../includes/head.php';
  require_once '../../includes/events.php';
  $events = new Events();
  ?>
</head>

<body>
  <?php include_once '../../includes/header.php'; ?>
  <div class="container-fluid">
    <div class="row">
      <?php include_once '../../includes/sidebar.php'; ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Events</h1>
        </div>
        <div class="table-responsive small">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Titulo</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Fecha de Inicio</th>
                <th scope="col">Hora de Inicio</th>
                <th scope="col">Fecha de Fin</th>
                <th scope="col">Hora de Fin</th>
                <th scope="col">Cliente</th>
                <th scope="col">Usuarios</th>
                <th scope="col">Mapa</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = $events->getAllData();
              if ($result->num_rows == 0) {
              ?>
                <tr class="text-center">
                  <td colspan="11">No se encontraron resultados</td>
                </tr>
              <?php
                return false;
              }

              while ($row = $result->fetch_object()) {
              ?>
                <tr>
                  <td><?php echo $row->id; ?></td>
                  <td><?php echo $row->title; ?></td>
                  <td><?php echo $row->description; ?></td>
                  <td><?php echo $row->start_date; ?></td>
                  <td><?php echo $row->start_hout; ?></td>
                  <td><?php echo $row->end_date; ?></td>
                  <td><?php echo $row->end_hour; ?></td>
                  <td><?php echo $row->client_id; ?></td>
                  <td><?php echo $row->user_id; ?></td>
                  <td><?php echo $row->map; ?></td>
                  <td><?php echo $row->active == 1 ? "Activo" : "Inactivo"; ?></td>
                  <td>
                    <button type="button" class="btn btn-warning">Editar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</body>

</html>