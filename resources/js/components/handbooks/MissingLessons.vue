<template>
    <div class="appHandbookMissingLessons">
        <pagination v-model="page" :total="total" :per-page="perPage"/>
        <div class="appTable appHandbookMissingLessonsTable">
            <div class="appTable-row appTable-head">
                <div class="appTable-col appHandbookMissingLessons-id">
                    <div>{{ __('ID') }}</div>
                </div>
                <div class="appTable-col appHandbookMissingLessons-name">
                    <div class="appTable-colTop" @click="sort('name')" >
                        <div>{{ __('Name') }}</div>
                        <div class="appTable-sort" v-if="sortBy === 'name'">
                            <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                        </div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.name" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appHandbookMissingLessons-currentLesson">
                    <div class="appTable-colTop" @click="sort('lesson')" >
                        <div>{{ __('Current lesson') }}</div>
                        <div class="appTable-sort" v-if="sortBy === 'lesson'">
                            <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                        </div>
                    </div>
                    <div class="appTable-filter_listFilter">
                        <dropdown v-model="filters.lesson" class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto" :options='lessonNumbers' />
                    </div>
                </div>
                <div class="appTable-col appHandbookMissingLessons-acaryaFirst">
                    <div>{{ __('First acarya') }}</div>
                </div>
                <div class="appTable-col appHandbookMissingLessons-acaryaCurrent">
                    <div>{{ __('Current acarya') }}</div>
                </div>
                <div class="appTable-col appUserList-created appHandbookMissingLessons-initiationDate">
                    <div class="appTable-colTop" @click="sort('receiving')">
                        <div>{{ __('Initiation date') }}</div>
                        <div class="appTable-sort" v-if="sortBy === 'receiving'">
                            <span class="appIcons" :class="'msppIcons-sort-numeric-' + sortOrder"></span>
                        </div>
                    </div>
                    <div class="appTable-filter">
                    </div>
                </div>
                <div class="appTable-col appHandbookMissingLessons-status">
                    <div>{{ __('Status') }}</div>
                </div>
            </div>
            <div class="appTable-body">
                <div v-for="(request, index) in requests" class="appTable-row">
                    <div class="appTable-col appHandbookMissingLessons-id">
                        {{ request.id }}
                    </div>
                    <div class="appTable-col appHandbookMissingLessons-name">
                        {{ request.name }}
                    </div>
                    <div class="appTable-col appHandbookMissingLessons-currentLesson">
                        {{ request.lesson }}
                    </div>
                    <div class="appTable-col appHandbookMissingLessons-acaryaFirst">
                        {{ request.first_acarya }}
                    </div>
                    <div class="appTable-col appHandbookMissingLessons-acaryaCurrent">
                        {{ request.acarya_changed ? request.current_acarya : ''}}
                    </div>
                    <div class="appTable-col appHandbookMissingLessons-status">
                        {{ request.status }}
                    </div>
                    <div class="appTable-col appHandbookMissingLessons-initiationDate">
                        {{ request.initiation_date }}
                    </div>
                    <div class="appTable-col appHandbookMissingLessons-tools">
                        <div class="dhrtDropdown menuWidthAuto dhrtDropdown-menuPositionDown" data-position="down"
                             data-indent-down="16" data-indent-up="16">
                            <div class="dhrtDropdown-back"></div>
                            <a href="#" data-target="appHandbookMissingLessonsTools" class="dhrtDropdown-link"
                               rel="nofollow" data-toggle="dhrtDropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">
                                <div class="appIcons msppIcons-tools appDiary-bodyIcon"></div>
                            </a>
                            <div class="dhrtDropdown-menu" aria-labelledby="appHandbookMissingLessonsTools">
                                <!--<a href="#" rel="nofollow" class="dhrtDropdown-item"
                                   @click.prevent="accept(request)">
                                    {{ __('Accept') }}
                                </a>
                                <a class="dhrtDropdown-item" rel="nofollow" href="#"
                                   @click.prevent="decline(request)">
                                    {{ __('Decline') }}
                                </a>-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <pagination v-if="total >= 50" v-model="page" :total="total" :per-page="perPage"/>
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

                requests: [],

                isProcessing: null,

                sortBy: 'name',
                sortOrder: 'desc',

                filters: {
                    name: '',
                    lesson: '',
                },
                lessonNumbers: {null: this.__('All'), 1: '1', 2: '2', 3: '3', 4: '4', 5: '5', 6: '6'},
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
                    if(this.filters.lesson === "null") this.filters.lesson = null;
                    this.page = 1;
                    this.getData();
                }
            },
        },

        methods: {
            getData() {
                let params = {
                    name: this.filters.name ? this.filters.name : null,
                    lesson: this.filters.lesson ? this.filters.lesson : null,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,

                    take: this.perPage,
                    skip: this.skip,
                };

                axios.get('/missing-lessons-handbook', {params: params}).then(response => {
                    this.requests = response.data.requests;
                    this.total = response.data.total;
                });
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

            accept(request) {
                axios.put('/missing-lesson-accept', {
                    data: request
                }).then(response => {
                    this.$nextTick(() => {
                        this.getData();
                    });
                });
            },

            decline(request) {
                axios.put('/missing-lesson-decline', {
                    data: request
                }).then(response => {
                    this.$nextTick(() => {
                        this.getData();
                    });
                });
            }
        }
    }

</script>
