require('./bootstrap');

if (document.getElementById('root')) {
    require('./partials/cart-counter');
}

if (document.getElementById('product-details')) {
    require('./pages/product-details');
}

if (document.getElementById('cart')) {
    require('./pages/cart');
}

if (document.getElementById('checkout')) {
    require('./pages/checkout');
}
