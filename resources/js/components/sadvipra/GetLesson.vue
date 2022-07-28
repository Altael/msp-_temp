<template>
    <div v-if="request" class="mfe-request">
        <template v-if="$root.user_info.call_requests && !$root.user_info.call_requests.includes('adequate-1')">
            <template v-if="page === 'request'" @click="back()">
                <div class="mfe-requestTitle" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="17.743" height="31.243" viewBox="0 0 17.743 31.243">
                        <g id="Сгруппировать_16213" data-name="Сгруппировать 16213" transform="translate(2.121 2.121)">
                            <line id="Линия_2" data-name="Линия 2" x1="13.5" y2="13.5" transform="translate(0)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="3"/>
                            <line id="Линия_3" data-name="Линия 3" x2="13.5" y2="13.5" transform="translate(0 13.5)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="3"/>
                        </g>
                    </svg>

                    <span>
                    Регистрация для связи с куратором
                </span>
                </div>
                <div class="mfe-requestNotice">
                    {{ __('Leave your contact (phone number and preferable messenger). Curator will answer your questions and will check if you are ready to get personal meditation lesson.') }}
                </div>
                <div class="mfe-requestForm">
<!--                    <div class="mfe-requestDatetime">
                        <div class="mfe-requestDate appForm-group">
                            <div class="appForm-groupTitle">{{ __('Date') }}</div>
                            <flat-pickr v-if="locale" :config="flatPickrConfig" v-model="request.date" :placeholder="__('Choose date')"></flat-pickr>
                        </div>
                        <div class="mfe-requestTime appForm-group">
                            <div class="appForm-groupTitle">{{ __('Time') }}</div>
                            <dropdown v-model="request.time"
                                      class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown dhrtDropdown-menuAlignmentLeft menuWidthAuto"
                                      :options="times"
                                      search
                            />
                        </div>
                    </div>-->
                    <div class="appForm-groupTitle">{{ __('Contacts') }}</div>
                    <div class="mfe-requestPhone">
                        <input class="appForm-input" type="text" v-model="request.phone" :placeholder="__('Your phone number')">
                    </div>
                    <div class="mfe-requestMessenger">
                        <dropdown :options="messengers" :placeholder="__('Preferable messenger')" v-model="request.messenger" class="withArrow arrowBold arrowSmall"></dropdown>
                    </div>
                    <div class="mfe-requestBtnWrapper">
                        <div class="mfe-requestBtn" :class="{disabled: !(request.messenger && request.phone)}" @click="saveRequest">
                            {{ __("Send request") }}
                        </div>
                    </div>

                </div>

            </template>
            <div v-if="page === 'confirm'" class="mfe-requested">
                <requested-image></requested-image>
                <div class="mfe-requestedThanks">Ваша заявка принята, спасибо</div>
                <div class="mfe-requestedNotice">Следите за сообщениями от своего куратора, постарайтесь не пропустить одно из важных событий в своей жизни!</div>
                <!--            <div>
                                <div>Видео о практике</div>
                            </div>
                            <div>Рава радио</div>-->
                <a href="/" class="mfe-requestedBtn back">
                    закрыть
                </a>
            </div>
        </template>
        <template v-else>
            <div class="mfe-requested">
                <requested-image></requested-image>
                <div class="mfe-requestedNotice">Ожидайте, когда с вами свяжутся. Если этого не произошло в течение 3-ёх рабочих дней после подачи заявки, то напишите в <a href="https://t.me/jyotindra" target="_blank">тех поддержку</a></div>
                <a href="/" class="mfe-requestedBtn back">
                    закрыть
                </a>
            </div>

        </template>
    </div>
</template>
<script>
    let moment = require('moment');
    import Multiselect from 'vue-multiselect'

    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js'
    import 'flatpickr/dist/l10n/uk.js'

    export default{
        components: {Multiselect, flatPickr},

        data() {
            return {
                saved_modal: false,
                request: {
                    date: null,
                    time: null,
                    phone: null,
                    messenger: null
                },
                call_request: null,

                times: [],

                messengers: {
                    telegram: this.__('Telegram'),
                    viber: this.__('Viber'),
                    whatsApp: this.__('WhatsApp')
                },

                flatPickrConfig: {
                    altInput: true,
                    altFormat: 'd F Y',
                    minDate: moment.now(),
                    disable: [],
                    disableMobile: true,
                    static: true,
                    locale: 'en'
                },

                page: 'request'
            }
        },

        mounted() {
            this.getData();

            let initial_hour = 9 - 3 + (moment().hours() - moment().utc().hours());

            this.times.push('--:--');

            for(let i = 0; i<9; i++) {
                let first_half = (initial_hour + i) + ':00-' + (initial_hour + i) + ':30';
                let second_half = (initial_hour + i) + ':30-' + ((initial_hour + i) + 1) + ':00';

                this.times.push(first_half);
                this.times.push(second_half);
            }
        },

        methods: {
            saveRequest() {
                let params = {
                    date: this.request.date,
                    time: this.times[this.request.time],
                    phone: this.request.phone,
                    messenger: this.request.messenger,
                    call: 'adequate-1'
                };

                axios.post('/save-call-request', params).then(response => {
                    this.page = 'confirm';
                });
            },

            getData() {
                axios.get('/user-info').then( response => {
                    if(response.data.phone) {
                        this.request.phone = response.data.phone;
                    }
                    if(response.data.telegram) {
                        this.request.messenger = 'telegram';
                    }
                });

                axios.get('/user-info').then( response => {
                    let request = response.data.requests.calls_details.find(request => {
                        return request.slug === 'adequate-1'
                    });

                    this.call_request = request ? moment(request.date).format('DD.MM HH:mm') : null;
                });
            },

            back() {
                this.link ? window.location.href = this.link : window.history.back();
            }
        },

        computed: {
            locale() {
                this.flatPickrConfig.locale = $('html').attr('lang');
                return $('html').attr('lang')
            }
        }
    }
</script>
