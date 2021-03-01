import { Bar } from 'vue-chartjs'

export default {
    extends: Bar,
    props: {
        chartdata: { type: Object, default: null },
        options: { type: Object, default: null }
    },
    mounted () {
        this.renderChart( this.chartdata, this.options );
    },
    watch: {
        options: function () {
            this.$data._chart.destroy()
            this.renderChart(this.chartdata, this.options);
        },
        chartdata: {
            handler: function () {
                this.$data._chart.destroy()
                this.renderChart(this.chartdata, this.options);
            },
            deep: true,
        },
    },
}