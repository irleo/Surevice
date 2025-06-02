// Clear fields
function clearFields() {
  const fields = document.querySelectorAll('#register input');
  fields.forEach(input => {
    if (input.type === 'radio' || input.type === 'checkbox') {
      input.checked = false;
    } else {
      input.value = '';
    }
  });
  document.getElementById('password-warning').textContent = '';
}

// Password confirmation live warning
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirm_password');
const warning = document.getElementById('password-warning');

confirmPassword.addEventListener('input', () => {
  warning.textContent = confirmPassword.value && confirmPassword.value !== password.value
    ? 'Passwords do not match'
    : '';
});

// Final check before form submission
function checkPasswords() {
  const firstName = document.querySelector('input[name="firstName"]');
  const lastName = document.querySelector('input[name="lastName"]');
  const phone = document.querySelector('input[name="phone"]');
  const gender = document.querySelector('input[name="gender"]:checked');
  const email = document.querySelector('input[name="email"]');
  const dob = document.querySelector('input[name="dob"]');
  const userType = document.querySelector('input[name="userType"]:checked');

  if (
    !firstName.value.trim() ||
    !lastName.value.trim() ||
    !phone.value.trim() ||
    !gender ||
    !email.value.trim() ||
    !dob.value.trim() ||
    !password.value ||
    !confirmPassword.value ||
    !userType
    
  ) {
    alert("Please complete all required fields.");
    return false;
  }

  if (!/^\d{10}$/.test(phone.value)) {
    alert("Phone number must be exactly 10 digits.");
    return false;
  }

  if (password.value !== confirmPassword.value) {
    alert("Passwords do not match.");
    return false;
  }

  return true;
}

// Step navigation (just show/hide steps — no disabling inputs)
function nextStep() {
  document.getElementById('step-1').classList.remove('active');
  document.getElementById('step-2').classList.add('active');
}

function prevStep() {
  document.getElementById('step-2').classList.remove('active');
  document.getElementById('step-1').classList.add('active');
}

// Initial setup
window.addEventListener('DOMContentLoaded', function () {
  const params = new URLSearchParams(window.location.search);
  const step = params.get('step') === '2' ? 'step-2' : 'step-1';

  document.getElementById('step-1').classList.remove('active');
  document.getElementById('step-2').classList.remove('active');
  document.getElementById(step).classList.add('active');

  const error = params.get('error');
  if (error) {
    alert(decodeURIComponent(error));
  }

  const dobInput = document.getElementById('dob');
  if (dobInput) {
    const today = new Date();
    const year = today.getFullYear() - 18;
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    dobInput.max = `${year}-${month}-${day}`;
  }
});
