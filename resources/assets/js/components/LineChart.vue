<template>
    <div :id="chartClass">
        <canvas :class="chartClass" height="70%"></canvas>
    </div>
</template>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    export default {
        props: {
            labels: Array,
            chartClass: String,
            dataset:Array
        },
        mounted() {
            var formatedDate = [];
            this.labels.forEach(function(item){
                var val = new Date(item.date).toLocaleDateString();
                formatedDate.push(val);
            })
            var element = document.querySelector('.'+ this.chartClass);
            var graph = new Chart(element, {
                type: 'line',
                options: {
                    maintainAspectRatio: true,
                    legend: {
                        labels: {
                            usePointStyle: true
                        }
                    }
                },
                data: {
                    labels: formatedDate,
                    datasets: this.dataset
                }
            });
        }
    }
</script>
