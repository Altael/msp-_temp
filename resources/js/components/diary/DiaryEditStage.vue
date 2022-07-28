<template>
    <div class="amDiaryPage amDiaryPage-help" :class="{'prevPage': curStage-stage === 1, 'curPage': curStage-stage === 0, 'nextPage': curStage-stage === -1}">
        <template v-if="helper">
            <div class="amDiaryPage-helpLink">
                <div class="appIcons msppIcons-help" v-if="hasHelp" @click="help = true"></div>
            </div>
            <div class="amDiaryPage-helpContent" v-if="help">
            <div class="amDiaryPage-helpHead">
                <div class="amDiaryPage-helpHeadTitle" v-html="helper.title"></div>
                <div class="amDiaryPage-helpHeadClose appIcons msppIcons-close-circle" @click="help = false"></div>
            </div>
            <div class="amDiaryPage-helpBody">
                <div class="dhrtScroll-wrapperOuter">
                    <div class="dhrtScroll-wrapperInner" v-html="helper.help">
                    </div>
                </div>

            </div>
        </div>
        </template>
        <slot></slot>
        <div class="amDiaryPage-button" @click="proceed">{{ $parent.process === "creating" ? __('Continue') : __('Save') }}</div>
    </div>
</template>

<script>
    export default {
        props: {
            hasHelp: {
                type: Boolean,
                default: false
            },
            practice: {
                type: String,
                default: null
            },
            stage: {
                type: Number,
                default: 0
            },
            curStage: {
                type: Number,
                default: 0
            }
        },

        data() {
            return {
                help: false,
                helper: null
            }
        },

        mounted() {
            this.getHelp();
        },

        methods: {
            proceed() {
                this.$parent.$parent.proceed();
            },

            getHelp() {
                axios.get('/api/daily-practices?info&practice=' + this.practice, ).then(response => {
                    this.helper = response.data.practiceInfo;
                }).catch((error) => {

                });
            },
        }
    }
</script>
