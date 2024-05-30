const viewData = document.querySelector('#viewData');
const viewForm = document.querySelector('#viewForm');
const btnNew = document.querySelector('#btnNew');
const btnSave = document.querySelector('#btnSave');
const btnClose = document.querySelector('#btnClose');
const name = document.querySelector('#name');
const email = document.querySelector('#email');
const phone = document.querySelector('#phone');
const status = document.querySelector('#status');

const clearForm = () => {
  name.value = '';
  email.value = '';
  phone.value = '';
  status.value = 0;
}

const showData = () => {
  viewForm.classList.add('zoom-out');
  viewForm.addEventListener('animationend', () => {
    viewForm.classList.add('d-none');
    viewForm.classList.remove('zoom-out');
    viewData.classList.remove('d-none');
    viewData.classList.add('zoom-in');
  }, { once: true });
}

const showForm = () => {
  viewData.classList.add('zoom-out');
  viewData.addEventListener('animationend', () => {
    viewData.classList.add('d-none');
    viewData.classList.remove('zoom-out');
    viewForm.classList.remove('d-none');
    viewForm.classList.add('zoom-in');
  }, { once: true });
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

btnSave.addEventListener('click', (e) => {
  e.preventDefault();

  const obj = {
    action: 'insert',
    name: name.value,
    email: email.value,
    phone: phone.value,
    status: status.value
  }

  fetch('../../includes/Clients.php', {
    method: 'POST',
    body: JSON.stringify(obj),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(json => {
    alert(json.message);
    clearForm();
    showData();
  })
});


document.querySelectorAll('.btnDelete').forEach(button => {
  button.addEventListener('click', (e) => {
    e.preventDefault();
    const id = button.getAttribute('data-id');
    if (confirm('¿Está seguro que desea eliminar este cliente?')) {
      const obj = {
        action: 'delete',
        id: id
      };

      fetch('../../includes/Clients.php', {
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

