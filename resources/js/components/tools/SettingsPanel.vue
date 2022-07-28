<template>
    <div v-if="mounted" class="appSettings">

        <div class="appSettings-sanskrit" v-if="settings">
            <div class="amBlock-title appBlock-title">
                {{ __('Sanskrit settings') }}
            </div>
            <div class="appBlock-body">
                <action-dropdown class="dropdownLang" menuAlignmentLeft>
                    <template #label>
                        <img :src="'/images/' + settings.dc_main_lang + '.png'" height="20">
                        <span>{{ __('Translation language') }}</span>
                    </template>
                    <template #default><a class="dhrtDropdown-item" @click.prevent="settings.dc_main_lang = 'en'" v-if="settings.dc_main_lang !== 'en'">
                        <img src="/images/en.png" height="20">
                        <span>{{ __('English') }}</span>
                    </a>
                        <a class="dhrtDropdown-item" @click.prevent="settings.dc_main_lang = 'ru'" v-if="settings.dc_main_lang !== 'ru'">
                            <img src="/images/ru.png" height="20">
                            <span>{{ __('Russian') }}</span>
                        </a>
                        <a class="dhrtDropdown-item" @click.prevent="settings.dc_main_lang = 'uk'" v-if="settings.dc_main_lang !== 'uk'">
                            <img src="/images/uk.png" height="20">
                            <span>{{ __('Ukrainian') }}</span>
                        </a></template>
                </action-dropdown>
                <action-dropdown class="dropdownLang" menuAlignmentLeft>
                    <template #label>
                        <img :src="'/images/' + settings.dc_transcription_lang + '.png'" height="20">
                        <span>{{ __('Transcription language') }}</span>
                    </template>
                    <template #default>
                        <a class="dhrtDropdown-item" @click.prevent="settings.dc_transcription_lang = 'en'" v-if="settings.dc_transcription_lang !== 'en'">
                            <img src="/images/en.png" height="20">
                            <span>{{ __('English') }}</span>
                        </a>
                        <a class="dhrtDropdown-item" @click.prevent="settings.dc_transcription_lang = 'ru'" v-if="settings.dc_transcription_lang !== 'ru'">
                            <img src="/images/ru.png" height="20">
                            <span>{{ __('Russian') }}</span>
                        </a>
                        <a class="dhrtDropdown-item" @click.prevent="settings.dc_transcription_lang = 'uk'" v-if="settings.dc_transcription_lang !== 'uk'">
                            <img src="/images/uk.png" height="20">
                            <span>{{ __('Ukrainian') }}</span>
                        </a>
                    </template>
                </action-dropdown>
            </div>

            <template v-if="entity !== 'user'">
                <div class="appForm-group appProfile-gender">
                    <div class="appForm-groupTitle">{{ __('Amount of standard PS') }}</div>
                    <input type="number" v-model="settings.standard_samgiits_amount">
                </div>

                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Random or predefined list of PS') }}</div>
                    <div class="dhrtRadio">
                        <label>
                            <input type="radio" class="dhrtRadio-noView" v-model="settings.standard_samgiits_type" value="random">
                            <span class="dhrtRadioView"></span>
                            <span>{{ __('Random') }}</span>
                        </label>
                        <label>
                            <input type="radio" class="dhrtRadio-noView" v-model="settings.standard_samgiits_type" value="list">
                            <span class="dhrtRadioView"></span>
                            <span>{{ __('Predefined') }}</span>
                        </label>
                    </div>
                </div>

                <div class="appForm-group" v-if="settings.standard_samgiits_type === 'list'">
                    <div class="appForm-groupTitle">{{ __('List of predefined PS (order sensitive)') }}</div>
                    <template v-for="(samgiit, key) in settings.standard_samgiits_list">
                        <input type="number" v-model="settings.standard_samgiits_list[key]" style="display: block">
                    </template>
                </div>

            </template>
        </div>

        <div class="amSettings-unit appSettings-unit" v-if="entity !== 'user'">
            <div class="amBlock-title appBlock-title">
                {{ __('Unit settings') }}
            </div>

            <div class="amBlock appBlock">
                <div class="appForm-groupTitle">{{ __('Maximum days without activity to count a unit member as active') }}</div>
                <input type="number" v-model="settings.active_member_quota">
            </div>
            <div class="amBlock appBlock">
                    <div class="amButton appButton" @click="statusesFilter = true">{{ __('Default unit statuses to show') }}&nbsp;&gt;&gt;</div>

                    <statuses-filter v-show="statusesFilter" @close="statusesFilter = false, save()" v-model="settings.standard_statuses"></statuses-filter>
                </div>
        </div>



        <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" @click="save">
            {{ __('Save') }}
        </div>
    </div>
</template>
<script>
    export default {
        props: ['entity', 'tl', 'ml', 'id'],

        data() {
            return {
                settings: null,
                mounted: false,
                statusesFilter: false,

                need_to_save: false
            }
        },

        watch: {
            'settings.standard_samgiits_amount' (newVal) {
                if(this.entity !== 'user') this.settings.standard_samgiits_list.length = newVal;
            }
        },

        mounted() {
            this.getData();
        },

        computed: {
            samgiits_page() {
                return window.location.pathname === '/prabhat-samgiits';
            }
        },

        methods: {
            getData() {
                let params = {
                    id: this.id ? this.id : null
                };

                axios.get('/settings/' + this.entity, {params}).then(response => {
                    this.settings = response.data.settings;
                    this.mounted = true;

                    if(!this.settings.dc_transcription_lang) {
                        this.settings.dc_transcription_lang = 'ru';
                        this.need_to_save = true;
                    }

                    if(!this.settings.dc_main_lang) {
                        this.settings.dc_main_lang = 'ru';
                        this.need_to_save = true;
                    }

                    if(this.tl && (this.tl !== this.settings.dc_transcription_lang)) {
                        this.settings.dc_transcription_lang = this.tl;
                        this.need_to_save = true;

                    }

                    if(this.ml && (this.ml !== this.settings.dc_main_lang)) {
                        this.settings.dc_main_lang = this.ml;
                        this.need_to_save = true;
                    }

                    if(this.need_to_save) {
                        this.save();
                    }
                });
            },

            save() {
                axios.post('/settings/' + this.entity, {settings: this.settings}).then(response => {
                    this.$emit('saved');
                });
            }
        }
    }
</script>
