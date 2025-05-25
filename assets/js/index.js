document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.querySelector('.search-input');
  const productCards = document.querySelectorAll('.product-card');

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.trim().toLowerCase();

    productCards.forEach(card => {
      const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
      card.style.display = title.includes(query) ? '' : 'none';
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const checkboxes = document.querySelectorAll('#categoryFilterForm input[type="checkbox"]');
  const productCards = document.querySelectorAll('.product-card');
  const clearBtn = document.getElementById('clearFilters');

  const filterCards = () => {
    const selected = Array.from(checkboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value.toLowerCase());

    productCards.forEach(card => {
      const cardCategories = (card.dataset.category || '')
        .toLowerCase()
        .split(',')
        .map(cat => cat.trim());

      const matches = selected.length === 0 || selected.some(cat => cardCategories.includes(cat));
      card.style.display = matches ? '' : 'none';
    });
  };

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', filterCards);
  });

  clearBtn.addEventListener('click', () => {
    checkboxes.forEach(cb => cb.checked = false);
    filterCards(); // show all
  });
});

// Toggle sidebar visibility
const btn = document.getElementById('toggleSidebarBtn');
const sidebar = document.getElementById('sidebar');

btn.addEventListener('click', () => {
  if (sidebar.style.display === 'none' || sidebar.style.display === '') {
    sidebar.style.display = 'block';
    btn.textContent = '<';  
  } else {
    sidebar.style.display = 'none';
    btn.textContent = '☰';  
  }
});
