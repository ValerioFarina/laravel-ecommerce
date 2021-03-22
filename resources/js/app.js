require('./bootstrap');

import Vue from 'vue';
import Swal from 'sweetalert2';

if (document.getElementById('app')) {
    var cart = new Vue({
        el: '#app',
        data: {
            cart: []
        },
        methods: {
            cartCount() {
                var count = 0;
                this.cart.forEach((product) => {
                   count += parseInt(product.qty);
                });
                return count;
            },
            cartSubtotal() {
                var subtotal = 0;
                this.cart.forEach((product) => {
                    subtotal += parseFloat(product.price) * parseInt(product.qty);
                });
                return subtotal;
            },
            updateQuantity(id) {
                axios.put('/api/cart/update/quantity', {
                    quantity: this.cart[id].qty,
                    rowId: this.cart[id].rowId
                }).then((response) => {
                    console.log(response.data.result);
                });
            },
            addToCart(id, availableQty) {
                var product = this.cart.find(item => item.model.id == id);

                if (product && product.qty < product.model.quantity) {
                    Swal.fire({
                        title: 'This product is already in the cart.',
                        text: "Do you want to add an item of this product to the cart?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.$refs.addToCart.submit();
                        }
                    })
                } else if (product) {
                    Swal.fire('All the available items of this product are already in the cart.');
                } else if (availableQty == 0) {
                    Swal.fire('This product is not available.');
                } else {
                    this.$refs.addToCart.submit();
                }
            }
        },
        mounted() {
            axios.get('/api/cart').then((response) => {
                for (let rowId in response.data.result) {
                    this.cart.push(response.data.result[rowId]);
                }
            });

            if (document.getElementById('payment-form')) {
                // Create a Stripe client
                axios.get('/api/getStripeKey').then((response) => {
                    var stripe = Stripe(response.data.result);
                    // Create an instance of Elements
                    var elements = stripe.elements();
                    // Create an instance of the card Element
                    var card = elements.create('card', {
                        hidePostalCode: true
                    });
                    // Add an instance of the card Element into the `card-element` <div>
                    card.mount('#card-element');
                    // Handle real-time validation errors from the card Element.
                    card.addEventListener('change', function(event) {
                        var displayError = document.getElementById('card-errors');
                        if (event.error) {
                            displayError.textContent = event.error.message;
                        } else {
                            displayError.textContent = '';
                        }
                    });
                    // Handle form submission
                    var form = document.getElementById('payment-form');
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        // Disable the submit button to prevent repeated clicks
                        document.getElementById('complete-order').disabled = true;
                        var options = {
                            name: document.getElementById('name_on_card').value,
                            address_line1: document.getElementById('address').value,
                            address_city: document.getElementById('city').value,
                            address_state: document.getElementById('province').value,
                            address_zip: document.getElementById('postalcode').value
                        }
                        stripe.createToken(card, options).then(function(result) {
                            if (result.error) {
                                // Inform the user if there was an error
                                var errorElement = document.getElementById('card-errors');
                                errorElement.textContent = result.error.message;
                                // Enable the submit button
                                document.getElementById('complete-order').disabled = false;
                            } else {
                                // Send the token to your server
                                stripeTokenHandler(result.token);
                            }
                        });
                    });
                    function stripeTokenHandler(token) {
                        // Insert the token ID into the form so it gets submitted to the server
                        var form = document.getElementById('payment-form');
                        var hiddenInput = document.createElement('input');
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'stripeToken');
                        hiddenInput.setAttribute('value', token.id);
                        form.appendChild(hiddenInput);
                        // Submit the form
                        form.submit();
                    }
                });
            }
        }
    });
}
