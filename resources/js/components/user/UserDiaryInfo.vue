<template>
    <div class="appUserDiaryInfo">
        {{ average_points }}
    </div>
</template>

<script>
    export default {
        data() {
            return {
                average_points: 0
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {
                axios.get('/user-diary-info').then(response => {
                    this.average_points = Math.trunc(response.data.average_points);
                });
            }
        }
    }
</script>
