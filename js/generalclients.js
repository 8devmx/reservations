const viewData = document.querySelector('#viewData');
const viewForm = document.querySelector('#viewForm');
const btnNew = document.querySelector('#btnNew');
const btnSave = document.querySelector('#btnSave');
const name = document.querySelector('#name');
const email = document.querySelector('#email');
const phone = document.querySelector('#phone');
const status = document.querySelector('#status');

viewForm.classList.add('d-none');

const showData = () => {
  viewData.classList.remove('d-none');
  viewData.classList.add('animate__zoomIn');
  viewForm.classList.add('d-none');
}

const showForm = () => {
  viewForm.classList.remove('d-none');
  viewForm.classList.add('animate__zoomIn');
  viewData.classList.add('d-none');
}

btnNew.addEventListener('click', (e) => {
  e.preventDefault();
  clearForm();
  showForm();
});

btnClose.addEventListener('click', (e) => {
  e.preventDefault();
  clearForm();
  showData();
});
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
