<template>
    <div class="appQuestionsList-wrap appUserQuestionsList-wrap">
        <div class="dhrtSearch">
            <input type="text" class="dhrtSearchField">
            <span class="appIcons msppIcons-search dhrtSearchField-icon"></span>
        </div>
        <div class="dhrtScroll-wrapperOuter">
            <div class="dhrtScroll-wrapperInner">
                <div class="appQuestionsListBlocks">
                    <div class="appQuestionsList-block mspQuestionsList-blockAwaiting" v-if="questions.awaiting_reply">
                        <div class="appQuestionsList-blockHead">
                            <div class="appQuestionsList-blockHeadName">{{ __('Awaiting response') }}</div>
                            <div class="appQuestionsList-blockHeadBadges"><span class="badge">{{ questions.awaiting_reply.length }}</span></div>
                        </div>
                        <div class="appQuestionsList-blockContent" v-for="question of questions.awaiting_reply">
                            <div @click.prevent="select(question)" class="appQuestionsList-blockContentQuestion">
                                <avatar class="appQuestionsList-blockContentAvatar appAvatar appLists-avatarImage" :src="question.userAvatar"></avatar>
                                <div class="appQuestionsList-blockContentMain">
                                    <div class="appQuestionsList-blockContentMainTop">
                                        <div class="appQuestionsList-subject">
                                            {{ question.subject }}
                                        </div>
                                        <div class="appQuestionsList-date">{{ dateFormat(question.last_message_date) }}</div>
                                    </div>
                                    <div class="appQuestionsList-blockContentMainBottom">
                                        <div class="appQuestionsList-name">{{ stripHtml(question.last_message) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="appQuestionsList-block mspQuestionsList-blockProgress" v-if="questions.in_progress">
                        <div class="appQuestionsList-blockHead">
                            <div class="appQuestionsList-blockHeadName">{{ __('In progress') }}</div>
                            <div class="appQuestionsList-blockHeadBadges"><span class="badge">{{ questions.in_progress.length }}</span></div>
                        </div>
                        <div class="appQuestionsList-blockContent" v-for="question of questions.in_progress">
                            <div @click.prevent="select(question)" class="appQuestionsList-blockContentQuestion">
                                <avatar class="appQuestionsList-blockContentAvatar appAvatar appLists-avatarImage" :src="question.userAvatar"></avatar>
                                <div class="appQuestionsList-blockContentMain">
                                    <div class="appQuestionsList-blockContentMainTop">
                                        <div class="appQuestionsList-subject">
                                            {{ question.subject }}
                                        </div>
                                        <div class="appQuestionsList-date">{{ dateFormat(question.last_message_date) }}</div>
                                    </div>
                                    <div class="appQuestionsList-blockContentMainBottom">
                                        <div class="appQuestionsList-name">{{ stripHtml(question.last_message) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="appQuestionsList-block mspQuestionsList-blockSolved" v-if="questions.decided">
                        <div class="appQuestionsList-blockHead">
                            <div class="appQuestionsList-blockHeadName">{{ __('Decided') }}</div>
                            <div class="appQuestionsList-blockHeadBadges"><span class="badge">{{ questions.decided.length }}</span></div>
                        </div>
                        <div class="appQuestionsList-blockContent" v-for="question of questions.decided">
                            <div  @click.prevent="select(question)" class="appQuestionsList-blockContentQuestion">
                                <avatar class="appQuestionsList-blockContentAvatar appAvatar appLists-avatarImage" :src="question.userAvatar"></avatar>
                                <div class="appQuestionsList-blockContentMain">
                                    <div class="appQuestionsList-blockContentMainTop">
                                        <div class="appQuestionsList-subject">
                                            {{ question.subject }}
                                        </div>
                                        <div class="appQuestionsList-date">{{ dateFormat(question.last_message_date) }}</div>
                                    </div>
                                    <div class="appQuestionsList-blockContentMainBottom">
                                        <div class="appQuestionsList-name">{{ stripHtml(question.last_message) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    let moment = require('moment');
    import 'moment/locale/uk'
    import 'moment/locale/ru'

    export default {
        data() {
            return {
                questions: [],
                selected: null
            }
        },

        mounted() {
            moment.locale($('html').attr('lang'));
            this.getQuestions();
        },

        methods: {
            dateFormat(date) {
                return moment.utc(date).utcOffset(moment().utcOffset()).fromNow();
            },

            stripHtml(html) {
                var tmp = document.createElement("DIV");
                tmp.innerHTML = html;
                return tmp.textContent||tmp.innerText;
            },

            select(question) {
                this.$parent.question = question;
                this.$parent.page = 'question';
            },

            getQuestions() {
                axios.get('/question').then(response => {
                    this.questions = response.data.result;
                });
            }
        }
    }
</script>
