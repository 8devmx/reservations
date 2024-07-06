const viewData = document.querySelector('#viewData')
const viewForm = document.querySelector('#viewForm')
const btnNew = document.querySelector('#btnNew')
const btnSave = document.querySelector('#btnSave')
const name = document.querySelector('#name')
const status = document.querySelector('#status')
const btnDelete = document.querySelectorAll('.btnDelete')

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

document.querySelectorAll('.btnDelete').forEach(button => {
  button.addEventListener('click', (e) => {
    e.preventDefault();
    const id = button.getAttribute('data-id');
    if (confirm('¿Está seguro que desea eliminar este cliente?')) {
      const obj = {
        action: 'delete',
        id: id
      };

      fetch('../../includes/Roles.php', {
        method: 'POST',
        body: JSON.stringify(obj),
        headers: {
          'Content-Type': 'application/json'
        }
      })
      .then(response => response.json())
      .then(json => {
        alert(json.message);
        if (json.status === 1) {
          button.closest('tr').remove();
        }
      });
    }
  });
});