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
        <strong class="fs-6">${booking.service} - </strong>
        <small class="fw-medium">${booking.service_fee}</small><br>
        <small>${booking.date}</small> 
      </div>
      <span class="status ${booking.status}">${booking.status.replace('_', ' ')}</span>
      <div class="actions">
        ${booking.status === "in_progress" 
        ? `<button class="btn btn-sm btn-success mark-complete" data-id="${booking.booking_id}">Mark Complete</button>` 
        : ""}
        <button class="btn btn-sm btn-danger cancel-booking" data-id="${booking.booking_id}>Cancel</button>
      </div>
    `;
    currentList.appendChild(div);
  });

  // Render past transactions
  pastTable.innerHTML = "";
  pastTransactions.forEach(tx => {
    const isCompleted = tx.status === 'completed';
    let reviewButton = '';

    if (tx.rating) {
      const stars = '★'.repeat(tx.rating) + '☆'.repeat(5 - tx.rating);
      reviewButton = `<span class="text-warning">${stars}</span>`;
    } else if (isCompleted) {
      reviewButton = `<button class="btn btn-sm btn-outline-secondary leave-review-btn" 
        data-bs-toggle="modal" data-bs-target="#reviewModal" 
        data-booking-id="${tx.booking_id}">Leave Review</button>`;
    }

    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${tx.service}</td>
      <td>${tx.date}</td>
      <td><span class="status ${tx.status}">${tx.status.replace('_', ' ')}</span></td>
      <td>${tx.amount ?? '₱0.00'}</td>
      <td>${reviewButton}</td>
    `;
    pastTable.appendChild(tr);
  });


  // Handle Complete or Cancel clicks
  currentList.addEventListener("click", function (e) {
    const bookingId = e.target.dataset.id;

    if (e.target.classList.contains("mark-complete")) {
      const confirmComplete = confirm("Are you sure you want to mark this booking as complete?");
      if (confirmComplete) {
        updateBookingStatus(bookingId, "completed");
      }
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

document.addEventListener('DOMContentLoaded', () => {
  const reviewModal = document.getElementById('reviewModal');
  if (reviewModal) {
    reviewModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;
      const bookingId = button.getAttribute('data-booking-id');
      reviewModal.querySelector('#bookingId').value = bookingId;
    });
  }

  const form = document.getElementById("reviewForm");
  form.addEventListener('submit', (e) => {
    e.preventDefault();

    const data = {
      booking_id: form.booking_id.value,
      rating: form.rating.value,
      comment: form.comment.value
    };

    fetch('../utils/submit-review.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    })
    .then(response => {
      if (!response.ok) throw new Error('Review submission failed');
      return response.text();
    })
    .then(data => {
      alert('Review submitted!');
      const modalInstance = bootstrap.Modal.getInstance(reviewModal); 
      modalInstance.hide();
    })
    .catch(err => alert(err.message));
  });

});




