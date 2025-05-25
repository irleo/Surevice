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
        if (confirm('Approve this document?')) {
            fetch('../utils/verify-document.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ document_id: docId, action: 'approve' })
            }).then(() => location.reload());
        }
    });
});

document.querySelectorAll('.reject-doc').forEach(button => {
    button.addEventListener('click', () => {
        const docId = button.dataset.docId;
        if (confirm('Reject this document?')) {
            fetch('../utils/verify-document.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ document_id: docId, action: 'reject' })
            }).then(() => location.reload());
        }
    });
});

