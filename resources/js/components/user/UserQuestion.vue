<template>
    <div class="appQuestion">
        <div class="dhrtModalWindow-head  appQuestionHead">
            <div class="appQuestionHead-back" @click="backToList">
                <span class="appIcons msppIcons-chevron-left appQuestionHead-backIcon"></span>
                <span class="appQuestionHead-backText">{{ __('To the list') }}</span>
            </div>
            <div class="appQuestionHead-subject">
                {{ question.subject }}
            </div>
        </div>
        <div class="dhrtModalWindow-body appQuestionBody">
            <div :class="{'dhrtScroll-wrapperOuter': showModal}">
                <div :class="{'dhrtScroll-wrapperInner': showModal}" v-scroll-bottom>
                    <div class="appQuestionMsg-container">
                        <div class="appQuestionMsgs" v-for="message of messages">
                            <div class="msgQuestionMsgs-msgMainInfo">
                                <div class="appQuestionMsgs-avatar">
                                    <avatar :src="message.userAvatar ? message.userAvatar : '/images/no-avatar.jpg'"></avatar>
                                </div>
                                <div class="appQuestionMsgs-userInfo">
                                    <div class="appQuestionMsgs-msgMainUserInfo">
                                        <div class="appQuestionMsgs-msgMainUserInfoName">
                                            <div class="appQuestionMsgs-msgMainUserInfoNameSpirit" v-if="message.userNameSpirit">{{ message.userNameSpirit }}</div>
                                            <div class="appQuestionMsgs-msgMainUserInfoNameCivil" v-if="message.userNameCivil">{{ message.userNameCivil }}</div>
                                        </div>
                                        <div class="appQuestionMsgs-msgMainUserInfoEmail"></div>
                                    </div>
                                    <div class="appQuestionMsgs-msgDate">{{ dateFormat(message.date) }}</div>
                                </div>
                            </div>


                            <div class="appQuestionMsgs-msgMainText" v-html="message.text"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dhrtModalWindow-footer appQuestionActions" v-if="question.status !== 2">
            <div class="appQuestionActions-avatar">
                <!-- <avatar class="appUserQuestion-avatarImage" :src="message.userImage ? message.userImage : '/images/no-avatar.jpg'"></avatar>-->
                <avatar class="appUserQuestion-avatarImage" src="/images/no-avatar.jpg"></avatar>
            </div>
            <div class="appQuestionActions-editor">
                <div class="appQuestionActions-editorField">
                    <html-editor  height="100" v-model="newMessage" />
                    <!--<textarea class="appForm-textarea appForm-textareaFixed" rows="4" :placeholder="__('Your message')" v-model="newMessage"></textarea>-->
                </div>
                <div class="appQuestionActions-EditorSend">
                    <div class="appQuestionEdit-sendBtn" @click="sendMessage" :class="{disabled: !newMessage}">{{ __('Send') }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let moment = require('moment');

    export default {
        props: ['question', 'showModal'],

        data() {
            return {
                messages: [],
                newMessage: '',
                isSending: null
            }
        },

        mounted() {
            this.getMessages();
            if(this.showModal) $('body').addClass('modalOpen');
        },

        beforeDestroy() {
            if(this.showModal) $('body').removeClass('modalOpen');
        },

        computed: {
        },

        methods: {
            dateFormat(date) {
                return moment.utc(date).utcOffset(moment().utcOffset()).fromNow();
            },

            backToList() {
                this.$parent.page = 'list';
            },

            getMessages() {
                axios.get('/question-message', {params: {questionId: this.question.id, orderType: 'asc'}}).then(response => {
                    this.messages = response.data.result;
                    this.$root.$emit('question-opened');
                });
            },

            sendMessage() {
                if(this.isSending || !this.newMessage) return;
                this.isSending = 1;
                axios.post('/question-message', {
                    questionId: this.question.id,
                    message: this.newMessage
                }).then(response => {
                    this.newMessage = null;
                    this.getMessages();
                    this.isSending = null;
                });
            }
        },

        directives: {
            scrollBottom: {
                componentUpdated: function(el) {
                    el.scrollTop = el.scrollHeight;
                }
            }
        }
    }
</script>
