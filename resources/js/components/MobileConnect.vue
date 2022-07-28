<template>
    <div class="appBlogNews-linkWrap" v-if="loadedMobile && (purpose !== 'news' || !mobileId)">
        <div class="appConnect2app" :class="{'connected': mobileId}">
            <div>
                <a @click.prevent="connectToMobile" class="mspForm-button">
                    <img class="appConnect2appImg" src="/images/msp-to-am.png" alt="">
                    <span class="appConnect2appText" v-if="!mobileId">{{ __('Connect MS account') }}</span>
                    <span class="appConnect2appText" v-else>{{ __('Disconnect MS account') }}</span>
                </a>
            </div>

            <modal-window id="appConnect2appModal-processing" v-if="processing" :buttonList="[]" nScroll
                          :windowName="__('Connecting')">
                <div class="appForm-group">
                    <div class="appModal-confirm">
                        <div>{{ __('Trying to connect your account to MeditationSteps') }}</div>
                        <div class="dhrtWaitAnimateLoader">
                            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-one"></div>
                            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-two"></div>
                            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-three"></div>
                        </div>
                    </div>
                </div>
            </modal-window>

            <modal-window id="appConnect2appModal-success" v-if="mobile_done" :buttonList="['Ok']" nScroll
                          @close="close()" @ok="close()" :windowName="__('App connected')">
                <div class="appForm-group">
                    <div class="appModal-confirm">
                        {{ __('Mobile application connected successfully') }}
                    </div>
                </div>
            </modal-window>

            <modal-window id="appConnect2appModal-fail" v-if="mobile_fail" :buttonList="['Ok']" nScroll
                          @close="close()" @ok="close()" :windowName="__('Connection failed')">
                <div class="appForm-group">
                    <div class="appModal-confirm">
                        <div>{{ __('Mobile application connection failed') }}</div>
                        <!--<div>{{ mobile_fail }}</div>-->
                    </div>
                </div>
            </modal-window>

            <modal-window id="appConnect2appModal-disSuccess" v-if="dismobile_done" :buttonList="['Ok']" nScroll
                          @close="close()" @ok="close()" :windowName="__('App disconnected')">
                <div class="appForm-group">
                    <div class="appModal-confirm">
                        {{ __('Mobile application disconnected successfully') }}
                    </div>
                </div>
            </modal-window>

            <modal-window id="appConnect2appModal-disFail" v-if="dismobile_fail" :buttonList="['Ok']" nScroll
                          @close="close()" @ok="close()" :windowName="__('Connection failed')">
                <div class="appForm-group">
                    <div class="appModal-confirm">
                        <div>{{ __('Mobile application disconnection failed') }}</div>
                        <!--<div>{{ mobile_fail }}</div>-->
                    </div>
                </div>
            </modal-window>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['purpose'],

        data() {
            return {
                mobileId: null,
                mobile_done: false,
                mobile_fail: false,
                dismobile_done: false,
                dismobile_fail: false,
                processing: false,
                loadedMobile: false
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {
                axios.get('/api/user-profile').then(response => {
                    this.mobileId = response.data.mobileId;
                    this.loadedMobile = true;
                });
            },

            connectToMobile() {
                if (!this.processing) {
                    this.processing = true;
                    if (!this.mobileId) {
                        axios.get('/connect-mobile-app').then(response => {
                            if (response.data.id) this.mobile_done = true;
                            else this.mobile_fail = true;
                            this.processing = false;
                        }).catch(error => {
                            this.mobile_fail = true;
                        });
                    } else {
                        axios.get('/disconnect-mobile-app').then(response => {
                            if (response.data.status === 'ok') this.dismobile_done = true;
                            else this.dismobile_fail = true;
                            this.processing = false;
                        }).catch(error => {
                            this.mobile_fail = true;
                        });
                    }
                }
            },

            close() {
                this.mobile_done = false;
                this.mobile_fail = false;
                this.dismobile_done = false;
                this.dismobile_fail = false;
                this.getData();
            }
        }
    }
</script>
