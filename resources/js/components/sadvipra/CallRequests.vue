<template>
    <div class="sadvipraCallRequests">

        <div>
            <pagination v-model="page" show-total :total-users="filtered" :total="total" :per-page="perPage"/>

            <div class="sadvipraCallRequests-content">
                <div class="appTable" :class="{'sadvipraCallRequests-set1': (bp || secretary) && !admin, 'admin': admin}">
                    <div class="appFilter">
                        <div class="appFilter-panel">
                            <div class="appFilter-tools sadvipraCallRequests-filters">
                                <div class="appFilter-toolsButtons">
                                    <div class="dhrtBtn appFilter-toolsButton users" :title="__('Filters')" @click="show_filters = !show_filters">
                                        <span class="dhrtBtnText">{{ __('Filters') }}</span>
                                        <span class="dhrtBtnIcon msppIcons-filter"></span>
                                    </div>
                                    <div class="dhrtBtn appFilter-toolsButton clear" v-if="are_filters" :title="__('Clear all filters')" @click="erase_filters">
                                        <span class="dhrtBtnText">{{ __('Clear all filters') }}</span>
                                        <span class="dhrtBtnIcon msppIcons-clean"></span>
                                    </div>
                                </div>
                                <div class="appFilter-toolsInfo">
                                    <div class="appFilter-toolsInfoItem id" v-if="request_filters.id">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('ID') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.id }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem name" v-if="request_filters.name">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Name') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.name }}</div>
                                        </div>
                                    </div>
<!--                                    <div class="appFilter-toolsInfoItem call" v-if="request_filters.call_type">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Call type') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.call_type.name }}</div>
                                        </div>
                                    </div>-->
                                    <div class="appFilter-toolsInfoItem phone" v-if="request_filters.phone">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Phone') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.phone }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem messenger" v-if="request_filters.messenger">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Messenger') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ messenger[request_filters.messenger] }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem closed" v-if="request_filters.closed">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Closed') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ closedOptions[request_filters.closed] }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem closed" v-if="request_filters.status">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Status type') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ closedStatuses[request_filters.status] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="appFilter-body sadvipraCallRequests-filtersAll" v-show="show_filters">
                                <div class="appFilter-bodyTools">
                                    <div class="appFilter-bodyToolsTitle">{{ __('Choose items for filter') }}</div>
                                    <div class="appFilter-clear">
                                        <span class="btnClose btnClose-size14" @click="show_filters = false"></span>
                                    </div>
                                </div>
                                <div class="appFilter-bodyContent">
                                    <div class="appFilter-item appFilterUser-id">
                                        <div class="appFilter-itemTitle">{{ __('ID') }}</div>
                                        <div class="appFilter-itemValue">
                                            <input type="text" class="appFilter-itemValueField" v-model.lazy="filters.id">
                                            <div class="appFilter-itemValueIcon msppIcons-filter"></div>
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-name">
                                        <div class="appFilter-itemTitle">{{ __('Name') }}</div>
                                        <div class="appFilter-itemValue">
                                            <input type="text" class="appFilter-itemValueField" v-model.lazy="filters.name">
                                            <div class="appFilter-itemValueIcon msppIcons-filter"></div>
                                        </div>
                                    </div>
<!--                                    <div class="appFilter-item appFilterUser-callType">
                                        <div class="appFilter-itemTitle">{{ __('Call type') }}</div>
                                        <div class="appFilter-itemValue">
                                            <object-dropdown v-model="filters.call_type"
                                                             class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                                                             :options='callsList'
                                                             label="name"
                                                             :placeholder="'Choose call type'"
                                            />
                                            <div class="appFilter-itemValueIcon msppIcons-filter"></div>
                                        </div>
                                    </div>-->
                                    <div class="appFilter-item appFilterUser-phone">
                                        <div class="appFilter-itemTitle">{{ __('Phone') }}</div>
                                        <div class="appFilter-itemValue">
                                            <input type="text" class="appFilter-itemValueField" v-model.lazy="filters.phone">
                                            <div class="appFilter-itemValueIcon msppIcons-filter"></div>
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-messenger">
                                        <div class="appFilter-itemTitle">{{ __('Messenger') }}</div>
                                        <div class="appFilter-itemValue">
                                            <dropdown v-model="filters.messenger"
                                                      class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                                                      :options='messenger'
                                                      :search="true"
                                            />
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-closed">
                                        <div class="appFilter-itemTitle">{{ __('Closed') }}</div>
                                        <div class="appFilter-itemValue">
                                            <dropdown v-model="filters.closed"
                                                      class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                                                      :options='closedOptions'/>
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-status">
                                        <div class="appFilter-itemTitle">{{ __('Status') }}</div>
                                        <div class="appFilter-itemValue">
                                            <dropdown v-model="filters.status"
                                                      class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                                                      :options='closedStatuses'/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="appTable-head">
                        <div class="appTable-row sadvipraCallRequests-item">
                            <div class="appTable-col sadvipraCallRequests-id" v-if="admin">
                                <div>{{ __('ID') }}</div>
                            </div>
                            <div class="appTable-col sadvipraCallRequests-avatar"></div>
                            <div class="appTable-col sadvipraCallRequests-name">
                                <div class="appTable-colTop" @click="sort('name')">
                                    <div>{{ __('Name') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'name'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
<!--                            <div class="appTable-col sadvipraCallRequests-callType">
                                <div class="appTable-colTop" @click="sort('call')">
                                    <div>{{ __('Call type') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'call'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>-->
<!--                            <div class="appTable-col sadvipraCallRequests-date">
                                <div class="appTable-colTop" @click="sort('date')">
                                    <div>{{ __('Date req.') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'date'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>-->
                            <div class="appTable-col sadvipraCallRequests-sex">
                                <div class="appTable-colTop" @click="sort('sex')">
                                    <div>{{ __('Sex') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'sex'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col sadvipraCallRequests-phone">
                                <div class="appTable-colTop" @click="sort('phone')">
                                    <div>{{ __('Phone') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'phone'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col sadvipraCallRequests-messenger">
                                <div class="appTable-colTop" @click="sort('messenger')">
                                    <div>{{ __('Messenger') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'messenger'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col sadvipraCallRequests-city">
                                <div class="appTable-colTop" @click="sort('city')">
                                    <div>{{ __('City') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'city'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col sadvipraCallRequests-country">
                                <div class="appTable-colTop" @click="sort('country')">
                                    <div>{{ __('Country') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'curator'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col sadvipraCallRequests-country">
                                <div class="appTable-colTop" @click="sort('curator')">
                                    <div>{{ __('Curator') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'country'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col sadvipraCallRequests-status">
                                <div class="appTable-colTop" @click="sort('closed')">
                                    <div>{{ __('Status') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'closed'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col sadvipraCallRequests-tools"></div>
                        </div>
                    </div>
                    <div class="appTable-body">
                        <div v-for="request of requests" class="appTable-row sadvipraCallRequests-item">
                            <div class="appTable-col sadvipraCallRequests-id" v-if="admin">
                                {{ request.id }}
                            </div>
                            <div class="appTable-col sadvipraCallRequests-avatar">
                                <avatar :key="request.user.avatar" class="appAvatar appLists-avatarImage"
                                        :src="request.user.avatar ? request.user.avatar : '/images/no-avatar.jpg'"></avatar>
                            </div>
                            <div class="appTable-col sadvipraCallRequests-name" :title="request.user.name + (request.user.spiritualName ? ' (' + request.user.spiritualName + ')' : '')">
                                <div class="sadvipraCallRequests-nameSocial">
                                    <div class="app-textEllipse">{{ request.user.name }} <span v-if="request.user.unit_alias">({{ request.user.unit_alias }})</span></div>
                                </div>
                                <div class="sadvipraCallRequests-nameSpiritual">
                                    <div class="app-textEllipse">{{ request.user.spiritualName }}</div>
                                </div>
                            </div>
<!--                            <div class="appTable-col sadvipraCallRequests-callType">
                                {{ request.call_type.name }}
                            </div>-->
<!--                            <div class="appTable-col sadvipraCallRequests-date">
                                {{ dateFormat(request.date) }}
                            </div>-->
                            <div class="appTable-col sadvipraCallRequests-sex">
                                {{ request.user.sex=='female'?'ж':'м' }}
                            </div>
                            <div class="appTable-col sadvipraCallRequests-phone">
                                {{ request.user_phone }}
                            </div>
                            <div class="appTable-col sadvipraCallRequests-messenger">
                                {{ messenger[request.user_messenger] }}
                            </div>
                            <div class="appTable-col sadvipraCallRequests-city">
                                {{ request.user.city }}
                            </div>
                            <div class="appTable-col sadvipraCallRequests-country">
                                {{ request.user.country }}
                            </div>
                            <div class="appTable-col sadvipraCallRequests-curator">
                                {{ request.host }}
                            </div>
                            <div class="appTable-col sadvipraCallRequests-status">
                                {{ request.closed ? __('Closed') : __('Opened') }} / {{ closedStatuses[request.closed_status] }}
                            </div>

                            <div class="appTable-col sadvipraCallRequests-tools">
                                <a href="#" rel="nofollow" class="dhrtDropdown-item" v-if="admin || curator"
                                   @click.prevent="edit(request)">
                                    <span class="appIcons msppIcons-edit-2" :title="__('Edit')"></span>
                                </a>
                                <a href="#" rel="nofollow" class="dhrtDropdown-item" v-if="curator && !request.host_id"
                                   @click.prevent="openActionModal('accept', request)">
                                    <span class="appIcons msppIcons-check" :title="__('Accept')"></span>
                                </a>
                                <a href="#" rel="nofollow" class="dhrtDropdown-item" v-if="(admin || curator) && request.host_id"
                                   @click.prevent="openActionModal('forward', request)">
                                    <span class="appIcons msppIcons-fast-forward" :title="__('Forward')"></span>
                                </a>
                                <a href="#" rel="nofollow" class="dhrtDropdown-item" v-if="(admin || curator) && !request.closed"
                                   @click.prevent="openActionModal('close', request)">
                                    <span class="appIcons msppIcons-x" :title="__('Close')"></span>
                                </a>
<!--                                <a href="#" rel="nofollow" class="dhrtDropdown-item"
                                   @click.prevent="details(request)">
                                    <span class="appIcons msppIcons-eye" :title="__('Details')"></span>
                                </a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <pagination v-if="total >= perPage" v-model="page" :total-users="filtered" :total="total" :per-page="perPage"/>
        </div>

        <modal-window v-if="request" :button-list="editor ? ['Close', 'Save'] : ['Close']"
                      @close="request = null, editor = false, detailed = false" @save="save"
                      :windowName="request.user.spiritualName ? request.user.spiritualName+' ('+request.user.name+')' : request.user.name">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('ID') }}</div>
                <div class="appForm-itemValue">{{ request.id }}</div>
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('User') }}</div>
                <avatar :key="request.user.avatar" class="appAvatar appLists-avatarImage"
                        :src="request.user.avatar ? request.user.avatar : '/images/no-avatar.jpg'"></avatar>
                <div class="appForm-itemValue">{{ request.user.name }}</div>
            </div>
<!--            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Call type') }}</div>
                <div class="appForm-itemValue" v-if="detailed">{{ request.call_type.name }}</div>
                <object-dropdown v-if="editor" v-model="request.call_type"
                                 class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                                 :options='callsList'
                                 label="name"
                                 :placeholder="'Choose call type'"
                />
            </div>-->
<!--            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Date') }}</div>
                <div class="appForm-itemValue" v-if="detailed">{{ dateFormat(request.date) }}</div>
                <flat-pickr v-if="editor" :config="flatPickrConfig" v-model="request.date"></flat-pickr>
            </div>-->
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Phone') }}</div>
                <div class="appForm-itemValue" v-if="detailed">{{ request.user_phone }}</div>
                <input v-if="editor" type="text" class="appForm-input" v-model="request.user_phone">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Messenger') }}</div>
                <div class="appForm-itemValue" v-if="detailed">{{ messenger[request.user_messenger] }}</div>
                <dropdown v-if="editor" v-model="request.user_messenger"
                          class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                          :options='messenger'
                          :search="true"
                />
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Description') }}</div>
                <div class="appForm-itemValue" v-if="detailed">{{ request.description }}</div>
                <textarea class="appForm-textarea" :placeholder="__('Notes about user')" v-model="request.description"></textarea>
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Status') }}</div>
                <div class="sadvipraCallRequests-statusButton" :class="{'check': request.host_id}" @click="request.host_id ? null : accept(request.id)">
                    <template v-if="!request.host_id">
                        {{ __('Accept request') }}
                    </template>
                    <template v-else>
                        {{ __('Curator') }}: {{ request.host }}
                    </template>
                </div>
                <div class="sadvipraCallRequests-statusButton" v-if="request.host_id && (request.host_id === user_id)">
                    <action-dropdown class="appLangDropdown" withArrow menuAlignmentLeft arrowBold>
                        <template #label>{{ __('Forward to...') }}</template>
                        <a v-for="curator of curators" v-if="curator.id !== user_id" class="dhrtDropdown-item" @click.prevent="forward(request.id, curator.id)" >
                            <span class="dhrtDropdown-itemText">{{ curator.name }}</span>
                        </a>
                    </action-dropdown>
                </div>
                <div class="sadvipraCallRequests-statusButton" :class="{'check': request.closed}" v-if="request.host_id && (request.host_id === user_id)">
                    <template v-if="!request.closed">
                        <action-dropdown class="appLangDropdown" withArrow menuAlignmentLeft arrowBold>
                            <template #label>{{ __('Close request') }}</template>
                            <a v-for="(status, index) of closedStatuses" v-if="index !== 'null'" class="dhrtDropdown-item" @click.prevent="close_request(request.id, index)" >
                                <span class="dhrtDropdown-itemText">{{ status }}</span>
                            </a>
                        </action-dropdown>
                    </template>
                    <template v-else>
                        {{ __('Request closed with status') }}: {{ closedStatuses[request.closed_status] }}
                    </template>
                </div>
            </div>
            <template v-if="request.closed">
<!--                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Status type') }}</div>
                    <div class="appForm-itemValue" v-if="detailed">{{ closedStatuses[request.closed_status] }}</div>
                    <dropdown v-if="editor" v-model="request.closed_status"
                              class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                              :options='closedStatuses'
                              :search="true"
                    />
                </div>
                <div class="appForm-group" v-if="request.closed_date">
                    <div class="appForm-groupTitle">{{ __('Closed date') }}</div>
                    <div class="appForm-itemValue">{{ dateFormat(request.closed_date) }}</div>
                </div>-->
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Notes') }}</div>
                    <div class="appForm-itemValue" v-if="detailed">{{ request.closed_notes }}</div>
                    <textarea class="appForm-textarea" :placeholder="__('Notes about call')" v-model="request.closed_notes"></textarea>
                </div>
            </template>
        </modal-window>

        <modal-window v-if="action" :button-list="action === 'accept' ? ['Close', 'Ok'] : ['Close']"
                      @close="action = null" @ok="accept(action_item.id)"
                      :windowName="{
                      accept: 'Принять заявку',
                      forward: 'Передать заявку другому куратору',
                      close: 'Закрыть заявку'}[action]">
            <div class="appForm-group">
                <template v-if="action === 'accept'">
                    {{ __('You are going to accept this call request. Continue?') }}
                </template>
                <template v-if="action === 'forward'">
                    <template v-if="curators && (curators.length > 1)">
                        <action-dropdown class="appLangDropdown" withArrow menuAlignmentLeft arrowBold v-if="(admin || curator) && action_item.host_id">
                            <template #label>{{ __('You are going to forward this call request to other curator. Please specify curator to continue') }}</template>
                            <a v-for="curator of curators" v-if="curator.id !== user_id" class="dhrtDropdown-item" @click.prevent="forward(action_item.id, curator.id)" >
                                <span class="dhrtDropdown-itemText">{{ curator.name }}</span>
                            </a>
                        </action-dropdown>
                    </template>
                    <template v-else>
                        {{ __('Currently there are no available curators to forward this call request.') }}
                    </template>
                </template>
                <template v-if="action === 'close'">
                    <action-dropdown class="appLangDropdown" withArrow menuAlignmentLeft arrowBold v-if="(admin || curator) && !action_item.closed">
                        <template #label>{{ __('You are going to close this call request. Please specify call result') }}</template>
                        <a v-for="(status, index) of closedStatuses" v-if="index !== 'null'" class="dhrtDropdown-item" @click.prevent="close_request(action_item.id, index)" >
                            <span class="dhrtDropdown-itemText">{{ status }}</span>
                        </a>
                    </action-dropdown>
                </template>
            </div>
        </modal-window>
    </div>
</template>
<script>
    let moment = require('moment');
    import Multiselect from 'vue-multiselect'
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js';

    export default {
        props: ['user_id'],

        components: {Multiselect, flatPickr},

        data() {
            return {
                page: 1,
                total: 0,
                filtered: 0,
                perPage: 100,
                requests: [],
                callsList: [],
                filters: {
                    id: null,
                    name: '',
                    phone: '',
                    call_type: null,
                    date: null,
                    messenger: null,
                    closed: 'false',
                    status: null
                },
                request: null,
                action: null,
                action_item: null,
                detailed: null,
                editor: null,
                locale: 'ru',
                curators: [],

                show_filters: false,

                sortBy: 'created_at',
                sortOrder: 'desc',

                closedStatuses: {
                    null: this.__('All'),
                    'successful': this.__('Successful'),
                    'fail': this.__('Failed'),
                    'user-not-appeared': this.__('User not appeared')
                },
                closedOptions: {
                    null: this.__('Both'),
                    true: this.__('Closed'),
                    false: this.__('Open')
                },
                messenger: {
                    null: this.__('All'),
                    'telegram': this.__('Telegram'),
                    'viber': this.__('Viber'),
                    'whatsapp': this.__('WhatsApp')
                },
                showFull: window.matchMedia("(max-width: 1199px)").matches,

                flatPickrConfig: {
                    disableMobile: "true",
                    altInput: true,
                    altFormat: 'd-m-y',
                    locale: 'ru'
                }
            }
        },

        mounted() {
            this.locale = $('html').attr('lang');
            this.getData();
        },

        watch: {
            page() {
                this.getData();
            },

            filters: {
                deep: true,
                handler() {
                    this.page = 1;
                    this.getData();
                }
            },
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },

            admin() {
                return this.$root.roles.includes('admin')
            },

            bp() {
                return this.$root.roles.includes('bp')
            },

            secretary() {
                return this.$root.roles.includes('secretary')
            },

            trustee() {
                return this.$root.roles.includes('trustee')
            },

            curator() {
                return this.$root.roles.includes('curator')
            },

            request_filters() {
                return {
                    id: this.filters.id ? this.filters.id  : null,
                    name: this.filters.name ? this.filters.name : null,
                    call_type: this.filters.call_type ? this.filters.call_type : null,
                    phone: this.filters.phone ? this.filters.phone : null,
                    messenger: (this.filters.messenger && (this.filters.messenger !== 'null')) ? this.filters.messenger : null,
                    closed: (this.filters.closed && (this.filters.closed !== 'null')) ? this.filters.closed : null,
                    status: (this.filters.status && (this.filters.status !== 'null')) ? this.filters.status : null,

                    take: this.perPage,
                    skip: this.skip,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,
                };
            },

            are_filters() {
                return this.request_filters.id ||
                    this.request_filters.name ||
                    this.request_filters.call_type ||
                    this.request_filters.phone ||
                    this.request_filters.messenger ||
                    this.request_filters.closed ||
                    this.request_filters.status
            }
        },

        methods: {
            erase_filters() {
                this.filters.id =  null;
                this.filters.name =  null;
                this.filters.call_type =  null;
                this.filters.phone =  null;
                this.filters.messenger =  null;
                this.filters.closed =  null;
                this.filters.status = null;
            },

            getData() {
                let params = this.request_filters;
                this.$root.loading = true;

                axios.get('/get-call-requests', {params: params}).then(response => {
                    this.total = response.data.meta.total;
                    this.requests = response.data.data;
                    this.filtered = response.data.meta.filtered;
                    this.callsList = response.data.meta.calls;
                    this.curators = response.data.meta.curators;

                    if(this.callsList && this.callsList.length) this.callsList.unshift({
                        id: null,
                        name: this.__('All call types')
                    });

                    this.show_filters = false;
                    this.$root.loading = false;
                });
            },

            dateFormat(date) {
                return moment(date).format('DD.MM.YY HH:mm');
            },

            edit(request) {
                this.editor = true;
                this.request = request;
            },

            details(request) {
                this.detailed = true;
                this.request = request;
            },

            save() {
                axios.put('/edit-call-request', {
                    data: this.request
                }).then( response => {
                    this.afterEdit();
                });
            },

            accept(id) {
                axios.post('/accept-call-request', {
                    id: id
                }).then( response => {
                    this.getData();
                    this.action = null;
                    this.action_item = null;
                }).catch( e => {

                });
            },

            close_request(request_id, status) {
                axios.post('/close-call-request', {
                    request_id: request_id,
                    status: status
                }).then( response => {
                    this.getData();
                    this.request.closed = true;
                    this.request.closed_status = status;
                    this.action = null;
                    this.action_item = null;
                }).catch( e => {

                });
            },

            forward(request_id, curator_id) {
                axios.post('/forward-call-request', {
                    request_id: request_id,
                    curator_id: curator_id
                }).then( response => {
                    this.getData();
                    this.editor = false;
                    this.request = null;
                    this.action = null;
                    this.action_item = null;
                }).catch( e => {

                });
            },

            afterEdit() {
                this.editor = false;
                this.detailed = false;
                this.request = null;
                this.getData();
            },

            sort(column) {
                return;
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

            openActionModal(action, request) {
                this.action = action;
                this.action_item = JSON.parse(JSON.stringify(request));
            },

            applyAction() {

            }
        }
    }
</script>
