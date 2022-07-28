<template>
    <div class="appUser" v-if="user">
        <avatar class="appUser-avatar"
                :src="user.profile.image ? user.profile.image : '/images/no-avatar.jpg'"></avatar>
        <div class="appUser-nameRole">
            <div class="appUser-name">
                <template v-if="isAcarya">{{ user.profile.displayName }}</template>
                <template v-else>
                    <div class="appUser-nameIcon" :class="{'withSpirit': user.profile.spiritual_name}">
                        <div class="appUser-nameMain">
                            <template v-if="user.profile.spiritual_name">
                                {{ user.profile.spiritual_name }}
                            </template>
                            <template v-else>
                                {{ user.profile.first_name + ' ' + user.profile.last_name }}
                            </template>
                        </div>
                        <template v-if="social">
                            <div v-if="social === 'google'" class="appIconsappIcons msppIcons-google-plus appUser-iconGoogle"></div>
                            <div v-if="social === 'facebook'" class="appIcons msppIcons-facebook appUser-iconFacebook"></div>
                            <div v-if="social === 'vkontakte'" class="appIcons msppIcons-vk appUser-iconVK"></div>
                            <div v-if="social === 'yandex'" class="appIcons msppI cons-yahoo appUser-iconYandex"></div>
                            <div v-if="social === 'mailru'" class="appIcons msppIcons-at-sign appUser-iconMailru"></div>
                        </template>
                        <div v-else class="appIcons msppIcons-mail appUser-iconEmail"></div>
                        <div class="appUser-nameSocial" v-if="user.profile.spiritual_name">
                            {{ user.profile.first_name + ' ' + user.profile.last_name }}
                        </div>
                    </div>



                </template>
            </div>
            <div class="appUser-role">
                {{ roleNames.join(', ') }}
            </div>
            <div class="appUser-boss" v-if="helper && acaryas">
                <div>
                    {{ __('Acarya') }}:&nbsp;
                </div>
                <object-dropdown class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto dhrtDropdown-menuAlignmentLeft"
                    :options="acaryas"
                    v-model="acarya"
                    label="name"
                ></object-dropdown>
            </div>
        </div>
        <div class="appUser-copyInfo">
            <span class="appIcons msppIcons-copy" @click="copy"></span>
        </div>

        <confirm-pop-up :label="__('Data copied to clipboard')" ref="confirm"></confirm-pop-up>
    </div>
</template>


<script>
    export default {
        props: ['userId', 'data'],

        data() {
            return {
                user: null,
                social: null,
                acaryas: [],
                acarya: null,
                loaded: false
            }
        },

        mounted() {
            this.getData();

            if (this.data) {
                this.acaryas = this.data.acaryas;
            }
        },

        watch: {
            acarya() {
                if(this.loaded) {
                    axios.post('/change-acarya', {id: this.acarya.id}).then(response => {
                        window.location.reload();
                    });
                }
            }
        },

        computed: {
            selectedAcarya() {
                let item = null;
                this.acaryas.map(acarya => {
                    if (acarya.id === this.data.acaryaId) {
                        item = acarya;
                        this.acarya = acarya;
                        this.$nextTick(() => this.loaded = true);
                    }
                });
                return item;
            },

            helper() {
                return this.user.roles.some(role => role.slug === 'helper');
            },

            isAcarya() {
                return this.user.roles.some(role => role.slug === 'acarya');
            },

            roleNames() {
                let names = [];

                this.user.full_roles.map(role => {
                    names.push(this.__(role.name));
                });

                return names;
            }
        },

        methods: {
            getData() {
                axios.get('/api/users/' + this.userId).then(response => {
                    this.acaryas = response.data.data.acaryas;
                    this.social = response.data.meta.social;
                    this.user = response.data.data;
                });
            },

            select(acarya) {
                axios.post('/change-acarya', {id: acarya.id}).then(response => {
                    window.location.reload();
                });
            },

            copy() {
                let $tmp = $("<textarea>");
                let name = this.user.profile.first_name + ' ' + this.user.profile.last_name;
                if(this.user.profile.spiritual_name) name += ' (' + this.user.profile.spiritual_name + ') - ' + this.user.profile.hash_id;

                $("body").append($tmp);
                $tmp.val(name).select();
                document.execCommand("copy");
                $tmp.remove();

                this.$refs.confirm.blink();
            }
        }
    }
</script>
