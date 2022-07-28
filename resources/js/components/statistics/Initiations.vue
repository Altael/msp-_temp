<script>
    import { Pie } from 'vue-chartjs'

    export default {
        props: ['start', 'end', 'id'],

        extends: Pie,

        data() {
            return {
                data: [],
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false,
                                stepValue: 1
                            }
                        }]
                    },
                }
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {

                axios.get('/statistics/initiations', {params: {start: this.start, end: this.end, id: this.id}}).then(response => {

                    this.data = response.data;

                    this.$nextTick(() => {
                        this.renderChart(this.data, this.options);
                    });
                });


            }
        }
    }
</script>
