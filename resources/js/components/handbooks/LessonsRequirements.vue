<template>
    <div class="appHandbookNames">
        <div class="appTable">
            <div class="appTable-row appTable-head">
                <div class="appTable-col">
                    <div>{{ __('Lesson') }}</div>
                </div>
                <div class="appTable-col">
                    <div>{{ __('En') }}</div>
                </div>
                <div class="appTable-col">
                    <div>{{ __('Ru') }}</div>
                </div>
            </div>
            <div class="appTable-body">
                <div v-for="lesson in 6" class="appTable-row">
                    <div class="appTable-col">
                        {{ reqs[lesson - 1].lesson }}
                    </div>
                    <div class="appTable-col">
                        <textarea v-model="reqs[lesson - 1].en"></textarea>
                    </div>
                    <div class="appTable-col">
                        <textarea v-model="reqs[lesson - 1].ru"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" @click="save">{{ __('Save') }}</div>
    </div>
</template>

<script>
    import Textarea from "../../../../vue/src/views/forms/form-elements/textarea/Textarea";

    export default {
        components: {
            Textarea
        },

        data() {
            return {
                reqs: [
                    {
                        'id': null,
                        'lesson': 1,
                        'ru': '',
                        'en': ''
                    },
                    {
                        'id': null,
                        'lesson': 2,
                        'ru': '',
                        'en': ''
                    },
                    {
                        'id': null,
                        'lesson': 3,
                        'ru': '',
                        'en': ''
                    },
                    {
                        'id': null,
                        'lesson': 4,
                        'ru': '',
                        'en': ''
                    },
                    {
                        'id': null,
                        'lesson': 5,
                        'ru': '',
                        'en': ''
                    },
                    {
                        'id': null,
                        'lesson': 6,
                        'ru': '',
                        'en': ''
                    },

                ],

                isProcessing: null,
            }
        },

        mounted() {
            this.getData();
        },

        computed: {

        },

        watch: {

        },

        methods: {
            getData() {
                axios.get('/lessons-requirements-list').then(response => {
                    if(response.data.reqs.length > 0) this.reqs = response.data.reqs;
                });
            },

            save() {
                if(this.isProcessing) return;
                this.isProcessing = 1;
                axios.post('/lessons-requirements-list', {reqs: this.reqs}).then(response => {
                    this.isProcesssing = 0;
                });
            }
        }
    }

</script>
