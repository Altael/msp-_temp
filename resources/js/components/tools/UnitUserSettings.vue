<template>
    <div class="amUnitMemberSettings">
        <div class="amBlock">
            <div class="amUnitMemberSettings-mainInfo">
                <avatar class="appUnit-memberAvatar" :src="member.image ? member.image : '/images/no-avatar.jpg'" :title="member.name"></avatar>
                <div class="appUnit-memberInfo">
                    <div class="appUnit-memberNameSpiritual">{{ member.spiritual_name }}</div>
                    <div class="appUnit-memberName">{{ member.name }}</div>
                </div>
            </div>

        </div>
        <div class="amBlock">
            <div class="appForm-groupTitle">{{ __('Alias') }}</div>
            <input type="text" class="appForm-input" v-model="member.unit_alias" :placeholder="__('Alias')">
        </div>
        <div class="amBlock">
            <div class="appForm-groupTitle">{{ __('System telegram') }}</div>
            <input type="text" class="appForm-input" v-model="member.telegram_system" :placeholder="__('System telegram')">
        </div>
        <div class="amBlock">
            <div class="appForm-groupTitle">{{ __('System email') }}</div>
            <input type="text" class="appForm-input" v-model="member.email_system" :placeholder="__('System email')">
        </div>
        <div class="amBlock">
            <div class="appForm-groupTitle">{{ __('System phone') }}</div>
            <input type="text" class="appForm-input" v-model="member.phone_system" :placeholder="__('System phone')">
        </div>
        <div class="amBlock">
            <div class="appForm-groupTitle">{{ __('Notes') }}</div>
            <input type="text" class="appForm-input" v-model="member.notes" :placeholder="__('Notes')">
        </div>
        <div class="amBlock">
            <div class="appForm-groupTitle">{{ __('Unit status') }}</div>

            <multiselect
                v-model="member.status"
                :options="statuses"
                :label="'name_' + locale"
                track-by="id"
            />
        </div>
        <div class="amBlock amUnitMember-settingsProgrammer" v-if="!member.fake">
            <label class="dhrtSwitch textLeft">
                <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                       v-model="member.is_programmer">
                <span class="dhrtSwitchSpinner"></span>
                <span class="dhrtSwitchSpinnerText">{{ __('Can add programs') }}</span>
            </label>
        </div>
        <div class="amUnitMemberSettings-Footer">
            <div class="dhrtModalWindow-footerButton" @click="save">{{ __('Save') }}</div>
            <div class="dhrtModalWindow-footerButton" v-if="member.fake && member.id" @click="snap_user">{{ __('Delete') }}</div>
        </div>

    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect';

    export default {
        props: ['member'],

        components: {Multiselect},

        data() {
            return {
                locale: 'en',

                statuses: []
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {
                axios.get('/get-statuses').then(response => {
                    this.statuses = response.data.statuses;
                    this.locale = response.data.locale;
                });
            },

            save() {
                axios.post('/save-unit-user-settings', {member: this.member}).then(response => {
                    this.$emit('saved');
                });
            },

            snap_user() {
                axios.get('/destroy-user/' + this.member.id).then(response => {
                    this.$emit('saved');
                });
            }
        }
    }
</script>
