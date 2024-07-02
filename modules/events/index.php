<!doctype html>
<html lang="en">
<link rel="stylesheet" href="../../css/styles.css">
<head>
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
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 animate_animated animate_faster" id="viewData">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Reservaciones</h1>
          <div class="ml-md-auto d-flex align-items-center">
              <form class="d-flex custom-margin me-1" id="searchForm">
              <div class="btn-group me-1">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="position: relative;right: 10px;">Filtro</button>
                <ul class="dropdown-menu" id="clientUL">
                <li><a class="dropdown-item" href="#" data-client-id="all">Todos</a></li>
                    <?php foreach ($clients as $client): ?><li><a class="dropdown-item" href="#" data-client-id="<?php echo $client->id; ?>"><?php echo $client->name; ?></a></li>
                    <?php endforeach; ?> 
                </ul>
                <input type="text" class="form-control" placeholder="Buscar..." id="searchInput">
            </div>
              </form>
            <button class="btn btn-warning me-2" id="btnNew" value="Buscar">+ Nuevo</button>
          </div>
        </div>
        <div class="table-responsive small">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">Titulo</th>
                <th scope="col">Cliente</th>
                <th scope="col">Fecha de Inicio</th>
                <th scope="col">Fecha de Fin</th>
                <th scope="col">Status</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody id="results"></tbody>
          </table>
        </div>
      </main>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 animate_animated animate_faster" id="viewForm">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom ">
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
            <label for="client">Cliente:</label>
            <select name="client" id="client" class="form-control">
            <option value="" selected>Seleccione una Opcion</option>
              <?php 
              require_once "../../includes/Clients.php";
              $clientes = new Clients();
              $data = $clientes->getClientsForEvents();
              foreach ($data as $key => $value) {
              ?> 
              <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
              <?php
              }
              print_r($data);
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="user">Usuarios:</label>
            <select class="form-control" name="user" id="user">
            <option value="" selected>Seleccione una Opcion</option>
              <?php 
              require_once "../../includes/Users.php";
              $usuario = new User();
              $data = $usuario->getUserForEvents();
              foreach ($data as $key => $value) {
              ?> 
              <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
              <?php
              }
              print_r($data);
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="map">Mapa:</label>
            <input type="url" class="form-control" id="map" name="map" placeholder="Lugar del Evento en Formato URL">
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
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
      description.value = ''
      start_date.value = ''
      start_hout.value = ''
      end_date.value = ''
      end_hour.value = ''
      client.value = ''
      user.value = ''
      map.value = ''
      status.value = 0
      btnSave.removeAttribute('data-id');
      btnSave.textContent = 'Registrar'
    }
    
    btnSave.addEventListener('click', (e) => {
      e.preventDefault()

      if (!title.value.trim() || !description.value.trim() || !start_date.value.trim() || !start_hout.value.trim() || !end_date.value.trim() || !end_hour.value.trim() || !map.value.trim()) {
        alert('Todos los campos son obligatorios.');
        return;
      }

      let obj = {
        action: 'insert',
        title: title.value,
        description: description.value,
        start_date: start_date.value,
        start_hout: start_hout.value,
        end_date: end_date.value,
        end_hour: end_hour.value,
        client: client.value,
        user: user.value,
        map: map.value,
        status: status.value
      }

      if (btnSave.hasAttribute('data-id')) {
        obj.action = 'update'
        obj.id = btnSave.getAttribute('data-id')
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
          alert(json.message);
          if (json.status === 2) {
            clearForm();
            showData();
            btnSave.removeAttribute('data-id');
            btnSave.textContent = 'Registrar'
            location.reload()
          }
          getAllData()
        })
    })

    const deleteData = e => {
      e.preventDefault();
      const id = e.target.getAttribute('data-id');
      if (confirm('¿Estás seguro que deseas eliminar este Evento?')) {
        const obj = {
          action: 'delete',
          id: id
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
            getAllData()
          })
      }
    }

      const editData = e => {
        e.preventDefault()
        showForm()
        const id =  e.target.getAttribute('data-id')
        const obj = {
          action: 'selectOne',
          id
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
            title.value = json.title
            description.value = json.description
            start_date.value = json.start_date
            start_hout.value = json.start_hout
            end_date.value = json.end_date
            end_hour.value = json.end_hour
            client.value = json.client_id
            user.value = json.user_id
            map.value = json.map
            status.value = json.active
            btnSave.textContent = 'Editar'
            btnSave.dataset.id = id
          })
      }

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
          let rowTemplate = ''
          json.forEach(row => {
            rowTemplate += `
            <tr>
              <td>${row.title}</td>
              <td>${row.client}</td>
              <td>${row.start_date + " " + row.start_hout}</td>
              <td>${row.end_date + " " + row.end_hour}</td>
              <td>${row.active == 1 ? "Activo" : "Inactivo"}</td>
              <td>
                <button type="button" class="btn btn-warning btnEdit" data-id="${row.id}">Editar</button>
                <button type="button" class="btn btn-danger btnDelete" data-id="${row.id}">Eliminar</button>
              </td>
            </tr>
            `
          })
          results.innerHTML = rowTemplate
        })
    }

    document.getElementById('clientUL').addEventListener('click', (e) => {
    e.preventDefault();
    if (e.target.classList.contains('dropdown-item')) {
        const clientId = e.target.getAttribute('data-client-id');
        if (clientId === 'all') {
            getAllData();
        } else {
  const obj = {
    action: 'filtroData',
    client_id: clientId
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
      let rowTemplate = '';
      json.forEach(row => {
        rowTemplate += `
        <tr>
          <td>${row.title}</td>
          <td>${row.client}</td>
          <td>${row.start_date + " " + row.start_hout}</td>
          <td>${row.end_date + " " + row.end_hour}</td>
          <td>${row.active == 1 ? "Activo" : "Inactivo"}</td>
          <td>
            <button type="button" class="btn btn-warning btnEdit" data-id="${row.id}">Editar</button>
            <button type="button" class="btn btn-danger btnDelete" data-id="${row.id}">Eliminar</button>
          </td>
        </tr>
        `;
      });
      document.getElementById('results').innerHTML = rowTemplate;
    })
    .catch(error => console.error('Error:', error));
  }
}
})

    getAllData()

      results.addEventListener('click', e => {
        e.preventDefault()
        if (e.target.classList.contains('btnEdit')) {
          editData(e)
        }
        if (e.target.classList.contains('btnDelete')) {
          deleteData(e)
        }
      })
      const searchInput = document.querySelector('#searchInput');
    searchInput.addEventListener('input', () => {
      const query = searchInput.value.trim();
      getAllData(query);
    });
  
    // Limpia el buscador
    const clearSearch = () => {
    searchInput.value = '';
  }

  btnClose.addEventListener('click', (e) => {
    e.preventDefault();
    clearForm();
    clearSearch();
    showData();
  });
  </script>
</body>

</html>