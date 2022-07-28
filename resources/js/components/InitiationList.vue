<template>

    <div class="appInitiationsList">
        <div class="appPageTools-wrap">
            <div class="appPageTools-total">
                {{ __('Total') }}: {{ total }}
            </div>
            <div class="appPageTools pagination">

                <div class="appPageTools-btn" :class="{disabled: page === 1}" @click.prevent="page = 1"><div class="appPageTools-btnText">«</div></div>

                <div class="appPageTools-btn" v-if="number !== '...'" :class="{active: page === number}" v-for="number of pagination(page, pages)" @click.prevent="page = number"><div class="appPageTools-btnText">{{ number }}</div></div>
                <div class="appPageTools-btn disabled" v-else><div class="appPageTools-btnText">...</div></div>

                <div class="appPageTools-btn" :class="{disabled: page === pages}" @click.prevent="page = pages"><div class="appPageTools-btnText">»</div></div>
            </div>
        </div>
        <div class="appPageContent">
                <div class="appTable appInitiations">
                    <div class="appTable-row appTable-head">
                        <div class="appTable-col appInitiations-avatar"></div>
                        <div class="appTable-col appInitiations-name">
                            <div class="appTable-colTop" @click="sort('name')" >
                                <div>{{ __('Name') }}</div>
                                <div class="appTable-sort" v-if="sortBy === 'name'">
                                    <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                                </div>
                            </div>
                            <div class="appTable-filter">
                                <input type="text" v-model="filters.name" class="appTable-filterField">
                                <div class="appTable-sortIcon appTable-filter_listIcon msppIcons-filter"></div>
                            </div>
                        </div>
                        <div class="appTable-col appInitiations-city">
                            <div class="appTable-colTop" @click="sort('city')" >
                                <div>{{ __('City') }}</div>
                                <div class="appTable-sort" v-if="sortBy === 'city'">
                                    <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                                </div>
                            </div>
                            <div class="appTable-filter">
                                <input type="text" v-model="filters.city" class="appTable-filterField">
                                <div class="appTable-sortIcon appTable-filter_listIcon appIcons msppIcons-filter"></div>
                            </div>
                        </div>
                        <div class="appTable-col appInitiations-phone">
                            <div>{{ __('Phone') }}</div>
                            <div class="appTable-filter">
                                <input type="text" class="appTable-filterField" v-model="filters.phone">
                                <div class="appTable-sortIcon appTable-filter_listIcon appIcons msppIcons-filter"></div>
                            </div>
                        </div>
                        <div class="appTable-col appInitiations-roles">
                            <div>{{ __('Country') }}</div>
                            <div class="appTable-filter">
                                <input type="text" v-model="filters.country" class="appTable-filterField">
                                <!--<div class="appTable-sortIcon appTable-filter_listIcon appIcons msppIcons-filter"></div>-->
                            </div>
                        </div>
                        <div class="appTable-col appInitiations-language">
                            <div class="appTable-colTop" @click="sort('en')" >
                                <div>{{ __('EN') }}</div>
                                <div class="appTable-sort" v-if="sortBy === 'en'">
                                    <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                                </div>
                            </div>
                            <div></div>
                        </div>
                        <div class="appTable-col appInitiations-lesson">
                            <div class="appInitiations-lessonText">{{ __('Lesson') }}</div>
                            <div class="appTable-filter_listFilter">
                                <dropdown v-model="filters.lesson" class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto" :options='lessonNumbers' />
                            </div>
                        </div>
                        <div class="appTable-col appInitiations-status">
                            <div class="appTable-colTop" @click="sort('lft')" >
                                <div>LFT</div>
                                <div class="appTable-sort" v-if="sortBy === 'lft'">
                                    <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                                </div>
                            </div>
                            <div></div>
                        </div>
                        <div class="appTable-col appInitiations-profession">
                            <div>{{ __('Profession') }}</div>
                            <div class="appTable-filter">
                                <input type="text" v-model="filters.profession" class="appTable-filterField">
                                <div class="appTable-sortIcon appTable-filter_listIcon msppIcons-filter"></div>
                            </div>
                        </div>
                        <div class="appTable-col appInitiations-receiving">
                            <div class="appTable-colTop" @click="sort('receiving_date')" >
                                <div>{{ __('Receiving date') }}</div>
                                <div class="appTable-sort" v-if="sortBy === 'receiving_date'">
                                    <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                                </div>
                            </div>
                            <div class="appTable-filter">

                            </div>
                        </div>
                        <div class="appTable-col appInitiations-tools"></div>
                    </div>

                    <div class="appTable-body">
                        <div v-for="initiation of initiations"  class="appTable-row">

                            <div class="appTable-col appInitiations-avatar">
                                <a :href="'https://vk.com/id' + initiation.vk_id" v-if="initiation.vk_id"><avatar class="appLists-avatarImage" :src="initiation.avatar ? initiation.avatar : '/images/no-avatar.jpg'"></avatar></a>
                                <avatar v-else class="appLists-avatarImage" :src="initiation.avatar ? initiation.avatar : '/images/no-avatar.jpg'"></avatar>
                            </div>
                            <div class="appTable-col appInitiations-name" :title="initiation.userName + ' (' + initiation.spiritual_name + ')'">
                                <div>{{ initiation.spiritual_name }}</div>
                                <div>{{ initiation.userName }}</div>
                            </div>
                            <div class="appTable-col appInitiations-city" :title="__('City')">{{ initiation.city }}</div>
                            <div class="appTable-col appInitiations-phone" :title="__('Phone')"><a :href="'tel:'+initiation.phone">{{ initiation.phone }}</a></div>
                            <div class="appTable-col appInitiations-roles">
                                <div>{{ initiation.country }}</div>
                            </div>
                            <div class="appTable-col appInitiations-language" :title="__('EN')">
                                <div v-if="!initiation.english" class="appInitiations-languageNo">
                                    {{ __('No') }}
                                </div>
                                <div v-else class="appInitiations-languageYes">
                                    {{ __('Yes') }}
                                </div>
                            </div>
                            <div class="appTable-col appInitiations-lesson" data-toggle="tooltip" :title="__('Lesson')">
                                <div class="appInitiations-lessonValue">
                                    {{ initiation.lesson_number }}
                                </div>
                            </div>
                            <div class="appTable-col appInitiations-status" :title="__('Status')">
                                <div class="appRequests-statusBtn" @click="unlimitedLftWorks(initiation)">{{ initiation.lftStatus }}</div>
                            </div>
                            <div class="appTable-col appInitiations-profession" :title="initiation.profession">
                                {{ initiation.profession }}
                            </div>
                            <div class="appTable-col appInitiations-receiving">{{ dateFormat(initiation.receiving_date) }}</div>
                            <div class="appTable-col appInitiations-tools">
                                <div class="dhrtDropdown menuWidthAuto dhrtDropdown-menuPositionDown" data-position="down" data-indent-down="16" data-indent-up="16">
                                    <div class="dhrtDropdown-back"></div>
                                    <a href="#appInitiationsTools" data-target="appInitiationsTools" class="dhrtDropdown-link" rel="nofollow" data-toggle="dhrtDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="appIcons msppIcons-more-vertical"></span>
                                    </a>
                                    <div class="dhrtDropdown-menu" aria-labelledby="appInitiationsToolsLink">
                                        <a class="dhrtDropdown-item" rel="nofollow" href="#" @click.prevent="openDetails(initiation)">
                                            {{ __('Details') }}
                                        </a>
                                        <a v-if="initiation.access" class="dhrtDropdown-item" rel="nofollow" href="#" @click.prevent="openDiary(initiation)">
                                            {{ __('Diary') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div v-if="total >= 10" class="appPageTools pagination">

            <div class="appPageTools-btn" :class="{disabled: page === 1}" @click.prevent="page = 1"><div class="appPageTools-btnText">«</div></div>

            <div class="appPageTools-btn" v-if="number !== '...'" :class="{active: page === number}" v-for="number of pagination(page, pages)" @click.prevent="page = number"><div class="appPageTools-btnText">{{ number }}</div></div>
            <div class="appPageTools-btn disabled" v-else><div class="appPageTools-btnText">...</div></div>

            <div class="appPageTools-btn" :class="{disabled: page === pages}" @click.prevent="page = pages"><div class="appPageTools-btnText">»</div></div>
        </div>

        <modal-window v-if="change" :buttonList="['Close', 'Save']" @close="closeChange" @save="applyName" :windowName="__('Initiation')">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{__('Spiritual Name')}}</div>
                <input type="text" class="form-control" v-model="change.spiritual_name">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{__('Notes')}}</div>
                <textarea class="form-control" v-model="change.notes"></textarea>
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{__('Lessons')}}</div>
                <div class="appForm-inline" v-for="prev_lesson of change.prev_lessons">
                    <span>{{ prev_lesson.lesson_number }}</span>
                    <span>{{ prev_lesson.teacher }}</span>
                    <span>{{ prev_lesson.receiving_date }}</span>
                </div>
            </div>
            <div class="appForm-group appForm-inline" v-if="change.access">
                <div class="appForm-groupTitle">{{__('Average practice diary points')}}</div>
                <div>{{ round(change.avgDiary) }}</div>
            </div>
        </modal-window>
    </div>
</template>

<script>
    import Textarea from "../../../vue/src/views/forms/form-elements/textarea/Textarea";
    let moment = require('moment');
    import Multiselect from 'vue-multiselect';

    export default {
        components: {Textarea, Multiselect},

        props: ['perPage'],

        data() {
            return {
                page: 1,
                total: 0,
                initiations: [],
                change: null,

                filters: {
                    name: '',
                    city: '',
                    phone: '',
                    profession: '',
                    lesson: null,
                    country: ''
                },

                lessonNumbers: {null: this.__('All'), 1:'1', 2:'2', 3: '3', 4:'4', 5:'5', 6:'6'},

                sortBy: 'receiving_date',
                sortOrder: 'desc',

                countries: []
            }
        },

        mounted() {
            this.getData();
        },

        watch: {
            page() {
                this.getData();
            },

            filters: {
                deep: true,
                handler() {
                    if(this.filters.lesson === "null") {
                        this.filters.lesson = null;
                    }
                    this.getData();
                }
            }
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },

            pages() {
                return parseInt(this.total / this.perPage) + (this.total % this.perPage ? 1 : 0)
            }
        },

        methods: {
            pagination(c, m) {
                let current = c,
                    last = m,
                    delta = 2,
                    left = current - delta,
                    right = current + delta + 1,
                    range = [],
                    rangeWithDots = [],
                    l;

                for (let i = 1; i <= last; i++) {
                    if (i === 1 || i === last || i >= left && i < right) {
                        range.push(i);
                    }
                }

                for (let i of range) {
                    if (l) {
                        if (i - l === 2) {
                            rangeWithDots.push(l + 1);
                        } else if (i - l !== 1) {
                            rangeWithDots.push('...');
                        }
                    }
                    rangeWithDots.push(i);
                    l = i;
                }

                return rangeWithDots;
            },

            round(n) {
              return Math.round(n*10)/10;
            },

            sort(field) {
                if(this.sortBy === field) {
                    this.sortOrder = this.sortOrder === 'desc' ? 'asc' : 'desc';
                } else {
                    this.sortBy = field;
                    this.sortOrder = 'desc';
                }

                this.$nextTick(() => {
                    this.getData();
                });
            },

            getData() {

                let params = {
                    userName: this.filters.name ? this.filters.name : null,
                    city: this.filters.city ? this.filters.city : null,
                    phone: this.filters.phone ? this.filters.phone : null,
                    profession: this.filters.profession ? this.filters.profession : null,
                    lesson: this.filters.lesson ? this.filters.lesson : null,
                    country: this.filters.country ? this.filters.country : null,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,

                    take: this.perPage,
                    skip: this.skip
                };

                axios.get('/from-meditation-lessons', {params: params}).then(response => {
                    this.initiations = response.data.result.lessons;
                    this.total = response.data.result.total;
                    this.countries = response.data.countries;
                });
            },

            dateFormat(date) {
                return moment(date).format('DD.MM.YY');
            },

            closeChange() {
                this.change = null;
            },

            openDetails(record) {
                this.change = record;
            },

            openDiary(diary) {
                window.open("/diary?user="+diary.userId)
            },

            applyName() {
                axios.post('/spiritual-name', {userId: this.change.userId, spiritualName: this.change.spiritual_name, notes: this.change.notes}).then(response => {
                    this.closeChange();
                });
            },

            unlimitedLftWorks(request) {
                axios.put('/lft', {userId: request.userId}).then(response => {
                    this.getData();
                });
            }

        }
    }
</script>
