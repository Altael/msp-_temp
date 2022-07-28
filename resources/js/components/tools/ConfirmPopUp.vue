<template>

</template>
<script>
    export default {
        props: {
            duration: {
                type: Number,
                default: 0.5
            },
            label: {
                type: String,
                default: 'Saved'
            }
        },

        data() {
            return {

            }
        },

        methods: {
            blink() {
                this.$root.$refs.confirm_popup_shell.confirm_popup_label = this.label;

                this.$root.$refs.confirm_popup_shell.confirm_popup_show = true;
                setTimeout(() => {
                    this.$root.$refs.confirm_popup_shell.confirm_popup_show = false;
                }, this.duration * 1000)
            }
        }
    }
</script>
