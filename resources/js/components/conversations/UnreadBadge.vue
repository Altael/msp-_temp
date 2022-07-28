<template>
    <div class="appUnreadMessages appBadge" v-if="count">
        <span>{{ count }}</span>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                count: 0
            }
        },

        mounted() {
            this.getData();

            this.$root.$on('question-opened', () => {
                this.getData();
            });
        },

        methods: {
            getData() {
                axios.get('/question-unread-message-count').then(response => {
                    this.count = response.data.count;
                });
            }
        }
    }

</script>
