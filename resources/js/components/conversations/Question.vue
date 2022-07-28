<template>
    <div class="appQuestion">
        <div class="dhrtModalWindow-head appQuestionHead">
            <div class="appQuestionHead-subject">
                {{ question.subject }}
            </div>
            <div class="appQuestionHead-actions">
                <div v-if="question.status !== 2" class="appQuestionHead-actionsButton" @click="closeQuestion">{{ __('Close the question') }}</div>
            </div>
        </div>
        <div class="dhrtModalWindow-body appQuestionBody">

            <div :class="{'dhrtScroll-wrapperOuter': showModal}">
                <div :class="{'dhrtScroll-wrapperInner': showModal}" v-scroll-bottom>
                    <div class="appQuestionMsg-container">
                        <div class="appQuestionMsgs" v-for="message of messages">
                            <div class="msgQuestionMsgs-msgMainInfo">
                                <div class="msgQuestionMsgs-msgMainInfo">
                                    <div class="appQuestionMsgs-avatar">
                                        <avatar class="appQuestion-avatarImage" :src="message.userAvatar ? message.userAvatar : '/images/no-avatar.jpg'"></avatar>
                                    </div>
                                    <div class="appQuestionMsgs-msgMainUserInfo">
                                        <div class="appQuestionMsgs-msgMainUserInfoName">
                                            <div class="appQuestionMsgs-msgMainUserInfoNameSpirit"  v-if="message.userNameSpirit">{{ message.userNameSpirit }}</div>
                                            <div class="appQuestionMsgs-msgMainUserInfoNameCivil"  v-if="message.userNameCivil && !message.acarya">{{ message.userNameCivil }}</div>
                                        </div>
                                        <div class="appQuestionMsgs-msgMainUserInfoEmail" v-if="!message.acarya">{{ message.userEmail }}</div>
                                        <div class="appQuestionMsgs-msgDate">{{ dateFormat(message.date) }}</div>
                                    </div>

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
                <avatar class="appQuestion-avatarImage" :src="question.userAvatar ? question.userAvatar : '/images/no-avatar.jpg'"></avatar>
            </div>
            <div class="appQuestionActions-editor">
                <div class="appQuestionActions-editorField">
                    <html-editor height="70" v-model="newMessage" />
                    <!--<textarea class="appForm-textarea appForm-textareaFixed" rows="4" :placeholder="__('Your message')" v-model="newMessage"></textarea>-->
                </div>
                <div class="appQuestionActions-EditorSend">
                    <div class="appQuestionEdit-sendBtn dhrtModalWindow-footerSave" :class="{disabled: !newMessage || isSending}" @click="sendMessage">{{ __('Send') }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let moment = require('moment');
    import Textarea from "../../../../vue/src/views/forms/form-elements/textarea/Textarea";

    export default {
        props: ['question', 'showModal'],

        components: {
            Textarea
        },

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

        methods: {
            dateFormat(date) {
                return moment.utc(date).utcOffset(moment().utcOffset()).fromNow();
            },

            getMessages() {
                axios.get('/question-message', {params: {questionId: this.question.id, orderType: 'asc'}}).then(response => {
                    this.messages = response.data.result;
                    this.$root.$emit('question-opened');
                    this.$parent.$emit('fetch-question-list');
                });
            },

            sendMessage() {
                if(!this.newMessage) return;
                if(this.isSending) return;
                this.isSending = 1;
                axios.post('/question-message', {
                    questionId: this.question.id,
                    message: this.newMessage
                }).then(response => {
                    this.newMessage = null;
                    this.getMessages();
                    this.isSending = null;
                });
            },

            inProgressQuestion() {
                axios.post('question-status', {
                    questionId: this.question.id,
                    status: 1
                }).then(response => {
                    this.question.status = 1;
                    this.$parent.$emit('fetch-question-list')
                });
            },

            closeQuestion() {
                axios.post('question-status', {
                    questionId: this.question.id,
                    status: 2
                }).then(response => {
                    this.question.status = 2;
                    this.$parent.$emit('fetch-question-list')
                });
            },
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

