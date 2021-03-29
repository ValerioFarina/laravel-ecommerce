import Vue from 'vue';
import Swal from 'sweetalert2';

var productDetails = new Vue({
    el: '#product-details',
    data: {
        cart: []
    },
    methods: {
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
    }
});
