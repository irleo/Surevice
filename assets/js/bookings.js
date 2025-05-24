document.addEventListener("DOMContentLoaded", function () {
<<<<<<< HEAD
  const currentList = document.getElementById("currentBookings");
  const pastTable = document.getElementById("pastTransactions");
  const pageIndicator = document.getElementById("pageIndicator");
  const prevBtn = document.getElementById("prevPage");
  const nextBtn = document.getElementById("nextPage");
  const editAddressBtn = document.getElementById("editAddressBtn");

  const ITEMS_PER_PAGE = 5;
  let currentPage = 1;
  let selectedBookingId = null;

  const currentBookings = [
    { booking_id: 1, service: "Aircon Cleaning", date: "2025-05-20", status: "pending" },
    { booking_id: 2, service: "Electrical Repair", date: "2025-05-21", status: "pending" },
    // more bookings ...
  ];

  const pastTransactions = [
    { service: "Aircon Cleaning", date: "2025-04-20", status: "completed", amount: "₱1500.00" },
    { service: "Electrical Repair", date: "2025-04-15", status: "cancelled", amount: "₱0.00" },
  ];

  function renderCurrentBookings() {
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
  }

  function renderPastTransactions() {
    pastTable.innerHTML = "";

    const start = (currentPage - 1) * ITEMS_PER_PAGE;
    const end = start + ITEMS_PER_PAGE;
    const currentItems = pastTransactions.slice(start, end);

    currentItems.forEach(tx => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${tx.service}</td>
        <td>${tx.date}</td>
        <td><span class="status ${tx.status}">${tx.status.replace('_', ' ')}</span></td>
        <td>${tx.amount ?? '₱0.00'}</td>
      `;
      pastTable.appendChild(tr);
    });

    pageIndicator.textContent = `Page ${currentPage}`;
    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = end >= pastTransactions.length;
  }

  function updateBookingStatus(bookingId, status) {
    fetch('../utils/update-booking-status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `booking_id=${bookingId}&status=${status}`
    })
      .then(res => res.text())
      .then(msg => {
        console.log(msg);
        location.reload(); 
      })
      .catch(err => console.error("Error:", err));
  }

  currentList.addEventListener("click", function (e) {
    const bookingId = e.target.dataset.id;

    if (e.target.classList.contains("mark-complete")) {
      updateBookingStatus(bookingId, "completed");
    }

    if (e.target.classList.contains("cancel-booking")) {
      selectedBookingId = bookingId;
      if (confirm("Are you sure you want to cancel this booking?")) {
        updateBookingStatus(selectedBookingId, "cancelled");
      }
    }
  });

  // Pagination Controls
  prevBtn.addEventListener("click", () => {
    if (currentPage > 1) {
      currentPage--;
      renderPastTransactions();
    }
  });

  nextBtn.addEventListener("click", () => {
    if ((currentPage * ITEMS_PER_PAGE) < pastTransactions.length) {
      currentPage++;
      renderPastTransactions();
    }
  });

  // Edit Address
  editAddressBtn.addEventListener("click", () => {
    const addressP = document.getElementById("savedAddress");
    const newAddress = prompt("Edit your address:", addressP.textContent);
    if (newAddress) {
      addressP.textContent = newAddress;
    }
  });

  // Initial rendering
  renderCurrentBookings();
  renderPastTransactions();
});
=======
  // Simulated real-time data fetch
  const currentBookings = [
    {
      service: "Deep Cleaning",
      date: "May 22, 2025 - 10:00 AM",
      status: "pending"
    },
    {
      service: "Window Washing",
      date: "May 23, 2025 - 2:00 PM",
      status: "in_progress"
    }
  ];

  const pastTransactions = [
    {
      service: "Carpet Cleaning",
      date: "May 15, 2025",
      status: "completed",
      amount: "₱800"
    },
    {
      service: "Bathroom Sanitization",
      date: "May 10, 2025",
      status: "cancelled",
      amount: "₱500"
    }
  ];

  const paymentDetails = {
    price: 1000,
    fee: 50,
    pending: 950,
    status: "Awaiting customer confirmation",
    wallet: 1500,
    isReleased: false
  };

  const currentList = document.getElementById("currentBookings");
  currentList.innerHTML = "";
  currentBookings.forEach(booking => {
    const div = document.createElement("div");
    div.innerHTML = `
      <div>
        <strong>${booking.service}</strong><br/>
        <small>${booking.date}</small>
      </div>
      <span class="status ${booking.status}">${booking.status.replace('_', ' ')}</span>
    `;
    currentList.appendChild(div);
  });

  const pastTable = document.getElementById("pastTransactions");
  pastTable.innerHTML = "";
  pastTransactions.forEach(tx => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${tx.service}</td>
      <td>${tx.date}</td>
      <td><span class="status ${tx.status}">${tx.status.replace('_', ' ')}</span></td>
      <td>${tx.amount}</td>
    `;
    pastTable.appendChild(tr);
  });

});



>>>>>>> 153431a06cee846cdda8c8ba39a9d30a86f3c3d7
