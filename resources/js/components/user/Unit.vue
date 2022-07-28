<template>
    <div class="amUnit-content" :class="{'amPage' : am}" v-show="unit">
        <template v-if="unit">
            <div :title="__('Backward')" class="amPage-title" v-if="am" @click="goToProfile">
                {{ __('Unit') }} {{ unit.name }}
            </div>
            <!--<div class="amUnit-motd" v-html="unit['welcome_page_' + lang]"></div>-->
            <div class="amUnit-tools">
                <div class="appPageTools-total">
                    <template v-if="secretary || programmer">{{ __('Total') }}: {{ total }} {{ __('users filtered out of') }} {{ unfiltered }}</template>
                </div>
                <div class="amUnit-toolbar">
                    <div class="amUnit-toolbarBtn" v-if="secretary || programmer" @click="create_new_user()" :title="__('Add new member to your unit')">
                        <span class="appIcons msppIcons-user-plus"></span>
                    </div>
                    <div class="amUnit-toolbarBtn" v-if="secretary || programmer" @click="statusesFilter = true" :title="__('Open statuses filter')">
                        <span class="appIcons msppIcons-filter"></span>
                    </div>
                    <a class="amUnit-toolbarBtn" href="/unit-programs" :title="__('Unit programs')">
                        <span class="appIcons msppIcons-file-text"></span>
                    </a>
                    <div class="amUnit-toolbarBtn" @click="dc_settings = true" v-if="secretary" :title="__('Settings')">
                        <span class="appIcons msppIcons-settings"></span>
                    </div>
                </div>
            </div>
            <div class="amUnit-members" v-if="secretaries.length">
                <div class="amUnit-member" v-for="member of secretaries" @click="edit(member)">
                    <avatar class="amUnit-memberAvatar" :src="member.image ? member.image : '/images/no-avatar.jpg'" :id="member.id" :title="member.name"></avatar>
                    <div class="amUnit-memberInfo">
                        <div class="amUnit-memberNameSpiritual">{{ member.spiritual_name }}</div>
                        <div class="amUnit-memberName">{{ member.name }}</div>
                    </div>
                </div>

            </div>
            <hr v-if="secretaries.length">

            <div class="amUnit-members">
                <div class="amUnit-member" v-for="member of members" v-if="member" @click="edit(member)" :class="{'userInStealthMode': member.hide_from_unit}">
                    <avatar class="amUnit-memberAvatar" :src="member.image ? member.image : '/images/no-avatar.jpg'" :id="member.id" :title="member.name"></avatar>
                    <div class="amUnit-memberInfo">
                        <div class="amUnit-memberNameSpiritual">{{ member.spiritual_name }}</div>
                        <div class="amUnit-memberName">{{ member.name }} {{ member.unit_alias ? '(' + member.unit_alias + ')' : '' }}</div>
                    </div>
                </div>
            </div>
        </template>

        <fs-modal-window v-if="dc_settings" id="amUnit-dc" @close="close"
                         @cancel="close" @save="save" :buttonList="['Cancel', 'Save']"
                         :windowName="__('Settings')"  class="amModal">
            <settings-panel entity="unit"></settings-panel>
        </fs-modal-window>

        <fs-modal-window v-if="member_editor" id="amUnit-member" @close="close"
                         @cancel="close" @save="save" :buttonList="['Cancel', 'Save']"
                         :windowName="__('Unit member settings')"  class="amModal">
            <unit-user-settings @saved="getData(); member_editor = null" :member="member_editor"></unit-user-settings>
        </fs-modal-window>

        <statuses-filter @loaded="statusesLoaded = true" v-show="statusesFilter" @close="filters.statuses = statuses_temp; statusesFilter = false" v-model="statuses_temp"></statuses-filter>

    </div>
</template>

<script>
    export default {
        props: ['secretary', 'programmer'],

        data() {
            return {
                unit: null,
                lang: 'en',
                members: [],
                secretaries: [],
                dc_settings: false,
                statusesFilter: false,
                statusesLoaded: false,

                filters: {
                    statuses: []
                },
                statuses_temp: [],

                member_editor: null,
                user: null,
                total: 0,
                unfiltered: 0,

                am: false
            }
        },

        watch: {
            filters: {
                deep: true,
                handler() {
                    if(this.statusesLoaded) this.getData();
                }
            }
        },


        mounted() {
            this.am = $('html').attr('data-am') === "1";
            this.getData();
        },

        methods: {
            getData() {
                let params = {
                    statuses: this.filters.statuses.length ? this.filters.statuses : null
                };

                axios.get('/unit-info', {params: params}).then(response => {
                    this.unit = response.data.unit;
                    this.members = response.data.members;
                    this.secretaries = response.data.secretaries;
                    this.lang = response.data.lang;
                    this.total = response.data.total;
                    this.unfiltered = response.data.unfiltered;
                });
            },

            back() {
                window.history.back();
            },

            close() {
                this.dc_settings = false;
                this.member_editor = false;
                this.user = null;
            },

            save() {

            },

            edit(member) {
                if(this.secretary || this.programmer) this.member_editor = JSON.parse(JSON.stringify(member));
            },

            create_new_user() {
                this.member_editor = {
                    id: null,
                    fake: true,
                    status: {
                        name_ru: 'Юнит',
                        name_en: 'Unit',
                        name_uk: 'Юніт',
                        id: 1
                    }
                };
            },

            goToProfile() {
                window.location = "/profile";
            }
        }
    }
</script>
