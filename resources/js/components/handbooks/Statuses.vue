<template>
    <div class="appHandbookStatuses">
        <div class="appBlock appButtons appButtons-rightAlign">
            <div class="appButton" @click="create()">
                {{ __('Create') }}
                <div class="appIcons appIcon-add"></div>
            </div>
        </div>

        <div class="appTable appHandbookStatusesTable">
            <div class="appTable-row appTable-head">

                <div class="appTable-col appHandbookStatusesTable-nameEn">
                    <div class="appTable-colTop">
                        <div>{{ __('Name') }}&nbsp;/{{ __('en') }}/</div>
                    </div>
                </div>
                <div class="appTable-col appHandbookStatusesTable-nameRu">
                    <div class="appTable-colTop">
                        <div>{{ __('Name') }}&nbsp;/{{ __('ru') }}/</div>
                    </div>
                </div>
                <div class="appTable-col appHandbookStatusesTable-nameUk">
                    <div class="appTable-colTop">
                        <div>{{ __('Name') }}&nbsp;/{{ __('uk') }}/</div>
                    </div>
                </div>
                <div class="appTable-col appHandbookStatusesTable-notesEn">
                    <div class="appTable-colTop">
                        <div>{{ __('Notes') }}&nbsp;/{{ __('en') }}/</div>
                    </div>
                </div>
                <div class="appTable-col appHandbookStatusesTable-notesRu">
                    <div class="appTable-colTop">
                        <div>{{ __('Notes') }}&nbsp;/{{ __('ru') }}/</div>
                    </div>
                </div>
                <div class="appTable-col appHandbookStatusesTable-notesUk">
                    <div class="appTable-colTop">
                        <div>{{ __('Notes') }}&nbsp;/{{ __('uk') }}/</div>
                    </div>
                </div>

            </div>
            <div class="appTable-body">
                <div v-for="(status, index) of statuses" class="appTable-row">
                    <div class="appTable-col appHandbookStatusesTable-nameEn">
                        {{ status.name_en }}
                    </div>
                    <div class="appTable-col appHandbookStatusesTable-nameRu">
                        {{ status.name_ru }}
                    </div>
                    <div class="appTable-col appHandbookStatusesTable-nameUk">
                        {{ status.name_uk }}
                    </div>
                    <div class="appTable-col appHandbookStatusesTable-notesEn">
                        {{ status.notes_en }}
                    </div>
                    <div class="appTable-col appHandbookStatusesTable-notesRu">
                        {{ status.notes_ru }}
                    </div>
                    <div class="appTable-col appHandbookStatusesTable-notesUk">
                        {{ status.notes_uk }}
                    </div>

                    <div class="appHandbookStatusesTable-tools">
                        <action-dropdown>
                            <a href="#" rel="nofollow" class="dhrtDropdown-item"
                               @click.prevent="edit(status)">
                                <span class="appIcons msppIcons-edit"></span>&nbsp;{{ __('Edit') }}
                            </a>
                            <a href="#" rel="nofollow" class="dhrtDropdown-item"
                               @click.prevent="destroy(status)">
                                {{ __('Delete') }}
                            </a>
                        </action-dropdown>
                    </div>
                </div>
            </div>
        </div>

        <modal-window v-if="status" @close="cancel" @enter="save()" :valid="status.name_ru || status.name_en || status.name_uk && !isProcessing"
                      @cancel="cancel" :buttonList="['Cancel', 'Save']" @save="save()"
                      :windowName="__('Edit user status')">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Status name') }}&nbsp;/{{ __('en') }}/</div>
                <input type="text" name="name_en" v-model="status.name_en" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Status name') }}&nbsp;/{{ __('ru') }}/</div>
                <input type="text" name="name_ru" v-model="status.name_ru" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Status name') }}&nbsp;/{{ __('uk') }}/</div>
                <input type="text" name="name_uk" v-model="status.name_uk" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Status notes') }}&nbsp;/{{ __('en') }}/</div>
                <textarea class="appForm-textarea" :placeholder="__('Status notes') + '/' + __('en') + '/'"
                          v-model="status.notes_en"></textarea>
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Status notes') }}&nbsp;/{{ __('ru') }}/</div>
                <textarea class="appForm-textarea" :placeholder="__('Status notes') + '/' + __('ru') + '/'"
                          v-model="status.notes_ru"></textarea>
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Status notes') }}&nbsp;/{{ __('uk') }}/</div>
                <textarea class="appForm-textarea" :placeholder="__('Status notes') + '/' + __('uk') + '/'"
                          v-model="status.notes_uk"></textarea>
            </div>
        </modal-window>
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
                statuses: [],
                status: null
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {
                axios.get('/get-statuses').then(response => {
                    this.statuses = response.data.statuses;
                });
            },

            edit(status) {
                this.status = JSON.parse(JSON.stringify(status));
            },

            destroy(status) {
                axios.post('/destroy-status/' + status.id).then(response => {
                    this.getData();
                });
            },

            create() {
                let status = {
                    id: null,
                    name_en: '',
                    name_ru: '',
                    name_uk: '',
                    notes_en: '',
                    notes_ru: '',
                    notes_uk: '',
                    unit_id: null
                };

                this.edit(status);
            },

            save() {
                axios.post('/save-status', {status: this.status}).then(response => {
                    this.getData();
                    this.cancel();
                });
            },

            cancel() {
                this.status = null;
            }
        }
    }
</script>

<style>
    .appHandbookStatusesTable .appTable-col {
        width: calc((100% - 32px) / 6);
    }
    .appHandbookStatusesTable-tools {
        width: 31px;
    }
</style>
