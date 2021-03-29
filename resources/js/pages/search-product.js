import Vue from 'vue';

var searchProduct = new Vue({
    el: '#search-product',
    data: {
        searched,
        category: '',
        maxPrice: 99999.99,
        showFilters: false,
        order: null,
        sortedProducts: []
    },
    methods: {
        checkCategory(categoryId) {
            return this.category == '' || categoryId == this.category;
        },
        checkPrice(price) {
            return parseFloat(price) <= this.maxPrice;
        },
        orderByPrice() {
            axios.get('/api/orderByPrice', {
                params: {
                    searched: this.searched,
                    order: this.order
                }
            }).then((response) => {
                this.sortedProducts = response.data.results;
            });
        },
        resetFilters() {
            this.category = '';
            this.maxPrice = 99999.99;
        }
    }
});
