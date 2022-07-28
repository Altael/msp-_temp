<template>
    <div class="appRolesCheat">
        <div v-if="!showRolesCheat" @click.prevent="showRolesCheat = true" class="appRolesCheat-label">
            <span class="appIcons msppIcons-users"></span>
        </div>
        <modal-window v-if="showRolesCheat" @close="close" @cancel="close" @save="save" :buttonList="['Cancel', 'Save']" :windowName="__('Do some roles magic')">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Roles') }}</div>
                <div class="dhrtCheckbox" v-for="role of availableRoles">
                    <label>
                        <input type="checkbox" class="dhrtCheckbox-noView" v-model="userRoles" :value="role">
                        <span class="dhrtCheckboxView"></span>
                        <div class="appProfile-agreement">
                            {{ role.name }}
                        </div>
                    </label>
                </div>
            </div>
        </modal-window>
    </div>
</template>
<script>
    export default {
        props: ['id'],

        data() {
            return {
                showRolesCheat: false,
                availableRoles: [],
                userRoles: [],
                back: []
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            close() {
                this.showRolesCheat = false;
                this.userRoles = this.back;
            },

            save() {
                axios.post('/save-roles', {roles: this.userRoles}).then( response => {
                    window.location.reload();
                });
            },

            getData() {
                axios.get('/api/users/' + this.id).then(response => {
                    this.userRoles = response.data.data.full_roles;
                    this.back = response.data.data.full_roles;
                    this.availableRoles = response.data.meta.roles;
                });
            },
        }
    }
</script>
