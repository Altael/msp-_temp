<template>
    <div class="amUnitStatistics">
        <div :title="__('Profile')" class="amPage-title"  @click="goToProfile">
            {{ entity === 'unit' ? __('Unit') : __('Bhukti') }} {{ __('Statistics') }}
        </div>
        <div class="appStatistics-btnGroupForm">
            <div class="appStatistics-btnGroup">
                <div class="appStatistics-btn" :class="{'active': period === 'day'}"
                     @click="period = 'day'">{{ __('Day') }}
                </div>
                <div class="appStatistics-btn" :class="{'active': period === 'week'}"
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
                <div class="appStatistics-formGroup appStatistics-formGroupFrom">
                    <label>{{ __('From') }}</label>
                    <flat-pickr :key="start"
                                v-model="start"
                                :config="{maxDate: end, locale: 'ru'}"
                                placeholder="Select date"
                                name="date">
                    </flat-pickr>
                </div>
                <div class="appStatistics-formGroup">
                    <label>{{ __('To') }}</label>
                    <flat-pickr :key="end"
                                v-model="end"
                                :config="{minDate: start, locale: 'ru'}"
                                placeholder="Select date"
                                name="date">
                    </flat-pickr>
                </div>
            </div>
        </div>
        <div class="amUnitStatistics-body">
            <div class="amUnitStatistics-area" v-for="(district, district_name) of districts">
                    <div class="amUnitStatistics-areaName">{{ district_name }}</div>
                    <div class="amUnitStatistics-areaInfo">
                        <div class="amUnitStatistics-areaInfoMembers">
                            <div class="amUnitStatistics-areaInfoLine">{{ __('Unique') }} {{ __('Initiated') }} {{ __('Members') }} - {{ district.unique_ini }}</div>
                            <div class="amUnitStatistics-areaInfoLine">{{ __('Unique') }} {{ __('Not') }} {{ __('Initiated') }} {{ __('Members') }} - {{ district.unique_not_ini }}</div>
                            <div class="amUnitStatistics-areaInfoLine">{{ __('Active') }} {{ __('Initiated') }} {{ __('Members') }} - {{ district.active_ini }}</div>
                            <div class="amUnitStatistics-areaInfoLine">{{ __('Active') }} {{ __('Not') }} {{ __('Initiated') }} {{ __('Members') }} - {{ district.active_not_ini }}</div>
                        </div>
                        <template v-if="district.events">
                            <div class="amUnitStatistics-events">
                                <div class="amUnitStatistics-eventsHead">{{ __('Bhukti') }} {{ __('Events') }}:</div>
                                <div class="amUnitStatistics-eventsList">
                                    <div class="amUnitStatistics-eventsListGroup" v-for="(event_group, event_name) in district.events">
                                        <div class="amUnitStatistics-eventsListGroupHead" :ref="district_name + event_name">
                                            {{ event_name }} - {{ event_group.length }}
                                        </div>
                                        <div class="amUnitStatistics-eventsListGroupBody">
                                            <div v-for="event in event_group">
                                                <div class="amUnitStatistics-eventsListItemHead">{{ event.unit }} - {{ dateFormat(event.date) }} - {{ event.program }}</div>
                                                <div class="amUnitStatistics-eventsListItemBody">
                                                    <div class="amUnitStatistics-eventsListItemBodyLine">{{ __('Initiated') }} {{ __('Members') }} - {{ event.initiated_members }}</div>
                                                    <div class="amUnitStatistics-eventsListItemBodyLine">{{ __('Not') }} {{ __('Initiated') }} {{ __('Members') }} - {{ event.not_initiated_members }}</div>
                                                    <div class="amUnitStatistics-eventsListItemBodyLine">{{ __('Initiated') }} {{ __('Guests') }} - {{ event.initiated_guests }}</div>
                                                    <div class="amUnitStatistics-eventsListItemBodyLine">{{ __('Not') }} {{ __('Initiated') }} {{ __('Guests') }} - {{ event.not_initiated_guests }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="amUnitStatistics-nan">
                                {{ __('No records for the chosen period') }}
                            </div>
                        </template>
                    </div>
                    <div class="amUnitStatistics-areaBody">
                        <div class="amUnitStatistics-areaBodyUnit" v-for="(unit, unit_name) of district.units">
                            <div class="amUnitStatistics-areaBodyUnitName">{{ unit_name }}</div>
                            <div class="amUnitStatistics-areaBodyUnitInfo">
                                <div class="amUnitStatistics-areaBodyUnitInfoActive">
                                    {{ __('Activity period') }} - {{ unit.activity_period }} {{ __('days') }}
                                    <div @click="settings_id = unit.id">
                                        {{ __('Edit') }}
                                    </div>
                                </div>
                                <div class="amUnitStatistics-general">
                                    <div class="amUnitStatistics-generalLine" v-if="unit.events">{{ __('Unique') }} {{ __('Initiated') }} {{ __('Members') }} - {{ unit.unique_ini }}</div>
                                    <div class="amUnitStatistics-generalLine" v-if="unit.events">{{ __('Unique') }} {{ __('Not') }} {{ __('Initiated') }} {{ __('Members') }} - {{ unit.unique_not_ini }}</div>
                                    <div class="amUnitStatistics-generalLine">{{ __('Active') }} {{ __('Initiated') }} {{ __('Members') }} - {{ unit.active_ini }}</div>
                                    <div class="amUnitStatistics-generalLine">{{ __('Active') }} {{ __('Not') }} {{ __('Initiated') }} {{ __('Members') }} - {{ unit.active_not_ini }}</div>
                                </div>
                                <template v-if="unit.events">
                                    <div class="amUnitStatistics-events">
                                        <div class="amUnitStatistics-eventsHead">{{ __('Unit') }} {{ __('Events') }}:</div>
                                        <div class="amUnitStatistics-eventsList">
                                            <div class="amUnitStatistics-eventsListGroup" v-for="(event_group, event_name) in unit.events">
                                                <div class="amUnitStatistics-eventsListGroupHead" :ref="district_name + unit_name + event_name">
                                                    {{ event_name }} - {{ event_group.length }}
                                                </div>
                                                <div class="amUnitStatistics-eventsListGroupBody">
                                                    <div v-for="event in event_group">
                                                        <div class="amUnitStatistics-eventsListItemHead">{{ dateFormat(event.date) }} - {{ event.program }}</div>
                                                        <div class="amUnitStatistics-eventsListItemBody">
                                                            <div class="amUnitStatistics-eventsListItemBodyLine">{{ __('Initiated') }} {{ __('Members') }} - {{ event.initiated_members }}</div>
                                                            <div class="amUnitStatistics-eventsListItemBodyLine">{{ __('Not') }} {{ __('Initiated') }} {{ __('Members') }} - {{ event.not_initiated_members }}</div>
                                                            <div class="amUnitStatistics-eventsListItemBodyLine">{{ __('Initiated') }} {{ __('Guests') }} - {{ event.initiated_guests }}</div>
                                                            <div class="amUnitStatistics-eventsListItemBodyLine">{{ __('Not') }} {{ __('Initiated') }} {{ __('Guests') }} - {{ event.not_initiated_guests }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="amUnitStatistics-nan">
                                        {{ __('No records for the chosen period') }}
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <fs-modal-window v-if="settings_id" id="amStatisticsPageModal-settings" @close="close"
                         @cancel="close" :windowName="__('Unit settings')">
            <settings-panel @saved="close" entity="unit" :id="settings_id"></settings-panel>
        </fs-modal-window>
    </div>
</template>
<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import moment from 'moment';

    export default {
        props: ['entity'],

        components: {flatPickr},

        data() {
            return {
                districts: [],
                settings_id: null,

                period: 'month',
                start: moment().startOf('month').format('YYYY-MM-DD'),
                end: moment().endOf('month').format('YYYY-MM-DD')
            }
        },

        watch: {
            period(val) {
                if (val !== 'custom') {
                    this.start = moment().startOf(val).format('YYYY-MM-DD');
                    this.end = moment().endOf(val).format('YYYY-MM-DD');
                }
            },
            dates(val) {
                this.getData();
            }
        },

        mounted() {
            this.getData();
        },

        computed: {
            dates() {
                return this.start+this.end;
            }
        },

        methods: {
            getData() {
                axios.get('/statistics/units', {params: {start: this.start, end: this.end, entity: this.entity}}).then(response => {
                    this.districts = response.data.districts;
                });
            },

            dateFormat(date) {
                return moment(date).format('DD.MM.YYYY')
            },

            goToProfile() {
                window.location = "/profile";
            },

            close() {
                this.settings_id = null;
                this.getData();
            }
        }
    }
</script>
