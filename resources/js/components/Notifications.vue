<template>
    <form v-if="geo">
        <div class="form-group">
            <label>{{ __('Object') }}</label>
            <input type="text" class="form-control" v-model="geo.name" readonly disabled>
        </div>
        <div class="form-group">
            <label>Роли</label>
            <multiselect
                :multiple="true"
                v-model="message.roles"
                :options="roles"
                label="name"
                track-by="id"
            ></multiselect>
        </div>
        <div class="form-group">
            <label>{{ __('Message') }}</label>
            <textarea class="form-control" v-model="message.text"></textarea>
        </div>
        <div class="form-group">
            <input type="button" class="btn btn-primary" @click="sendMessage" :value="__('Send')">
        </div>
    </form>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: { Multiselect },

        props: ['type', 'item'],

        data() {
            return {
                geo: null,
                roles: [],
                message: {
                    text: '',
                    roles: []
                }
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {
                axios.get('/notifications?json', {params: {type: this.type, item: this.item}}).then(response => {
                    this.geo = response.data.geo;
                    this.roles = response.data.roles;
                });
            },

            sendMessage() {
                axios.post('/notifications', {
                    type: this.type,
                    item: this.item,
                    message: this.message
                }).then(response => {
                    this.message.text = '';
                    this.message.roles = [];
                    this.$notify({text: `Done. ${response.data.users} users got that message.`});
                });
            }
        }
    }
</script>
