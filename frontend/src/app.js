import { createUser } from '../src/scripts/api/create.js';
import { renderUsers, findUserById } from '../src/scripts/dom/render.js';
import { updateUser, patchUser } from '../src/scripts/api/update.js';
import {deleteUser} from '../src/scripts/api/delete.js';

const apiUrl = 'http://localhost:8000/api/users';

const form = document.getElementById('create-user-form');
const formError = document.getElementById('form-error');

const usersSection = document.getElementById('users');

const formTitle = document.getElementById('form-title');
const submitBtn = form.querySelector('button[type="submit"]');
const cancelBtn = document.getElementById('cancel-edit');

let editingId = null;
let originalUser =null;

document.addEventListener('DOMContentLoaded', () => renderUsers(apiUrl));

form.addEventListener('submit', async (event) => {
  event.preventDefault();

  const name = document.getElementById('name').value;
  const age = document.getElementById('age').value;
  const email = document.getElementById('email').value;

  hideError();

  try {
  if (editingId !== null){
    //modo edição
    const changed = {};
    if (name !== originalUser.name ) changed.name = name;
    if (Number(age) !== originalUser.age) changed.age = age;
    if (email !== originalUser.email) changed.email = email;

    if (Object.keys(changed).length === 0){
      exitEditMode()
      return;
    }
    const allChanged = Object.keys(changed).length === 3;

    if(allChanged) {
      await updateUser(apiUrl , editingId, {name, age, email});
    } else {
      await patchUser(apiUrl, editingId, changed);
    }
  }else {
    //modo criaçap
    await createUser(apiUrl, {name,age,email});
  }
  exitEditMode();
  renderUsers(apiUrl);
}catch (error) {
  showError(error.message);
}
});

function showError(message) {
  formError.textContent = message;
  formError.classList.remove('d-none');
}

function hideError() {
  formError.classList.add('d-none');
  formError.textContent = '';
}

function getUserFromCard(button){
  const card = button.closest('.user-card');
  return findUserById(Number(card.dataset.id));
}

function enterEditMode(user){
  editingId = user.id;
  originalUser = {...user};

  document.getElementById('name').value = user.name;
  document.getElementById('age').value = user.age;
  document.getElementById('email').value = user.email;

  formTitle.textContent = 'edit User';
  submitBtn.textContent = 'update';
  cancelBtn.style.display = '';

  document.getElementById('name').focus()
}

function exitEditMode() {
  editingId = null;
  originalUser = null;
  formTitle.textContent = 'Create User';
  submitBtn.textContent = 'create'
  cancelBtn.style.display = 'none';
  form.reset();
}

cancelBtn.addEventListener('click', exitEditMode);

usersSection.addEventListener('click', async (event) => {
  const {target} = event;

  const user = getUserFromCard(target);

  if (target.dataset.action === 'edit'){
    enterEditMode(getUserFromCard(target));
  }

  if (target.dataset.action === 'delete')
  {
    try {
      await deleteUser(apiUrl, user.id);

      if(editingId === user.id) exitEditMode();

      renderUsers(apiUrl);
    }catch(error) {
      showError(error.message);
    }
  }
});

