<template>
    <div :id="customId" class="dhrtModalWindow" :class="[customClass, { 'dhrtModalWindow-scroll' : !nScroll}]">
        <div class="dhrtModalWindow-back"></div>
        <div class="dhrtModalWindow-content">
            <div class="dhrtModalWindow-tools"></div>
            <div class="dhrtModalWindow-head" @click="close">
                <div class="dhrtModalWindow-title">{{ windowName }}</div>
                <div class="dhrtModalWindow-close" @click="close">&times;</div>
            </div>
            <div class="dhrtModalWindow-body">
                <template v-if="!nScroll">
                    <div class="dhrtScroll-wrapperOuter">
                        <div class="dhrtScroll-wrapperInner" ref="scroll">
                            <div class="dhrtModalWindow-bodyContent">
                                <slot></slot>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="dhrtModalWindow-bodyContent">
                        <slot></slot>
                    </div>
                </template>
            </div>
            <div class="dhrtModalWindow-footer" v-if="buttonList">
                <div class="dhrtModalWindow-footerButtons">
                    <div class="dhrtModalWindow-footerButton" :class="{'dhrtModalWindow-footerSave': yellowButton(button.toLowerCase()), disabled: button.toLowerCase()=='save' && !valid}" v-for="button of buttonList" @click="$emit(button.toLowerCase())">{{ __(button) }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import JQuery from 'jquery';
    let $ = JQuery;

    export default {
        props: {
            customId: String,
            customClass: String,
            windowName: String,
            valid: {
                type: Boolean,
                default: true
            },
            nScroll: {
                type: Boolean,
                default: false
            },
            buttonList: Array,
            windowScrollTop: {
                type: Number,
                default: 0
            }
        },

        data(){
            return {

            }
        },

        mounted() {
            document.body.classList.add('modalOpen');
            this.$refs.scroll.scrollTop = this.windowScrollTop;
            /*$('html').keydown((e) => {
                if (e.keyCode === 13) {
                    this.$emit('enter');
                }
            });*/
        },

        beforeDestroy() {
            document.body.classList.remove('modalOpen');
        },

        methods: {
            close() {
                this.$emit('close');
            },

            save() {
                this.$emit('save');
            },

            yellowButton(name) {
                let yellows = [
                    'save', 'ok', 'create'
                ];
                let match = false;
                yellows.map((yellow) => {
                    if(name === yellow) match = true;
                });
                return match;
            }
        },
    }
</script>
