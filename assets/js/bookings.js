document.addEventListener("DOMContentLoaded", function () {
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



