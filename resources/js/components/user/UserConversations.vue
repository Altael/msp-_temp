<template>
    <div v-if="loaded" class="appUserConversations" :class="{'amPage' : am}">
        <div :title="__('Backward')" class="amPage-title" v-if="am" @click="goToProfile">
            {{ __('Conversations') }}
        </div>
        <template v-if="hasLesson">
            <telegram-connect>
                {{ __('To get notifications about new messages connect your telegram account') }}
            </telegram-connect>
            <div v-if="page === 'list' && daysDifference>=7" @click="newQuestion" class="appUserConversations-new">
                {{ __('New question') }}
            </div>
            <div v-else-if="page === 'list' && daysDifference<7" class="appUserConversations-wait">
                <div>{{ __('A new dialogue will be available starting from') }}</div>
                <div v-if="messageAt">{{ dateFormat(messageAt) }}</div>
            </div>

            <user-question-list v-if="page === 'list'"></user-question-list>
            <template v-if="page === 'question'">
                <user-question :question="question" v-if="!showModal" :show-modal="showModal"></user-question>

                <div class="dhrtModalWindow mspQuestionsModal"  v-if="showModal">
                    <div class="dhrtModalWindow-back"></div>
                    <div class="dhrtModalWindow-content">
                        <div class="dhrtModalWindow-contentTools" @click="question = null, page = 'list'"><div class="dhrtModalWindow-contentClose">&times;</div></div>
                        <user-question :key="question.id" :question="question" :show-modal="showModal"/>
                    </div>
                </div>
            </template>
            <user-new-question @asked="getQuestionDates" v-if="page === 'newQuestion'"></user-new-question>
        </template>
        <div class="appUserConversations-unavailable" v-else>
            <div>{{ __('For you to ask acarya a question we should have an information about you personal lessons. To fill in this information complete the form') }}
            <a href="/user/missing-lessons">{{ __('here') }}</a>.</div>
            <div>{{ __('If you dont have any lessons yet you can apply a request') }}
            <a href="/user/request">{{ __('here') }}</a>.</div>
        </div>
    </div>
</template>

<script>
    let moment = require('moment');

    export default {
        props: ['dialogueId'],

        data() {
            return {
                loaded: false,
                page: 'list', // list, newQuestion, question,
                question: null,
                daysDifference: null,
                messageAt: '',
                showModal: window.matchMedia("(max-width: 1199px)").matches,
                hasLesson: false,
                am: false
            }
        },

        mounted() {
            this.am = $('html').attr('data-am') === "1";
            this.getQuestionDates();
            if(this.dialogueId) this.getQuestion();
        },

        methods: {
            newQuestion() {
                this.page = 'newQuestion';
            },

            dateFormat(date) {
                return moment(date, 'YYYY.MM.DD HH:mm:ss').format('DD.MM.YY HH:mm:ss');
            },

            getQuestionDates() {
                axios.get('/questions').then(response => {
                    this.daysDifference = response.data.daysDifference;
                    this.messageAt = response.data.messageAt;
                    this.hasLesson = response.data.hasLesson;
                    this.loaded = true;
                });
            },

            getQuestion() {
                axios.get('/conversations-dialogue?dialogue=' + this.dialogueId).then(response => {
                    this.question = response.data.question;
                    this.page = 'question';
                });
            },

            goToProfile() {
                window.location = "/profile";
            }
        }
    }
</script>
