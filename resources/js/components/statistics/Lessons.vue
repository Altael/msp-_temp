<script>
    import { Bar } from 'vue-chartjs'

    export default {
        props: ['start', 'end', 'id'],

        extends: Bar,

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

                axios.get('/statistics/lessons', {params: {start: this.start, end: this.end, id: this.id}}).then(response => {

                    this.data = response.data;

                    this.$nextTick(() => {
                        this.renderChart(this.data, this.options);
                    });
                });


            }
        }
    }
</script>
