<template>
    <div class="amProfile">
        <template v-if="page === 'main'">
            <div class="amProfileTop">
                <div class="amProfileTop-left"></div>
                <div class="amProfileTop-info">
                    <avatar class="amAvatar amProfileTop-infoAvatar"
                            :src="userInfo.avatar ? userInfo.avatar : '/images/no-avatar.jpg'"></avatar>
                    <div class="amProfileTop-infoName">{{ userInfo.name }}</div>
                    <div class="amProfileTop-infoRoles">
                        <template v-for="role of userInfo.roles"><span>{{ __(role) }}</span></template>
                    </div>
                    <div class="amProfileTop-infoMessage" v-if="!registered">
                        <span>{{ __('In order to write your Acarya and get information about your unit it is necessary to register first.') }}</span>
                    </div>

                </div>
                <div class="amProfileTop-right"></div>
                <div class="appUser-copyInfo" @click="copy()">
                    <span class="appIcons msppIcons-copy"></span>
                </div>
            </div>
            <div class="amProfileMenu">
                <div class="amProfileMenuGroup">
                    <a @click.prevent="page = 'editProfile'" class="amProfileMenuGroupItem">
                        <div>
                            <div class="appIcons msppIcons-settings amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ registered ? __('Profile settings') : __('Register') }}</div>
                        </div>
                        <div class="appIcons msppIcons-chevron-right"></div>
                    </a>
                </div>
                <div class="amProfileMenuGroup">
                    <a v-if="registered" class="amProfileMenuGroupItem" href="/user/conversations">
                        <div>
                            <div class="appIcons msppIcons-conversations amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ __('Write to acarya') }}</div>
                        </div>
                        <div class="appIcons msppIcons-chevron-right"></div>
                    </a>
                    <a v-if="registered" class="amProfileMenuGroupItem" href="/user/request">
                        <div>
                            <div class="appIcons msppIcons-edit amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ __('Get or check lesson') }}</div>
                        </div>
                        <span class="appIcons msppIcons-chevron-right"></span>
                    </a>
                </div>
                <div class="amProfileMenuGroup">
                    <a v-if="registered" class="amProfileMenuGroupItem" href="/unit">
                        <div>
                            <div class="appIcons msppIcons-users amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ __('My unit') }}</div>
                        </div>
                        <span class="appIcons msppIcons-chevron-right"></span>
                    </a>
                    <a v-if="secretary || admin" class="amProfileMenuGroupItem" href="/unit-statistics">
                        <div>
                            <div class="appIcons msppIcons-trending-up amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ __('Unit') }} {{ __('Statistics') }}</div>
                        </div>
                        <span class="appIcons msppIcons-chevron-right"></span>
                    </a>
                    <a v-if="bp || admin" class="amProfileMenuGroupItem" href="/bhukti-statistics">
                        <div>
                            <div class="appIcons msppIcons-trending-up amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ __('Bhukti') }} {{ __('Statistics') }}</div>
                        </div>
                        <span class="appIcons msppIcons-chevron-right"></span>
                    </a>
                </div>
                <div class="amProfileMenuGroup">
                    <a class="amProfileMenuGroupItem" href="/fastings">
                        <div>
                            <div class="appIcons msppIcons-calendar-fasting amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ __('Fasting calendar') }}</div>
                        </div>
                        <div class="appIcons msppIcons-chevron-right"></div>
                    </a>
                </div>
                <div class="amProfileMenuGroup">
                    <a class="amProfileMenuGroupItem" href="#" @click.prevent="page = 'needHelp'">
                        <div>
                            <div class="appIcons msppIcons-support amProfileMenuGroupItem-icon"></div>
                            <div>
                                <div class="amProfileMenuGroupItem-name">{{ __('Need a help?') }}</div>
                                <div class="amProfileMenuGroupItem-underText">{{ __('Questions, reviews, other issues') }}</div>
                            </div>
                        </div>
                        <div class="appIcons msppIcons-chevron-right"></div>
                    </a>
                    <a class="amProfileMenuGroupItem" href="#" @click.prevent="page = 'donation'">
                        <div>
                            <div class="appIcons msppIcons-donation amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ __('Donation') }}</div>
                        </div>
                        <div class="appIcons msppIcons-chevron-right"></div>
                    </a>
                    <a class="amProfileMenuGroupItem" href="#" @click.prevent="page = 'useful'">
                        <div>
                            <div class="appIcons msppIcons-guru amProfileMenuGroupItem-icon"></div>
                            <div class="amProfileMenuGroupItem-name">{{ __('Useful') }}</div>
                        </div>
                        <div class="appIcons msppIcons-chevron-right"></div>
                    </a>
                </div>

            </div>
        </template>

        <div class="amPage" v-if="page === 'editProfile'">
            <div @click="page = 'main'" :title="__('Backward')" class="amPage-title">
                {{ __('Profile settings') }}
            </div>

            <user-profile></user-profile>
        </div>

        <div class="amPage" v-if="page === 'needHelp'">
            <div class="amPage-title" @click="page = 'main'">
                {{ __('Need a help?') }}
            </div>
            <div class="amPage-body">
                <a target="_blank" href="https://t.me/joinchat/HwvLX042zULgX-KjhYi_Ag" class="amPage-bodyHelp">
                    <span class="amPage-bodyHelpIcon appIcons msppIcons-mail"></span>
                    <div class="amPage-bodyHelpText">
                        <span class="amPage-bodyHelpTextName">{{ __('App review')}}</span>
                        <span class="amPage-bodyHelpTextAbout">{{ __('Feedback is very important for us, write about any problems in the application, as well as ideas and wishes')}}</span>
                    </div>

                </a>
                <a target="_blank" class="amPage-bodyHelp appItemHidden" href="https://www.facebook.com/notes/%D1%81%D0%B0%D1%82%D1%81%D0%B0%D0%BD%D0%B3-%D0%BE%D0%BD%D0%BB%D0%B0%D0%B9%D0%BD/%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82-%D1%81%D0%B0%D1%82%D1%81%D0%B0%D0%BD%D0%B3-%D0%BE%D0%BD%D0%BB%D0%B0%D0%B9%D0%BD/393714067922744/">
                    <span class="amPage-bodyHelpIcon appIcons msppIcons-life-buoy"></span>
                    <div class="amPage-bodyHelpText">
                        <span class="amPage-bodyHelpTextName">{{ __('Satsang online')}}</span>
                        <span class="amPage-bodyHelpTextAbout">{{ __('Skilled psychologists will help you get out of difficult situations and clashes')}}</span>
                    </div>

                </a>
                <a target="_blank" href="https://t.me/aravinda_deva" class="amPage-bodyHelp">
                    <span class="amPage-bodyHelpIcon appIcons msppIcons-message-square"></span>
                    <div class="amPage-bodyHelpText">
                        <span class="amPage-bodyHelpTextName">{{ __('Complain about organizational problems')}}</span>
                        <span class="amPage-bodyHelpTextAbout">{{ __('If you have any difficulties that are difficult to solve at the unit level, please contact here')}}</span>
                    </div>

                </a>
            </div>
        </div>

        <div class="amPage" v-if="page === 'useful'">
            <div class="amPage-title" @click="page = 'main'">
                {{ __('Useful') }}
            </div>
            <div class="amPage-body">
                <a target="_blank" href="https://anandamarga.ru/info" class="amPage-bodyHelp">
                    <span class="amPage-bodyHelpIcon appIcons msppIcons-svadhyaya"></span>
                    <div class="amPage-bodyHelpText">
                        <span class="amPage-bodyHelpTextName">{{ __('Anandamarga.ru')}}</span>
                        <span class="amPage-bodyHelpTextAbout">{{ __('Information about Ananda Marga and practices')}}</span>
                    </div>

                </a>
                <a target="_blank" href="https://anandamarga.ru/acb-sb" class="amPage-bodyHelp">
                    <span class="amPage-bodyHelpIcon appIcons msppIcons-users"></span>
                    <div class="amPage-bodyHelpText">
                        <span class="amPage-bodyHelpTextName">{{ __('Семейный комитет')}}</span>
                        <span class="amPage-bodyHelpTextAbout">{{ __('поддержка будущих и уже созданных семей в русскоязычном пространстве «Ананда марга»')}}</span>
                    </div>

                </a>

            </div>
        </div>


        <div class="amPage amProfileDonation" v-if="page === 'donation'">
            <div class="amPage-title" @click="page = 'main'">
                {{ __('Donation') }}
            </div>
            <div class="amPage-body">
                <post post_slug="donation" post_class="amProfileDonation-post"></post>
            </div>
        </div>

        <!--<div class="amPage" v-if="page === ''">
            <div class="amPage-title">
                <span class="amPage-titleBack appIcons msppIcons-chevron-left" @click="page = 'main'"></span>
                <span class="amPage-titleName">{{ __('') }}</span>
            </div>
            <div class="amPage-body">

            </div>
        </div>-->

        <confirm-pop-up label="Data copied to clipboard" ref="confirm"></confirm-pop-up>
    </div>

</template>

<script>
    import SidebarParent from "../../../../vue/src/views/components/vuesax/sidebar/SidebarParent";
    export default {
        components: {SidebarParent},

        props: ['bp', 'secretary', 'admin'],

        data() {
            return {
                page: null,
                userInfo: null,
                registered: false
            }
        },

        mounted() {
            this.registered = $('html').attr('data-registered') === "1";
            this.getData();
        },

        methods: {
            getData() {
                axios.get('api/user-cabinet').then(response => {
                    this.userInfo = response.data.userInfo;
                    this.page = 'main';
                    /*if(!this.registered) {
                        this.page = 'editProfile';
                    }*/
                });
            },

            copy() {
                let $tmp = $("<textarea>");
                let name = this.userInfo.first_name + ' ' + this.userInfo.last_name;
                if(this.userInfo.spiritual_name) name += ' (' + this.userInfo.spiritual_name + ') - ' + this.userInfo.hash_id;

                $("body").append($tmp);
                $tmp.val(name).select();
                document.execCommand("copy");
                $tmp.remove();

                this.$refs.confirm.blink();
            }
        }
    }
</script>
