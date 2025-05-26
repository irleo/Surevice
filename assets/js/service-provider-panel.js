document.addEventListener('DOMContentLoaded', () => {
  // Earnings Chart Setup
  const canvas = document.getElementById('earningsChart');
  if (typeof Chart !== 'undefined' && canvas) {
    const ctx = canvas.getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'March', 'May', 'Jul', 'Sep', 'Nov'],
        datasets: [{
          label: 'Earnings (last 12 months)',
          data: [1000, 1800, 2900, 2800, 3600, 4200],
          borderColor: '#ff8210',
          backgroundColor: 'orange',
          fill: false,
          tension: 0.4,
          pointRadius: 5,
          pointBackgroundColor: '#282828',
        }]
      },
      options: {
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }

  // Handle Form Submission
  const form = document.getElementById('addServiceForm');
  const tableBody = document.querySelector('table tbody');

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    const dateTimeRaw = document.getElementById('serviceDateTime').value;
    const type = document.getElementById('serviceType').value;
    const customer = document.getElementById('customerName').value;
    const amount = document.getElementById('amount').value;
    const status = document.getElementById('status').value;

    // Format Date
    const formattedDate = new Date(dateTimeRaw).toLocaleString('en-PH', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: 'numeric',
      minute: '2-digit',
      hour12: true
    });

    // Create and append row
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${formattedDate}</td>
      <td>${type}</td>
      <td>${customer}</td>
      <td>₱${amount}</td>
      <td>${status}</td>
    `;
    tableBody.appendChild(row);

    form.reset(); // Clear form
    const modal = bootstrap.Modal.getInstance(document.getElementById('addServiceModal'));
    modal.hide(); // Close modal
  });
});

  document.addEventListener('DOMContentLoaded', () => {
      const dashboardLink = document.getElementById('dashboardLink');
      const profileLink = document.getElementById('profileLink');
      const dashboardContent = document.getElementById('dashboardContent');
      const profileContent = document.getElementById('profileContent');
      const sectionTitle = document.getElementById('sectionTitle');

      dashboardLink.addEventListener('click', (e) => {
        e.preventDefault();
        dashboardContent.style.display = 'block';
        profileContent.style.display = 'none';
        sectionTitle.textContent = 'Service Provider';
      });

      profileLink.addEventListener('click', (e) => {
        e.preventDefault();
        dashboardContent.style.display = 'none';
        profileContent.style.display = 'block';
        sectionTitle.textContent = 'My Profile';
      });
    });

    