<template>
    <div class="appHandbookCategories">
        <!--<pagination v-model="page" :total="total" :per-page="perPage"/>-->
        <div class="appTable">
            <div class="appTable-row appTable-head">
                <div class="appTable-col">
                    <div class="appTable-colTop">
                        <div>{{ __('Name') }}</div>
                    </div>
                </div>
                <div class="appTable-col">
                    <div class="appTable-colTop">
                        <div>{{ __('Parent') }}</div>
                    </div>
                </div>
                <div class="appTable-col">
                    <div class="appTable-colTop">
                        <div>{{ __('Author avatar') }}</div>
                    </div>
                </div>
                <div class="appTable-col">
                    <div class="appTable-colTop">
                        <div>{{ __('Author name en') }}</div>
                    </div>
                </div>
                <div class="appTable-col">
                    <div class="appTable-colTop">
                        <div>{{ __('Author name ru') }}</div>
                    </div>
                </div>
                <div class="appTable-col">
                    <div class="appIcons msppIcons-tools appDiary-headIcon"></div>
                </div>
            </div>
            <div class="appTable-body">
                <div v-for="(category, index) in categories" class="appTable-row">
                    <div class="appTable-col">
                        {{ category.name }}
                    </div>
                    <div class="appTable-col">
                        {{ category.parent ? category.parent.name : __('No') }}
                    </div>
                    <div class="appTable-col">
                        {{ category.author_avatar }}
                    </div>
                    <div class="appTable-col">
                        {{ category.author_name_en }}
                    </div>
                    <div class="appTable-col">
                        {{ category.author_name_ru }}
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
                                   @click.prevent="edit(category, index)">
                                    {{ __('Edit') }}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--<pagination v-if="total >= 50" v-model="page" :total="total" :per-page="perPage"/>-->

        <modal-window v-if="item && editor" @close="close" @enter="save()" :valid="!isProcessing"
                      @cancel="close" :buttonList="['Cancel', 'Save']" @save="save()"
                      :windowName="item.name">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Parent') }}</div>
                <multiselect
                    v-model="item.parent"
                    :options="categories"
                    label="name"
                    track-by="id"
                    :placeholder="__('Select option')"
                />
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Author avatar') }}</div>
                <input type="text" v-model="item.author_avatar" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Author name en') }}</div>
                <input type="text" v-model="item.author_name_en" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Author name ru') }}</div>
                <input type="text" v-model="item.author_name_ru" class="appForm-input">
            </div>
        </modal-window>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: {
            Multiselect
        },

        data() {
            return {
                page: 1,
                perPage: 10,
                total: 0,

                categories: [],
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

                axios.get('/posts-categories-list', {params: params}).then(response => {
                    this.categories = response.data.categories;
                    //this.total = response.data.total;
                });
            },

            save() {
                if(this.isProcessing) return;
                this.isProcessing = 1;
                axios.post('/posts-categories-list', {category: this.item}).then(response => {
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
