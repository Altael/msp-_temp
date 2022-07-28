<template>
    <div class="appStatistics">
        <div class="appStatistics-btnGroupForm">
            <div class="appStatistics-type">
                <div class="appStatistics-btnGroup" v-if="admin">
                    <div class="appStatistics-btn" :class="{'active': mode === 'diagram'}"
                         @click="mode = 'diagram'">{{ __('Diagram') }}
                    </div>
                    <div class="appStatistics-btn" :class="{'active': mode === 'table'}"
                         @click="mode = 'table'">{{ __('Table') }}
                    </div>
                </div>
            </div>
            <div class="appStatistics-period">
                <div class="appStatistics-btnGroup">
                    <div class="appStatistics-btn" :class="{'active': period === 'day'}" v-if="mode === 'diagram'"
                         @click="period = 'day'">{{ __('Day') }}
                    </div>
                    <div class="appStatistics-btn" :class="{'active': period === 'week'}" v-if="mode === 'diagram'"
                         @click="period = 'week'">{{ __('Week') }}
                    </div>
                    <div class="appStatistics-btn" :class="{'active': period === 'month'}"
                         @click="period = 'month'">{{ __('Month') }}
                    </div>
                    <div class="appStatistics-btn" :class="{'active': period === 'year'}"
                         @click="period = 'year'">{{ __('Year') }}
                    </div>
                    <div class="appStatistics-btn" :class="{'active': period === 'custom'}"
                         @click="period = 'custom'">{{ __('Random') }}
                    </div>
                </div>
                <div class="appStatistics-form" v-if="period === 'custom'">
                    <div class="appStatistics-formGroup periodFrom">
                        <label>{{ __('From') }}</label>
                        <flat-pickr :key="start"
                                    v-model="start"
                                    :config="startConfig"
                                    :placeholder="__('Select date')"
                                    class="appForm-input"
                                    name="date">
                        </flat-pickr>
                    </div>
                    <div class="appStatistics-formGroup periodTo">
                        <label>{{ __('To') }}</label>
                        <flat-pickr :key="end"
                                    v-model="end"
                                    :config="endConfig"
                                    :placeholder="__('Select date')"
                                    class="appForm-input"
                                    name="date">
                        </flat-pickr>
                    </div>
                </div>
                <!--<div class="appStatistics-form" v-if="period === 'month'">
                    <div class="appStatistics-formGroup periodFrom" ref="month_picker">
                        <label>{{ __('Choose month') }}</label>
                        <flat-pickr :key="start"
                                    v-model="start"
                                    :config="{
                                        appendTo: month_append
                                    }"
                                    :placeholder="__('Select date')"
                                    class="appForm-input"
                                    name="date"
                        >
                        </flat-pickr>
                    </div>
                </div>-->
            </div>
        </div>
        <div class="appStatistics-summary" v-if="mode === 'table'">
            <div v-for="lesson of lessons" class="appStatistics-summaryLesson" :class="'lesson' + lesson">
                <div class="appStatistics-summaryLessonHeadWrapper">
                    <div class="appStatistics-summaryLessonHead">
                        <div class="appStatistics-summaryLessonHeadTitle">
                            {{ __('Lesson') }} {{ lesson }}
                        </div>
                        <div class="appStatistics-summaryLessonHeadTools">
                            <div @click="unlimitedCSVworks(lesson)">
                                <span class="appIcons msppIcons-file-excel"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="appStatistics-summaryLessonBody">
                    <div class="appTable">
                        <div class="appTable-head">
                            <div class="appTable-row">
                                <div class="lessons-acarya">
                                    {{  __('Acarya') }}
                                </div>
                                <div class="lessons-value">
                                    <div class="lessons-period" v-for="month of months" :class="{'all_column': month === 'all'}">
                                        {{ month === 'all' ? __('Overall') : dateFormat(month) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="appTable-body">
                            <div class="appTable-row" v-for="(data, acarya) of table_data" v-if="acarya !== 'all'" :class="{'all_row': acarya === 'all'}">
                                <div class="lessons-acarya">
                                    <div>{{ acarya === 'all' ? __('Overall') : acarya }}</div>
                                </div>
                                <div class="lessons-value">
                                    <div class="lessons-period" v-for="month of months" :class="{'all_column': month === 'all'}">
                                        <div class="period">{{ month === 'all' ? __('Overall') : dateFormat(month) }}</div>
                                        <div>{{ data ? data[month] ? data[month][lesson] ? data[month][lesson] : 0 : 0 : 0 }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-row all_row">
                                <div class="lessons-acarya">
                                    <div>{{ __('Overall') }}</div>
                                </div>
                                <div class="lessons-value">
                                    <div class="lessons-period" v-for="month of months" :class="{'all_column': month === 'all'}">
                                        <div class="period">{{ month === 'all' ? __('Overall') : dateFormat(month) }}</div>
                                        <div>{{ table_data['all'] ? table_data['all'][month] ? table_data['all'][month][lesson] ? table_data['all'][month][lesson] : 0 : 0 : 0 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="appStatistics-summaryLesson checks">
                <div class="appStatistics-summaryLessonHeadWrapper">
                    <div class="appStatistics-summaryLessonHead">
                        <div class="appStatistics-summaryLessonHeadTitle">
                            {{ __('Lesson checks') }}
                        </div>
                        <div class="appStatistics-summaryLessonHeadTools">
                            <div @click="unlimitedCSVworks(0)">
                                <span class="appIcons msppIcons-file-excel"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="appStatistics-summaryLessonBody">
                    <div class="appTable">
                        <div class="appTable-head">
                            <div class="appTable-row">
                                <div class="lessons-acarya">
                                    {{  __('Acarya') }}
                                </div>
                                <div class="lessons-value">
                                    <div class="lessons-period" v-for="month of months" :class="{'all_column': month === 'all'}">
                                        {{ month === 'all' ? __('Overall') : dateFormat(month) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="appTable-body">
                            <div class="appTable-row" v-for="(data, acarya) of checks" v-if="acarya !== 'all'" :class="{'all_row': acarya === 'all'}">
                                <div class="lessons-acarya">
                                    <div>{{ acarya === 'all' ? __('Overall') : acarya }}</div>
                                </div>
                                <div class="lessons-value">
                                    <div class="lessons-period" v-for="month of months" :class="{'all_column': month === 'all'}">
                                        <div class="period">{{ month === 'all' ? __('Overall') : dateFormat(month) }}</div>
                                        <div>{{ data ? data[month] ? data[month] : 0 : 0 }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-row all_row">
                                <div class="lessons-acarya">
                                    <div>{{ __('Overall') }}</div>
                                </div>
                                <div class="lessons-value">
                                    <div class="lessons-period" v-for="month of months" :class="{'all_column': month === 'all'}">
                                        <div class="period">{{ month === 'all' ? __('Overall') : dateFormat(month) }}</div>
                                        <div>{{ checks['all'] ? checks['all'][month] ? checks['all'][month] : 0 : 0 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <template v-if="mode === 'diagram'">
            <div style="display: flex; flex-wrap: wrap; align-items: center;">
                <div class="appStatisticsDiagram" style="margin-bottom: 16px;">
                    <statistics-initiations :key="start+end" :start="start" :end="end"></statistics-initiations>
                </div>
                <div class="appStatisticsDiagram">
                    <statistics-lessons :key="start+end" :start="start" :end="end"></statistics-lessons>
                </div>
            </div>
            <div style="display: flex; flex-wrap: wrap; align-items: center; flex-direction: column" v-for="acarya of acaryas">
                {{ acarya.name }}
                <div class="appStatisticsDiagram-container" style="display: flex; flex-wrap: wrap; align-items: center;">
                    <div class="appStatisticsDiagram" style="margin-bottom: 16px;">
                        <statistics-initiations :id="acarya.id" :key="start+end" :start="start" :end="end"></statistics-initiations>
                    </div>
                    <div class="appStatisticsDiagram">
                        <statistics-lessons :id="acarya.id" :key="start+end" :start="start" :end="end"></statistics-lessons>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import moment from 'moment';
    import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect";

    export default {
        props: ['admin', 'statistics_viewer'],

        components: {flatPickr},

        data() {
            return {
                period: 'year', // day, week, month, year, custom
                start: moment().startOf('year').format('YYYY-MM-DD'),
                end: moment().format('YYYY-MM-DD'),

                startConfig: {
                    altInput: true,
                    altFormat: 'd-m-Y',
                    maxDate: this.end,
                    altInputClass: 'appForm-input'
                },

                endConfig: {
                    altInput: true,
                    altFormat: 'd-m-Y',
                    minDate: this.start,
                    altInputClass: 'appForm-input'
                },

                yearPicker: {

                },

                acaryas: [],

                mode: 'table', // table or diagram

                lessons: [1, 2, 3, 4, 5, 6],

                table_data: {},
                checks: {}
            }
        },

        watch: {
            period(val) {
                if(this.mode === 'table') {
                    if(val === 'month') {
                        this.end = moment().format('YYYY-MM-DD');
                        this.start = moment().startOf('month').format('YYYY-MM-DD');
                    }
                    if(val === 'year') {
                        this.end = moment().format('YYYY-MM-DD');
                        this.start = moment().startOf('year').format('YYYY-MM-DD');
                    }
                    /*if(val === 'custom') {
                        this.start = moment().startOf('year').format('YYYY-MM-DD');
                        this.end = moment().format('YYYY-MM-DD');
                    }*/
                } else if (val !== 'custom') {
                    this.start = moment().startOf(val).format('YYYY-MM-DD');
                    this.end = moment().endOf(val).format('YYYY-MM-DD');
                }
            },

            period_conc() {
                if(this.mode === 'table') this.getData();
            },

            mode(val) {
                if(val === 'table') this.period = 'year';
                this.getData()
            }
        },

        computed: {
            period_conc() {
                return this.start + this.end;
            },

            months() {
                let months = [];
                let dateStart = moment(this.start).startOf('month');
                let dateEnd = moment(this.end).startOf('month');
                while (dateEnd.diff(dateStart, 'months') >= 0) {
                    months.push(dateStart.format('YYYY_M'));
                    dateStart.add(1, 'month');
                }
                months.push('all');
                return months;
            },

            month_append() {
                return this.$refs.month_picker
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            dateFormat(date) {
                return moment(date, 'YYYY_M').format('MMM YY');
            },

            getData() {
                if(this.mode === 'diagram') axios.get('/statistics/main').then(response => {
                    this.acaryas = response.data.acaryas;
                });
                if(this.mode === 'table') {
                    let params = {
                        start: this.start,
                        end: this.end
                    };

                    axios.get('/statistics/table', {params: params}).then( response => {
                        this.table_data = response.data.lessons;
                        this.checks = response.data.checks;
                    })
                }
            },

            unlimitedCSVworks(lesson) {
                let rows = [
                    ['acarya']
                ];

                this.months.forEach( month => {
                    rows[0].push(month === 'all' ? this.__('Overall') : this.dateFormat(month));
                });

                let row = [];

                if(lesson > 0) {
                    for(let acarya in this.table_data) {
                        row = [acarya === 'all' ? this.__('Overall') : acarya];
                        this.months.forEach( month => {
                            row.push(this.table_data[acarya] ? this.table_data[acarya][month] ? this.table_data[acarya][month][lesson] ? this.table_data[acarya][month][lesson] : 0 : 0 : 0);
                        });
                        rows.push(row);
                    }
                } else {
                    for(let acarya in this.checks) {
                        row = [acarya === 'all' ? this.__('Overall') : acarya];
                        this.months.forEach( month => {
                            row.push(this.checks[acarya] ? this.checks[acarya][month] ? this.checks[acarya][month] : 0 : 0);
                        });
                        rows.push(row);
                    }
                }

                let csvContent = "data:text/csv;charset=utf-8,"
                    + rows.map(e => e.join(",")).join("\n");

                var encodedUri = encodeURI(csvContent);
                var link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "lessons_" + lesson  + ".csv");
                document.body.appendChild(link); // Required for FF

                link.click(); // This will download the data file named "my_data.csv".
            }
        }
    }
</script>
