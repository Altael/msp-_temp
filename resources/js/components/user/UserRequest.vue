<template>
    <div class="appUserRequest" :class="{'amPage' : am}">
        <div :title="__('Backward')" class="amPage-title"  v-if="am" @click="goToProfile">
            {{ __('Getting or checking lessons') }}
        </div>
        <div class="appUserRequest-content">
            <div class="appUserRequest-finish" v-if="finish">
                <div class="appUserRequest-finishText">{{ __('Your request has been successfully saved') }}</div>
                <div class="appUserRequest-acaryaForeign" v-if="nextLesson !== 1">
                    <div class="appUserRequest-acaryaForeignNote">
                        {{ __('To get new lesson not from') }} {{ teacher ? __('acarya') + teacher : __('your acarya') }}, {{ __('you have to ask his permission') }}.
                    </div>
                </div>
                <div class="appUserRequest-requirements" v-if="reqs[nextLesson - 1] && lesson.type === 'get'">
                    <span>{{ __('To get requested lesson you have to fullfill your acarya requirements') }}:</span>
                    <span v-html="reqs[nextLesson - 1][locale]"></span>
                </div>

                <telegram-connect>
                    {{ __('To get notifications about request answer connect your telegram account. Upon your Telegram application opens don\'t forget to click on \'Start\' button.') }}
                </telegram-connect>

                <a href="/" class="appUserRequest-finishClose">
                    {{ __('Close') }}
                </a>
            </div>
            <template v-else-if="display">
                <div class="appUserRequest-first" v-if="!currentLesson && !lessonRequested && !missingLesson">
                    <div class="appUserRequest-head">{{ __('Request for the first lesson:') }}</div>
                    <div class="appUserRequest-firstHours" v-if="!$root.sadvipra">
                        <div class="appUserRequest-firstHoursQuestion">{{ __('How many hours did you meditate with the mantra “Baba Nam Kevalam”?') }}</div>
                        <input class="appUserRequest-firstHoursInput" type="number" v-model.number="initiation.hours">
                    </div>

                    <div class="appUserRequest-firstVariant">
                        <div class="appUserRequest-firstVariantQuestion">{{ __('Which option is right for you?') }}</div>
                        <div class="appUserRequest-firstVariantInput">
                            <div class="dhrtCheckbox">
                                <label>
                                    <input type="checkbox" class="dhrtCheckbox-noView"  value="wait" v-model="initiation.where" id="waitForAcarya">
                                    <span class="dhrtCheckboxView"></span>
                                    <span>{{ __('Wait for an alert when Dada/Didi arrives in my city or nearby cities') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="appUserRequest-firstVariantInput">
                            <div class="dhrtCheckbox">
                                <label>
                                    <input type="checkbox" class="dhrtCheckbox-noView" value="visit" v-model="initiation.where" id="visitAcarya">
                                    <span class="dhrtCheckboxView"></span>
                                    <span>{{ __('Come to Dada/Didi on your own, but by prior arrangement') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="appUserRequest-submit">
                        <div class="appUserRequest-btnSave" :class="{disabled: isSending}" @click="initiationRequest">{{ __('Save') }}</div>
                    </div>

                </div>

                <div class="appUserRequest-rest">
                    <template v-if="!lesson.type && !missingLesson && (currentLesson || lessonRequested === 1)">
                        <div class="appUserRequest-restBlock">
                            <div class="appUserRequest-head" v-if="!lessonRequested">{{ __('Ask for:') }}</div>
                            <div class="appUserRequest-restActions">
                                <template v-if="!lessonRequested && currentLesson && currentLesson<6">
                                    <div class="appUserRequest-restActionsButton"  @click.prevent="lesson.type = 'get'">{{ __('Lesson') }} {{ currentLesson+1 }}</div>
                                    <div class="appUserRequest-requirements" v-if="reqs[currentLesson + 1]">
                                        <div class="appUserRequest-requirementsTitle">{{ __('To get next lesson you have to fullfill your acarya requirements') }}:</div>
                                        <div v-html="reqs[currentLesson + 1][locale]"></div>
                                    </div>
                                </template>
                                <template v-if="lessonRequested">
                                    <div class="appUserRequest-restActionsNote" >{{ __('You already requested lesson') }} {{ lessonRequested }}</div>
                                    <div class="appUserRequest-requirements" v-if="reqs[lessonRequested - 1]">
                                        <div class="appUserRequest-requirementsTitle">{{ __('To get next lesson you have to fullfill your acarya requirements') }}:</div>
                                        <div v-html="reqs[lessonRequested - 1][locale]"></div>
                                    </div>
                                </template>
                                <div class="appUserRequest-restActionsButton" v-if="currentLesson > 0" @click.prevent="lesson.type = 'check'">{{ __('Lesson check') }}</div>
                            </div>
                        </div>
                        <div class="appUserRequest-restBlock">
                            <div class="appUserRequest-head" v-if="activeRequests.length">{{ __('Your active requests') }}:</div>
                            <div class="appUserRequest-restHistory">
                            <span class="appUserRequest-restHistoryItem" v-for="request of activeRequests">
                                <template v-if="request.type === 'get'">{{ __('Getting lesson') }}</template>
                                <template v-if="request.type === 'check'">{{ __('Check lesson') }}</template>
                                {{ request.lesson }}.&nbsp;
                                {{ __('Request date') }}: {{ dateFormat(request.created_at) }}

                            </span>
                            </div>
                        </div>
                    </template>
                    <template v-if="lesson.type">
                        <div class="appUserRequest-head">
                            <!--<div v-if="lesson.type === 'get'">{{ __('I want to get') }}</div>-->
                            <div v-if="lesson.type === 'check'">{{ __('I want to check') }}</div>
                        </div>
                        <template v-if="lesson.type === 'check'">
                            <div class="dhrtCheckbox" :class="{disabled : isAsked(1)}">
                                <label>
                                    <input type="checkbox" class="dhrtCheckbox-noView" :disabled="isAsked(1)" :value="1"  v-model="lesson.lessons" id="lesson-1">
                                    <span class="dhrtCheckboxView"></span>
                                    <span>{{ __('First lesson') }}</span>
                                </label>
                            </div>

                            <div class="dhrtCheckbox" v-if="currentLesson>1" :class="{disabled : isAsked(2)}">
                                <label>
                                    <input type="checkbox" class="dhrtCheckbox-noView" :disabled="isAsked(2)" :value="2" v-model="lesson.lessons" id="lesson-2">
                                    <span class="dhrtCheckboxView"></span>
                                    <span>{{ __('Second lesson') }}</span>
                                </label>
                            </div>

                            <div class="dhrtCheckbox" v-if="currentLesson>2" :class="{disabled : isAsked(3)}">
                                <label>
                                    <input type="checkbox" class="dhrtCheckbox-noView" :disabled="isAsked(3)" :value="3" v-model="lesson.lessons" id="lesson-3">
                                    <span class="dhrtCheckboxView"></span>
                                    <span>{{ __('Third lesson') }}</span>
                                </label>
                            </div>

                            <div class="dhrtCheckbox" v-if="currentLesson>3" :class="{disabled : isAsked(4)}">
                                <label>
                                    <input type="checkbox" class="dhrtCheckbox-noView" :disabled="isAsked(4)" :value="4" v-model="lesson.lessons" id="lesson-4">
                                    <span class="dhrtCheckboxView"></span>
                                    <span>{{ __('Fourth lesson') }}</span>
                                </label>
                            </div>

                            <div class="dhrtCheckbox" v-if="currentLesson>4" :class="{disabled : isAsked(5)}">
                                <label>
                                    <input type="checkbox" class="dhrtCheckbox-noView" :disabled="isAsked(5)" :value="5" v-model="lesson.lessons" id="lesson-5">
                                    <span class="dhrtCheckboxView"></span>
                                    <span>{{ __('Fifth lesson') }}</span>
                                </label>
                            </div>

                            <div class="dhrtCheckbox" v-if="currentLesson>5" :class="{disabled : isAsked(6)}">
                                <label>
                                    <input type="checkbox" class="dhrtCheckbox-noView" :disabled="isAsked(6)" :value="6" v-model="lesson.lessons" id="lesson-6">
                                    <span class="dhrtCheckboxView"></span>
                                    <span>{{ __('Sixth lesson') }}</span>
                                </label>
                            </div>

                            <div class="appUserRequest-btn">
                                <div class="appUserRequest-btnBack" @click="lesson.type=null">{{ __('Back') }}</div>
                                <div class="appUserRequest-btnSave" :class="{disabled: !lesson.lessons.length || isSending}" @click="lessonRequest">{{ __('Save') }}</div>
                            </div>
                        </template>
                    </template>
                </div>

                <template v-if="currentLesson < 6 && !missingLesson && !($root.sadvipra && currentLesson === 0)">
                    <div class="appUserRequest-restActions">
                        <div class="appUserRequest-restActionsButton" @click.prevent="missingLesson = true">{{ __('I have unregistered lessons') }}</div>
                    </div>
                </template>

                <user-missing-lessons v-if="missingLesson" user-id="userId"></user-missing-lessons>
                <!--<user-missing-lessons-am v-if="missingLesson && am" ></user-missing-lessons-am>-->
            </template>
        </div>

    </div>
</template>

<script>
    let moment = require('moment');
    import Multiselect from 'vue-multiselect'
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js'
    export default {
        props: ['userId', 'locale', 'sex', 'am'],
        components: {Multiselect, flatPickr},

        data() {
            return {
                currentLesson: null,
                missingLesson: false,
                acaryas: [],

                availableLessons: [],

                datePickerConfig: {
                    disableMobile: "true",
                    altInput: true,
                    altFormat: 'd-m-y',
                    dateFormat: "Y-m-d",
                    locale: 'ru',
                    maxDate: moment.now()
                },

                initiation: {
                    hours: 0,
                    where: []
                },

                lesson: {
                    lessons: [],
                    type: null
                },

                activeRequests: [],
                reqs: [],
                teacher: null,
                display: 0,
                isUkraine: false,

                finish: false,

                isSending: null,
                am: false
            }
        },

        mounted() {
            this.am = $('html').attr('data-am') === "1";
            this.getLesson();
        },

        computed: {
            nextLesson() {
                return this.currentLesson + 1;
            },

            lessonRequested() {
                let lesson = null;

                this.activeRequests.map(request => {
                    if (request.type === 'get') {
                        lesson = request.lesson;
                    }
                });

                return lesson;
            }
        },

        watch: {
            'lesson.type': function (type) {
                if (type === 'get') {

                    this.lesson.lessons.push(this.nextLesson);

                    this.$nextTick(() => {
                        this.lessonRequest();
                    });
                }
            }
        },

        methods: {
            getLesson() {
                axios.get('/user-meditation-lesson').then(response => {
                    this.currentLesson = response.data.lastUserLesson;
                    this.$nextTick(() => {
                        for(let i = this.currentLesson+1; i<=6; i++){
                            this.availableLessons.push(i);
                        }
                    });

                    this.activeRequests = response.data.activeUserRequests;
                    this.reqs = response.data.reqs;
                    if(response.data.missingLessonRequest) this.missingRequest = response.data.missingLessonRequest;

                    this.acaryas = response.data.acaryas;
                    this.acaryas.push({
                        id: null,
                        name: this.__("My acarya is not on the list")
                    });
                    this.teacher = response.data.teacher;
                    this.isUkraine = response.data.isUkraine;
                    this.display = 1;
                });
            },

            dateFormat(date) {
                return moment(date).format('DD.MM.YY');
            },

            initiationRequest() {
                if(this.isSending) return;
                this.isSending = 1;
                axios.post('/lesson-request', {
                    type: 'get',
                    lessons: [1],
                    meditation_hours: this.initiation.hours
                }).then(response => {
                    if (response.data.result) {
                        this.finish = true;
                    }
                    this.isSending = null;
                });
            },

            isAsked(lesson) {
                for(let i=0; i<this.activeRequests.length; i++) {
                    if(this.activeRequests[i].lesson === lesson){
                        return true;
                    }
                }
                return false;
            },

            lessonRequest() {
                if(this.lesson.type === 'check' && !this.lesson.lessons.length) return;
                if(this.isSending) return;
                this.isSending = 1;
                axios.post('/lesson-request', {
                    type: this.lesson.type,
                    lessons: this.lesson.lessons,
                    meditation_hours: this.initiation.hours
                }).then(response => {
                    if (response.data.result) {
                        this.finish = true;
                    }
                    this.isSending = null;
                });
            },

            goToProfile() {
                window.location = "/profile";
            }
        }
    }
</script>
