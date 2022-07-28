<template>
    <div class="appActionNotice" v-if="confirm_popup_show">
        <div class="appActionNotice-content animate__zoomIn animate__animated">
            {{ confirm_popup_label }}
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                confirm_popup_show: false,
                confirm_popup_label: 'Saved'
            }
        }

    }
</script>
