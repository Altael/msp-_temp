<template>
    <div class="appUserRequest-miss">
        <div class="appUserRequest-finish" v-if="finish">
            <div class="appUserRequest-saveRequest">{{ __('Information about your lessons has been successfully saved') }}</div>
            <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave appUserRequest-missBack" @click="refresh">{{ __('Back') }}</div>
        </div>
        <template v-else-if="loaded">


            <template v-if="showFirstAcarya">
                <div class="appForm-group">
                    <div class="appForm-groupTitle appForm-mark">{{ __('Who gave you first lesson?') }}</div>
                    <div class="appProfile-acaryaFirst">
                        <div class="dhrtRadio appMissingLessongs-gender">
                            <label>
                                <input type="radio" class="dhrtRadio-noView" v-model="sex" value="male">
                                <span class="dhrtRadioView"></span>
                                <span>{{ __('Dada') }}</span>
                            </label>
                            <label>
                                <input type="radio" class="dhrtRadio-noView" v-model="sex" value="female">
                                <span class="dhrtRadioView"></span>
                                <span>{{ __('Didi') }}</span>
                            </label>
                        </div>
                        <div class="dhrtDropdownWrap">
                            <object-dropdown class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto dhrtDropdown-menuAlignmentLeft"
                                             v-model="missingRequest.acarya_first"
                                             :options='acaryas[sex]'
                                             label="name"
                            />
                        </div>
                    </div>

                </div>



                <div class="appForm-group" v-if="missingRequest.acarya_first.id === null">
                    <div class="appForm-groupTitle appForm-mark">{{ __('Write name of acarya who gave you first lesson') }}</div>
                    <input type="text" name="acarya_name" v-model="missingRequest.acarya_first_missing" class="appForm-input">
                </div>

                <div class="appForm-group ">
                    <div class="appForm-groupTitle">{{ __('When did you get first lesson') }} ({{ __('at least approximately') }})</div>
                    <div class="appProfile-initiationDate">
                        <flat-pickr :config="datePickerConfig" class="appForm-input" v-model="missingRequest.initiation_date"></flat-pickr>
                    </div>
                </div>

                <div class="dhrtCheckbox" v-if="!currentLesson">
                    <label>
                        <input type="checkbox" class="dhrtCheckbox-noView" v-model="missingRequest.acarya_changed">
                        <span class="dhrtCheckboxView"></span>
                        <span>{{ __('Now i have different acarya') }}</span>
                    </label>
                </div>
            </template>

            <div class="appForm-group " v-if="(missingRequest.acarya_changed || currentLesson) && !dontShowCurrentAcarya">
                <div class="appForm-groupTitle appForm-mark">{{ __('Who is your acarya now?') }}</div>
                <object-dropdown class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto"
                                 v-model="missingRequest.acarya_now"
                                 :options='acaryas[sex]'
                                 label="name"
                />
            </div>

            <div class="appForm-group " v-if="missingRequest.acarya_now.id === null">
                <div class="appForm-groupTitle appForm-mark">{{ __('Write name of you current acarya') }}</div>
                <input type="text" name="acarya_name" v-model="missingRequest.acarya_missing" class="appForm-input">
            </div>

            <div class="appForm-group">
                <div class="appForm-groupTitle appForm-mark">{{ __('Choose your lessons please') }}</div>
                <div class="dhrtCheckbox"><label><input type="checkbox" class="dhrtCheckbox-noView" v-model="missingRequest.lessons" @click="lessonsCalc(1)" :value="1"><span class="dhrtCheckboxView"></span><span>{{ __('1 - Iishvara Pranidhana') }}</span></label></div>
                <div class="dhrtCheckbox"><label><input type="checkbox" class="dhrtCheckbox-noView" v-model="missingRequest.lessons" @click="lessonsCalc(2)" :value="2"><span class="dhrtCheckboxView"></span><span>{{ __('2 - Madhuvidya') }}</span></label></div>
                <div class="dhrtCheckbox"><label><input type="checkbox" class="dhrtCheckbox-noView" v-model="missingRequest.lessons" @click="lessonsCalc(3)" :value="3"><span class="dhrtCheckboxView"></span><span>{{ __('3 - Tattva Dharana') }}</span></label></div>
                <div class="dhrtCheckbox"><label><input type="checkbox" class="dhrtCheckbox-noView" v-model="missingRequest.lessons" @click="lessonsCalc(4)" :value="4"><span class="dhrtCheckboxView"></span><span>{{ __('4 - Sadharana Pranayama') }}</span></label></div>
                <div class="dhrtCheckbox"><label><input type="checkbox" class="dhrtCheckbox-noView" v-model="missingRequest.lessons" @click="lessonsCalc(5)" :value="5"><span class="dhrtCheckboxView"></span><span>{{ __('5 - Cakra Shodhana') }}</span></label></div>
                <div class="dhrtCheckbox"><label><input type="checkbox" class="dhrtCheckbox-noView" v-model="missingRequest.lessons" @click="lessonsCalc(6)" :value="6"><span class="dhrtCheckboxView"></span><span>{{ __('6 - Guru Dhyana') }}</span></label></div>
            </div>



            <div class="dhrtModalWindow-footerButtons appUserRequest-btn">
            <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" :class="{disabled: !missingLessonRequests || isSending}" @click="sendMissingRequest">{{ __('Save') }}</div>
        </div>
        </template>
        <modal-window id="appMessingLessonsModal-error" class="appModal-warning" v-if="errors" :buttonList="['Cancel']" nScroll @close="closeErrors" @cancel="closeErrors" :windowName="__('Warning!!!')">
            <div class="appForm-group">
                <div class="appModal-confirm">
                    <template v-for="(error, name) in errors">
                        <div v-for="(errorText, id) in error">
                            {{ errorText }}
                        </div>
                    </template>
                </div>
            </div>
        </modal-window>
    </div>
</template>

<script>

    let moment = require('moment');
    import Multiselect from 'vue-multiselect'
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js'

    export default {
        props: ['userId'],
        components: {Multiselect, flatPickr},

        data() {
            return {
                errors: null,
                currentLesson: null,
                missingRequest: {
                    acarya_first: {
                        id: 0,
                        name: this.__('Choose one')
                    },
                    acarya_first_missing: '',
                    initiation_date: null,
                    acarya_changed: false,
                    acarya_now: {
                        id: 0,
                        name: this.__('Choose one')
                    },
                    acarya_missing: '',
                    lessons: []
                },

                acaryas: {
                    male: [],
                    female: []
                },
                activeRequests: [],
                missingLessonRequests: [],
                userLessonsReady: [],
                isSending: false,
                finish: false,
                loaded: 0,

                sex: 'male',

                datePickerConfig: {
                    disableMobile: "true",
                    altInput: true,
                    altFormat: 'd-m-y',
                    dateFormat: "Y-m-d",
                    locale: 'ru',
                    maxDate: moment.now()
                },
            }
        },

        mounted() {
            this.getLesson();
        },

        watch: {
            sex(newVal, oldVal) {
                this.setSex(newVal)
            }
        },

        methods: {
            setSex(sex) {
                axios.post('/set-sex', {sex: sex}).then( response => {

                });
            },

            sendMissingRequest() {
                if(this.isSending) return;
                this.isSending = true;
                this.missingRequest.hadLessons = this.userLessonsReady;
                axios.post('/missing-request', this.missingRequest).then(response => {
                    this.isSending = false;
                    this.finish = true;
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });
            },

            getLesson() {
                axios.get('/user-meditation-lesson').then(response => {
                    this.currentLesson = response.data.lastUserLesson;
                    this.missingRequest.lessons = response.data.userLessons;
                    this.missingRequest.acarya_now = response.data.current_acarya ? response.data.current_acarya : this.missingRequest.acarya_now;
                    this.userLessonsReady = JSON.parse(JSON.stringify(response.data.userLessons));
                    this.activeRequests = response.data.activeUserRequests;
                    if(response.data.missingLessonRequest) this.missingRequest = response.data.missingLessonRequest;
                    this.sex = response.data.sex;
                    if(response.data.acaryas.length)
                    response.data.acaryas.map(acarya => {
                        this.acaryas[acarya.sex].push(acarya);
                    });
                    this.acaryas['male'].push({
                        id: null,
                        name: this.__("My acarya is not on the list")
                    });
                    this.acaryas['female'].push({
                        id: null,
                        name: this.__("My acarya is not on the list")
                    });
                    this.loaded = 1;
                });
            },

            unavailableLesson(lesson) {
                return this.userLessonsReady.includes(lesson);
            },

            closeErrors() {
                this.errors = null;
                this.isSending = false;
            },

            refresh() {
                window.location.reload();
            },

            lessonsCalc(lesson) {
                if(!this.missingRequest.lessons.includes(lesson)) {
                    for(let i=1; i <= lesson; i++) {
                        if(!this.missingRequest.lessons.includes(i)) {
                            this.missingRequest.lessons.push(i);
                        }
                    }
                } else {
                    for(let i = lesson; i <= 6; i++) {
                        if(this.missingRequest.lessons.includes(i)) {
                            let index = this.missingRequest.lessons.indexOf(i);
                            this.missingRequest.lessons.splice(index, 1);
                        }
                    }
                }
            }
        },

        computed: {
            showFirstAcarya() {
                return this.missingRequest.lessons.includes(1) && !this.userLessonsReady.includes(1);
            },

            dontShowCurrentAcarya() {
                return !this.missingRequest.lessons.includes(1) && this.userLessonsReady.includes(1);
            }
        }
    }
</script>

<style>
    .placeholder {
        color: rgb(194, 198, 220);
    }
</style>
