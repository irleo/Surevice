window.onload = () => {
  const product = getQueryParam('product');
  const price = getQueryParam('price');
  const qty = getQueryParam('qty');

  if (product) document.getElementById('productName').value = decodeURIComponent(product);
  if (price) document.getElementById('price').value = price;
  if (qty) document.getElementById('quantity').value = qty;

  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const cartList = document.getElementById('cartList');

  if (cart.length === 0) {
    cartList.innerHTML = '<li class="list-group-item">Your cart is empty.</li>';
  } else {
    cart.forEach(item => {
      const li = document.createElement('li');
      li.className = 'list-group-item d-flex justify-content-between align-items-center';
      li.textContent = `${item.product} - ₱${item.price} x ${item.quantity}`;
      cartList.appendChild(li);
    });
  }
};

function calculate() {
  const quantity = parseFloat(document.getElementById('quantity').value);
  const price = parseFloat(document.getElementById('price').value);

  if (isNaN(quantity) || isNaN(price) || quantity < 1 || price < 0) {
    alert("Please enter valid quantity and price values.");
    return;
  }

  const total = quantity * price;
  alert(`Total Amount: ₱${total.toFixed(2)}`);
}

function getQueryParam(name) {
const urlParams = new URLSearchParams(window.location.search);
return urlParams.get(name);
}

function clearCart() {
  // localStorage.removeItem('cart');
  document.getElementById('billingForm').reset();
}