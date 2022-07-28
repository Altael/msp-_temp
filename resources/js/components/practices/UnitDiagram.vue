<script>
import { Line } from 'vue-chartjs'
import moment from 'moment';

export default {
    props: ['mode', 'unit', 'periods', 'full', 'practice'],

    extends: Line,

    data() {
        return {
            data: [],
            options: {
                responsive: false,
                maintainAspectRatio: true,
                legend: {
                    display: false
                },
                title: {
                    display: false,
                },
                label: false,
                scales: {
                    xAxes: [{
                        display: false
                    }]
                }
            },
            options_full: {
                responsive: false,
                maintainAspectRatio: true
            }
        }
    },

    watch: {
        unit: {
            deep: true,
            handler() {
                if(this.unit && this.periods) this.buildData();
            }
        }
    },

    mounted() {
        if(this.unit && this.periods) this.buildData();
    },

    methods: {
        buildData() {
            let data = [];
            let labels = [];
            let key = '';

            if(Array.isArray(this.periods)) {
                this.periods.forEach((period, index) => {
                    labels[index] = period.range;

                    key = moment(period.day).format('YYYY.MM.DD') + '_' + moment(period.day).endOf(this.mode).format('YYYY.MM.DD');

                    if(this.practice === 'km') {
                        if(this.unit && this.unit['km'] && this.unit['km'][key]) {
                            data[index] = (this.unit['km'][key]['ini']['guests'] ? this.unit['km'][key]['ini']['guests'] : 0) +
                                (this.unit['km'][key]['not_ini']['guests'] ? this.unit['km'][key]['not_ini']['guests'] : 0) +
                                (this.unit['km'][key]['ini']['users'] ? this.unit['km'][key]['ini']['users'] : 0) +
                                (this.unit['km'][key]['not_ini']['users'] ? this.unit['km'][key]['not_ini']['users'] : 0)
                        } else {
                            data[index] = 0;
                        }
                    }

                    if(this.practice === 'dc') {
                        if(this.unit && this.unit['dc'] && this.unit['dc'][key]) {
                            data[index] = (data[index] ? data[index] : 0) +
                                (this.unit['dc'][key]['ini']['guests'] ? this.unit['dc'][key]['ini']['guests'] : 0) +
                                (this.unit['dc'][key]['not_ini']['guests'] ? this.unit['dc'][key]['not_ini']['guests'] : 0) +
                                (this.unit['dc'][key]['ini']['users'] ? this.unit['dc'][key]['ini']['users'] : 0) +
                                (this.unit['dc'][key]['not_ini']['users'] ? this.unit['dc'][key]['not_ini']['users'] : 0)
                        } else {
                            data[index] = data[index] ? data[index] : 0;
                        }
                        if(this.unit && this.unit['ak'] && this.unit['ak'][key]) {
                            data[index] = (data[index] ? data[index] : 0) +
                                (this.unit['ak'][key]['ini']['guests'] ? this.unit['ak'][key]['ini']['guests'] : 0) +
                                (this.unit['ak'][key]['not_ini']['guests'] ? this.unit['ak'][key]['not_ini']['guests'] : 0) +
                                (this.unit['ak'][key]['ini']['users'] ? this.unit['ak'][key]['ini']['users'] : 0) +
                                (this.unit['ak'][key]['not_ini']['users'] ? this.unit['ak'][key]['not_ini']['users'] : 0)
                        } else {
                            data[index] = data[index] ? data[index] : 0;
                        }
                        if(this.unit && this.unit['sadhana_sivir'] && this.unit['sadhana_sivir'][key]) {
                            data[index] = (data[index] ? data[index] : 0) +
                                (this.unit['sadhana_sivir'][key]['ini']['guests'] ? this.unit['sadhana_sivir'][key]['ini']['guests'] : 0) +
                                (this.unit['sadhana_sivir'][key]['not_ini']['guests'] ? this.unit['sadhana_sivir'][key]['not_ini']['guests'] : 0) +
                                (this.unit['sadhana_sivir'][key]['ini']['users'] ? this.unit['sadhana_sivir'][key]['ini']['users'] : 0) +
                                (this.unit['sadhana_sivir'][key]['not_ini']['users'] ? this.unit['sadhana_sivir'][key]['not_ini']['users'] : 0)
                        } else {
                            data[index] = data[index] ? data[index] : 0;
                        }
                    }
                });

                this.data = {
                    labels: labels.reverse(),
                    datasets: [
                        {
                            label: this.practice === 'dc' ? this.__('DC') : this.__('KM'),
                            data: data.reverse(),
                            borderColor: this.practice === 'dc' ? 'rgba(255, 99, 132, 1)' : 'rgba(54, 162, 235, 1)'
                        }
                    ]
                }

                this.$nextTick(() => {
                    if(!this.$refs.chart) this.renderChart(this.data, this.full ? this.options_full : this.options);
                });
            }
        }
    }
}
</script>
