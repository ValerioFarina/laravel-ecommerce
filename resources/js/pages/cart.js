import Vue from 'vue';

var cart = new Vue({
    el: '#cart',
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
        }
    },
    mounted() {
        axios.get('/api/cart').then((response) => {
            for (let rowId in response.data.result) {
                this.cart.push(response.data.result[rowId]);
            }
        });
    }
})
