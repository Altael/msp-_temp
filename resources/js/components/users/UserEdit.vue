<template>
    <modal-window id="appUserModal" v-if="user" :buttonList="['Close', 'Save']" @close="close" @save="save" :windowName="user.name">

        <div class="appForm-group">
            <div class="appForm-groupTitle">{{ __('Alias') }}</div>
            <input type="text" class="appForm-input" v-model="user.unit_alias">
        </div>
        <div class="appForm-group">
            <div class="appForm-groupTitle">{{ __('Status') }}</div>
            <multiselect
                v-model="user.status"
                :options="statuses"
                :label="'name_' + locale"
                track-by="id"
            />
        </div>
        <div class="appForm-group">
            <div class="appForm-groupTitle">{{ __('Phone') }}</div>
            <input type="text" class="appForm-input" v-model="user.phone_system">
        </div>
        <div class="appForm-group">
            <div class="appForm-groupTitle">{{ __('Email') }}</div>
            <input type="text" class="appForm-input" v-model="user.email_system">
        </div>
        <div class="appForm-group">
            <div class="appForm-groupTitle">{{ __('Telegram') }}</div>
            <input type="text" class="appForm-input" v-model="user.telegram_system">
        </div>

        <div class="appForm-group" v-if="admin">
            <div class="appForm-groupTitle">{{ __('Roles') }}</div>
            <div class="dhrtCheckbox" v-for="role of roles">
                <label>
                    <input type="checkbox" class="dhrtCheckbox-noView" v-model="user.roles" :value="role">
                    <span class="dhrtCheckboxView"></span>
                    <div class="appProfile-agreement">
                        {{ role.name }}
                    </div>
                </label>
            </div>
        </div>

        <div class="appForm-group" v-if="helper && admin">
            <div class="appForm-groupTitle">{{ __('Acarya assistant') }}</div>
            <multiselect
                    :multiple="true"
                    v-model="user.acaryas"
                    :options="acaryas"
                    label="name"
                    track-by="id"
            ></multiselect>
            <!--<div class="dhrtCheckbox">
                <label>
                    <input type="checkbox" class="dhrtCheckbox-noView" v-model="isTemporaryHelper">
                    <span class="dhrtCheckboxView"></span>
                    <span>{{ __('Temporary helper') }}</span>
                </label>
            </div>-->
            <!--<flat-pickr :config="flatPickrConfig" v-model=""></flat-pickr>-->
        </div>

        <div class="appForm-group" v-if="curator && admin">
            <div class="appForm-groupTitle">{{ __('Curator for') }}</div>
            <multiselect
                :multiple="true"
                v-model="user.dioceses"
                :options="dioceses"
                label="name"
                track-by="id"
            ></multiselect>
        </div>

        <div class="appForm-group">
            <div class="appForm-groupTitle">{{ __('Change unit') }}</div>
            <multiselect
                :multiple="false"
                :allow-empty="false"
                v-model="user.unit"
                :options="area_units"
                label="name"
                track-by="id"
            ></multiselect>
        </div>

        <div class="appForm-group">
            <div class="appForm-groupTitle">{{ __('Notes') }}</div>
            <textarea class="appForm-textarea" :placeholder="__('Notes about user')" v-model="user.notes"></textarea>
        </div>
    </modal-window>
</template>

<script>

    import Multiselect from 'vue-multiselect'
    import Textarea from "../../../../vue/src/views/forms/form-elements/textarea/Textarea";
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js'

    export default {
        components: { Multiselect, Textarea, flatPickr },

        props: {
            userId: {
                type: Number
            },
            admin: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                user: null,
                //isTemporaryHelper: null,
                roles: [],
                acaryas: [],
                statuses: [],
                dioceses: [],
                locale: 'en',

                flatPickrConfig: {

                },
                area_units: []
            };
        },

        mounted() {
            this.getData();
            this.getStatuses();
            this.getDioceses();
        },

        watch: {
            helper(state) {
                if (!state && this.user.acaryas.length) {
                    this.user.acaryas = [];
                }
            }
        },

        computed: {
            helper() {
                return this.user && this.user.roles.some(role => role.slug === 'helper');
            },

            curator() {
                return this.user && this.user.roles.some(role => role.slug === 'curator');
            }
        },

        methods: {
            close() {
                $(this.$el).modal('hide');
                this.$emit('close');
            },

            getData() {
                axios.get('/api/users/' + this.userId).then(response => {
                    this.user = response.data.data;
                    this.roles = response.data.meta.editable_roles;
                    this.acaryas = response.data.meta.acaryas;
                    this.area_units = response.data.meta.area_units;
                });
            },

            getStatuses() {
                axios.get('/get-statuses').then(response => {
                    this.statuses = response.data.statuses;
                    this.locale = response.data.locale;
                });
            },

            getDioceses() {
                axios.get('/api/dioceses').then(response => {
                    this.dioceses = response.data.data;
                });
            },

            save() {
                axios.put('/api/users/' + this.userId, {
                    data: this.user
                }).then(response => {
                    this.$nextTick(() => {
                        this.close();
                    });
                });
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
