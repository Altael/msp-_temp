<template>
    <span class="unit">{{ __(declension) }}</span>
</template>

<script>
    export default {
        props: ['amount', 'word'],

        data() {
            return {

            }
        },

        computed: {
            declension() {
                let word = this.word;

                if(this.amount > 10 && this.amount < 20) return word + '   ';
                if(this.amount%10 === 1) return word + ' ';
                if(this.amount%10 === 0) return word + '   ';
                if(this.amount%10 < 5) return word + '  ';
                return word + '   ';
            }
        }
    }
</script>
