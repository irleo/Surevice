function showSection(sectionId) {
  const sections = document.querySelectorAll('.section');
  sections.forEach(section => section.classList.remove('active'));

  const activeSection = document.getElementById(sectionId);
  if (activeSection) {
    activeSection.classList.add('active');
  }
}

function search() {
  const query = document.getElementById('searchInput').value.toLowerCase();
  alert("Search feature not yet implemented. You searched for: " + query);
}

document.querySelectorAll('.approve-btn').forEach(btn => {
  btn.addEventListener('click', () => updateUserStatus(btn.dataset.id, 'approve'));
});

document.querySelectorAll('.suspend-btn').forEach(btn => {
  btn.addEventListener('click', () => updateUserStatus(btn.dataset.id, 'suspend'));
});

document.querySelectorAll('.reactivate-btn').forEach(btn => {
  btn.addEventListener('click', () => updateUserStatus(btn.dataset.id, 'reactivate'));
});

function updateUserStatus(userId, action) {
  if (!confirm(`Are you sure you want to ${action} this user?`)) return;

  fetch('../utils/update-user-status.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `user_id=${userId}&action=${action}`
  })
  .then(res => res.text())
  .then(msg => {
    alert(msg);
    location.reload();
  })
  .catch(err => {
    console.error(err);
    alert("Something went wrong.");
  });
}


// Handle Approve/Reject 
document.querySelectorAll('.approve-doc').forEach(button => {
    button.addEventListener('click', () => {
        const docId = button.dataset.docId;
        const action = 'approve'; 
        console.log('Action being sent:', action, 'Document ID:', docId);
        if (confirm('Approve this document?')) {
          fetch('../utils/verify-document.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({ document_id: docId, action: action })
          })
          .then(response => response.text())
          .then(data => {
              console.log('Server response:', data);
              location.reload();
          });
        }
    });
});

document.querySelectorAll('.reject-doc').forEach(button => {
    button.addEventListener('click', () => {
        const docId = button.dataset.docId;
        const action = 'reject'; 
        if (confirm('Reject this document?')) {
            fetch('../utils/verify-document.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({ document_id: docId, action: action })
          })
          .then(response => response.text())
          .then(data => {
              console.log('Server response:', data);
              location.reload();
          });
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
  if (typeof serviceChartData !== 'undefined' && serviceChartData.length > 0) {
    const labels = serviceChartData.map(item => item.service_type);
    const data = serviceChartData.map(item => item.count);
    const backgroundColors = ['#FF6384', '#36A2EB', '#FFCE56', '#8AFFC1', '#D276FF', '#FFA07A'];

    const ctx = document.getElementById('servicePieChart').getContext('2d');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: backgroundColors
        }]
      },
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Service Type Distribution'
          },
          tooltip: {
            callbacks: {
              label: function (context) {
                const total = data.reduce((a, b) => a + b, 0);
                const percent = ((context.raw / total) * 100).toFixed(1);
                return `${context.label}: ${context.raw} (${percent}%)`;
              }
            }
          }
        }
      }
    });

    // Highlight most popular service
    const maxIndex = data.indexOf(Math.max(...data));
    const popular = labels[maxIndex];
    const count = data[maxIndex];
    document.getElementById('popularService').textContent = `Most Popular Service: ${popular} (${count} listings)`;
  }
});

const rowsPerPage = 7;
  const table = document.getElementById('userMgmt');
  const tbody = table.querySelector('tbody');
  const pagination = document.getElementById('pagination');
  const rows = Array.from(tbody.rows);
  const totalPages = Math.ceil(rows.length / rowsPerPage);

  function showPage(page) {
    tbody.innerHTML = '';
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const pageRows = rows.slice(start, end);
    pageRows.forEach(row => tbody.appendChild(row));

    Array.from(pagination.children).forEach(btn => btn.classList.remove('active'));
    pagination.children[page - 1].classList.add('active');
  }

  function setupPagination() {
    pagination.innerHTML = '';
    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement('button');
      btn.textContent = i;
      btn.addEventListener('click', () => showPage(i));
      pagination.appendChild(btn);
    }
  }

  // Initialize
  setupPagination();
  showPage(1);