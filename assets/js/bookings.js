
document.addEventListener("DOMContentLoaded", function () {
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





