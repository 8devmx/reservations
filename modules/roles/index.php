<!doctype html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../../css/styles.css">
  <?php
  include_once '../../includes/head.php';
  require_once '../../includes/Roles.php';
  $roles = new Roles();
  ?>
</head>

<body>
  <?php include_once '../../includes/header.php'; ?>
  <div class="container-fluid">
    <div class="row">
      <?php include_once '../../includes/sidebar.php'; ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 animate__animated animate__faster" id="viewData">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Roles</h1>
          <button class="btn btn-warning" id="btnNew">+ Nuevo</button>
        </div>
        <div class="table-responsive small">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = $roles->getAllData();
              if ($result->num_rows == 0) {
              ?>
                <tr class="text-center">
                  <td colspan="7">No se encontraron resultados</td>
                </tr>
              <?php
                return false;
              }

              while ($row = $result->fetch_object()) {
              ?>
                <tr>
                  <td><?php echo $row->id; ?></td>
                  <td><?php echo $row->name; ?></td>
                  <td><?php echo $row->active == 1 ? "Activo" : "Inactivo"; ?></td>
                  <td>
                    <button type="button" class="btn btn-warning btnEdit" data-id="<?php echo $row->id; ?>">Editar</button>
                    <button type="button" class="btn btn-danger btnDelete" data-id="<?php echo $row->id; ?>">Eliminar</button>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </main>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 animate__animated animate__faster" id="viewForm">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Roles</h1>
          <button class="btn btn-dark" id="btnClose">Cerrar</button>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa el nombre">
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
  <script>
    const clearForm = () => {
      name.value = ''
      status.value = 0
    }
    btnSave.addEventListener('click', (e) => {
      e.preventDefault()

      const obj = {
        action: 'insert',
        name: name.value,
        status: status.value
      }

      if (btnSave.hasAttribute('data-id')) {
        obj.action = 'update'
        obj.id = btnSave.getAttribute('data-id')
      }

      fetch('../../includes/Roles.php', {
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
        })
        .catch(error => console.error('Error:', error));
    })
    document.querySelectorAll('.btnDelete').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const id = button.getAttribute('data-id');
        if (confirm('¿Estás seguro que deseas eliminar este cliente?')) {
          const obj = {
            action: 'Delete',
            id: id
          };
        }
      });
    });
    document.querySelectorAll('.btnEdit').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault()
        showForm()
        const id = button.getAttribute('data-id')
        const obj = {
          action: 'selectOne',
          id
        }
        fetch('../../includes/Roles.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(obj)
          })
          .then(response => response.json())
          .then(json => {
            name.value = json.name  
            status.value = json.active
            btnSave.textContent = 'Editar'
            btnSave.dataset.id = id
          })
      })
    })
  </script>
</body>

</html>