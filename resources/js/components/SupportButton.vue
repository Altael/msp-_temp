<template>
    <div class="appSupportButton">
        <span @click="opened = 1" class="appPageSupport appIcons msppIcons-telegram-nobg"></span>
        <modal-window v-if="opened" @close="opened = null" @ok="redirect" :buttonList="['Close', 'Ok']" :windowName="__('Contact support')">
            <div class="appSupportButton-text">{{ __('Our support works in Telegram messenger. Click \'Ok\' to open our supporter\'s contact in app.') }}</div>
        </modal-window>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                opened: null
            }
        },

        methods: {
            redirect() {
                window.open('https://t.me/jyotindra');
            }
        }
    }
</script>
