<template>
    <div :id="chartClass">
        <canvas :class="chartClass"></canvas>
    </div>
</template>
<script>
    export default {
        props: {
            dataValues: Array,
            chartClass: String,
            chartLabels: Array,
            chartColors: Array,
            chartType: String,
            datasetLabel: String
        },
        computed: {
            display: function() {
                var display = true;
                if (this.chartType === "bar") {
                    display = false;
                }
                return display;
            }
        },
        mounted() {
            var element = document.querySelector('.'+ this.chartClass);
            var graph = new Chart(element, {
                type: this.chartType,
                options: {
                    maintainAspectRatio: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            display: this.display
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                },
                data: {
                    labels: this.chartLabels,
                    datasets: [
                        {
                            label: this.datasetLabel,
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
