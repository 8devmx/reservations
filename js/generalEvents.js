const viewData = document.querySelector('#viewData')
const viewForm = document.querySelector('#viewForm')
const btnNew = document.querySelector('#btnNew')
const btnSave = document.querySelector('#btnSave')
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

btnClose.addEventListener('click', (e) => {
  e.preventDefault()
  clearForm()
  showData()
})

