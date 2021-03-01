<template>
    <div :id="chartClass">
        <canvas :class="chartClass"></canvas>
    </div>
</template>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    export default {
        props: {
            dataValues: Array,
            chartClass: String,
            chartLabels: Array,
            chartColors: Array
        },
        mounted() {
            var element = document.querySelector('.'+ this.chartClass);
            var graph = new Chart(element, {
                type: 'pie',
                options: {
                    maintainAspectRatio: true,
                    tooltips: {
                        callbacks: {
                            label: function label(tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
                                    return previousValue + currentValue;
                                });
                                var currentValue = dataset.data[tooltipItem.index];
                                var precentage = Math.floor(currentValue / total * 100 + 0.5);
                                return precentage + "%, " + currentValue;
                            }
                        }
                    }
                },
                data: {
                    labels: this.chartLabels,
                    datasets: [
                        {
                            data: this.dataValues,
                            backgroundColor: this.chartColors,
                            fill: true
                        },

                    ]
                }
            });
        }
    }
</script>
