require('./bootstrap');

if (document.getElementById('cart-counter') && !document.getElementById('cart')) {
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

if (document.getElementById('search-product')) {
    require('./pages/search-product');
}

if (document.getElementById('statistics')) {
    require('./pages/statistics');
}
