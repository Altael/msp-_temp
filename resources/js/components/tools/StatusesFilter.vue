<template>
    <div>
        <modal-window :button-list="['Close']" nScroll
                      @close="close()"
                      :windowName="__('Statuses filter')" customClass="appStatusesFilter">
            <div class="appForm-group">
                <div class="appStatusesFilter-items">
                    <label class="appStatusesFilter-item" v-for="status of statuses">
                        <input type="checkbox" v-model="chosen" :value="status.id">
                        <span>{{ status['name_' + locale] }}</span>
                    </label>
                </div>
                <div class="appStatusesFilter-notes">
                    <div class="appStatusesFilter-note" v-for="status of statuses">

                        <div>{{ status['name_' + locale] }}&nbsp;&ndash;&nbsp;</div>
                        <div>{{ status['notes_' + locale] }}</div>
                    </div>
                </div>
            </div>
        </modal-window>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                statuses: [],
                chosen: [],
                locale: 'en'
            }
        },

        watch: {
            chosen: {
                deep: true,
                handler() {
                    this.$emit('input', this.chosen)
                }
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {
                axios.get('/get-statuses').then(response => {
                    this.statuses = response.data.statuses;
                    this.chosen = response.data.settings.standard_statuses;
                    this.locale = response.data.locale;
                    this.$nextTick(() => {
                        this.$emit('loaded');
                    });
                });
            },

            close() {
                this.$emit('close');
            }
        }
    }
</script>
