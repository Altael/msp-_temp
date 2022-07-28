<template>
    <div id="appMedia">
        <div class="appMediaTools">
            <div class="appMediaTools-files">
                <upload-file @media-uploaded="getData"></upload-file>
                <add-web-file @saved="getData"></add-web-file>
            </div>
            <div class="appMediaTools-filters">
                <div class="appMedia-filterFileName">
                    <input type="text" v-model.lazy="filters.name" class="appTable-filterField" :placeholder="__('Search filename...')">
                </div>
                <label class="dhrtSwitch textLeft">
                    <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                           v-model="filters.hidden">
                    <span class="dhrtSwitchSpinner"></span>
                    <span class="dhrtSwitchSpinnerText">{{ __('Show hidden files') }}</span>
                </label>
            </div>
        </div>

        <pagination v-model="page" :total="total" :per-page="perPage"/>

        <div class="appTable appMediaLibraryTable">
            <div class="appTable-row appTable-head appMediaLibraryTable-head">
                <div class="appTable-col appMediaLibraryTable-filePath">
                    <div class="appTable-colTop">
                        <div>{{ __('File name') }}</div>
                    </div>
                </div>
                <div class="appTable-col appMediaLibraryTable-fileLink">
                    <div class="appTable-colTop">
                        <div>{{ __('File link') }}</div>
                    </div>
                </div>
                <div class="appTable-col appMediaLibrary-tools">
                    <div class="appIcons msppIcons-tools appDiary-headIcon"></div>
                </div>
            </div>
            <div class="appTable-body">
                <div v-for="file of files" class="appTable-row">
                    <div class="appTable-col appMediaLibraryTable-filePath textOverflowRow">
                        {{ file.path }}
                    </div>
                    <div class="appTable-col appMediaLibraryTable-fileLink textOverflowRow">
                        <template v-if="file.source === 'file'">
                            <a :href=" root  + '/media/' + file.path">{{ root }}/media/{{ file.path }}</a>
                        </template>
                        <template v-else>
                            <a :href="file.path">{{ file.path }}</a>
                        </template>
                    </div>
                    <div class="appTable-col appMediaLibrary-tools">
                        <action-dropdown menuAlignmentLeft>
                            <template #label><div class="appIcons msppIcons-tools appDiary-bodyIcon"></div></template>
                            <template v-if="file.source === 'url'">
                                <a href="#" rel="nofollow" class="dhrtDropdown-item"
                                   @click.prevent="edit(file)">
                                    {{ __('Edit') }}
                                </a>
                            </template>
                            <a href="#" rel="nofollow" class="dhrtDropdown-item"
                               @click.prevent="destroy_window(file)">
                                {{ __('Delete') }}
                            </a>
                        </action-dropdown>
                    </div>
                </div>
            </div>
        </div>

        <modal-window v-if="file && remove" @close="close" @no="close" @ok="destroy(file)"
                      :buttonList="['No', 'Ok']" :windowName="__('Confirmation')">
            <div class="appForm-group">
                <span>{{ __('Are you sure?') }}</span>
            </div>
        </modal-window>
    </div>
</template>

<script>
    export default {
        props: ['root'],

        data() {
            return {
                files: [],
                file: null,

                remove: false,
                editor: false,
                isProcessing: false,

                page: 1,
                perPage: 50,
                total: 0,

                filters: {
                    hidden: false,
                    name: null
                }
            }
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },
        },

        watch: {
            skip() {
                this.getData();
            },
            filters: {
                deep: true,
                handler() {
                    this.getData();
                }
            }
        },

        methods: {
            getData() {
                let params = {
                    take: this.perPage,
                    skip: this.skip,
                    hidden: this.filters.hidden ? this.filters.hidden : null,
                    name: this.filters.name ? this.filters.name : null
                };

                axios.get('/get-media-lib-list', {params: params}).then( response => {
                    this.files = response.data.files;
                    this.total = response.data.total;
                });
            },

            destroy_window(file) {
                this.file = JSON.parse(JSON.stringify(file));
                this.remove = true;
            },

            edit(file) {
                this.file = JSON.parse(JSON.stringify(file));
                this.editor = true;
            },

            destroy(file) {
                this.isProcessing = true;
                axios.get('/delete-media', {params: {file: file.id}}).then(response => {
                    this.isProcessing = false;
                    this.close();
                    this.getData();
                });
            },

            save() {
                this.isProcessing = true;
                axios.post('/save-file',  {file: this.file}).then(response => {
                    this.isProcessing = false;
                    this.close();
                    this.getData();
                });
            },

            close() {
                this.editor = false;
                this.remove = false;
                this.file = null;
            },
        },

        mounted() {
            this.getData();
        }
    }
</script>

<style>
    .appMediaLibraryTable .appTable-col {
        width: calc(50% - 16px);
    }
    .appMediaLibrary-tools {
        width: 31px;
    }
</style>
