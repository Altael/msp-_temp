<template>
    <div class="infoBlockModal withText appMemberInfo" v-if="id && !loading">
        <div class="infoBlockModal-back" @click="close()"></div>
        <div class="infoBlockModal-content">
            <div class="infoBlockModal-tools" @click="close()">
                <div class="infoBlockModal-toolsHead">{{ __('User info') }}</div>
                <div class="infoBlockModal-toolsClose">
                    <div class="msppIcons msppIcons-x"></div>
                </div>
            </div>
            <div class="infoBlockModal-body">
                <div class="dhrtScroll-wrapperOuter">
                    <div class="dhrtScroll-wrapperInner">
                        <div class="appMemberInfo-content">
                            <div class="mappMembarInfo-main">
                                <div class="appMemberInfo-item avatar">
                                    <avatar class="appMemberInfo-avatar"
                                            :src="user.profile.image ? user.profile.image : '/images/no-avatar.jpg'"></avatar>
                                </div>
                                <div class="appMemberInfo-item name">
                                    <div>
                                        <div class="appMemberInfo-nameSpiritual">{{ user.profile.first_name }} {{ user.profile.last_name }}</div>
                                        <div class="appMemberInfo-nameCivil">{{ user.profile.spiritual_name }}</div>
                                        <div class="appMemberInfo-nameAlias">{{ user.profile.unit_alias }}</div>
                                    </div>
                                </div>

                                <div class="appMemberInfo-item roles">
                                    <div class="appMemberInfo-itemValue">
                                        <div class="appBadge" v-for="role of user.roles">
                                            {{ role.name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="appMemberInfo-item helper" v-if="helper">
                                    <div class="appMemberInfo-itemValue">
                                        <span>{{ __('Acarya assistant') }}:&nbsp;</span><span><template v-for="acarya of user.acaryas">{{ acarya.name }}</template></span>
                                    </div>
                                </div>

                            </div>
                            <div class="appMemberInfo-items">
                                <div class="appMemberInfo-item">
                                    <div class="appMemberInfo-itemTitle">{{ __('ID') }}</div>
                                    <div class="appMemberInfo-itemValue">{{ user.id }}</div>
                                </div>
                                <div class="appMemberInfo-item" v-if="user.city">
                                    <div class="appMemberInfo-itemTitle">{{ __('City') }}</div>
                                    <div class="appMemberInfo-itemValue">{{ user.city }}<template v-if="user.country"> ({{ user.country }})</template></div>
                                </div>
                                <div class="appMemberInfo-item">
                                    <div class="appMemberInfo-itemTitle">{{ __('Unit') }}</div>
                                    <div class="appMemberInfo-itemValue">
                                        <template v-if="user.unit && user.unit.name">
                                            {{ user.unit.name }}
                                            (
                                            <template v-if="user.districtArea.district && user.districtArea.district.diocese && user.districtArea.district.diocese.region">{{ user.districtArea.district.diocese.region.name }}&rarr;&nbsp;</template>
                                            <template v-if="user.districtArea.district && user.districtArea.district.diocese">{{ user.districtArea.district.diocese.name }}&rarr;&nbsp;</template>
                                            <template v-if="user.districtArea.district">{{ user.districtArea.district.name }}</template>
                                            &rarr;&nbsp;{{ user.districtArea.name }}
                                            )
                                        </template>
                                        <template v-else>{{ __('No unit') }}</template>
                                    </div>
                                </div>

                                <div class="appMemberInfo-item">
                                    <div class="appMemberInfo-itemTitle">{{ __('Unit status') }}</div>
                                    <div class="appMemberInfo-itemValue">{{ user.status ? user.status['name_' + locale] : '' }}</div>
                                </div>
                                <div class="appMemberInfo-item" v-if="user.title">
                                    <div class="appMemberInfo-itemTitle">{{ __('Unit title') }}</div>
                                    <div class="appMemberInfo-itemValue">{{ user.title.name }}</div>
                                </div>
                                <div class="appMemberInfo-item">
                                    <div class="appMemberInfo-itemTitle">{{ __('LFT status') }}</div>
                                    <div class="appMemberInfo-itemValue">{{ user.lft }}</div>
                                </div>

                                <div class="appMemberInfo-item contact" >
                                    <div class="appMemberInfo-itemTitle">{{ __('Contacts') }}</div>
                                    <div class="appMemberInfo-itemValue">
                                        <a :href="'mailto:' + user.profile.email" class="withIcons" v-if="user.profile.email">
                                            <span class="appIcons msppIcons-mail"></span>
                                            <span>{{ user.profile.email }}</span>
                                        </a>
                                        <a :title="__('Technical')" :href="'mailto:' + user.email_system" class="withIcons system" v-if="user.email_system" >
                                            <span class="appIcons msppIcons-mail"></span>
                                            <span>{{ user.email_system }}</span>
                                        </a>
                                        <a :href="'tel:' + user.profile.phone" class="withIcons" v-if="user.profile.phone">
                                            <span class="appIcons msppIcons-phone"></span>
                                            <span>{{ user.profile.phone }}</span>
                                        </a>
                                        <a :title="__('Technical')" :href="'tel:' + user.phone_system" class="withIcons system" v-if="user.phone_system">
                                            <span class="appIcons msppIcons-phone"></span>
                                            <span>{{ user.phone_system }}</span>
                                        </a>
                                        <a class="withIcons" v-if="user.profile.telegram_id" :class="{'disabled': !user.profile.telegram_nickname}" target="_blank" :href="'https://t.me/' + user.profile.telegram_nickname">
                                            <span  class="appIcons" :class="{'msppIcons-telegram-nobg': !user.profile.telegram_nickname, 'appUser-telegramIcon msppIcons-telegram': user.profile.telegram_nickname, 'appUser-telegramTrue': user.profile.telegram_id || user.profile.telegram_nickname, 'appUser-telegramFalse': !user.profile.telegram_id}"></span>
                                            <span>{{ user.profile.telegram_nickname ? user.profile.telegram_nickname : __('No nickname in telegram') }}</span>
                                        </a>
                                        <a class="withIcons system" v-if="user.telegram_system" :class="{'disabled': !user.telegram_system}" target="_blank" :href="user.telegram_system ? 'https://t.me/' + user.telegram_system : '#'" :title="__('Technical')">
                                            <span  class="appIcons" :class="{'msppIcons-telegram-nobg': !user.telegram_system, 'appUser-telegramIcon msppIcons-telegram': user.telegram_system, 'appUser-telegramTrue': user.telegram_system, 'appUser-telegramFalse': !user.telegram_system}"></span><span v-if="user.telegram_system">{{ user.telegram_system }}</span>
                                        </a>
                                        <a class="withIcons" v-if="user.vk_id" :href="'https://vk.com/id' + user.vk_id" :class="{'disabled': !user.vk_id}" target="_blank">
                                            <span class="appIcons msppIcons-vk"></span>
                                            <span>ВКонтакте</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="appMemberInfo-item lesson" v-if="user.lesson_number">
                                    <div class="appMemberInfo-itemTitle">{{ __('Lesson') }}</div>
                                    <div class="appMemberInfo-itemValue">
                                        <div class="appMemberInfo-lesson">
                                            <div>{{ user.lesson_number }}</div>

                                            <div class="appUser-acarya" v-if="user.system_acarya">
                                                <avatar v-if="user.system_acarya" class="appAvatar"
                                                        :src="user.system_acarya_avatar" :title="user.system_acarya"></avatar>
                                                <span>{{ user.system_acarya }}</span>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="appMemberInfo-item" v-if="user.profession">
                                    <div class="appMemberInfo-itemTitle">{{ __('Profession') }}</div>
                                    <div class="appMemberInfo-itemValue">{{ user.profession }}</div>
                                </div>
                                <div class="appMemberInfo-item" v-if="user.registration_date">
                                    <div class="appMemberInfo-itemTitle">{{ __('Registration date') }}</div>
                                    <div class="appMemberInfo-itemValue">{{ date(user.registration_date) }}</div>
                                </div>
                                <div class="appMemberInfo-item" v-if="user.initiation_date">
                                    <div class="appMemberInfo-itemTitle">{{ __('Initiation date') }}</div>
                                    <div class="appMemberInfo-itemValue">{{ date(user.initiation_date) }}</div>
                                </div>
                                <div class="appMemberInfo-item" v-if="user.notes">
                                    <div class="appMemberInfo-itemTitle">{{ __('Notes') }}</div>
                                    <div class="appMemberInfo-itemValue">{{ user.notes }}</div>
                                </div>
                                <div class="appMemberInfo-item" v-if="history.length">
                                    <div class="appMemberInfo-itemTitle">{{ __('User activity') }}</div>
                                    <div class="appMemberInfo-itemValue" v-for="record of history">{{ record.name }} - {{ record.date }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</template>
<script>
    let moment = require('moment');

    export default{
        data() {
            return {
                user: null,
                loading: true,
                locale: 'ru',
                history: []
            }
        },

        watch: {
            id() {
                if(this.id){
                    this.loading = true;
                    this.getData();
                }
            }
        },

        mounted() {
            this.locale = $('html').attr('lang');
            document.body.classList.add('modalOpen');
        },

        beforeDestroy() {
            document.body.classList.remove('modalOpen');
        },

        computed: {
            helper() {
                return this.user.roles.some(role => role.slug === 'helper');
            },

            id() {
                return this.$root.member_info_user_id;
            }
        },

        methods: {
            getData() {
                axios.get('/api/users/' + this.id).then(response => {
                    this.user = response.data.data;
                    this.history = response.data.meta.history;
                    this.loading = false;
                });
            },

            close() {
                this.$root.member_info_user_id = null;
            },

            date(date) {
                return moment(date).format('DD.MM.YYYY');
            }
        }
    }
</script>
