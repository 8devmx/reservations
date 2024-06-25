<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-dark text-white" style="height: 120vh;">
  <style>
    .sidebar {
      width: 210px;
      overflow: hidden;
      transition: width 0.3s;
    }

    .sidebar.collapsed {
      width: 50px;
    }

    .sidebar .nav-link {
      padding: 10px;
      transition: background-color 0.3s, color 0.3s;
      display: flex;
      align-items: center;
      white-space: nowrap;
    }

    .sidebar .nav-link:hover {
      background-color: #495057; /* Color de fondo cuando se pasa el cursor */
      color: #fff; /* Color del texto cuando se pasa el cursor */
    }

    .sidebar .nav-link.active {
      background-color: #343a40; /* Color de fondo para el enlace activo */
      color: #fff; /* Color del texto para el enlace activo */
    }

    .sidebar .nav-link .icon {
      height: 59px;
      margin-right: 25px !important;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .sidebar.collapsed .nav-link p {
      display: none;
    }

    .sidebar .nav-link p {
      margin: 0;
      line-height: 59px;
      transition: opacity 0.3s;
    }

    .sidebar.collapsed .nav-link .icon {
      margin-right: 0;
    }
  </style>
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="#" class="nav-link text-white d-flex active">
        <div class="icon me-2"><i class="bi bi-speedometer2"></i></div>
        <p>Dashboard</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/modelos-de-bd-primer-parcial/modules/users/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-people"></i></div>
        <p>Usuarios</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/modelos-de-bd-primer-parcial/modules/clients/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-person"></i></div>
        <p>Clientes</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/modelos-de-bd-primer-parcial/modules/roles/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-person-badge"></i></div>
        <p>Roles</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/modelos-de-bd-primer-parcial/modules/events/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-calendar-event"></i></div>
        <p>Reservaciones</p>
      </a>
    </li>
  </ul>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.querySelector('.sidebar');

    sidebar.addEventListener('mouseenter', function() {
      sidebar.classList.remove('collapsed');
    });

    sidebar.addEventListener('mouseleave', function() {
      sidebar.classList.add('collapsed');
    });
  });
</script>





