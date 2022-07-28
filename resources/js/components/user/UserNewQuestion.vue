<template>
    <div class="appUserNewQuestion">
        <template v-if="finish">

            <div class="appUserNewQuestion-finish">
                {{ __('The question has been successfully asked. As soon as acharya answers, you will receive a notification.') }}
            </div>
            <div class="appUserNewQuestion-submit">
                <button @click="showList">{{ __('Ok') }}</button>
            </div>

        </template>
        <template v-else>
            <div class="appUserNewQuestion-head">{{ __('Ask a new question to the acharya') }}</div>

            <div class="appUserNewQuestion-field">
                <div class="appUserNewQuestion-fieldName appProfile-mark">{{ __('Question subject:') }}</div>
                <input type="text" class="appUserNewQuestion-fieldInput" v-model="subject">
            </div>
            <div class="appUserNewQuestion-field">
                <div class="appUserNewQuestion-fieldName appProfile-mark">{{ __('Question:') }}</div>
                <textarea rows="10" class="appUserNewQuestion-fieldInput" v-model="message"></textarea>
            </div>

            <div class="dhrtModalWindow-footerButtons appUserNewQuestion-footerButtons">
                <div class="dhrtModalWindow-footerButton" @click="showList">{{ __('Back') }}</div>
                <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" :class="{disabled: !subject || !message || isSending}" @click="ask">{{ __('Ask a question') }}</div>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                subject: '',
                message: '',
                finish: false,
                isSending: null
            }
        },

        mounted() {

        },

        methods: {
            ask() {
                if(this.isSending) return;
                this.isSending = 1;
                axios.post('/question', {
                    subject: this.subject,
                    message: this.message,
                }).then(response => {
                    this.finish = response.data.result;
                    this.$emit('asked');
                    this.isSending = null;
                }).catch(error => {
                    this.isSending = null;
                });
            },

            showList() {
                this.$parent.page = 'list';
            }
        }
    }
</script>
