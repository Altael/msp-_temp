<template>
    <div class="appFastingsList">
        <pagination v-model="page" :total="total" :per-page="perPage"/>
        <div class="dhrtRadio" v-if="times">
            <label>
                <input @click="handleTimes(2)" type="radio" class="dhrtRadio-noView" v-model="times" :value="2">
                <span class="dhrtRadioView"></span>
                <span>2 {{ __('fastings per month') }}</span>
            </label>
            <label>
                <input @click="handleTimes(4)" type="radio" class="dhrtRadio-noView" v-model="times" :value="4">
                <span class="dhrtRadioView"></span>
                <span>4 {{ __('fastings per month') }}</span>
            </label>
        </div>
        <div class="appTable appFastingsListTable">
            <div class="appTable-row appTable-head appFastingsListTable-head">
                <div class="appTable-col appFastingsListTable-fastingType">
                    <div class="appTable-colTop" @click="sort('type')" >
                        <div>{{ __('Fasting type') }}</div>
                        <div class="appTable-sort" v-if="sortBy === 'type'">
                            <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                        </div>
                    </div>
                    <div class="appTable-filter_listFilter">
                        <dropdown v-model="filters.type" class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto" :options='fastingTypes' />
                    </div>
                </div>
                <div class="appTable-col appFastingsListTable-fastingDate">
                    <div class="appTable-colTop" @click="sort('date')">
                        <div>{{ __('Fasting date') }}</div>
                        <div class="appTable-sort" v-if="sortBy === 'date'">
                            <span class="appIcons" :class="'msppIcons-sort-numeric-' + sortOrder"></span>
                        </div>
                    </div>
                    <div class="appTable-filter">
                    </div>
                </div>
            </div>
            <div class="appTable-body">
                <div v-for="(fasting, index) in fastings" class="appTable-row" :class="{'nearest': fasting.is_nearest}">
                    <div class="appTable-col appFastingsListTable-fastingType">
                        {{ fasting.type }}
                    </div>
                    <div class="appTable-col appFastingsListTable-fastingDate">
                        {{ dateFormat(fasting.date) }}
                    </div>
                </div>
            </div>
        </div>
        <pagination v-if="total >= 50" v-model="page" :total="total" :per-page="perPage"/>
    </div>
</template>

<script>
    let moment = require('moment');

    export default {
        data() {
            return {
                page: 1,
                perPage: 10,
                total: 0,

                fastings: [],
                times: 0,

                isProcessing: null,

                sortBy: 'date',
                sortOrder: 'asc',

                filters: {
                    type: ''
                },
                fastingTypes: {null: this.__('All'), ekadashi: this.__('Ekadashi'), amavasya: this.__('Amavasya'), purnima: this.__('Purnima')},
            }
        },

        mounted() {
            this.getData();
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },
        },

        watch: {
            page() {
                this.getData();
            },

            filters: {
                deep: true,
                handler() {
                    if(this.filters.type === "null") this.filters.type = null;
                    this.page = 1;
                    this.getData();
                }
            }
        },

        methods: {
            handleTimes(times) {
                axios.post('/set-fastings-amount?fasting=' + times).then( response => {
                    this.getData();
                });
            },

            getData() {
                let params = {
                    type: this.filters.type ? this.filters.type : null,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,

                    take: this.perPage,
                    skip: this.skip
                };

                axios.get('/fastings-handbook', {params: params}).then(response => {
                    this.fastings = response.data.fastings;
                    this.total = response.data.total;
                    this.times = response.data.amount;
                });
            },



            sort(column) {
                if (this.sortBy === column) {
                    this.sortOrder = this.sortOrder === 'desc' ? 'asc' : 'desc';
                } else {
                    this.sortOrder = 'desc';
                    this.sortBy = column;
                }

                this.$nextTick(() => {
                    this.getData();
                });
            },

            dateFormat(date){
                return moment(date).format('DD.MM.YYYY')
            },

            /*accept(request) {
                axios.put('/missing-lesson-accept', {
                    data: request
                }).then(response => {
                    this.$nextTick(() => {
                        this.getData();
                    });
                });
            },

            decline(request) {
                axios.put('/missing-lesson-decline', {
                    data: request
                }).then(response => {
                    this.$nextTick(() => {
                        this.getData();
                    });
                });
            }*/
        }
    }

</script>
