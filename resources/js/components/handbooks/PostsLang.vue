<template>
    <div class="appHandbookPosts">
        <pagination v-model="page" :total="total" :per-page="perPage"/>
        <div class="appTable">
            <div class="appTable-row appTable-head">
                <div class="appTable-col">
                    <div>{{ __('ID') }}</div>
                </div>
                <div class="appTable-col">
                    <div class="appTable-colTop">
                        <div>{{ __('Title') }}</div>
                    </div>
                </div>
                <div class="appTable-col">
                    <div class="appTable-colTop">
                        <div>{{ __('Lang') }}</div>
                    </div>
                </div>
                <div class="appTable-col">
                    <div class="appTable-colTop">
                        <div>{{ __('Audio') }}</div>
                    </div>
                </div>
                <div class="appTable-col">
                    <div class="appTable-colTop">
                        <div>{{ __('Video') }}</div>
                    </div>
                </div>
                <div class="appTable-col">
                    <div class="appIcons msppIcons-tools appDiary-headIcon"></div>
                </div>
            </div>
            <div class="appTable-body">
                <div v-for="(post, index) in posts" class="appTable-row">
                    <div class="appTable-col">
                        {{ post.id }}
                    </div>
                    <div class="appTable-col">
                        {{ post.title }}
                    </div>
                    <div class="appTable-col">
                        {{ post.lang }}
                    </div>
                    <div class="appTable-col">
                        {{ post.audio }}
                    </div>
                    <div class="appTable-col">
                        {{ post.video }}
                    </div>
                    <div class="appTable-col appHandbookNames-tools">
                        <div class="dhrtDropdown menuWidthAuto dhrtDropdown-menuPositionDown" data-position="down"
                             data-indent-down="16" data-indent-up="16">
                            <div class="dhrtDropdown-back"></div>
                            <a href="#" data-target="appHandbookNamesTools" class="dhrtDropdown-link"
                               rel="nofollow" data-toggle="dhrtDropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">
                                <div class="appIcons msppIcons-tools appDiary-bodyIcon"></div>
                            </a>
                            <div class="dhrtDropdown-menu" aria-labelledby="appHandbookNamesTools">
                                <a href="#" rel="nofollow" class="dhrtDropdown-item"
                                   @click.prevent="edit(post, index)">
                                    {{ __('Edit') }}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <pagination v-if="total >= 50" v-model="page" :total="total" :per-page="perPage"/>

        <modal-window v-if="item && editor" @close="close" @enter="save()" :valid="item.lang && !isProcessing"
                      @cancel="close" :buttonList="['Cancel', 'Save']" @save="save()"
                      :windowName="item.title">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Audio') }}</div>
                <input type="text" name="post_audio" v-model="item.audio" class="appForm-input">
            </div>

            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Video') }}</div>
                <input type="text" name="post_audio" v-model="item.video" class="appForm-input">
            </div>

            <upload-file></upload-file>

            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Language') }}</div>
                <div class="dhrtRadio">
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.lang" value="en">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('English') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.lang" value="ru">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Russian') }}</span>
                    </label>
                </div>
            </div>
        </modal-window>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js'

    import Multiselect from 'vue-multiselect'

    let moment = require('moment');

    import Textarea from "../../../../vue/src/views/forms/form-elements/textarea/Textarea";

    export default {
        components: {
            Textarea,
            flatPickr,
            Multiselect
        },

        data() {
            return {
                page: 1,
                perPage: 10,
                total: 0,

                posts: [],
                item: null,
                itemIndex: null,
                editor: null,
                isProcessing: false,

                sortBy: 'posted_at',
                sortOrder: 'desc',
            }
        },

        mounted() {
            this.getData();
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },
        },

        watch: {
            page() {
                this.getData();
            },

            filters: {
                deep: true,
                handler() {
                    //if(this.filters.sex === "null") this.filters.sex = null;
                    this.page = 1;
                    this.getData();
                }
            },
        },

        methods: {
            getData() {
                let params = {
                    //ru: this.filters.ru ? this.filters.ru : null,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,

                    take: this.perPage,
                    skip: this.skip,
                };

                axios.get('/posts-resource-list', {params: params}).then(response => {
                    this.posts = response.data.posts;
                    this.total = response.data.total;
                });
            },

            save() {
                if(this.isProcessing) return;
                this.isProcessing = 1;
                axios.post('/posts-resource-edit', {post: this.item}).then(response => {
                    this.isProcessing = 0;
                    this.getData();
                    this.close();
                }).catch(error => {
                    this.isProcessing = 0;
                });
            },

            close() {
                this.item = null;
                this.editor = null;
            },

            edit(item, index) {
                this.item = JSON.parse(JSON.stringify(item));
                this.itemIndex = index;
                this.editor = 1;
            },

            sort(column) {
                if (this.sortBy === column) {
                    this.sortOrder = this.sortOrder === 'desc' ? 'asc' : 'desc';
                } else {
                    this.sortOrder = 'desc';
                    this.sortBy = column;
                }

                this.$nextTick(() => {
                    this.getData();
                });
            }
        }
    }

</script>
