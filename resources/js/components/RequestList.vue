<template>

    <div class="appRequestList">
        <div class="appPageTools-wrap" v-if="!id">
            <div class="appPageTools-total">
                {{ __('Total') }}: {{ total }}
            </div>
            <div class="appPageTools pagination">
                <div class="appPageTools-btn" :class="{'active': show === 'all'}" @click="show = 'all'"><div class="appPageTools-btnText">{{ __('All') }}</div></div>
                <div class="appPageTools-btn" :class="{'active': show === 'new'}" @click="show = 'new'"><div class="appPageTools-btnText">{{ __('New') }}</div></div>
                <div class="appPageTools-btn" :class="{'active': show === 'old'}" @click="show = 'old'"><div class="appPageTools-btnText">{{ __('Old') }}</div></div>
                <div class="appPageTools-btn" :class="{disabled: page === 1}" @click.prevent="page = 1"><div class="appPageTools-btnText">«</div></div>

                <div class="appPageTools-btn" v-if="number !== '...'" :class="{active: page === number}" v-for="number of pagination(page, pages)" @click.prevent="page = number"><div class="appPageTools-btnText">{{ number }}</div></div>
                <div class="appPageTools-btn disabled" v-else><div class="appPageTools-btnText">...</div></div>

                <div class="appPageTools-btn" :class="{disabled: page === pages}" @click.prevent="page = pages"><div class="appPageTools-btnText">»</div></div>
            </div>
        </div>

        <div class="appRequests-actionBtn" v-if="id"><a href="/requests">{{ __('Return to standard view') }}</a></div>

        <div class="appPageContent">
            <div class="appTable appRequests">
                <div v-if="!id" class="appTable-row appTable-head">
                    <div class="appTable-col appRequests-avatar"></div>
                    <div class="appTable-col appRequests-name">
                        <div>{{ __('Name') }}</div>
                        <div class="appTable-sortFilter">
                            <input type="text" v-model.lazy="filters.name" class="appTable-filterField">
                            <div class="appTable-sortIcon appTable-filter_listIcon msppIcons-filter"></div>
                        </div>
                    </div>
                    <div class="appTable-col appRequests-city">
                        <div>{{ __('City') }}</div>
                        <div class="appTable-sortFilter">
                            <input type="text" v-model.lazy="filters.city" class="appTable-filterField">
                            <div class="appTable-sortIcon appTable-filter_listIcon appIcons msppIcons-filter"></div>
                        </div>
                    </div>
                    <div class="appTable-col appRequests-action">
                        <div class="appRequests-actionText">{{ __('Act') }}</div>

                        <dropdown v-model="filters.requestType" class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto" :options='{null: __("All"), get: __("Lesson"), check: __("Check")}' />

                        <!--<select class="appTable-filterField" v-model="filters.requestType">
                                <option :value="null">Все</option>
                                <option value="get">Урок</option>
                                <option value="check">Проверка</option>
                            </select>-->
                    </div>
                    <div class="appTable-col appRequests-lesson">
                        <div class="appRequests-lessonText">{{ __('Lesson') }}</div>
                        <div class="appTable-filter_listFilter">
                            <dropdown v-model="filters.lesson" class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto" :options='lessonNumbers' />
                        </div>
                    </div>
                    <div class="appTable-col appRequests-phone">
                        <div>{{ __('Phone') }}</div>
                        <div class="appTable-sortFilter">
                            <input type="text" class="appTable-filterField" v-model.lazy="filters.phone">
                            <div class="appTable-sortIcon appTable-filter_listIcon appIcons msppIcons-filter"></div>
                        </div>
                    </div>
                    <div class="appTable-col appRequests-language">
                        <div>{{ __('Country') }}</div>
                        <div class="appTable-sortFilter">
                            <input type="text" class="appTable-filterField" v-model.lazy="filters.country">
                            <!--<div class="appTable-sortIcon appTable-filter_listIcon appIcons msppIcons-filter"></div>-->
                        </div>
                    </div>
                    <div class="appTable-col appRequests-hours">
                        <div>{{ __('Time') }}</div>
                        <div class="appTable-sortFilter">
                            <input type="number" class="appTable-filterField" v-model.lazy="filters.time">
                            <div class="appTable-sortIcon appTable-filter_listIcon appIcons msppIcons-filter"></div>
                        </div>
                    </div>
                    <div class="appTable-col appRequests-status">
                        <div class="appTable-colTop">
                            <div>LFT</div>
                            <div></div>
                        </div>
                    </div>

                    <div class="appTable-col appRequests-creation" @click="sort('created')">
                        <div class="appTable-colTop">
                            <div>{{ __('Created') }}</div>
                            <div class="appTable-sort" v-if="sortBy === 'created'">
                                <span class="appIcons" :class="'msppIcons-sort-alpha-' + sortOrder"></span>
                            </div>
                        </div>

                        <div class="appTable-sortFilter">
                        </div>
                    </div>
                    <div class="appTable-col appRequests-tools"></div>
                </div>

                <div class="appTable-body">
                    <div v-for="request of requests"  class="appTable-row">

                        <div class="appTable-col appRequests-avatar">
                            <a :href="'https://vk.com/id' + request.vk_id" v-if="request.vk_id"><avatar class="appLists-avatarImage" :src="request.userImage ? request.userImage : '/images/no-avatar.jpg'"></avatar></a>
                            <avatar v-else class="appLists-avatarImage" :src="request.userImage ? request.userImage : '/images/no-avatar.jpg'"></avatar>
                        </div>
                        <div class="appTable-col appRequests-name" :title="request.userName">
                            <span class="appIcons msppIcons-telegram appUser-telegramIcon" :class="{'appUser-telegramTrue': request.telegram_id, 'appUser-telegramFalse': !request.telegram_id}"></span>
                            {{ request.userName }}
                        </div>
                        <div class="appTable-col appRequests-city">{{ request.city }}</div>
                        <div class="appTable-col appRequests-action">
                            <template v-if="request.status">
                                <template v-if="request.type === 'get'">{{ __('Received') }}</template>
                                <template v-if="request.type === 'check'">{{ __('Checked') }}</template>
                            </template>
                            <div class="appRequests-actionBtn" @click="lessonRedirect(request)" v-else-if="$root.permissions.includes('approve_lessons')">
                                <template v-if="request.type === 'get'">
                                    {{ __('Give a lesson') }}
                                </template>
                                <template v-if="request.type === 'check'">
                                    {{ __('Check') }}
                                </template>
                            </div>
                            <div v-else>
                                <template v-if="request.type === 'get'">
                                    {{ __('Give a lesson') }}
                                </template>
                                <template v-if="request.type === 'check'">
                                    {{ __('Check') }}
                                </template>
                            </div>
                        </div>
                        <div class="appTable-col appRequests-lesson" data-toggle="tooltip" :title="__('Lesson')">
                            <div class="appRequests-lessonValue">
                                {{ request.lesson }}
                            </div>
                        </div>
                        <div class="appTable-col appRequests-phone" :title="__('Phone')"><a :href="'tel:'+request.phone">{{ request.phone }}</a></div>
                        <div class="appTable-col appRequests-language" :title="__('Country')">
                                {{ request.country }}
                        </div>
                        <div class="appTable-col appRequests-hours" :title="__('Number of hours')">
                            {{ request.meditation_hours ? request.meditation_hours : '-' }}
                        </div>
                        <div class="appTable-col appRequests-status" :title="__('Status')">
                            <div class="appRequests-statusBtn" @click="unlimitedLftWorks(request)">{{ request.lftStatus }}</div>
                        </div>
                        <div class="appTable-col appRequests-creation" :title="__('Creation date')">
                            {{ dateFormat(request.created_at) }}
                        </div>
                        <div class="appTable-col appRequests-tools">
                            <action-dropdown>
                                <a href="#" rel="nofollow" class="dhrtDropdown-item" v-if="request.status" @click.prevent="cancelLesson(request)">{{ __('Cancel') }}</a>
                                <a class="dhrtDropdown-item" rel="nofollow" href="#" v-if="!request.status" @click.prevent="deleteLesson(request)">{{ __('Reject') }}</a>
                                <a class="dhrtDropdown-item" rel="nofollow" href="#" @click.prevent="openDelegateWindow(request)">{{ __('Delegate') }}</a>
                            </action-dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!id" class="appPageTools pagination">
            <div class="appPageTools-btn" :class="{'active': show === 'all'}" @click="show = 'all'"><div class="appPageTools-btnText">{{ __('All') }}</div></div>
            <div class="appPageTools-btn" :class="{'active': show === 'new'}" @click="show = 'new'"><div class="appPageTools-btnText">{{ __('New') }}</div></div>
            <div class="appPageTools-btn" :class="{'active': show === 'old'}" @click="show = 'old'"><div class="appPageTools-btnText">{{ __('Old') }}</div></div>
            <div class="appPageTools-btn" :class="{disabled: page === 1}" @click.prevent="page = 1"><div class="appPageTools-btnText">«</div></div>

            <div class="appPageTools-btn" v-if="number !== '...'" :class="{active: page === number}" v-for="number of pagination(page, pages)" @click.prevent="page = number"><div class="appPageTools-btnText">{{ number }}</div></div>
            <div class="appPageTools-btn disabled" v-else><div class="appPageTools-btnText">...</div></div>

            <div class="appPageTools-btn" :class="{disabled: page === pages}" @click.prevent="page = pages"><div class="appPageTools-btnText">»</div></div>
        </div>
        <modal-window id="appInitiationModal" v-if="initiation" :valid="!isSending" :buttonList="['Cancel', 'Save']" @close="initiation = null" @cancel="initiation = null" @save="approveLesson(initiation)" :windowName="__('Initiation')">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{__('Spiritual Name')}}</div>
                <input type="text" class="form-control" v-model="initiation.spiritual_name">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{__('Notes')}}</div>
                <input type="text" class="form-control" v-model="initiation.notes">
            </div>
        </modal-window>
        <modal-window id="appInitiationModal" v-if="request" :valid="!isSending && delegate_acarya" :buttonList="['Cancel', 'Save']" @close="request = null; delegate_acarya = null" @cancel="request = null; delegate_acarya = null" @save="delegate(request, delegate_acarya)" :windowName="__('Delegate lesson request from ') + request.userName">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{__('Choose an acarya')}}</div>
                <object-dropdown search
                                 class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto widthAuto"
                                 :options="acaryas"
                                 v-model="delegate_acarya"
                                 label="displayName"
                                 :placeholder="__('Choose an acarya...')"
                                 :title="__('Acarya')"
                ></object-dropdown>
            </div>
        </modal-window>
    </div>


</template>

<script>
    let moment = require('moment');

    export default {
        props: ['perPage', 'id'],

        data() {
            return {
                page: 1,
                total: 0,
                requests: [],
                helper: false,

                show: 'new', // 'all', 'old',
                filters: {
                    name: '', // userName
                    city: '', // city
                    phone: '',
                    time: '' ,
                    lesson: null,
                    requestType: null, // type
                    country: ''
                },

                request: null,
                delegate_acarya: null,

                lessonNumbers: {null: this.__('All'), 1:'1', 2:'2', 3: '3', 4:'4', 5:'5', 6:'6', 7:'2-6'},

                acaryas: [],

                initiation: null,
                isSending: null,

                sortBy: 'created',
                sortOrder: 'desc'
            }
        },

        mounted() {
            this.getAcaryas();
            switch (this.$route.query.helper_filter) {
                case '1':
                    this.filters.lesson = 1;
                    this.filters.requestType = 'get';
                    break;
                case '2':
                    this.filters.lesson = 7;
                    this.filters.requestType = 'get';
                    break;
                case '3':
                    this.filters.requestType = 'check';
                    break;
                default:
                    this.getData();
                    break;
            }
        },

        watch: {
            show() {
                this.getData();
            },

            page() {
                this.getData();
            },

            'filters': {
                deep: true,
                handler() {
                    if(this.filters.lesson === "null") {
                        this.filters.lesson = null;
                    }
                    if(this.filters.requestType === "null") {
                        this.filters.requestType = null;
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

            dateFormat(date) {
                return moment(date).format('DD.MM.YY');
            },

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

            getData() {
                let params = {
                    type: this.filters.requestType,
                    userName: this.filters.name ? this.filters.name : null,
                    city: this.filters.city ? this.filters.city : null,
                    country: this.filters.country ? this.filters.country : null,
                    time: this.filters.time ? this.filters.time : null,
                    phone: this.filters.phone ? this.filters.phone : null,
                    lesson: this.filters.lesson ? this.filters.lesson : null,
                    take: this.perPage,
                    skip: this.skip,

                    id: this.id ? this.id : null,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder
                };

                if (this.show === 'new') {
                    params.status = 0;
                }

                if (this.show === 'old') {
                    params.status = 1;
                }

                if (this.id) {
                    params.status = null;
                }

                axios.get('/lesson-request', {params: params}).then(response => {
                    this.requests = response.data.result.requests;
                    this.total = response.data.result.total;
                    this.helper = response.data.meta.isHelper;

                    this.$nextTick(() => {
                        $('.appRequestList [title]').tooltip();
                    });
                });
            },

            getAcaryas() {
                axios.get('/acaryas').then(response => {
                    this.acaryas = response.data.result;
                });
            },

            lessonRedirect(request) {
              //if(request.type === 'get' && request.lesson === 1) {
                  this.initiation = request;
              //} else {
                  //this.approveLesson(request);
              //}
            },

            approveLesson(request) {
                if(this.isSending) return;
                this.isSending = 1;
                axios.post('/approve-lesson-request', {id: request.id, spiritual_name: request.spiritual_name, notes: request.notes}).then(response => {
                    request.status = response.data.result;
                    this.initiation =  null;
                    this.isSending = null;
                });
            },

            cancelLesson(request) {
                axios.post('/cancel-lesson-request', {id: request.id}).then(response => {
                    request.status = !response.data.result;
                });
            },

            deleteLesson(request) {
                axios.delete('/lesson-request', {params: {id: request.id}}).then(response => {
                    this.getData();
                });
            },

            delegate(request, acarya) {
                axios.post('/delegate-lesson-request', {id: request.id, userId: acarya.user_id}).then(response => {
                    Vue.toasted.show(`<div>Delegated to ${acarya.displayName}.</div>`, {
                        position: "top-center",
                        type: 'show',
                        duration: null,
                        closeOnSwipe: true,
                        action : [
                            {
                                text : 'Ok',
                                onClick : (e, toastObject) => {
                                    toastObject.goAway(0);
                                }
                            }
                        ]
                    });

                    this.request = null;
                    this.delegate_acarya = null;
                    this.getData();
                });
            },

            unlimitedLftWorks(request) {
                axios.put('/lft', {userId: request.userId}).then(response => {
                    this.getData();
                });
            },

            openDelegateWindow(request) {
                this.request = JSON.parse(JSON.stringify(request));
            }
        }
    }
</script>

