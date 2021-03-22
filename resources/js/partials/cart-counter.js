import Vue from 'vue';

var cartCounter = new Vue({
    el: '#root',
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
        }
    },
    mounted() {
        axios.get('/api/cart').then((response) => {
            for (let rowId in response.data.result) {
                this.cart.push(response.data.result[rowId]);
            }
        });
    }
});
