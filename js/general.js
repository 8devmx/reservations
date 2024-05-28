const viewData = document.querySelector('#viewData')
const viewForm = document.querySelector('#viewForm')
const btnNew = document.querySelector('#btnNew')
const btnSave = document.querySelector('#btnSave')
const btnClose = document.querySelector('#btnClose')
const name = document.querySelector('#name')
const email = document.querySelector('#email')
const phone = document.querySelector('#phone')
const rol = document.querySelector('#rol')
const status = document.querySelector('#status')


viewForm.classList.add('d-none')

const showData = () => {
  viewData.classList.remove('d-none')
  viewData.classList.add('animate__zoomIn')
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

