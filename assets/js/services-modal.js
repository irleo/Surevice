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
    document.getElementById('modalPrice').textContent = parseFloat(button.getAttribute('data-price')).toLocaleString('en-PH', { minimumFractionDigits: 2 });
    document.getElementById('modalReview').textContent = button.getAttribute('data-review');
    document.getElementById('modalDescription').textContent = button.getAttribute('data-description');

    const providerText = button.getAttribute('data-provider');
    document.getElementById('modalProviderProfile').innerHTML = `Provider: <strong>${providerText}</strong>`;

    const categories = button.getAttribute('data-categories').split(',');
    const catContainer = document.getElementById('modalCategories');
    catContainer.innerHTML = '';
    categories.forEach(cat => {
      catContainer.innerHTML += `<span class="badge bg-primary me-1">${cat.trim()}</span>`;
    });

    const title = encodeURIComponent(button.getAttribute('data-title'));
    const price = button.getAttribute('data-price');
    document.getElementById('modalBookNowLink').href = `billing.html?product=${title}&price=${price}&qty=1`;
  });
});
