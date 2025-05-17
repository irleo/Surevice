const wrapper = document.querySelector('.category-wrapper');
const leftBtn = document.querySelector('.scroll-btn.left');
const rightBtn = document.querySelector('.scroll-btn.right');

leftBtn.addEventListener('click', () => {
  wrapper.scrollBy({ left: -300, behavior: 'smooth' });
});

rightBtn.addEventListener('click', () => {
  wrapper.scrollBy({ left: 300, behavior: 'smooth' });
});

 const serviceModal = document.getElementById('serviceModal')
  serviceModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget
    const image = button.getAttribute('data-image')
    const title = button.getAttribute('data-title')
    const price = button.getAttribute('data-price')
    const review = button.getAttribute('data-review')
    const categories = button.getAttribute('data-categories')  // comma separated
    const description = button.getAttribute('data-description')
    const provider = button.getAttribute('data-provider')

    // Populate modal content
    serviceModal.querySelector('#modalImage').src = image
    serviceModal.querySelector('#serviceModalLabel').textContent = title
    serviceModal.querySelector('#modalServiceName').textContent = title
    serviceModal.querySelector('#modalPrice').textContent = parseFloat(price).toFixed(2)
    serviceModal.querySelector('#modalReview').textContent = review
    serviceModal.querySelector('#modalDescription').textContent = description
    serviceModal.querySelector('#modalProviderProfile').innerHTML = provider.replace(/, /g, '<br>')

    // Populate categories as badges
    const categoriesContainer = serviceModal.querySelector('#modalCategories')
    categoriesContainer.innerHTML = ''  // clear previous
    if (categories) {
      const categoryList = categories.split(',').map(cat => cat.trim())
      categoryList.forEach(cat => {
        const badge = document.createElement('span')
        badge.className = 'badge bg-primary me-1'
        badge.textContent = cat
        categoriesContainer.appendChild(badge)
      })
    }
  })




