<template>
    <div class="appEasterEgg">

        <div class="appEasterEgg_main" v-if="!sent">
            <div class="appEasterEgg_text">
                <div class="appEasterEgg_textLine">{{ __('Congratulations! You found an easter egg page and what I want to tell you is - Baba Nam Kevalam. :)') }}</div>
                <div class="appEasterEgg_textLine">{{ __('Also if you got here without any hints (almost or completely) from other people, who found this page before, you may write you name and a message to project development team.') }}</div>
                <div class="appEasterEgg_textLine">{{ __('I rely on you honesty! >:)') }}</div>
            </div>

            <div class="appEasterEgg_form" v-if="!sent">
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Name') }}</div>
                    <input class="appForm-input appEasterEgg_form" v-model="score.name">
                </div>
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Message') }}</div>
                    <textarea class="appForm-input appEasterEgg_form" v-model="score.message"></textarea>
                </div>
                <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave appEasterEgg_formSave" @click="save">{{ __('Save') }}</div>
            </div>
        </div>

        <div class="appEasterEgg_list">
            <div class="appEasterEgg_listTitle">{{ __('Other people who managed to find this page and left a comment.') }}<template v-if="!sent">{{ __('You may appear here too ;)') }}</template></div>
            <div class="appEasterEgg_listItem" v-for="score in scores">{{ score.name }}</div>
        </div>

        <modal-window id="appProfileModal-error" v-if="errorModal" :buttonList="['Ok']" nScroll @close="errorModal = null" @ok="errorModal = null" :windowName="__('Warning!!!')">
            <div class="appForm-group">
                <div class="appModal-confirm">
                    <div>{{ __('Something went wrong') }}:</div>
                    {{ __('If you already sent a message and trying to do it again (you weren\'t supposed to tho) - stop playing with page.') }}
                </div>
            </div>
        </modal-window>
    </div>
</template>
<script>

    export default {
        props: {

        },

        data(){
            return {
                scores: [],
                score: {
                    'name': '',
                    'message': ''
                },
                errorModal: null,
                sent: 1
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {
                axios.get('/easter-egg').then(response => {
                    this.scores = response.data.scores;
                    this.sent = response.data.sent;
                });
            },
            save() {
                axios.post('/easter-egg', {score: this.score}).then(response => {
                    this.getData();
                }).catch(error => {
                    this.errorModal = 1;
                });
            }
        },
    }
</script>
