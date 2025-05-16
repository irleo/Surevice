const wrapper = document.querySelector('.category-wrapper');
const leftBtn = document.querySelector('.scroll-btn.left');
const rightBtn = document.querySelector('.scroll-btn.right');

leftBtn.addEventListener('click', () => {
  wrapper.scrollBy({ left: -300, behavior: 'smooth' });
});

rightBtn.addEventListener('click', () => {
  wrapper.scrollBy({ left: 300, behavior: 'smooth' });
});
