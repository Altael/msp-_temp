<template>
    <div class="amDiaryNumpadWrapper">
        <div class="amDiaryNumpad">
            <div class="amDiaryNumpad-head">
                <div class="amDiaryNumpad-headQuestion" v-if="slots.question">
                    <slot name="question"></slot>
                </div>
                <input type="number" class="amDiaryNumpad-headDisplay" readonly
                       v-model="numericDisplay">
                <div class="amDiaryNumpad-headUnit">
                    <!--<slot name="unit"></slot>-->
                    <declension :amount="numericDisplay" word="minutes"></declension>
                </div>
            </div>
            <div class="amDiaryNumpad-body">
                <div class="amDiaryNumpad-bodySave">
                    <div class="amDiaryNumpad-bodySaveButton">
                        <span @click="save">{{ __('Save') }}</span>
                        <span class="appIcons msppIcons-chevron-right"></span>
                    </div>
                </div>
                <div class="amDiaryNumpad-bodyKeyboard">
                    <div class="amDiaryNumpad-bodyKeyboardKey" @click="addDigit(1)">1</div>
                    <div class="amDiaryNumpad-bodyKeyboardKey" @click="addDigit(2)">2</div>
                    <div class="amDiaryNumpad-bodyKeyboardKey" @click="addDigit(3)">3</div>
                    <div class="amDiaryNumpad-bodyKeyboardKey" @click="addDigit(4)">4</div>
                    <div class="amDiaryNumpad-bodyKeyboardKey" @click="addDigit(5)">5</div>
                    <div class="amDiaryNumpad-bodyKeyboardKey" @click="addDigit(6)">6</div>
                    <div class="amDiaryNumpad-bodyKeyboardKey" @click="addDigit(7)">7</div>
                    <div class="amDiaryNumpad-bodyKeyboardKey" @click="addDigit(8)">8</div>
                    <div class="amDiaryNumpad-bodyKeyboardKey" @click="addDigit(9)">9</div>
                    <div class="amDiaryNumpad-bodyKeyboardKey" @click="addDigit(0)">0</div>
                    <div class="amDiaryNumpad-bodyKeyboardKey appIcons msppIcons-delete" @click="removeDigit()"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let moment = require('moment');

    export default {
        props: ['practice'],

        data() {
            return {
                slots: {
                    question: true,
                    unit: true
                },

                numericDisplay: 0,
                time: moment('00:00', 'HH:mm')
            }
        },

        mounted() {
            for(let slot in this.slots) {
                this.slots[slot] = this.$slots[slot];
            }
            this.time = this.$parent.$parent.$parent.item[this.practice];
            this.numericDisplay = moment.duration(this.$parent.$parent.$parent.item[this.practice]).asMinutes();
            this.$parent.$parent.$parent.isNumpadShow = true;
        },

        destroyed() {
            this.$parent.$parent.$parent.isNumpadShow = false;
        },

        computed: {
            questionSlot() {
                return this.$slots.question;
            },

            unitSlot() {
                return this.$slots.unit;
            }
        },

        watch: {
            numericDisplay() {
                this.time = moment(Math.trunc(this.numericDisplay / 60) + ':' + this.numericDisplay % 60, 'HH:mm').format('HH:mm');
                this.$parent.$parent.$parent.item[this.practice] = this.time;
            },
            practice() {
                this.numericDisplay = 0;
                this.time = moment('00:00', 'HH:mm');
            }
        },

        methods: {
            addDigit(digit) {
                this.numericDisplay = this.numericDisplay * 10 + digit;
            },

            removeDigit() {
                this.numericDisplay = Math.trunc( this.numericDisplay / 10 );
            },

            save() {
                this.$parent.proceed();
            }
        }
    }
</script>
