window.onload = () => {
  const product = getQueryParam('product');
  const fee = getQueryParam('fee');
  const serviceId = getQueryParam('service_id');

  if (product) document.getElementById('productName').value = decodeURIComponent(product);
  if (fee) document.getElementById('service_fee').value = fee;
  if (serviceId) document.getElementById('serviceId').value = serviceId;  
};


function getQueryParam(name) {
const urlParams = new URLSearchParams(window.location.search);
return urlParams.get(name);
}

document.addEventListener('DOMContentLoaded', () => {
  const datetimeInput = document.getElementById('scheduledFor');

  function setMinDateTime() {
    const now = new Date();
    now.setSeconds(0, 0); // Remove seconds/milliseconds
    const offset = -now.getTimezoneOffset();
    const diffHours = Math.floor(offset / 60);
    const diffMinutes = offset % 60;

    // Adjust for timezone offset
    now.setHours(now.getHours() + diffHours);
    now.setMinutes(now.getMinutes() + diffMinutes);

    const localISOTime = now.toISOString().slice(0, 16);
    datetimeInput.min = localISOTime;

    // Optional: clear out past value
    if (datetimeInput.value && datetimeInput.value < localISOTime) {
      datetimeInput.value = '';
    }
  }

  setMinDateTime();
  datetimeInput.addEventListener('focus', setMinDateTime);
});

function clearCart() {
  document.getElementById('billingForm').reset();
}


function toggleAddressInput(value) {
  const addressTextarea = document.getElementById('address');
  const savedAddress = addressTextarea.defaultValue.trim();

  if (value === 'saved') {
    if (savedAddress !== '') {
      addressTextarea.value = savedAddress;
      addressTextarea.placeholder = '';  // Clear placeholder if address exists
    } else {
      addressTextarea.value = '';
      addressTextarea.placeholder = 'No saved address available';  // Set placeholder if no saved address
    }
    addressTextarea.readOnly = true;
  } else {
    addressTextarea.readOnly = false;
    addressTextarea.value = '';
    addressTextarea.placeholder = 'Enter your address here';  // Placeholder for manual input
  }
}
