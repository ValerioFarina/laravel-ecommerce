import Vue from 'vue';
var Chart = require('chart.js');

var chart = new Vue({
    el: '#statistics',
    data: {
        year: new Date().getFullYear(),
        dataset: 'items',
        myChart: undefined,
        productId,
        productFilter: 'all',
        productType: undefined
    },
    methods: {
        getData() {
            var url = '';
            var label = '';
            var stepSize = undefined;
            switch (this.dataset) {
                case "items":
                    url = 'getNumOfItems';
                    label = 'Number of items sold';
                    stepSize = 5;
                    break;

                case "revenues":
                    url = 'getRevenues';
                    label = 'revenues';
                    stepSize = 100;
                    break;
            }
            axios.get('/api/' + url, {
                params: {
                    year: this.year,
                    productId: this.productId,
                    productType: this.productType
                }
            }).then((response) => {
                var results = response.data.results;
                var data = [];
                for (let i=1; i<=12; i++) {
                    var currentMonth = i<10 ? '0'+i : ''+i;
                    var value = results.hasOwnProperty(currentMonth) ? results[currentMonth] : 0;
                    data.push(value);
                }
                if (this.myChart) {
                    this.myChart.destroy();
                }
                var ctx = document.getElementById('myChart');
                this.myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [
                            'January',
                            'February',
                            'March',
                            'April',
                            'May',
                            'June',
                            'July',
                            'August',
                            'September',
                            'October',
                            'November',
                            'December'
                        ],
                        datasets: [{
                            label,
                            data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize
                                }
                            }]
                        }
                    }
                });
            });
        },
        changeProductFilter() {
            if (this.productFilter == 'all' && (this.productType || this.productId)) {
                this.productType = undefined;
                this.productId = undefined;
                this.getData();
            }
            this.productType = undefined;
            this.productId = undefined;
        }
    },
    mounted() {
        this.getData();
    }
});
