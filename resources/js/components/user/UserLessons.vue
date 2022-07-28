<template>
    <div class="appUserLessons appTable" :class="{'amPage' : am}" v-if="lessons.length">
        <div :title="__('Backward')" class="amPage-title" v-if="am" @click="goToProfile">
            {{ __('My lessons') }}
        </div>
        <div class="amPage-body">
            <div>
            <div class="appTable-row appTable-head">
                <div class="appTable-col appUserLessons-lesson">{{ __('Lesson') }}</div>
                <div class="appTable-col appUserLessons-date">{{ __('Date') }}</div>
                <div class="appTable-col appUserLessons-acarya">{{ __('Acarya') }}</div>
            </div>
            <div class="appTable-body">
                <div class="appTable-row" v-for="lesson of lessons">
                    <div class="appTable-col appUserLessons-lesson">{{ lesson.lesson_number }}</div>
                    <!--<div class="appTable-col appUserLessons-date">{{ lesson.date_indicated === 1 || lesson.manual !==1 ? lesson.receiving_date : ''}}</div>-->
                    <div class="appTable-col appUserLessons-date">
                        <flat-pickr :config="flatpickrConfig" v-model="lesson.receiving_date"></flat-pickr>
                    </div>
                    <div class="appTable-col appUserLessons-acarya">
                        <div class="appUserLessons-acaryaText">
                            <object-dropdown class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto dhrtDropdown-menuAlignmentLeft"
                                             v-model="lesson.teacher"
                                             :options='acaryas'
                                             label="name"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" @click="save()">{{ __('Save') }}
            </div>

            </div>
        </div>
        <modal-window id="appUserLessons-success" v-if="saved" :buttonList="['Ok']" nScroll @close="saved = false"
                      @ok="saved = false" :windowName="__('Lessons')">
            <div class="appForm-group">
                <div class="appModal-confirm">
                    {{ __('Data saved successfully') }}
                </div>
            </div>
        </modal-window>

    </div>
    <div class="appUserLessons-none" v-else-if="ready">{{ __('You didn\'t get any lessons yet') }}. {{ __('You may leave lesson request') }}<a href="/user/request">{{ __('here') }}</a></div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js'

    let moment = require('moment');
    export default {
        components: {flatPickr},

        props: ['userId'],

        data() {
            return {
                lessons: [],
                ready: null,
                flatpickrConfig: {
                    disableMobile: "true",
                    dateFormat: "Y-m-d H:i:S",
                    altInput: true,
                    altFormat: 'd-m-y',
                    maxDate: moment.now(),
                    locale: 'ru'
                },
                acaryas: [],
                saved: false,
                am: false
            }
        },

        mounted() {
            this.am = $('html').attr('data-am') === "1";
            this.getLessons();
        },

        methods: {
            getLessons() {
                axios.get('/user-meditation-lessons').then(response => {
                    this.lessons = response.data.lessons;
                    this.acaryas = response.data.acaryas;
                    this.ready = 1;
                });
            },

            save() {
                axios.put('/save-user-lessons', {lessons: this.lessons}). then( response => {
                    this.saved = true;
                });
            },

            goToProfile() {
                window.location = "/profile";
            }
        }
    }
</script>
