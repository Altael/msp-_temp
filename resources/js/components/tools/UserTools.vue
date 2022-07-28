<template>
    <div class="appUser-tools" v-if="user">
        <a :href="'https://vk.com/id' + user.vk_id" :class="{'disabled': !user.vk_id}" target="_blank" class="appUser-toolsBtn vk">
            <span class="appIcons msppIcons-vk"></span>
        </a>
        <a class="appUser-toolsBtn appGEO-telegram" :class="{'disabled': !user.telegram_nickname}" target="_blank" :href="'https://t.me/' + user.telegram_nickname">
            <span  class="appIcons" :class="{'msppIcons-telegram-nobg': !user.telegram_nickname, 'appUser-telegramIcon msppIcons-telegram': user.telegram_nickname, 'appUser-telegramTrue': user.telegram || user.telegram_nickname, 'appUser-telegramFalse': !user.telegram}"></span>
        </a>
        <a :href="'tel:' + user.phone" class="appUser-toolsBtn phone" :title="user.phone">
            <span class="appIcon msppIcons-phone"></span>
        </a>
        <a :href="'mailto:' + user.email" class="appUser-toolsBtn email" :title="user.email">
            <span class="appIcon msppIcons-mail"></span>
        </a>
        <a @click.prevent="user_edit = true" class="appUser-toolsBtn edit">
            <span class="appIcon msppIcons-edit"></span>
        </a>
        <a @click.prevent="details(user.id)" class="appUser-toolsBtn view">
            <span class="appIcon msppIcons-eye"></span>
        </a>

        <user-edit :admin="admin" @close="edited()" :key="user.id" v-if="user_edit" :user-id="user.id"/>
    </div>
</template>
<script>
    export default {
        props: ['id'],

        data() {
            return {
                user: null,
                user_edit: false,
                user_id: null,
                admin: false
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {ы
                this.user_edit = false;
                axios.get('/api/get-user-tools-info/' + this.id).then(response => {
                    this.user = response.data.user;
                    this.admin = response.data.admin;
                });
            },

            details(id) {
                this.$root.member_info_user_id = id;
            },

            edited() {
                this.$emit('edited');
                this.getData();
            }
        }
    }
</script>
