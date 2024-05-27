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

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="viewData">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Events</h1>
          <button class="btn btn-warning" id="btnNew">+ Nuevo</button>
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
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="viewForm">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Events</h1>
          <button class="btn btn-dark" id="btnClose">Cerrar</button>
        </div>
        <div class="row">
          <div class="form-group">
            <label for="title">Titulo:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Ingresa el Titulo">
          </div>
          <div class="form-group">
            <label for="description">Descripcion:</label>
            <textarea type="text" class="form-control" id="description" name="description" placeholder="Descripcion del evento"></textarea>
          </div>
          <div class="form-group">
            <label for="start_date">Fecha de Inicio:</label>
            <input type="date" class="form-control" id="start_date" name="start_date">
          </div>
          <div class="form-group">
            <label for="start_hout">Hora de Inicio:</label>
            <input type="time" class="form-control" id="start_hout" name="start_hout">
          </div>
          <div class="form-group">
            <label for="end_date">Fecha de Fin:</label>
            <input type="date" class="form-control" id="end_date" name="end_date">
          </div>
          <div class="form-group">
            <label for="end_hour">Hora de Fin:</label>
            <input type="time" class="form-control" id="end_hour" name="end_hour">
          </div>
          <div class="form-group">
            <label for="client_id">Cliente:</label>
            <input type="text" class="form-control" id="client_id" name="client_id" placeholder="Escribe tu nombre de Cliente">
          </div>
          <div class="form-group">
            <label for="user_id">Usuarios:</label>
            <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Usuarios Invitados">
          </div>
          <div class="form-group">
            <label for="map">Mapa:</label>
            <input type="url" class="form-control" id="map" name="map" placeholder="Lugar del Evento en Formato URL">
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
              <option value="0">Inactivo</option>
              <option value="1">Activo</option>
            </select>
          </div>
          <div class="form-group mt-3">
            <button class="btn btn-primary" id="btnSave">Registrar</button>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script src="../../js/generalEvents.js"></script>
  <script>
    const clearForm = () => {
      title.value = ''
      status.value = 0
      description.value=''
      start_date.value=''
      start_hout.value=''
      end_date.value=''
      end_hour.value=''
      client_id.value= ''
      user_id.value= ''
      map.value=''

    }
    btnSave.addEventListener('click', (e) => {
      e.preventDefault()

      const obj = {
        action: 'insert',
        title: title.value,
        status: status.value,
        description: description.value,
        start_date: start_date.value,
        start_hout: start_hout.value,
        end_date: end_date.value,
        end_hour: end_hour.value,
        client_id: client_id.value,
        user_id: user_id.value,
        map: map.value
      }

      fetch('../../includes/events.php', {
          method: 'POST',
          body: JSON.stringify(obj)
        })
        .then(response => response.json())
        .then(json => {
          alert(json.message)
          clearForm()
          showData()
        })

    })
  </script>
</body>

</html>