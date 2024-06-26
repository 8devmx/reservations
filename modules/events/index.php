<!doctype html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../../css/styles.css">
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
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 animate__animated animate__faster" id="viewData">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Events</h1>
          <div class="ml-md-auto d-flex align-items-center">
              <form class="d-flex custom-margin me-3" id="searchForm">
              <div class="btn-group me-1">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Selecciona un cliente</button>
                <ul class="dropdown-menu" id="clientUL">
                    <?php foreach ($clients as $client): ?><li><a class="dropdown-item" href="#" data-client-id="<?php echo $client->id; ?>"><?php echo $client->name; ?></a></li>
                    <?php endforeach; ?> 
                </ul>
            </div>
                <input type="search" class="form-control me-1" placeholder="Buscar.." id="searchInput">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
              </form>
            <button class="btn btn-warning" id="btnNew" value="Buscar">+ Nuevo</button>
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
              </tr>
            </thead>
            <tbody id="results"></tbody>
          </table>
        </div>
      </main>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 animate__animated animate__faster" id="viewForm">
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
            <input type="text" class="form-control" id="client" name="client" placeholder="Escribe tu ID de cliente">
          </div>
          <div class="form-group">
            <label for="user">Usuarios:</label>
            <input type="text" class="form-control" id="user" name="user" placeholder="Usuario ID">
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
      description.value = ''
      start_date.value = ''
      start_hout.value = ''
      end_date.value = ''
      end_hour.value = ''
      client.value = ''
      user.value = ''
      map.value = ''

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
        status: status.value,
        description: description.value,
        start_date: start_date.value,
        start_hout: start_hout.value,
        end_date: end_date.value,
        end_hour: end_hour.value,
        client: client.value,
        user: user.value,
        map: map.value
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
            client.value = json.client
            user.value = json.user
            map.value = json.map
            status.value = json.active
            btnSave.textContent = 'Editar'
            btnSave.dataset.id = id
          })
      }

      const getAllData = () => {
      const obj = {
        action: 'showData',
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
    
    document.getElementById('searchForm').addEventListener('submit', (e) => {
      e.preventDefault();
      const query = document.getElementById('searchInput').value;
      const obj = {
        action: 'search',
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
            </tr>
            `
          })
          results.innerHTML = rowTemplate
        })
        .catch(error => console.error('Error:', error));
    });

    document.getElementById('clientUL').addEventListener('click', (e) => {
    e.preventDefault();
    if (e.target.classList.contains('dropdown-item')) {
        const clientId = e.target.getAttribute('data-client-id');
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
});

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
  </script>
</body>

</html>