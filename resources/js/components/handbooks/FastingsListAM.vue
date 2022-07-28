<template>
    <div class="amFastingBody amPage">
        <div @click="back()" class="amPage-title">
            {{ __('Fasting calendar') }}
        </div>
        <div class="amHandbookMissingLessons-Header">
            <div class="amHandbookMissingLessons-timezone">
                <div class="amHandbookMissingLessons-timezoneWrapper">
                    <div class="amHandbookMissingLessons-timezoneButton appIcons msppIcons-chevron-left"></div>
                    <div class="amHandbookMissingLessons-timezoneValue">Часовой пояс</div>
                    <div class="amHandbookMissingLessons-timezoneButton appIcons msppIcons-chevron-right"></div>
                </div>
            </div>
            <div class="amHandbookMissingLessons-typeFasting dhrtRadio" v-if="times">
                <label>
                    <input @click="handleTimes(2)" type="radio" class="dhrtRadio-noView" v-model="times" :value="2">
                    <span class="amHandbookMissingLessons-typeFastingRadioView dhrtRadioView"></span>
                    <span class="amHandbookMissingLessons-typeFastingValue">2 {{ __('times') }}</span>
                </label>
                <label>
                    <input @click="handleTimes(4)" type="radio" class="dhrtRadio-noView" v-model="times" :value="4">
                    <span class="amHandbookMissingLessons-typeFastingRadioView dhrtRadioView"></span>
                    <span class="amHandbookMissingLessons-typeFastingValue">4 {{ __('times') }}</span>
                </label>
            </div>
        </div>
        <div class="amHandbookMissingLessons-list">
            <div v-for="fasting in fastings" class="amHandbookMissingLessons-listItem" :class="{'nearest': fasting.is_nearest}">
                <span>{{ dateFormat(fasting.date) }}</span>
                <span>{{ __(fasting.type) }} ({{ weekday(fasting.date) }})</span>
            </div>
        </div>
    </div>
</template>

<script>
    let moment = require('moment');

    export default {
        props: ['lang'],

        data() {
            return {
                fastings: [],
                times: 0
            }
        },

        mounted() {
            this.getData();
        },

        computed: {

        },

        methods: {
            handleTimes(times) {
                axios.post('/set-fastings-amount?fasting=' + times).then( response => {
                    this.getData();
                });
            },

            getData() {
                let params = {
                    infinite: true
                };

                axios.get('/fastings-handbook', {params: params}).then(response => {
                    this.fastings = response.data.fastings;
                    this.times = response.data.amount;
                });
            },

            dateFormat(date){
                return moment(date).locale(this.lang).format('D MMMM');
            },

            weekday(date) {
                return moment(date).locale(this.lang).format('dddd');
            },

            back() {
                window.history.back();
            }
        }
    }

</script>
