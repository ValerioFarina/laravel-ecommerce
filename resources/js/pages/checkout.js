import Vue from 'vue';

var checkout = new Vue({
    el: '#checkout',
    data: {
        cart: [],
        cardError: '',
        nameOnCard: '',
        address: '',
        city: '',
        province: '',
        postalcode: ''
    },
    methods: {
        cartCount() {
            var count = 0;
            this.cart.forEach((product) => {
                count += parseInt(product.qty);
            });
            return count;
        },
        stripeTokenHandler(token) {
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
    },
    mounted() {
        axios.get('/api/cart').then((response) => {
            for (let rowId in response.data.result) {
                this.cart.push(response.data.result[rowId]);
            }
        });

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
            var self = this;
            card.addEventListener('change', function(event) {
                if (event.error) {
                    self.cardError = event.error.message;
                } else {
                    self.cardError = '';
                }
            });

            this.handleSubmission = () => {
                // Disable the submit button to prevent repeated clicks
                document.getElementById('complete-order').disabled = true;
                var options = {
                    name: this.nameOnCard,
                    address_line1: this.address,
                    address_city: this.city,
                    address_state: this.province,
                    address_zip: this.postalcode
                }
                stripe.createToken(card, options).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        self.cardError = result.error.message;
                        // Enable the submit button
                        document.getElementById('complete-order').disabled = false;
                    } else {
                        // Send the token to your server
                        self.stripeTokenHandler(result.token);
                    }
                });
            };
        });
    }
});
