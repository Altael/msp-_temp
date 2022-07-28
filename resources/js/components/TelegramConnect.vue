<template>
    <div class="appBlogNews-linkWrap" v-if="loadedTelegram && (purpose !== 'news' || !telegram_id)">
        <div class="appTelegram">
            <div class="appTelegramNotice" v-if="slotPassed"><slot v-if="!telegram_id"></slot></div>
            <div class="appTelegramConnected" v-if="telegram_id">
                <div class="appForm-button">
                    <div class="appTelegramIcon appIcons msppIcons-telegram"></div>
                    <div class="appTelegramText" @click="disconnect">{{ __('Telegram') }} {{ __('Connected') }}</div>
                </div>
                <div class="appTelegramNotice-after">{{ __('You are able to get notification in your telegram') }}</div>
                <div class="appTelegramNotice-after">{{ __('Click on the button above to disconnect') }}</div>
            </div>
            <div class="appTelegramNotConnected" v-else>
                <div class="appForm-button" @click="connect" target="_blank">
                    <div class="appTelegramIcon appIcons msppIcons-telegram"></div>
                    <div class="appTelegramText">{{ __('Connect to Telegram') }}</div>
                </div>
                <div><a class="appCheck-telegramTerms" href="/newsletter" :target="$root.am ? '_self' : '_blank'">{{ __('By clicking on the button above I accept the terms of mailing from "Meditationsteps.Personal"') }}</a></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['purpose'],

        data() {
            return {
                telegram_id: null,
                profile_id: null,
                loadedTelegram: false
            }
        },

        computed: {
          slotPassed() {
              return this.$slots.default;
          }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {
                axios.get('/telegram-connect').then(response => {
                    this.telegram_id = response.data.telegram_id;
                    this.profile_id = response.data.profile_id;
                    this.loadedTelegram = true;
                });
            },

            connect() {
                window.open("https://t.me/personal_ms_bot?start=connect_user_"+this.profile_id);
            },

            disconnect() {
                axios.get('/telegram-disconnect').then(response => {
                    this.getData();
                });
            }
        }
    }
</script>
