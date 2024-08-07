<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="../../css/styles.css">
<head>
  <?php
  include_once '../../includes/head.php';
  require_once '../../includes/Clients.php';
  $clients = new Clients();
  ?>
</head>

<body>
  <?php include_once '../../includes/header.php'; ?>
  <div class="container-fluid">
    <div class="row">
      <?php include_once '../../includes/sidebar.php'; ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" id="viewData">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Clientes</h1>
          <div class="ml-md-auto d-flex align-items-center">
            <div class="btn-group me-2" role="group">
              <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="position: relative;right: 10px;">Filtro</button>
              <ul class="dropdown-menu" id="filterMenu">
                <li><a class="dropdown-item" data-status="all">Todos</a></li>
                <li><a class="dropdown-item" data-status="1">Activo</a></li>
                <li><a class="dropdown-item" data-status="0">Inactivo</a></li>
              </ul>
              <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
            </div>
            <button class="btn btn-warning me-2" id="btnNew">+ Nuevo</button>
          </div>
        </div>
        <div class="table-responsive small">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Status</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody id="results"></tbody>
          </table>
        </div>
      </main>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 d-none" id="viewForm">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Clientes</h1>
          <button class="btn btn-dark" id="btnClose">Cerrar</button>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa el nombre">
          </div>
          <div class="form-group col-sm-6">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Ingresa el email">
          </div>
          <div class="form-group col-sm-6">
            <label for="phone">Teléfono:</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Ingresa el teléfono">
          </div>
          <div class="form-group col-sm-6">
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
  <script src="../../js/general.js"></script>
  <script src="../../js/generalclients.js"></script>
  <script>
    const clearForm = () => {
      name.value = '';
      email.value = '';
      phone.value = '';
      status.value = '0';
      btnSave.removeAttribute('data-id');
      btnSave.textContent = 'Registrar'
    }

    btnSave.addEventListener('click', (e) => {
      e.preventDefault();
      
      if (!name.value.trim() || !email.value.trim() || !phone.value.trim()) {
        alert('Todos los campos son obligatorios.');
        return;
      }

      let obj = {
        action: 'insert',
        name: name.value,
        email: email.value,
        phone: phone.value,
        status: status.value
      };

      if (btnSave.hasAttribute('data-id')) {
        obj.action = 'update';
        obj.id = btnSave.getAttribute('data-id');
      }

      fetch('../../includes/Clients.php', {
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
          btnSave.textContent = 'Registrar';
        }
        getAllData();
      })
      .catch(error => console.error('Error:', error));
    });

    const deleteData = e => {
      e.preventDefault();
      const id = e.target.getAttribute('data-id');
      if (confirm('¿Estás seguro que deseas eliminar este cliente?')) {
        const obj = {
          action: 'delete',
          id: id
        };
        fetch('../../includes/Clients.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(obj)
        })
        .then(response => response.json())
        .then(json => {
          getAllData();
        });
      }
    };

    const editData = e => {
      e.preventDefault();
      showForm();
      const id = e.target.getAttribute('data-id');
      const obj = {
        action: 'selectOne',
        id: id
      };
      fetch('../../includes/Clients.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(obj)
      })
      .then(response => response.json())
      .then(json => {
        name.value = json.name;
        email.value = json.email;
        phone.value = json.phone;
        status.value = json.active;
        btnSave.textContent = 'Editar';
        btnSave.dataset.id = id;
      });
    };

    const getAllData = (query = '') => {
      const obj = {
        action: 'showData',
        query: query
      };
      fetch('../../includes/Clients.php', {
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
              <td>${row.id}</td>
              <td>${row.name}</td>
              <td>${row.email}</td>
              <td>${row.phone}</td>
              <td>${row.active == 1 ? "Activo" : "Inactivo"}</td>
              <td>
                <button type="button" class="btn btn-warning btnEdit" data-id="${row.id}">Editar</button>
                <button type="button" class="btn btn-danger btnDelete" data-id="${row.id}">Eliminar</button>
              </td>
            </tr>
          `;
        });
        results.innerHTML = rowTemplate;
      });
    };

    document.getElementById('filterMenu').addEventListener('click', (e) => {
      e.preventDefault();
      const status = e.target.getAttribute('data-status');
      const obj = {
        action: 'filter',
        status: status
      };
      fetch('../../includes/Clients.php', {
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
              <td>${row.id}</td>
              <td>${row.name}</td>
              <td>${row.email}</td>
              <td>${row.phone}</td>
              <td>${row.active == 1 ? "Activo" : "Inactivo"}</td>
              <td>
                <button type="button" class="btn btn-warning btnEdit" data-id="${row.id}">Editar</button>
                <button type="button" class="btn btn-danger btnDelete" data-id="${row.id}">Eliminar</button>
              </td>
            </tr>
          `;
        });
        results.innerHTML = rowTemplate;
        })
        .catch(error => console.error('Error:', error));
    });


    getAllData();

    results.addEventListener('click', e => {
      e.preventDefault();
      if (e.target.classList.contains('btnEdit')) {
        editData(e);
      }
      if (e.target.classList.contains('btnDelete')) {
        deleteData(e);
      }
    });

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