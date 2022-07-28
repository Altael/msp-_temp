<template>
    <div class="appBlogNews">
        <div class="appBlogNews-tools">
            <!--<div class="appBlogNews-toolsTitle">
                {{ __('News') }}
            </div>-->
            <div class="appBlogNews-toolsButtons">
                <lang-page></lang-page>
                <div class="appIcons msppIcons-calendar appBlogNewsIcon appItemHidden"></div>
            </div>
        </div>
        <div class="appBlogNews-linksWrapper">
            <div class="dhrtHorizontalScroll-wrapperOuter">
                <div class="dhrtHorizontalScroll-wrapperInner">
                    <div class="appBlogNews-links">
                        <div class="appBlogNews-linkWrap">
                            <a href="#" @click.prevent="modal = 'svadhyaya'"
                               class="appBlogNews-link orange">
                                <span class="appBlogNews-linkIcon appIcons msppIcons-book1"></span>
                                <span class="appBlogNews-linkText">{{ __('Svadhyaya') }}</span>
                            </a>
                        </div>
                        <div class="appBlogNews-linkWrap">
                            <a href="/dc"
                               class="appBlogNews-link green">
                                <span class="appBlogNews-linkIcon appIcons msppIcons-pravil"></span>
                                <span class="appBlogNews-linkText">{{ __('Dharmacakra') }}</span>
                            </a>
                        </div>
                        <div class="appBlogNews-linkWrap">
                            <a href="/fastings" class="appBlogNews-link purple">
                                <span class="appBlogNews-linkIcon appIcons msppIcons-spoon-fork"></span>
                                <span class="appBlogNews-linkText" v-if="fasting || fasting === 0">
                                    {{ __('Fasting') }} <br>{{ fasting === 0 ? __('today') : fasting === 1 ? __('tomorrow') : __('in') + '&nbsp;' + fasting + '&nbsp;' + __('days') }}
                                </span>
                            </a>
                        </div>
                        <div class="appBlogNews-linkWrap">
                            <a href="#" v-if="daily" @click.prevent="modal = 'daily'" class="appBlogNews-link blue">
                                <span class="appBlogNews-linkIcon appIcons msppIcons-quotes"></span>
                                <span class="appBlogNews-linkText">{{ __('Daily quote') }}</span>
                            </a>
                        </div>
                        <telegram-connect purpose="news"></telegram-connect>
                        <mobile-connect  purpose="news"></mobile-connect>

                    </div>
                </div>
            </div>

        </div>

        <posts category="news" :post="post"></posts>

        <daily-quote v-if="modal === 'daily'" :daily="daily"></daily-quote>
        <svadhyaya ref="svadhyaya" v-show="modal === 'svadhyaya'" :show_interface="true"></svadhyaya>
    </div>

</template>

<script>
    let moment = require('moment');

    export default {
        props: ['post'],

        data() {
            return {
                'daily': null,
                'svadhyaya': null,

                'fasting': null,

                'modal': null
            }
        },

        methods: {
            getDailyQuote() {
                axios.get('/reward/daily').then(response => {
                    this.daily = response.data.daily;
                });
            },

            getSvadhyaya() {
                axios.get('/reward/svadhyaya').then(response => {
                    this.svadhyaya = response.data.svadhyaya;
                });
            },

            getFasting() {
                axios.get('/nearest-fasting?widget').then(response => {
                    this.fasting = Math.ceil(moment(response.data.fasting.date).diff(moment.now(), 'days', true));
                });
            },

            sendLogOpenSvadhyaya() {
                axios.post('/api/log-save', {action: 'svadhyaya-open'}).then( response => {
                    this.$refs.svadhyaya.getStatistics();
                });
            }
        },

        watch: {
            modal(newVal) {
                if(newVal === 'svadhyaya') {
                    document.body.classList.add('toolbarNone');
                    this.sendLogOpenSvadhyaya();
                } else {
                    document.body.classList.remove('toolbarNone');
                }
            }
        },

        mounted() {
            this.getDailyQuote();
            this.getFasting();
            if(this.$route.query.svadhyaya) {
                this.modal = 'svadhyaya';
            }
        }
    }
</script>
