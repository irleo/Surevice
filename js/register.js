function clearFields() {
  const fields = document.querySelectorAll('#register input');
  fields.forEach(input => {
    if (input.type === 'radio' || input.type === 'checkbox') {
      input.checked = false;
    } else {
      input.value = '';
      warning.textContent = '';
    }
  });
}

  const password = document.getElementById('password');
  const confirmPassword = document.getElementById('confirm_password');
  const warning = document.getElementById('password-warning');

  confirmPassword.addEventListener('input', () => {
    if (confirmPassword.value === '') {
      warning.textContent = '';
    } else if (confirmPassword.value !== password.value) {
      warning.textContent = 'Passwords do not match';
    } else {
      warning.textContent = '';
    }

  });


  function checkPasswords() {
    if (password.value !== confirmPassword.value) {
      alert("Passwords do not match.");
      return false;
    }
    alert("Registered");
    return true;
  }

  window.addEventListener('DOMContentLoaded', function () {
    const dobInput = document.getElementById('dob');
    const today = new Date();
    const year = today.getFullYear() - 18;
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const maxDate = `${year}-${month}-${day}`;

    dobInput.max = maxDate;
  });
