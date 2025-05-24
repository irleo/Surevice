// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
  // Add click event listener to all buttons with class "method"
  document.querySelectorAll('.method').forEach(btn => {
    btn.addEventListener('click', () => {
      const method = btn.dataset.method; // Get method type from data-method attribute
      localStorage.setItem('selectedPaymentMethod', method); // Save to localStorage
      window.location.href = 'payment.html'; // Redirect to payment page
    });
  });
});
