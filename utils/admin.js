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
