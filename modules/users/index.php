<!doctype html>
<html lang="en">

<head>
  <?php
  include_once '../../includes/head.php';
  require_once '../../includes/Users.php';
  $user = new User();
  ?>
</head>

<body>
  <?php include_once '../../includes/header.php'; ?>
  <div class="container-fluid">
    <div class="row">
      <?php include_once '../../includes/sidebar.php'; ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Users</h1>
        </div>
        <div class="table-responsive small">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Rol</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = $user->getAllData();
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
                  <td><?php echo $row->email; ?></td>
                  <td><?php echo $row->phone; ?></td>
                  <td><?php echo $row->rol; ?></td>
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