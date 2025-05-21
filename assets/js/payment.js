document.addEventListener('DOMContentLoaded', () => {
  const selectedMethod = localStorage.getItem('selectedPaymentMethod');
  const selectedMethodDisplay = document.getElementById('selectedMethodDisplay');
  const payBtn = document.querySelector('.pay-btn');
  const completeBtn = document.getElementById('completeBtn');
  const statusBox = document.getElementById('paymentStatusBox');
  const statusText = document.getElementById('paymentStatusText');

  const methodLabels = {
    card: `<strong>Credit/Debit Card</strong><br><small>Visa, Mastercard, JCB</small>`,
    paypal: `<strong>PayPal</strong><br><small>Pay securely via PayPal</small>`,
    gcash: `<strong>GCash</strong><br><small>Pay with your GCash wallet</small>`,
    bank: `<strong>Bank Transfer</strong><br><small>Direct bank transfer</small>`
  };

  const platformFees = {
    card: 50,
    paypal: 70,
    gcash: 40,
    bank: 30
  };

  const serviceFee = 1000;

  if (selectedMethod && methodLabels[selectedMethod]) {
    selectedMethodDisplay.innerHTML = methodLabels[selectedMethod];

    const platformFee = platformFees[selectedMethod] || 50;
    const totalAmount = serviceFee + platformFee;

    document.getElementById('feeAmount').innerText = `₱${platformFee}`;
    document.getElementById('platformFee').innerText = `₱${platformFee}`;
    document.getElementById('totalAmount').innerText = `₱${totalAmount}`;
    document.getElementById('serviceFee').innerText = `₱${serviceFee}`;

    payBtn.innerText = `Pay Now – ₱${totalAmount}`;
    payBtn.addEventListener('click', () => showModal('pay'));
    completeBtn.addEventListener('click', () => showModal('complete'));
  } else {
    selectedMethodDisplay.innerHTML = `<strong>No method selected</strong>`;
    payBtn.disabled = true;
    completeBtn.disabled = true;
  }

  // Modal logic
  let currentAction = null;

  function showModal(action = 'pay') {
    currentAction = action;
    document.getElementById('modalMessage').innerText = action === 'pay'
      ? 'Are you sure you want to pay now?'
      : 'Mark the service as complete?';
    document.getElementById('confirmationModal').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('confirmationModal').style.display = 'none';
    currentAction = null;
  }

  function confirmAction() {
    if (!currentAction) return;

    statusBox.style.display = 'flex';

    if (currentAction === 'pay') {
      statusBox.classList.remove('success');
      statusBox.classList.add('warning');
      statusText.innerText = 'Payment held securely in Escrow.';
      completeBtn.disabled = false;
    } else if (currentAction === 'complete') {
      statusBox.classList.remove('warning');
      statusBox.classList.add('success');
      statusText.innerText = 'Service marked as complete. Funds released to Service Provider.';
    }

    closeModal();
  }

  // Hook up modal buttons
  document.getElementById("confirmBtn").addEventListener("click", confirmAction);
  document.getElementById("cancelBtn").addEventListener("click", closeModal);
});

function goBack() {
  window.location.href = 'select-method.html';
}
