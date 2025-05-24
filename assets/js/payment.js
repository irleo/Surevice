<<<<<<< HEAD
 document.addEventListener('DOMContentLoaded', () => {
      const methodPage = document.getElementById('methodPage');
      const checkoutPage = document.getElementById('checkoutPage');
      const selectedMethodDisplay = document.getElementById('selectedMethodDisplay');
      const payBtn = document.getElementById('payBtn');
      const completeBtn = document.getElementById('completeBtn');
      const statusBox = document.getElementById('paymentStatusBox');
      const statusText = document.getElementById('paymentStatusText');

      const feeAmountElem = document.getElementById('feeAmount');
      const platformFeeElem = document.getElementById('platformFee');
      const totalAmountElem = document.getElementById('totalAmount');
      const serviceFeeElem = document.getElementById('serviceFee');

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

      function formatCurrency(amount) {
        return `₱${amount.toLocaleString()}`;
      }

      function showCheckoutPage(method) {
        methodPage.classList.add('hidden');
        checkoutPage.classList.remove('hidden');

        const platformFee = platformFees[method] ?? 50;
        const totalAmount = serviceFee + platformFee;

        // Set breakdown values
        selectedMethodDisplay.innerHTML = methodLabels[method];
        if (feeAmountElem) feeAmountElem.innerText = formatCurrency(serviceFee);
        if (platformFeeElem) platformFeeElem.innerText = formatCurrency(platformFee);
        if (totalAmountElem) totalAmountElem.innerText = formatCurrency(totalAmount);
        if (serviceFeeElem) serviceFeeElem.innerText = formatCurrency(serviceFee);

        payBtn.innerText = `Pay Now – ${formatCurrency(totalAmount)}`;
        payBtn.disabled = false;
        completeBtn.disabled = true;

        payBtn.onclick = () => showModal('pay');
        completeBtn.onclick = () => showModal('complete');
      }

      // Handle method selection
      document.querySelectorAll('.method').forEach(btn => {
        btn.addEventListener('click', () => {
          const method = btn.dataset.method;
          localStorage.setItem('selectedPaymentMethod', method);
          showCheckoutPage(method);
        });
      });

      // Load stored method if exists
      const storedMethod = localStorage.getItem('selectedPaymentMethod');
      if (storedMethod && methodLabels[storedMethod]) {
        showCheckoutPage(storedMethod);
      }

      // Modal logic
      let currentAction = null;

      function showModal(action) {
        currentAction = action;
        const modal = document.getElementById('confirmationModal');
        const message = document.getElementById('modalMessage');

        message.textContent = action === 'pay'
          ? 'Are you sure you want to proceed with payment?'
          : 'Are you sure you want to mark this as complete?';

        modal.classList.remove('hidden');
      }

      function closeModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
        currentAction = null;
      }

      function confirmAction() {
        if (!currentAction) return;

        statusBox.classList.remove('hidden');
        statusBox.style.display = 'block'; // fallback

        if (currentAction === 'pay') {
          statusBox.classList.remove('success');
          statusBox.classList.add('warning');
          statusText.textContent = 'Payment held securely in Escrow.';
          completeBtn.disabled = false;
        } else if (currentAction === 'complete') {
          statusBox.classList.remove('warning');
          statusBox.classList.add('success');
          statusText.textContent = 'Service marked as complete. Funds released to Service Provider.';
        }

        closeModal();
      }

      document.getElementById('confirmBtn').addEventListener('click', confirmAction);
      document.getElementById('cancelBtn').addEventListener('click', closeModal);
    });

    // Go back to payment method selection
    function goBack() {
      document.getElementById('checkoutPage').classList.add('hidden');
      document.getElementById('methodPage').classList.remove('hidden');

    }
=======

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
>>>>>>> 153431a06cee846cdda8c8ba39a9d30a86f3c3d7
