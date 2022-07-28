<template>
    <div id="nearestFasting">
        {{ typeNames[fasting.type] }} - {{ dateFormat(fasting.date) }}
    </div>
</template>

<script>
    let moment = require('moment');

    export default {
        data() {
            return {
                fasting: null,

                typeNames: {
                    'amavasya': 'Amavasya',
                    'purnima': 'Purnima',
                    'ekadashi': 'Ekadashi'
                }
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData(){
                axios.get('/nearest-fasting').then(response => {
                    this.fasting = response.data.fasting;
                });
            },

            dateFormat(date){
                return moment(date).format('DD.MM.YYYY')
            }
        }
    }
</script>
