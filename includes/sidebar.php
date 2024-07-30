<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-dark text-white" style="height: 120vh;">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/dashboard/index.php" class="nav-link text-white d-flex active">
        <div class="icon me-2"><i class="bi bi-speedometer2"></i></div>
        <p>Dashboard</p>
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

<!-- Script JavaScript -->
<script>
    // Obtener el elemento del sidebar
    const sidebar = document.querySelector('.sidebar');

    // Agregar evento al mover el mouse dentro del sidebar
    sidebar.addEventListener('mouseenter', function() {
      this.classList.remove('collapsed'); // Quitar clase 'collapsed'
    });

    // Agregar evento al mover el mouse fuera del sidebar
    sidebar.addEventListener('mouseleave', function() {
      this.classList.add('collapsed'); // Agregar clase 'collapsed'
    });
  </script>
  