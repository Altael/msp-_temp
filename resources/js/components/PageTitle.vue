<template>
    <div class="amPage-title" @click="back()">
        {{ __(title) }}
    </div>
</template>

<script>
export default {
    props: {
        link: {
            type: String,
            default: null
        },
        title: {
            type: String,
            default: null
        }
    },

    data() {
        return {

        }
    },

    methods: {
        back() {
            this.link ? window.location.href = this.link : window.history.back();
        }
    }
}
</script>
