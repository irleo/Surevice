document.addEventListener('DOMContentLoaded', () => {
  // Earnings Chart Setup
  const canvas = document.getElementById('earningsChart');
  if (typeof Chart !== 'undefined' && canvas && typeof earningsChartData !== 'undefined') {
    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: earningsChartData.labels,
        datasets: [{
          label: 'Earnings (Last 12 Months)',
          data: earningsChartData.data,
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

// Booking Stats Chart Setup
const ctx = document.getElementById('statsChart').getContext('2d');
  const statsChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Category Popularity',
        data: data,
        backgroundColor: 'rgba(75, 192, 192, 0.6)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        borderRadius: 5
      }]
    },
    options: {
      responsive: true,
    
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 5
          }
        }
      },
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });


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
  const sectionTitle = document.getElementById('sectionTitle');

  const navLinks = {
    dashboardLink: {
      contentId: 'dashboardContent',
      title: 'Service Provider',
    },
    profileLink: {
      contentId: 'profileContent',
      title: 'My Profile',
    },
    servicesLink: {
      contentId: 'servicesContent',
      title: 'My Services',
    },
    walletLink: {
      contentId: 'walletContent',
      title: 'My Wallet',
    },
  };

  // Hide all content sections
  const hideAllContents = () => {
    Object.values(navLinks).forEach(({ contentId }) => {
      const el = document.getElementById(contentId);
      if (el) el.style.display = 'none';
    });
  };

  // Set up each nav link
  Object.entries(navLinks).forEach(([linkId, { contentId, title }]) => {
    const link = document.getElementById(linkId);
    if (link) {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        hideAllContents();
        const content = document.getElementById(contentId);
        if (content) content.style.display = 'block';
        sectionTitle.textContent = title;
      });
    }
  });
});



document.getElementById('addServiceForm').addEventListener('submit', function (e) {
e.preventDefault();

const formData = new FormData(this);

fetch('add_service.php', {
  method: 'POST',
  body: formData
})
  .then(response => response.text())
  .then(result => {
    if (result.trim() === 'success') {
      alert('Service schedule added!');
      location.reload();
    } else {
      console.error(result);
      alert('Something went wrong.');
    }
  })
  .catch(error => {
    console.error(error);
    alert('Error occurred.');
  });
});

const serviceImageInput = document.getElementById('serviceImage');
  const primaryIndexInput = document.getElementById('primaryIndex');
  const previewContainer = document.getElementById('previewContainer');

  let files = [];

  serviceImageInput.addEventListener('change', () => {
    files = Array.from(serviceImageInput.files);
    renderPreviews();
  });

  primaryIndexInput.addEventListener('input', () => {
    renderPreviews();
  });

  function renderPreviews() {
    previewContainer.innerHTML = '';
    const primaryIndex = parseInt(primaryIndexInput.value, 10);

    files.forEach((file, idx) => {
      const img = document.createElement('img');
      img.src = URL.createObjectURL(file);
      img.style.width = '80px';
      img.style.height = '80px';
      img.style.objectFit = 'cover';
      img.style.border = '3px solid transparent';
      img.style.borderRadius = '8px';

      if (primaryIndex === idx + 1) {
        img.style.borderColor = 'orange';
      }

      previewContainer.appendChild(img);
    });
  }

document.querySelectorAll('.booking-action').forEach(button => {
  button.addEventListener('click', function () {
    const bookingId = this.getAttribute('data-id');
    const action = this.getAttribute('data-action');

    let status, confirmMessage;

    switch (action) {
      case 'confirm':
        status = 'in_progress';
        confirmMessage = "Are you sure you want to confirm this booking?";
        break;
      case 'decline':
        status = 'cancelled';
        confirmMessage = "Are you sure you want to decline this booking?";
        break;
      default:
        alert("Invalid action.");
        return;
    }

    // Show confirmation dialog
    if (!confirm(confirmMessage)) return;

    // If confirmed, proceed with request
    fetch('../utils/update-booking-status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `booking_id=${bookingId}&status=${status}`
    })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      location.reload();
    })
    .catch(err => console.error("Error:", err));
  });
});

