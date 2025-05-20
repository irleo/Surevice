document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('serviceModal');
  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const images = (button.getAttribute('data-images') || '').split(',');
    const carouselInner = document.getElementById('modalCarouselInner');
    carouselInner.innerHTML = '';
    images.forEach((img, index) => {
      const activeClass = index === 0 ? 'active' : '';
      carouselInner.innerHTML += `
        <div class="carousel-item ${activeClass}">
          <img src="${img.trim()}" class="d-block w-100 rounded" alt="Service Image ${index + 1}">
        </div>
      `;
    });

    document.getElementById('modalServiceName').textContent = button.getAttribute('data-title');
    document.getElementById('modalFee').textContent = parseFloat(button.getAttribute('data-fee')).toLocaleString('en-PH', { minimumFractionDigits: 2 });
    document.getElementById('modalReview').textContent = button.getAttribute('data-review');
    document.getElementById('modalDescription').textContent = button.getAttribute('data-description');

    const providerName = button.getAttribute('data-provider');
    const providerEmail = button.getAttribute('data-email');
    const providerPhone = button.getAttribute('data-phone');

    document.getElementById('modalProviderProfile').innerHTML = `${providerName}`;
    document.getElementById('modalProviderEmail').innerHTML = `${providerEmail}`;
    document.getElementById('modalProviderPhone').innerHTML = `${providerPhone}`;

    const catContainer = document.getElementById('modalCategories');
    catContainer.innerHTML = '';

    let categories;
    try {
      categories = JSON.parse(button.getAttribute('data-categories'));
    } catch (e) {
      categories = [];
    }

    categories.forEach(cat => {
      const badge = document.createElement('span');
      badge.className = 'badge me-1';
      badge.style.backgroundColor = cat.color || '#ccc';  
      badge.textContent = cat.name;
      catContainer.appendChild(badge);
    });

    const title = encodeURIComponent(button.getAttribute('data-title'));
    const fee = button.getAttribute('data-fee');
    document.getElementById('modalBookNowLink').href = `billing.html?product=${title}&fee=${fee}`;
  });
});
