<template>
    <div class="amProfile-settings">
        <div class="amProfile-settingsTools" v-if="am">
            <lang-selector></lang-selector>
            <info id="amProfile-mainHelp" v-cloak :with-text="false" :with-video="true" title="How to register">
                <div class="iframeResponsive">
                    <iframe src="https://drive.google.com/file/d/1-10UgDHeW4oE2aQoGKE5xLrae1mvqu5f/preview"></iframe>
                </div>
            </info>
        </div>

        <div class="appProfile-infoMessage" v-if="profile && !registration">
            <span>{{ __('Please fill out your profile to continue!') }}</span>
        </div>
        <div class="appProfile" v-if="profile">
            <div class="appProfileCard">
                <avatar class="appProfile-avatar"
                        :src="profile.image ? profile.image : '/images/no-avatar.jpg'"></avatar>
                <div class="appProfileCard-name">
                    <div class="appProfileCard-nameSpirit">{{ profile.spiritual_name }}</div>
                    <div class="appProfileCard-nameCivil">{{ profile.first_name }} {{ profile.last_name }}</div>
                </div>

                <div class="appProfileCard-main">
                    <div class="appProfileCard-mainField">
                        <div class="appProfileCard-mainFieldName">{{ __('Role') }}</div>
                        <div class="appProfileCard-mainFieldValue">
                            <div v-for="role of roles" class="appProfileCard-mainFieldRole appBadge"
                                 :class="{'appBadge-acarya' : role.slug === 'acarya'}">{{ role.name }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="amProfileMenu" v-if="am">
                <div class="amProfileMenuGroup">
                    <a v-if="registered" class="amProfileMenuGroupItem" href="/user/missing-lessons">
                        <div>
                            <div class="appIcons msppIcons-lessons amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ __('Register lessons') }}</div>
                        </div>
                        <span class="appIcons msppIcons-chevron-right"></span>
                    </a>
                    <a v-if="registered" class="amProfileMenuGroupItem" href="/user/lessons">
                        <div>
                            <div class="appIcons msppIcons-sunrise amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ __('My lessons') }}</div>
                        </div>
                        <span class="appIcons msppIcons-chevron-right"></span>
                    </a>
                </div>
                <div class="amProfileMenuGroup">
                    <a class="amProfileMenuGroupItem" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div>
                            <div class="appIcons msppIcons-log-out amProfileMenuGroupItem-icon"></div>
                            <div>
                                <div class="amProfileMenuGroupItem-name">{{ __('Logout') }}</div>
                            </div>
                        </div>
                        <div class="appIcons msppIcons-chevron-right"></div>
                    </a>
                </div>
                <form id="logout-form" action="/logout" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            </div>

            <div class="appProfileInfo">
                <div class="appPageForm-header">
                    <div class="appPageForm-headerTitle">
                        <div class="appPageForm-headerTitleName">{{ __('Personal Data') }}</div>
                        <div class="appPageForm-headerTitleAddition">{{ __('You can view or edit your personal data') }}
                        </div>
                    </div>
                </div>
                <div class="appPageForm-body">
                    <div>
                        <div class="appForm-group appProfile-firstName">
                            <div class="appForm-groupTitle appProfile-mark">{{ __('First name') }}</div>
                            <input type="text" name="first_name" v-model="profile.first_name" class="appForm-input">
                        </div>
                        <div class="appForm-group appProfile-lastName">
                            <div class="appForm-groupTitle appProfile-mark">{{ __('Last name') }}</div>
                            <input type="text" name="last_name" v-model="profile.last_name" class="appForm-input">
                        </div>
<!--                        <div class="appForm-group appProfile-city">
                            <div class="appForm-groupTitle appProfile-mark">{{ __('City') }}</div>
                            <div class="appProfile-cityText">{{ __('Please, choose your city from dropdown list') }}
                            </div>
                            <input type="text" ref="adr" name="city" v-model="place" :placeholder="__('City')"
                                   class="appForm-input" @change="profile.place_id = null">
                            <input type="hidden" id="place" name="place_id" v-model="profile.place_id"
                                   class="appForm-input">
                        </div>-->
                        <div class="appForm-group appProfile-country">
                            <div class="appForm-groupTitle appProfile-mark">{{ __('Country') }}</div>
                            <input type="text" ref="country" name="country" v-model="profile.country" :placeholder="__('Country')" class="appForm-input">
                        </div>
                        <div class="appForm-group appProfile-region">
                            <div class="appForm-groupTitle appProfile-mark">{{ __('Region') }}</div>
                            <input type="text" ref="region" name="region" v-model="profile.region" :placeholder="__('Region')" class="appForm-input">
                        </div>
                        <div class="appForm-group appProfile-city">
                            <div class="appForm-groupTitle appProfile-mark">{{ __('City') }}</div>
                            <input type="text" ref="city" name="city" v-model="profile.city" :placeholder="__('City')" class="appForm-input">
                        </div>
                        <div class="dhrtCheckbox">
                            <label>
                                <input type="checkbox" class="dhrtCheckbox-noView" v-model="profile.hide_from_unit">
                                <span class="dhrtCheckboxView"></span>
                                <span>{{ __('Do not show me on the unit list') }}</span>
                            </label>
                        </div>
                        <div class="appForm-group appProfile-phone">
                            <div class="appForm-groupTitle appProfile-mark">{{ __('Phone') }}</div>
                            <input type="text" name="phone" v-model="profile.phone" class="appForm-input">
                        </div>
                        <div class="appForm-group appProfile-gender">
                            <div class="appForm-groupTitle">{{ __('Gender') }}</div>
                            <div class="dhrtRadio">
                                <label>
                                    <input type="radio" class="dhrtRadio-noView" v-model="profile.sex" value="male">
                                    <span class="dhrtRadioView"></span>
                                    <span>{{ __('Male') }}</span>
                                </label>
                                <label>
                                    <input type="radio" class="dhrtRadio-noView" v-model="profile.sex" value="female">
                                    <span class="dhrtRadioView"></span>
                                    <span>{{ __('Female') }}</span>
                                </label>
                            </div>
                        </div>
                        <mobile-connect v-if="registered" purpose="profile"></mobile-connect>
                        <div class="appProfile-englishTelegram">
                            <div class="appForm-group appProfile-english">
                                <label class="dhrtSwitch textLeft">
                                    <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                                           v-model="profile.english">
                                    <span class="dhrtSwitchSpinner"></span>
                                    <span class="dhrtSwitchSpinnerText">{{ __('I know english') }}</span>
                                </label>
                            </div>
                            <telegram-connect purpose="profile"></telegram-connect>
                        </div>
                    </div>
                    <div>
                        <!--<div class="appForm-group appProfile-middleName">
                            <div class="appForm-groupTitle">{{ __('Middle name') }}</div>
                            <input type="text" name="middle_name" v-model="profile.middle_name" class="appForm-input">
                        </div>-->
                        <div class="appForm-group appProfile-email">
                            <div class="appForm-groupTitle">{{ __('Email') }}</div>
                            <input type="text" name="email" v-model="profile.email" class="appForm-input">
                        </div>
                        <div class="appForm-group appProfile-acarya">
                            <div class="appForm-groupTitle">{{ __('Acarya') }}</div>
                            <object-dropdown class="withArrow arrowBold arrowSmall  dhrtDropdown-menuPositionDown dhrtDropdown-menuAlignmentLeft menuWidthAuto"
                                             v-model="acarya"
                                             :options='acaryas[profile.sex]'
                                             label="name"
                            />
                            <input class="appForm-input" v-if="acarya.id === null || profile.acarya" type="text" name="acarya" v-model="profile.acarya" :placeholder=" __('Name of acarya who gave you an initiation') ">
                        </div>
                        <div class="appForm-group appProfile-spiritualName">
                            <div class="appForm-groupTitle">{{ __('Spiritual name') }}</div>
                            <!--<multiselect
                                    v-model="spiritual_name"
                                    :options="spiritualNames"
                                    :label="lang"
                                    track-by="id"
                            />-->
                            <input type="text" name="spiritual_name" v-model="profile.spiritual_name"
                                   class="appForm-input">
                        </div>
                        <div class="appForm-group appProfile-profession">
                            <div class="appForm-groupTitle">{{ __('Profession') }}</div>
                            <input type="text" name="profession" v-model="profile.profession" class="appForm-input">
                        </div>
                        <div class="appForm-group appProfile-birthday">
                            <div class="appForm-groupTitle">{{ __('Birthday') }}</div>
                            <flat-pickr :config="datePickerConfig" class="appForm-input"
                                        v-model="profile.birthday"></flat-pickr>
                        </div>
                        <template v-if="registered">
                            <div class="dhrtCheckbox">
                                <label>
                                    <input type="checkbox" class="dhrtCheckbox-noView" v-model="profile.acarya_diary">
                                    <span class="dhrtCheckboxView"></span>
                                    <span>{{ __('I want my acarya to see my practice diary') }}</span>
                                </label>
                            </div>
                            <div class="appForm-group appProfile-diaryInfo">
                                <div class="appForm-groupRow">
                                    <div class="appForm-groupTitle">{{ __('Average diary points:') }}</div>
                                    <user-diary-info></user-diary-info>
                                </div>
                            </div>
                            <div class="appForm-group appProfile-fasting">
                                <div class="appForm-groupRow">
                                    <div class="appForm-groupTitle">{{ __('Fastings per month amount') }}:</div>
                                    <div class="appProfile-fastingItems dhrtRadio">
                                        <label>
                                            <input type="radio" class="dhrtRadio-noView" v-model="profile.fasting" :value="2">
                                            <span class="appProfile-fastingView dhrtRadioView"></span>
                                            <span class="appProfile-fastingValue">2 {{ __('times') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="dhrtRadio-noView" v-model="profile.fasting" :value="4">
                                            <span class="appProfile-fastingView dhrtRadioView"></span>
                                            <span class="appProfile-fastingValue">4 {{ __('times') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="appPageForm-footer">
                    <div class="appProfile-fieldMark appProfile-mark">{{ __('Fields marked with an asterisk are required') }}
                    </div>
                    <div class="appPageForm-footerBlock">
                        <div class="appProfile-eula">
                            <div class="dhrtCheckbox">
                                <label>
                                    <input type="checkbox" class="dhrtCheckbox-noView" v-model="profile.eula">
                                    <span class="dhrtCheckboxView"></span>
                                    <div class="appProfile-agreement">
                                        <span class="appProfile-mark">{{ __('I agree to the terms of participation in project') }}&nbsp;"{{ am ? 'Anandamarga.me' : 'Meditationsteps.Personal' }}"</span>
                                    </div>
                                </label>
                                <div class="appProfile-agreementDoc">
                                    <span>{{ __('Read the agreement') }}</span>
                                    <a :class="am ? 'amProfile-agreementLink' : 'appProfile-agreementLink'" href="/policy" :target="am ? '_self' : '_blank'">{{ __('here') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="appProfile-save">
                            <div class="appForm-button appForm-buttonMarga" @click="save">{{ __('Save') }}</div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <modal-window id="appProfileModal-success" v-if="done" :buttonList="['Ok']" nScroll @close="redirect()"
                      @ok="redirect()" :windowName="__('Profile')">
            <div class="appForm-group">
                <div class="appModal-confirm">
                    {{ __('Data saved successfully') }}
                </div>
            </div>
        </modal-window>
        <modal-window id="appUserProfileModal-error" class="appModal-warning" v-if="errors" :buttonList="['Cancel']"
                      nScroll @close="errors = null" @cancel="errors = null" :windowName="__('Warning!!!')">
            <div class="appForm-group">
                <div class="appModal-confirm">
                    <div>{{ __('Error has occured') }}:</div>
                    <template v-for="(error, name) in errors">
                        <div v-for="(errorText, id) in error">
                            {{ errorText }}
                        </div>
                    </template>
                </div>
            </div>
        </modal-window>
        <modal-window v-if="cityError" :buttonList="['Ok']" nScroll @close="closeCityModal" @ok="closeCityModal"
                      :windowName="__('Warning')">
            <div class="appForm-group">
                <div class="appModal-confirm">
                    {{ __('Only city accepted') }}
                </div>
            </div>
        </modal-window>
    </div>
</template>
<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js'
    import Multiselect from 'vue-multiselect'

    let moment = require('moment');

    export default {
        props: ['lang', 'app'],

        components: {
            flatPickr,
            Multiselect
        },

        data() {
            return {
                profile: null,
                place: null,
                roles: [],
                done: null,
                errors: null,
                cityError: null,

                acarya: {
                    id: 0,
                    name: this.__('Acarya"s name')
                },
                acaryas: {
                    male: [],
                    female: []
                },

                registration: null,

                spiritual_names: [],
                spiritual_name: null,
                datePickerConfig: {
                    disableMobile: "true",
                    altInput: true,
                    altFormat: 'd-m-y',
                    dateFormat: "Y-m-d",
                    locale: 'ru'
                },
                am: false,
                registered: false
            }
        },

        mounted() {
            this.getData();
            this.am = this.$root.am;
            this.registered = this.$root.registered;
            axios.post('/api/user-disable-name-notification').then(response => {

            });
        },

        watch: {
            page() {
                this.getData();
            },

            'profile.place': function (value) {
                if (value) {
                    this.place = value.name;
                }
            }
        },

        computed: {
            spiritualNames() {
                return this.spiritual_names.filter(name => {
                    return name.sex === this.profile.sex;
                });
            }
        },

        methods: {
            getData() {
                axios.get('/api/user-profile').then(response => {
                    this.profile = response.data.profile;
                    this.roles = response.data.roles;
                    this.registration = response.data.registration;
                    this.spiritual_names = response.data.spiritual_names;
                    this.acarya = response.data.acarya;

                    this.acaryas['male'] = [];
                    this.acaryas['female'] = [];
                    if(response.data.acaryas.length) {
                        response.data.acaryas.map(acarya => {
                            this.acaryas[acarya.sex].push(acarya);
                        });
                    }
                    this.acaryas['male'].push({
                        id: null,
                        name: this.__("My acarya is not on the list")
                    });
                    this.acaryas['female'].push({
                        id: null,
                        name: this.__("My acarya is not on the list")
                    });

                    /*this.$nextTick(() => {
                        this.init();
                    });*/
                });
            },

            cityModal() {
                this.cityError = 1;
            },

            closeCityModal() {
                this.cityError = null;
                this.profile.place_id = null
            },

            redirect() {
                if (!this.registration) window.location.assign("/");
                this.done = 0;
                this.getData();
            },

            save() {
                this.profile.teacher = this.acarya;

                axios.post('/api/user-profile', this.profile).then(response => {
                    this.done = 1;
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });

            },

            init() {
                let autocomplete = new google.maps.places.Autocomplete(this.$refs.adr, {
                    types: ['(cities)'],
                    fields: ['name', 'place_id', 'types']
                });

                autocomplete.addListener('place_changed', () => {
                    let address = autocomplete.getPlace();
                    console.log(address);
                    if (address.types.indexOf('locality') === -1) {
                        this.cityModal();
                    } else {
                        this.place = address.name;
                        this.profile.place_id = address.place_id;
                    }
                });
            }
        }
    }
</script>
