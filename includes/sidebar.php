<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-dark text-white" style="height: 120vh;">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="#" class="nav-link text-white d-flex active">
        <div class="icon me-2"><i class="bi bi-speedometer2" style="height: 38px;" ></i></div>
        <p>Dashboard</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/users/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-person" style="height: 38px;" ></i></div>
        <p>Usuarios</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/clients/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-people" style="height: 38px;" ></i></div>
        <p>Clientes</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/roles/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-key" style="height: 38px;" ></i></div>
        <p>Roles</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="http://localhost/reservations/modules/events/index.php" class="nav-link text-white d-flex">
        <div class="icon me-2"><i class="bi bi-calendar-event" style="height: 38px;" ></i></div>
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










