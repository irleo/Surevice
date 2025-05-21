document.addEventListener("DOMContentLoaded", function () {
  const currentList = document.getElementById("currentBookings");
  const pastTable = document.getElementById("pastTransactions");
  let selectedBookingId = null;
  // Render current bookings
  currentList.innerHTML = "";
  currentBookings.forEach(booking => {
    const div = document.createElement("div");
    div.classList.add("booking-item");
    div.innerHTML = `
      <div class="service-info">
        <strong>${booking.service}</strong><br/>
        <small>${booking.date}</small>
      </div>
      <span class="status ${booking.status}">${booking.status.replace('_', ' ')}</span>
      <div class="actions">
        <button class="btn btn-sm btn-success mark-complete" data-id="${booking.booking_id}">Complete</button>
        <button class="btn btn-sm btn-danger cancel-booking" data-id="${booking.booking_id}">Cancel</button>
      </div>
    `;
    currentList.appendChild(div);
  });
  // Render past transactions
  pastTable.innerHTML = "";
  pastTransactions.forEach(tx => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${tx.service}</td>
      <td>${tx.date}</td>
      <td><span class="status ${tx.status}">${tx.status.replace('_', ' ')}</span></td>
      <td>${tx.amount ?? '₱0.00'}</td>
    `;
    pastTable.appendChild(tr);
  });


  // Handle Complete or Cancel clicks
  currentList.addEventListener("click", function (e) {
    const bookingId = e.target.dataset.id;

    if (e.target.classList.contains("mark-complete")) {
      // Complete booking immediately
      updateBookingStatus(bookingId, "completed");
    }

    if (e.target.classList.contains("cancel-booking")) {
      // Open confirmation modal
      selectedBookingId = bookingId;
      const cancelModal = new bootstrap.Modal(document.getElementById("confirmCancelModal"));
      cancelModal.show();
    }
  });

  // Confirm cancel button in modal
  document.getElementById("confirmCancelBtn").addEventListener("click", function () {
    if (selectedBookingId) {
      updateBookingStatus(selectedBookingId, "cancelled");
    }
  });

  // Reusable update function
  function updateBookingStatus(bookingId, status) {
    fetch('../utils/update-booking-status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `booking_id=${bookingId}&status=${status}`
    })
    .then(res => res.text())
    .then(msg => {
      console.log(msg);
      location.reload(); // Refresh to reflect changes
    })
    .catch(err => console.error("Error:", err));
  }
});
