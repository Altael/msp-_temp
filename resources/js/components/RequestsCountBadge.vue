<template>
    <div class="appUnreadMessages appBadge" v-if="count">
        {{ count }}
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
                let params = {
                    status: 0
                };

                axios.get('/initiations-count', {params: params}).then(response => {
                    this.count = response.data;
                });
            }
        }
    }

</script>
