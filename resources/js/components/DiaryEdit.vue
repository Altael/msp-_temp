<template>
    <div class="appDiaryEdit">
        <div class="appTable appDiariesEdit">
            <div class="appTable-row appTable-head appDiaryEdit-tableHead">
                <div class="appTable-col appDiaryEdit-name">
                    <div>Название практики</div>
                </div>
                <div class="appTable-col appDiaryEdit-points">
                    <div>Максимум очков за практику</div>
                </div>
                <div class="appTable-col appDiaryEdit-time">
                    <div>Максимальное время (количество раз) выполнения практики</div>
                </div>
                <div class="appTable-col appDiaryEdit-fee">
                    <div>Штраф за невыполнение практики</div>
                </div>
            </div>
            <div class="appTable-body">
                <div v-for="practice in timePractices" class="appTable-row">
                    <div class="appTable-col appDiaryEdit-name">
                        <span>{{ practice.name }}</span>
                    </div>
                    <div class="appTable-col appDiaryEdit-points">
                        <input type="number" step=0.01 v-model="practice.points">
                    </div>
                    <div class="appTable-col appDiaryEdit-time">
                        <input type="number" step=0.01 v-model="practice.time">
                    </div>
                    <div class="appTable-col appDiaryEdit-fee">
                        <input type="number" step=0.01 v-model="practice.fee">
                    </div>
                </div>
                <div class="appTable-col appDiaryEdit-practice">{{__('Aharya')}}</div>
                <div v-for="(practice, key) in aharya" class="appTable-row">
                    <div class="appTable-col appDiaryEdit-chooseName">
                        <span>{{ practice.name }}</span>
                    </div>
                    <div class="appTable-col appDiaryEdit-points">
                        <input type="number" step=0.01 v-model="practice.points">
                    </div>
                </div>
                <div class="appTable-col appDiaryEdit-practice">{{__('Asanas')}}</div>
                <div v-for="(practice, key) in asanas" class="appTable-row">
                    <div class="appTable-col appDiaryEdit-chooseName">
                        <span>{{ practice.name }}</span>
                    </div>
                    <div class="appTable-col appDiaryEdit-points">
                        <input type="number" step=0.01 v-model="practice.points">
                    </div>
                </div>
                <div class="appTable-col appDiaryEdit-practice">{{__('Dharmacakra')}}</div>
                <div v-for="(practice, key) in dharmacakra" class="appTable-row">
                    <div class="appTable-col appDiaryEdit-chooseName">
                        <span>{{ practice.name }}</span>
                    </div>
                    <div class="appTable-col appDiaryEdit-points">
                        <input type="number" step=0.01 v-model="practice.points">
                    </div>
                </div>
                <div class="appTable-col appDiaryEdit-practice">{{__('Full')}} bath</div>
                <div v-for="(practice, key) in fullbath" class="appTable-row">
                    <div class="appTable-col appDiaryEdit-chooseName">
                        <span>{{ practice.name }}</span>
                    </div>
                    <div class="appTable-col appDiaryEdit-points">
                        <input type="number" step=0.01 v-model="practice.points">
                    </div>
                </div>
                <div class="appTable-col appDiaryEdit-practice">{{__('Half')}} bath</div>
                <div v-for="(practice, key) in halfbath" class="appTable-row">
                    <div class="appTable-col appDiaryEdit-chooseName">
                        <span>{{ practice.name }}</span>
                    </div>
                    <div class="appTable-col appDiaryEdit-points">
                        <input type="number" step=0.01 v-model="practice.points">
                    </div>
                </div>
                <div class="appTable-col appDiaryEdit-practice">{{__('Pancajania')}}</div>
                <div v-for="(practice, key) in pancajania" class="appTable-row">
                    <div class="appTable-col appDiaryEdit-chooseName">
                        <span>{{ practice.name }}</span>
                    </div>
                    <div class="appTable-col appDiaryEdit-points">
                        <input type="number" step=0.01 v-model="practice.points">
                    </div>
                </div>
                <div class="appTable-col appDiaryEdit-practice">{{__('Upavasa')}}</div>
                <div v-for="(practice, key) in upavasa" class="appTable-row">
                    <div class="appTable-col appDiaryEdit-chooseName">
                        <span>{{ practice.name }}</span>
                    </div>
                    <div class="appTable-col appDiaryEdit-points">
                        <input type="number" step=0.01 v-model="practice.points">
                    </div>
                </div>
                <div class="appTable-col appDiaryEdit-practice">{{__('Ranks')}}</div>
                <div v-for="practice in ranks" class="appTable-row">
                    <div class="appTable-col appDiaryEdit-chooseName">
                        <input type="text" v-model="practice.en">
                    </div>
                    <div class="appTable-col appDiaryEdit-chooseName">
                        <input type="text" v-model="practice.ru">
                    </div>
                    <div class="appTable-col appDiaryEdit-points">
                        <input type="number" step=0.01 v-model="practice.points">
                    </div>
                </div>
            </div>
        </div>
        <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" @click="save">{{ __('Save') }}</div>
    </div>
</template>

<script>
    let moment = require('moment');
    export default {

        props: {

        },



        data() {
            return {
                timePractices: [],

                aharya: [],
                asanas: [],
                dharmacakra: [],
                fullbath: [],
                halfbath: [],
                pancajania: [],
                upavasa: [],

                ranks: [],
            }
        },

        mounted() {
            this.getData();
        },

        watch: {

        },

        computed: {

        },

        methods: {
            getData(){
                axios.get('/diary-settings').then(response => {
                    this.timePractices  = response.data.points;

                    this.aharya         = response.data.aharya;
                    this.asanas         = response.data.asanas;
                    this.dharmacakra    = response.data.dharmacakra;
                    this.fullbath       = response.data.fullbath;
                    this.halfbath       = response.data.halfbath;
                    this.pancajania     = response.data.pancajania;
                    this.upavasa        = response.data.upavasa;

                    this.ranks          = response.data.ranks;
                });
            },

            save(){
                axios.post('/diary-settings', {
                    timePractices: this.timePractices,
                    aharya: this.aharya,
                    asanas: this.asanas,
                    dharmacakra: this.dharmacakra,
                    fullbath: this.fullbath,
                    halfbath: this.halfbath,
                    pancajania: this.pancajania,
                    upavasa: this.upavasa,
                    ranks: this.ranks,
                }).then(response => {

                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>
