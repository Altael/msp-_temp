<template>
    <div class="appHandbookPrograms">
        <!--<pagination v-model="page" :total="total" :per-page="perPage"/>-->
        <div :title="__('Backward')"  class="amPage-title" v-if="$root.am" @click="back">
            {{ __('Unit programs editor') }}
        </div>
        <div class="appHandbookPrograms-toolbar">
            <div></div>
            <div class="appHandbookPrograms-toolbarButtons">
                <div class="appHandbookPrograms-toolbarButtonsItem appIcon msppIcons-file-plus" @click="create()" :title="__('Add program')"></div>
            </div>
        </div>

        <div class="appTable">
            <div class="appTable-row appTable-head">
                <div class="appTable-col appHandbookPrograms-order">
                    <div class="appTable-colTop">
                        <div>n/n</div>
                    </div>
                </div>
                <div class="appTable-col appHandbookPrograms-name">
                    <div class="appTable-colTop">
                        <div>{{ __('Program name') }}&nbsp</div>
                    </div>
                </div>
                <div class="appTable-col appHandbookPrograms-vip">
                    <div class="appTable-colTop">
                        <div>{{ __('VIP') }}</div>
                    </div>
                </div>


            </div>
            <div class="appTable-body">
                <div v-for="(program, index) in programs" class="appTable-row">
                    <div class="appTable-col appHandbookPrograms-order">
                        {{ program.order ? program.order : ''}}
                    </div>

                    <div class="appTable-col appHandbookPrograms-name">
                        <div class="appHandbookPrograms-nameName">
                            <template v-if="!(program.short_name_ru || program.name_ru || program.short_name_en || program.name_en)">
                                {{ __('No name') }}
                            </template>
                            <template v-else-if="$root.lang === 'ru'">
                                <span class="short" v-if="program.short_name_ru">{{ program.short_name_ru }}</span>
                                <span v-if="program.short_name_ru && program.name_ru">:&nbsp;</span>
                                <span v-if="program.name_ru">{{ program.name_ru }}</span>
                            </template>
                            <template v-else>
                                <span class="short" v-if="program.short_name_ru">{{ program.short_name_ru }}</span>
                                <span v-if="program.short_name_ru && program.name_ru">:&nbsp;</span>
                                <span v-if="program.name_ru">{{ program.name_ru }}</span>
                            </template>

                        </div>
                        <div class="appHandbookPrograms-nameNotes">
                            <template v-if="$root.lang === 'ru'">
                                {{ program.notes_ru }}
                            </template>
                            <template v-else>
                                {{ program.notes_en }}
                            </template>
                        </div>
                    </div>

                    <div class="appTable-col appHandbookPrograms-vip">
                        {{ program.vip ? __('VIP') : '' }}
                    </div>

                    <div class="appTable-col appHandbookPrograms-tools">
                        <action-dropdown>
                            <a href="#" rel="nofollow" class="dhrtDropdown-item"
                               @click.prevent="edit(program, index)">
                                {{ __('Edit') }}
                            </a>
                        </action-dropdown>
                    </div>
                </div>
            </div>
        </div>
        <!--<pagination v-if="total >= 50" v-model="page" :total="total" :per-page="perPage"/>-->

        <modal-window v-if="item && editor" @close="close" @enter="save()" :valid="!isProcessing && item.short_name_en.length <= 5 && item.short_name_ru.length <= 5"
                      @cancel="close" :buttonList="['Cancel', 'Save']" @save="save()"
                      :windowName="item.slug">

<!--            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Program slug') }}</div>
                <input type="text" v-model="item.slug" class="appForm-input">
            </div>-->
            <div class="appForm-group eventEdit-vip">
                <div class="appForm-groupTitle">
                    <div>{{ __('VIP') }}</div>
                    <div class="appForm-groupSubtitle">{{ __('Show collapse in visit statistics page') }}</div>
                </div>
                <div class="eventEdit-vipCheckbox">
                    <input type="checkbox" class="appForm-input" v-model="item.vip"/>
                </div>
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">
                    <div>{{ __('Order') }}</div>
                    <div class="appForm-groupSubtitle">{{ __('Col number (prior)') }}</div>
                </div>
                <div>
                    <input type="number" class="appForm-input" v-model="item.order"/>
                </div>
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Program shortname') }} /ру/</div>
                <input type="text" class="appForm-input" :class="{'error': item.short_name_ru.length > 5}" v-model="item.short_name_ru"/>
                <div class="appForm-groupNotes" v-if="item.short_name_ru.length > 5">{{ __('Program shortname may contain only 5 characters or less') }}</div>
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Program shortname') }} /en/</div>
                <input type="text" class="appForm-input" :class="{'error': item.short_name_en.length > 5}" v-model="item.short_name_en"/>
                <div class="appForm-groupNotes" v-if="item.short_name_en.length > 5">{{ __('Program shortname may contain only 5 characters or less') }}</div>
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Program name') }} /ру/</div>
                <input type="text" v-model="item.name_ru" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Program name') }} /en/</div>
                <input type="text" v-model="item.name_en" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Program notes') }} /ру/</div>
                <textarea class="appForm-textarea" v-model="item.notes_ru"></textarea>
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Program notes') }} /en/</div>
                <textarea class="appForm-textarea" v-model="item.notes_en"></textarea>
            </div>

        </modal-window>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    import Textarea from "../../../../vue/src/views/forms/form-elements/textarea/Textarea";

    export default {
        components: {
            Multiselect,
            Textarea
        },

        data() {
            return {
                page: 1,
                perPage: 10,
                total: 0,

                programs: [],
                item: null,
                itemIndex: null,
                editor: null,
                isProcessing: false,

                sortBy: 'created_at',
                sortOrder: 'desc',
                am: false
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

                axios.get('/programs-list', {params: params}).then(response => {
                    this.programs = response.data.programs;
                    //this.total = response.data.total;
                });
            },

            save() {
                if(this.isProcessing) return;
                this.isProcessing = 1;
                axios.post('/programs-list', {program: this.item}).then(response => {
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

            create() {
                this.item = {
                    id: null,
                    slug: '',
                    name_en: '',
                    name_ru: '',
                    notes_en: '',
                    notes_ru: '',
                    vip: false,
                    order: 0,
                    short_name_ru: '',
                    short_name_en: ''
                };
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
            },

            back() {
                window.history.back();
            }
        }
    }

</script>
