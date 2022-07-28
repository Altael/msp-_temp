<template>
    <div class="appUserList">

        <div>
            <pagination v-model="page" show-total :total-users="total_users" :total="total" :per-page="perPage"/>

            <div class="appUserList-content">
                <div class="appTable" :class="{'appUserList-set1': (bp || secretary) && !admin, 'admin': admin}">
                    <div class="appFilter">
                        <div class="appFilter-panel">
                            <div class="appFilter-tools appUserList-filters">
                                <div class="appFilter-toolsButtons">
                                    <div @click="getData(true)">
                                        <span class="appIcons msppIcons-file-excel"></span>
                                    </div>
                                    <div class="dhrtBtn appFilter-toolsButton statuses" @click="statusesFilter = true" :title="__('Unit statuses')">
                                        <span class="dhrtBtnText">{{ __('Unit statuses') }}</span>
                                        <span class="dhrtBtnIcon msppIcons-status_filter"></span>
                                    </div>
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
                                    <div class="appFilter-toolsInfoItem statuses" v-if="chosen_statuses.length">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Unit statuses') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue" v-for="status of chosen_statuses">{{ status['name_' + locale] }}</div>
                                        </div>
                                    </div>
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
                                    <div class="appFilter-toolsInfoItem city" v-if="request_filters.city">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('City') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.city }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem phone" v-if="request_filters.phone">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Phone') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.phone }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem lesson" v-if="request_filters.lesson">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Lesson') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.lesson }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem email" v-if="request_filters.email">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Email') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.email }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem profession" v-if="request_filters.profession">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Profession') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.profession }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem role" v-if="request_filters.role">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Role') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.role }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem acarya" v-if="request_filters.acarya">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Acarya') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.acarya }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem region" v-if="request_filters.region">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Region') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.region }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem country" v-if="request_filters.country">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Country') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ request_filters.country }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem unit" v-if="request_filters.unit">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Unit') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ filters.unit.name }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem officer" v-if="request_filters.title">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('officer') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ filters.title.name }}</div>
                                        </div>
                                    </div>
                                    <div class="appFilter-toolsInfoItem fake" v-if="request_filters.fake">
                                        <div class="appFilter-toolsInfoItemTitle">{{ __('Fake') }}:</div>
                                        <div class="appFilter-toolsInfoItemValues">
                                            <div class="appFilter-toolsInfoItemValue">{{ fakeOptions[filters.fake] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="appFilter-body appUserList-filtersAll" v-show="show_filters">
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
                                    <div class="appFilter-item appFilterUser-country">
                                        <div class="appFilter-itemTitle">{{ __('Country') }}</div>
                                        <div class="appFilter-itemValue">
                                            <input type="text" class="appFilter-itemValueField" v-model.lazy="filters.country" :placeholder="__('en only')">
                                            <div class="appFilter-itemValueIcon msppIcons-filter"></div>
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-city">
                                        <div class="appFilter-itemTitle">{{ __('City') }}</div>
                                        <div class="appFilter-itemValue">
                                            <input type="text" class="appFilter-itemValueField" v-model.lazy="filters.city">
                                            <div class="appFilter-itemValueIcon msppIcons-filter"></div>
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-unit">
                                        <div class="appFilter-itemTitle">{{ __('Unit') }}</div>
                                        <div class="appFilter-itemValue">
                                            <!--<object-dropdown v-model="filters.unit"
                                                         class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                                                         :options='unitsList'
                                                         label="name"
                                                         :placeholder="'Choose unit'"
                                        />-->
                                            <multiselect
                                                v-model="filters.unit"
                                                :options="unitsList"
                                                label="name"
                                                track-by="id"
                                            />
                                            <div class="appFilter-itemValueIcon msppIcons-filter"></div>
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-email">
                                        <div class="appFilter-itemTitle">{{ __('Email') }}</div>
                                        <div class="appFilter-itemValue">
                                            <input type="text" class="appFilter-itemValueField" v-model.lazy="filters.email">
                                            <div class="appFilter-itemValueIcon msppIcons-filter"></div>
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-phone">
                                        <div class="appFilter-itemTitle">{{ __('Phone') }}</div>
                                        <div class="appFilter-itemValue">
                                            <input type="text" class="appFilter-itemValueField" v-model.lazy="filters.phone">
                                            <div class="appFilter-itemValueIcon msppIcons-filter"></div>
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-role">
                                        <div class="appFilter-itemTitle">{{ __('Role') }}</div>
                                        <div class="appFilter-itemValue">
                                            <dropdown v-model="filters.role"
                                                      class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                                                      :options='userRoles'
                                                      :search="true"
                                            />
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-title" v-if="titles">
                                        <div class="appFilter-itemTitle">{{ __('Officer') }}</div>
                                        <div class="appFilter-itemValue">
                                            <object-dropdown v-model="filters.title"
                                                             class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                                                             :options='titles'
                                                             label="name"
                                                             :placeholder="'Choose officer'"
                                            />
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-acarya">
                                        <div class="appFilter-itemTitle">{{ __('Acarya') }}</div>
                                        <div class="appFilter-itemValue">
                                            <input type="text" class="appFilter-itemValueField" v-model.lazy="filters.acarya">
                                            <div class="appFilter-itemValueIcon msppIcons-filter"></div>
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-lesson">
                                        <div class="appFilter-itemTitle">{{ __('Lesson') }}</div>
                                        <div class="appFilter-itemValue">
                                            <dropdown v-model="filters.lesson"
                                                      class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                                                      :options='lessonNumbers'/>
                                        </div>
                                    </div>
                                    <div class="appFilter-item appFilterUser-fake">
                                        <div class="appFilter-itemTitle">{{ __('Fake') }}</div>
                                        <div class="appFilter-itemValue">
                                            <dropdown v-model="filters.fake"
                                                      class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
                                                      :options='fakeOptions'/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="appTable-head">
                        <div class="appTable-row">
                            <div class="appTable-col appUserList-id" v-if="admin">
                                <div>{{ __('ID') }}</div>
                            </div>
                            <div class="appTable-col appUserList-avatar"></div>
                            <div class="appTable-col appUserList-name">
                                <div class="appTable-colTop" @click="sort('name')">
                                    <div>{{ __('Name') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'name'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col appUserList-post">
                                <div class="appTable-colTop" @click="sort('post')">
                                    <div>{{ __('Post') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'post'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col appUserList-lesson">
                                <div class="appUserList-lessonText">{{ __('Lesson') }}</div>
                            </div>
                            <div class="appTable-col appUserList-acarya">
                                <div>{{ __('Acarya') }}</div>

                            </div>
                            <div class="appTable-col appUserList-role">
                                <div class="appUserList-roleText">{{ __('Role') }}</div>
                            </div>
                            <div class="appTable-col appUserList-geo">
                                <div class="appTable-colTop" @click="sort('unit')">
                                    <div>{{ __('Unit') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'unit'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                                <div class="appTable-colTop" @click="sort('city')">
                                    <div>{{ __('City') }}</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'city'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                                <div class="appTable-colTop" @click="sort('country')" v-if="admin || acarya">
                                    <div>({{ __('Country') }})</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'country'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                                <div class="appTable-colTop" @click="sort('region')" v-if="admin || acarya">
                                    <div>/{{ __('Region') }}/</div>
                                    <div class="appTable-sort">
                                        <span v-if="sortBy === 'region'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                        <span v-else class="msppIcons-align-left"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col appUserList-created">
                                <div class="appTable-colTop">
                                    <div>
                                        <div class="flexRow" @click="sort('created')">
                                            <div>{{ __('Created') }}</div>
                                            <div class="appTable-sort">
                                                <span v-if="sortBy === 'created'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                                <span v-else class="msppIcons-align-left"></span>
                                            </div>
                                        </div>
                                        <div class="flexRow" @click="sort('initiation')">
                                            <div>{{ __('Initiat.') }}</div>
                                            <div class="appTable-sort">
                                                <span v-if="sortBy === 'initiation'" :class="'msppIcons-sort-amount-' + sortOrder"></span>
                                                <span v-else class="msppIcons-align-left"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="appTable-filter">
                                    <!--<input type="text" class="appTable-filterField" v-model="filters.created">
                                    <div class="appTable-filterIcon appTable-filter_listIcon appIcons msppIcons-filter"></div>-->
                                </div>
                            </div>
                            <div class="appTable-col appUserList-contact">
                                <div>{{ __('Contact') }}</div>
                            </div>
                            <div class="appTable-col appUserList-tools"></div>
                        </div>
                    </div>
                    <div class="appTable-body">
                        <div v-for="user of users" v-if="user.has_profile" class="appTable-row" :class="{'userWithPost': user.title, 'userInStealthMode': user.hide_from_unit}">
                            <div class="appTable-col appUserList-id" v-if="admin">
                                {{ user.id }}
                            </div>
                            <div class="appTable-col appUserList-avatar">
                                <avatar :key="user.avatar" class="appAvatar appLists-avatarImage"
                                        :src="user.avatar ? user.avatar : '/images/no-avatar.jpg'"></avatar>
                            </div>
                            <div class="appTable-col appUserList-name" :title="user.name + (user.spiritualName ? ' (' + user.spiritualName + ')' : '')">
                                <div class="appUserList-nameSocial">
                                    <div class="app-textEllipse">{{ user.name }} <span v-if="user.unit_alias">({{ user.unit_alias }})</span></div>
                                </div>
                                <div class="appUserList-nameSpiritual">
                                    <div class="app-textEllipse">{{ user.spiritualName }}</div>
                                </div>
                                <div class="appUserList-namePost" v-if="user.title">
                                    <div class="app-textEllipse">{{ user.title.name }}</div>
                                </div>
                            </div>
                            <div class="appTable-col appUserList-post">
                                <template v-if="user.title">
                                    {{ user.title.name }}
                                </template>
                            </div>
                            <div class="appTable-col appUserList-lesson">
                                <div class="appUserList-lessonValue" v-if="user.lesson_number">{{ user.lesson_number }}</div>
                            </div>
                            <div class="appTable-col appUserList-acarya">
                                <avatar v-if="user.system_acarya" class="appUserList-acaryaAvatar appAvatar"
                                        :src="user.system_acarya_avatar" :title="user.system_acarya"></avatar>
                                <div class="appUserList-acaryaBody" v-if="showFull">{{ user.system_acarya }}</div>
                            </div>
                            <div class="appTable-col appUserList-contact">
                                <div class="appUserList-contactVK">
                                    <a v-if="user.vk_id" :href="'https://vk.com/id' + user.vk_id" target="_blank">
                                        <span class="appIcons msppIcons-vk"></span>
                                    </a>
                                    <span class="appIcons msppIcons-vk" v-else></span>
                                </div>
                                <div class="appUserList-contactPhone" :title="__('Phone')">
                                    <a :href="'tel:'+user.phone" :title="user.phone">
                                        <div class="msppIcons-phone"></div>
                                    </a>
                                </div>
                                <div class="appUserList-contactEmail" :title="user.email">
                                    <a v-if="user.email" :href="'mailto:'+user.email"><span class="appIcons msppIcons-mail msppIcons-mailTrue"></span></a>
                                    <span class="appIcons msppIcons-mail msppIcons-mailFalse" v-else></span>
                                </div>
                                <div class="appUserList-contactTelegram">
                                    <!--                                    <a class="appUserList-telegramOnline" target="_blank" v-if="user.telegram_nickname" :href="'https://t.me/' + user.telegram_nickname">
                                                                            <span class="appIcons msppIcons-telegram appUser-telegramIcon" :class="{'appUser-telegramTrue': user.telegram, 'appUser-telegramFalse': !user.telegram}"></span>
                                                                        </a>
                                                                        <span v-else class="appIcons msppIcons-telegram-nobg appUser-telegramIcon" :class="{'appUser-telegramTrue': user.telegram, 'appUser-telegramFalse': !user.telegram}"></span>-->
                                    <a class="appUserList-telegram" :class="{'disabled': !user.telegram_nickname}" target="_blank" :href="'https://t.me/' + user.telegram_nickname">
                                        <span  class="appIcons" :class="{'msppIcons-telegram-nobg': !user.telegram_nickname, 'appUser-telegramIcon msppIcons-telegram': user.telegram_nickname, 'appUser-telegramTrue': user.telegram || user.telegram_nickname, 'appUser-telegramFalse': !user.telegram}"></span>
                                    </a>
                                </div>

                            </div>
                            <div class="appTable-col appUserList-role" :title="__('Role')">
                                <div class="appUserList-roleBadges">
                                    <div class="appBadge msp-textEllipse" v-for="role of user.roles"
                                         :class="'appBadge-'+role.slug">
                                        {{ role.name }}
                                    </div>
                                </div>
                            </div>
                            <div class="appTable-col appUserList-geo" :title="__('GEO')">
                                <div class="msppIcons-map-pin"></div>
                                <div class="appUserList-geoSet">
                                    <div class="appUserList-geoUnit" :title="user.unit ? user.unit.name : __('No unit')"><span class="marginRight4" v-if="user.unit">Юнит:</span><span>{{  user.unit ? user.unit.name : __('No unit') }}</span></div>
                                    <div class="appUserList-geoCity" v-if="user.city">г. {{ user.city }}</div>
                                    <div class="appUserList-geoCountry" v-if="(admin || acarya) && user.country">({{ user.country }})</div>
                                    <div class="appUserList-geoRegion" :title="__('Region')" v-if="admin || acarya">/{{ user.region }} {{ __('Region') }}/</div>
                                </div>
                            </div>

                            <div class="appTable-col appUserList-created">
                                <div :title="__('Created')">
                                    {{ dateFormat(user.created_at) }}
                                </div>
                                <div class="appUser-initDate" :title="__('Initiation')">
                                    {{ user.initiation_date ? dateFormat(user.initiation_date) : __('No') }}
                                </div>
                            </div>
                            <div class="appTable-col appUserList-tools">
                                <action-dropdown>
                                    <a href="#" rel="nofollow" class="dhrtDropdown-item" v-if="admin || trustee || bp || secretary || curator"
                                       @click.prevent="edit(user)">
                                        {{ __('Edit') }}
                                    </a>
                                    <a href="#" rel="nofollow" class="dhrtDropdown-item"
                                       @click.prevent="details(user)">
                                        {{ __('Details') }}
                                    </a>
                                    <a href="#" rel="nofollow" class="dhrtDropdown-item" v-if="bp"
                                       @click.prevent="unitEdit(user)">
                                        {{ __('Unit') }}
                                    </a>
                                    <a v-if="user.avgDiary" class="dhrtDropdown-item" rel="nofollow" href="#"
                                       @click.prevent="openDiary(user)">
                                        {{ __('Diary') }}
                                    </a>
                                    <a v-if="(user.fake && (admin || secretary || bp)) || admin" class="dhrtDropdown-item" rel="nofollow" href="#"
                                       @click.prevent="destroy(user)">
                                        {{ user.fake ? __('Delete fake') : __('Delete user') }}
                                    </a>
                                </action-dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <pagination v-if="total >= 50" v-model="page" :total="total" :per-page="perPage"/>
        </div>

        <user-edit :admin="admin" @close="afterEdit" :key="user.id" v-if="user && editor" :user-id="user.id"/>
        <modal-window v-if="user && unitEditor" :button-list="['Close', 'Save']" nScroll
                      @close="user = null, unitEditor = null" @save="unitSave"
                      :windowName="user.spiritualName ? user.spiritualName+' ('+user.name+')' : user.name">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Unit') }}</div>
                <multiselect
                    v-model="user.unit"
                    :options="user.units"
                    label="name"
                    track-by="id"
                />
            </div>
        </modal-window>
        <statuses-filter @loaded="load_statuses()" v-show="statusesFilter" @close="filters.statuses = statuses_temp; statusesFilter = false" v-model="statuses_temp"></statuses-filter>
    </div>
</template>

<script>
    let moment = require('moment');
    import Multiselect from 'vue-multiselect'

    export default {
        components: {Multiselect},

        props: {
            perPage: {
                type: Number
            },
            admin: {
                type: Boolean,
                default: false
            },
            curator: {
                type: Boolean,
                default: false
            },
            trustee: {
                type: Boolean,
                default: false
            },
            bp: {
                type: Boolean,
                default: false
            },
            acarya: {
                type: Boolean,
                default: false
            },
            secretary: {
                type: Boolean,
                default: false
            },
            userId: {
                type: String,
                default: null
            }
        },

        data() {
            return {
                page: 1,
                total: 0,
                total_users: 0,
                users: [],
                unitsList: [],
                filters: {
                    id: null,
                    name: '',
                    city: '',
                    phone: '',
                    lesson: null,
                    email: '',
                    profession: '',
                    role: null,
                    acarya: '',
                    region: '',
                    statuses: [],
                    unit: null,
                    country: '',
                    title: null,
                    fake: null
                },
                statuses_temp: [],
                user: null,
                user_id: null,
                detailed: null,
                editor: null,
                unitEditor: null,
                statusesFilter: false,
                statusesLoaded: false,
                locale: 'ru',
                statuses: [],
                show_filters: false,
                titles: null,

                sortBy: 'created_at',
                sortOrder: 'desc',

                lessonNumbers: {null: this.__('All'), 7: this.__('No'), 1: '1', 2: '2', 3: '3', 4: '4', 5: '5', 6: '6', 8: this.__('Any lesson')},
                fakeOptions: {null: this.__('Both'), fake: this.__('Only fake'), not_fake: this.__('Only not fake')},
                userRoles: {
                    null: this.__('All'),
                    'sadhaka': this.__('Sadhaka'),
                    'admin': this.__('Admin'),
                    'acarya': this.__('Acarya'),
                    'helper': this.__('Acarya assistant'),
                    'secretary': this.__('Secretary'),
                    'bp': this.__('Bhukti Pradhan'),
                    'margii': this.__('Margii'),
                    'geo': this.__('Geo'),
                    'trustee': this.__('Trustee')
                },
                showFull: window.matchMedia("(max-width: 1199px)").matches,
            }
        },

        mounted() {
            this.getStatuses();
            this.getTitles();
            this.getRoles();
            this.locale = $('html').attr('lang');
        },

        watch: {
            page() {
                this.getData();
            },

            filters: {
                deep: true,
                handler() {
                    this.page = 1;
                    if (this.filters.lesson === "null") this.filters.lesson = null;
                    if (this.filters.role === "null") this.filters.role = null;
                    if(this.statusesLoaded) {
                        console.log('filtered Data');
                        this.getData();
                    }
                }
            },
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },

            bpOrSecretary() {
                return this.bp || this.secretary
            },

            chosen_statuses() {
                if(this.statuses) {
                    let results = this.statuses.reduce((results, status) => {
                        if (this.filters.statuses.includes(status.id)) results.push(status);
                        return results;
                    }, []);

                    return results;
                }
            },

            request_filters() {
                return {
                    name: this.filters.name ? this.filters.name : null,
                    city: this.filters.city ? this.filters.city : null,
                    phone: this.filters.phone ? this.filters.phone : null,
                    lesson: this.filters.lesson ? this.filters.lesson : null,
                    email: this.filters.email ? this.filters.email : null,
                    profession: this.filters.profession ? this.filters.profession : null,
                    role: this.filters.role ? this.filters.role : null,
                    acarya: this.filters.acarya ? this.filters.acarya : null,
                    region: this.filters.region ? this.filters.region : null,
                    id: this.filters.id ? this.filters.id : this.userId ? this.userId : null,
                    statuses: this.filters.statuses.length ? this.filters.statuses : null,
                    country: this.filters.country ? this.filters.country : null,
                    unit: this.filters.unit ? this.filters.unit.id : null,
                    title: this.filters.title ? this.filters.title.id : null,
                    fake: this.filters.fake ? this.filters.fake : null,

                    take: this.perPage,
                    skip: this.skip,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,
                };
            },

            are_filters() {
                return this.request_filters.name ||
                this.request_filters.city ||
                this.request_filters.phone ||
                this.request_filters.lesson ||
                this.request_filters.email ||
                this.request_filters.profession ||
                this.request_filters.role ||
                this.request_filters.acarya ||
                this.request_filters.region ||
                this.request_filters.id ||
                this.request_filters.country ||
                this.request_filters.fake ||
                this.request_filters.unit || (JSON.stringify(this.request_filters.statuses) !== "[1]")
            }
        },

        methods: {
            erase_filters() {
                this.filters.name = null;
                this.filters.city = null;
                this.filters.phone = null;
                this.filters.lesson = null;
                this.filters.email = null;
                this.filters.profession = null;
                this.filters.role = null;
                this.filters.acarya = null;
                this.filters.region = null;
                this.filters.id = null;
                this.filters.country = null;
                this.filters.unit = null;
                this.filters.fake = null;
                this.filters.statuses = [1];
                this.statuses_temp = [1];
            },

            round(n) {
                return Math.round(n * 10) / 10;
            },

            load_statuses() {
                if (this.statusesLoaded) this.getData();
                else this.statusesLoaded = true;
                this.filters.statuses = this.statuses_temp;
            },

            getData(full = false) {
                let params = this.request_filters;
                params.full = full ? full : null;
                this.$root.loading = !full;

                axios.get('/api/users', {params: params}).then(response => {
                    if (!full) {
                        this.total = response.data.meta.total;
                        this.users = response.data.data;
                        this.unitsList = response.data.meta.units;
                        this.total_users = response.data.meta.total_users;

                        if (this.unitsList && this.unitsList.length) this.unitsList.push({
                            id: null,
                            name: this.__('All units')
                        });

                        this.show_filters = false;
                        this.$root.loading = false;
                    } else {
                        let users = response.data.data;
                        let data = users.map(e =>
                            [
                                e.id,
                                e.name,
                                e.spiritual_name,
                                e.unit_alias,
                                e.title,
                                e.lesson_number,
                                e.system_acarya,
                                e.unit_name,
                                e.city,
                                e.country,
                                e.region,
                                e.roles.map(r => r.name).join('.'),
                                e.created_at,
                                e.initiation_date,
                                e.vk_id,
                                e.phone,
                                e.email,
                                e.telegram_nickname
                            ]
                                .join(","));

                        data.unshift(
                            [
                                'id',
                                'name',
                                'spiritual_name',
                                'unit_alias',
                                'title',
                                'lesson_number',
                                'system_acarya',
                                'unit_name',
                                'city',
                                'country',
                                'region',
                                'roles',
                                'creation_date',
                                'initiation_date',
                                'vk_id',
                                'phone',
                                'email',
                                'telegram',
                            ]
                        );

                        data = data.join("\n");

                        let csvContent = "data:text/csv;charset=utf-8,"
                            + data;

                        var encodedUri = encodeURI(csvContent);
                        var link = document.createElement("a");
                        link.setAttribute("href", encodedUri);
                        link.setAttribute("download", "users_" + moment().format('DD-MM-YYYY') + ".csv");
                        document.body.appendChild(link); // Required for FF

                        link.click(); // This will download the data file named "my_data.csv".

                        return response.data.data;
                    }
                });
            },

            getStatuses() {
                axios.get('/get-statuses').then(response => {
                    this.$nextTick(() => {
                        this.statuses = response.data.statuses;
                    });
                });
            },

            getTitles() {
                axios.get('/get-unit-titles').then(response => {
                    this.titles = response.data.titles;
                    this.titles.push({
                        id: 'all',
                        name: this.__('All secretaries')
                    });
                });
            },

            getRoles() {
                axios.get('/get-roles').then(response => {
                    this.userRoles = response.data.roles;
                });
            },

            openDiary(diary) {
                window.open("/diary?user=" + diary.id)
            },

            dateFormat(date) {
                return moment(date).format('DD.MM.YY');
            },

            edit(user) {
                this.editor = 1;
                this.user = user;
            },

            details(user) {
                this.$root.member_info_user_id = user.id;
            },

            unitEdit(user) {
                this.user = user;
                this.unitEditor = 1;
            },

            unitSave() {
                let params = {
                    userId: this.user.id,
                    unitId: this.user.unit.id
                };

                axios.post('/api/users', params).then(response => {
                    this.user = null;
                    this.unitEditor = null;
                });
            },

            afterEdit() {
                this.editor = null;
                this.user = null;
                this.getData();
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

            destroy(user) {
                axios.get('/destroy-user/' + user.id).then(response => {
                    this.getData();
                });
            }
        }
    }
</script>
