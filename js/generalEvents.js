const viewData = document.querySelector('#viewData')
const viewForm = document.querySelector('#viewForm')
const btnNew = document.querySelector('#btnNew')
const btnSave = document.querySelector('#btnSave')
const btnClose = document.querySelector('#btnClose')
const title = document.querySelector('#title')
const status = document.querySelector('#status')
const description = document.querySelector('#description')
const start_date = document.querySelector('#start_date')
const start_hout = document.querySelector('#start_hout')
const end_date = document.querySelector('#end_date')
const end_hour = document.querySelector('#end_hour')
const client_id = document.querySelector('#client_id')
const user_id = document.querySelector('#user_id')
const map = document.querySelector('#map')

viewForm.classList.add('d-none')

const showData = () => {
  viewData.classList.remove('d-none')
  viewForm.classList.add('animate__zoomIn')
  viewForm.classList.add('d-none')
}

const showForm = () => {
  viewForm.classList.remove('d-none')
  viewForm.classList.add('animate__zoomIn')
  viewData.classList.add('d-none')
}

btnNew.addEventListener('click', (e) => {
  e.preventDefault()
  clearForm()
  showForm()
})

btnClose.addEventListener('click', (e) => {
  e.preventDefault()
  clearForm()
  showData()
})
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