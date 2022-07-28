<template>
    <div class="appSpiritualNames">
        <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" @click="create()">{{ __('Add') }}</div>

        <pagination v-model="page" :total="total" :per-page="perPage"/>
        <div class="appTable appSpiritualNamesTable">
            <div class="appTable-row appTable-head">
                <div class="appTable-col appSpiritualNames-nameSanskrit">
                    <div>{{ __('Sanskrit name') }}</div>
                </div>
                <div class="appTable-col appSpiritualNames-nameEn">
                    <div class="appTable-colTop" @click="sort('en')" >
                        <div>{{ __('En name') }}</div>
                        <div class="appTable-sort" v-if="sortBy === 'en'">
                            <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                        </div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.en" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSpiritualNames-nameRu">
                    <div class="appTable-colTop" @click="sort('ru')" >
                        <div>{{ __('Ru name') }}</div>
                        <div class="appTable-sort" v-if="sortBy === 'ru'">
                            <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                        </div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.ru" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSpiritualNames-descEn">
                    <div>{{ __('En description') }}</div>
                </div>
                <div class="appTable-col appSpiritualNames-descRu">
                    <div>{{ __('Ru description') }}</div>
                </div>
                <div class="appTable-col appSpiritualNames-sex">
                    <div class="appTable-colTop" @click="sort('sex')" >
                        <div>{{ __('Sex') }}</div>
                        <div class="appTable-sort" v-if="sortBy === 'sex'">
                            <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                        </div>
                    </div>
                    <div class="appTable-filter_listFilter">
                        <dropdown v-model="filters.sex" class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto" :options='sexType' />
                    </div>
                </div>
                <div class="appTable-col appSpiritualNames-tools">
                    <div class="appIcons msppIcons-tools appDiary-headIcon"></div>
                </div>
            </div>
            <div class="appTable-body appSpiritualNamesTable-body">
                <div v-for="(name, index) in names" class="appTable-row">
                    <div class="appTable-col appSpiritualNames-nameSanskrit">
                        {{ name.sanskrit }}
                    </div>
                    <div class="appTable-col appSpiritualNames-nameEn">
                        {{ name.en }}
                    </div>
                    <div class="appTable-col appSpiritualNames-nameRu">
                        {{ name.ru }}
                    </div>
                    <div class="appTable-col appSpiritualNames-descEn">
                        {{ name.desc_en }}
                    </div>
                    <div class="appTable-col appSpiritualNames-descRu">
                        {{ name.desc_ru }}
                    </div>
                    <div class="appTable-col appSpiritualNames-sex">
                        {{ name.sex }}
                    </div>
                    <div class="appTable-col appSpiritualNames-tools">
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
                                   @click.prevent="edit(name, index)">
                                    {{ __('Edit') }}
                                </a>
                                <a class="dhrtDropdown-item" rel="nofollow" href="#"
                                   @click.prevent="destroyModal(name, index)">
                                    {{ __('Delete') }}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <pagination v-if="total >= 50" v-model="page" :total="total" :per-page="perPage"/>

        <modal-window v-if="item && editor" @close="close" @enter="save()" :valid="item.sanskrit && item.en && item.ru && !isProcessing"
                      @cancel="close" :buttonList="['Cancel', 'Save']" @save="save()"
                      :windowName="item.sanskrit">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Sanskrit') }}</div>
                <input type="text" name="middle_name" v-model="item.sanskrit" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('English name') }}</div>
                <input type="text" name="middle_name" v-model="item.en" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Russian name') }}</div>
                <input type="text" name="middle_name" v-model="item.ru" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('English description') }}</div>
                <input type="text" name="middle_name" v-model="item.desc_en" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Russian description') }}</div>
                <input type="text" name="middle_name" v-model="item.desc_ru" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Sex') }}</div>
                <div class="dhrtRadio">
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.sex" value="male">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Male') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.sex" value="female">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Female') }}</span>
                    </label>
                </div>
            </div>
        </modal-window>
        <modal-window v-if="item && remove" @close="close" @no="close" @ok="destroy(item, itemIndex)"
                      :buttonList="['No', 'Ok']" :windowName="__('Confirmation')">
            <div class="appForm-group">
                <span>{{ __('Are you sure?') }}</span>
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
                page: 1,
                perPage: 10,
                total: 0,

                names: [],
                item: null,
                itemIndex: null,
                editor: null,
                detail: null,
                remove: null,
                isProcessing: null,

                sortBy: 'sex',
                sortOrder: 'desc',

                filters: {
                    ru: '',
                    en: '',
                    sex: null
                },
                sexType: {null: this.__('Both'), male: this.__('Male'), female: this.__('Female')},
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
                    if(this.filters.sex === "null") this.filters.sex = null;
                    this.page = 1;
                    this.getData();
                }
            },
        },

        methods: {
            getData() {
                let params = {
                    ru: this.filters.ru ? this.filters.ru : null,
                    en: this.filters.en ? this.filters.en : null,
                    sex: this.filters.sex,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,

                    take: this.perPage,
                    skip: this.skip,
                };

                axios.get('/names', {params: params}).then(response => {
                   this.names = response.data.names;
                   this.total = response.data.total;
                });
            },

            create() {
                this.item = {
                    id: null,
                    sanskrit: null,
                    en: null,
                    ru: null,
                    desc_en: '',
                    desc_ru: '',
                    sex: 'male'
                };
                this.editor = 1;
            },

            save() {
                if(this.isProcessing) return;
                this.isProcessing = 1;
                axios.post('/names', {name: this.item}).then(response => {
                    this.isProcesssing = 0;
                    this.names[this.itemIndex] = JSON.parse(JSON.stringify(this.item));
                    this.close();
                });
            },

            destroy(item, index) {
                axios.delete('/names/'+ item.id).then(response => {
                    this.names.splice(index, 1);
                    this.remove = null;
                });
            },

            destroyModal(item, index) {
                this.remove = 1;
                this.item = JSON.parse(JSON.stringify(item));
                this.itemIndex = index;
            },

            close() {
                this.item = null;
                this.editor = null;
                this.detail = null;
                this.remove = null;
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
