const viewData = document.querySelector('#viewData')
const viewForm = document.querySelector('#viewForm')
const btnNew = document.querySelector('#btnNew')
const btnSave = document.querySelector('#btnSave')
const name = document.querySelector('#name')
const status = document.querySelector('#status')

const showData = () => {
  viewData.classList.remove('d-none')
  viewForm.classList.add('d-none')
}

const showForm = () => {
  viewForm.classList.remove('d-none')
  viewData.classList.add('d-none')
}

btnNew.addEventListener('click', (e) => {
  e.preventDefault()
  clearForm()
  showForm()
})

