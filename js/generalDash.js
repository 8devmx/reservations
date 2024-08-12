
const UserSidebar = JSON.parse(sessionStorage.getItem("users"));
if (UserSidebar) {
  document.querySelector('#NameLogin').innerText = UserSidebar.name;
} else {
  location.href = "/reservations/modules/login.php";
}

document.querySelector('#Logout').addEventListener('click', (e) => {
  e.preventDefault();
  const confirmation = confirm("¿Deseas cerrar sesión?");
  if (confirmation) {
    sessionStorage.removeItem("users");
    location.href = "/reservations/modules/login.php";
  }
});

