<<<<<<< Updated upstream
<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-dark text-white" style="height: 120vh;">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/dashboard/index.php" class="nav-link text-white d-flex active">
        <div class="icon me-2"><i class="bi bi-speedometer2"></i></div>
        <p>Dashboard</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/VistaSemanal/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-person"></i></div>
        <p>VistaSemanal</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/users/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-person"></i></div>
        <p>Usuarios</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/clients/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-people"></i></div>
        <p>Clientes</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/roles/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-key"></i></div>
        <p>Roles</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/events/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-calendar-event"></i></div>
        <p>Reservaciones</p>
      </a>
    </li>
  </ul>
  <p><strong id="NameLogin"></strong><a href="#" id="Logout">Cerrar sesión</a></p>
</div>
=======
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar Empresarial</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
>>>>>>> Stashed changes

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Estilos personalizados -->
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f4f5f7;
    }
    .sidebar {
      width: 250px;
      height: 100vh;
      background-color: #2c3e50;
      color: white;
      padding: 20px;
      transition: all 0.3s ease;
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    .sidebar .sidebar-header {
      font-size: 1.5em;
      margin-bottom: 30px;
      font-weight: bold;
      color: #ecf0f1;
      text-align: center;
      letter-spacing: 1px;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      margin: 10px 0;
      display: flex;
      align-items: center;
      padding: 12px 15px;
      border-radius: 4px;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .sidebar a .icon {
      margin-right: 10px;
    }
    .sidebar a:hover {
      background-color: #34495e;
      transform: translateX(5px);
    }
    .sidebar .nav-item.active a {
      background-color: #1abc9c;
      color: white;
      transform: translateX(5px);
    }
    .sidebar p {
      font-size: 0.9em;
      margin: 0;
      padding: 0;
    }
    .sidebar-footer {
      position: absolute;
      bottom: 20px;
      left: 20px;
      width: 90%;
    }
    .sidebar-footer strong {
      display: block;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="sidebar-header">
      Panel de Control
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="http://localhost/reservations/modules/dashboard/index.php" class="nav-link">
          <div class="icon"><i class="bi bi-speedometer2"></i></div>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="http://localhost/reservations/modules/VistaSemanal/index.php" class="nav-link">
          <div class="icon"><i class="bi bi-calendar-week"></i></div>
          <p>Vista Semanal</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="http://localhost/reservations/modules/users/index.php" class="nav-link">
          <div class="icon"><i class="bi bi-person"></i></div>
          <p>Usuarios</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="http://localhost/reservations/modules/clients/index.php" class="nav-link">
          <div class="icon"><i class="bi bi-people"></i></div>
          <p>Clientes</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="http://localhost/reservations/modules/roles/index.php" class="nav-link">
          <div class="icon"><i class="bi bi-key"></i></div>
          <p>Roles</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="http://localhost/reservations/modules/events/index.php" class="nav-link">
          <div class="icon"><i class="bi bi-calendar-event"></i></div>
          <p>Reservaciones</p>
        </a>
      </li>
    </ul>
    <div class="nav-itemr">
      <strong id="NameLogin"> </strong>
      <a  id="Logout" class="text-white">Cerrar sesión</a>
    </div>
  </div>

  <!-- Script JavaScript -->
  <script>
    // Obtener el pathname actual
    const currentPath = window.location.pathname;

    // Seleccionar todos los enlaces del sidebar
    const menuItems = document.querySelectorAll('.nav-link');

    // Loop para comparar la ruta actual con los hrefs de los enlaces
    menuItems.forEach(item => {
      if (item.getAttribute('href') === currentPath) {
        item.parentElement.classList.add('active');
      } else {
        item.parentElement.classList.remove('active');
      }
    });
  </script>
</body>
</html>
