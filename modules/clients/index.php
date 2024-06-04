<!doctype html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../../css/styles.css">
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
          <button class="btn btn-warning" id="btnNew">+ Nuevo</button>
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
            <tbody>
              <?php
              $result = $clients->getAllData();
              if ($result->num_rows == 0) {
              ?>
                <tr class="text-center">
                  <td colspan="6">No se encontraron resultados</td>
                </tr>
              <?php
              } else {
                while ($row = $result->fetch_object()) {
              ?>
                  <tr>
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->email; ?></td>
                    <td><?php echo $row->phone; ?></td>
                    <td><?php echo $row->active == 1 ? "Activo" : "Inactivo"; ?></td>
                    <td>
                      <button type="button" class="btn btn-warning btnEdit" data-id="<?php echo $row->id; ?>">Editar</button>
                      <button type="button" class="btn btn-danger btnDelete" data-id="<?php echo $row->id; ?>">Eliminar</button>
                    </td>
                  </tr>
              <?php
                }
              }
              ?>
            </tbody>
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
            <label for="email">Correo:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa el correo">
          </div>
          <div class="form-group col-sm-6">
            <label for="phone">Telefono:</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Ingresa el telefono">
          </div>
          <div class="form-group col-sm-6">
            <label for="status">Status:</label>
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

  <script src="../../js/generalclients.js"></script>
  <script>
    const clearForm = () => {
      document.querySelector('#name').value = '';
      document.querySelector('#email').value = '';
      document.querySelector('#phone').value = '';
      document.querySelector('#status').value = 0;
      btnSave.textContent = 'Registrar';
      delete btnSave.dataset.id;
    };

    document.querySelector('#btnSave').addEventListener('click', (e) => {
  e.preventDefault()

  const id = btnSave.dataset.id;
  const action = id ? 'update' : 'insert';

  const obj = {
    action,
    id: id ? id : null,
    name: document.querySelector('#name').value,
    email: document.querySelector('#email').value,
    phone: document.querySelector('#phone').value,
    status: document.querySelector('#status').value
  }

  fetch('../../includes/Clients.php', {
      method: 'POST',
      body: JSON.stringify(obj),
      headers: {
        'Content-Type': 'application/json'
      }
    })
    .then(response => response.json())
    .then(json => {
      alert(json.message)
      clearForm()
      showData()
      location.reload(); 
    })
})

    document.querySelectorAll('.btnDelete').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const id = button.getAttribute('data-id');
        if (confirm('¿Está seguro que desea eliminar este cliente?')) {
          const obj = {
            action: 'delete',
            id: id
          };

          fetch('../../includes/Clients.php', {
            method: 'POST',
            body: JSON.stringify(obj),
            headers: {
              'Content-Type': 'application/json'
            }
          })
          .then(response => response.json())
          .then(json => {
            alert(json.message);
            if (json.status === 1) {
              button.closest('tr').remove();
            }
          });
        }
      });
    });

    document.querySelectorAll('.btnEdit').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        showForm();
        const id = button.getAttribute('data-id');
        const obj = {
          action: 'selectOne',
          id
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
            document.querySelector('#name').value = json.name;
            document.querySelector('#email').value = json.email;
            document.querySelector('#phone').value = json.phone;
            document.querySelector('#status').value = json.active;
            btnSave.textContent = 'Editar';
            btnSave.dataset.id = id;
          });
      });
    });
  </script>
</body>

</html>
