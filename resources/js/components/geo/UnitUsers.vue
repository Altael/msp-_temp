<template>
    <div class="appGEO-structureItem">
        <div class="appGEO-structureItemHeader">
            <div class="appGEO-structureItemHeaderText">
                <div class="appIcons-grid msppIcons-grid"></div>
                <div>{{ __('Members') }}</div>
            </div>
            <div class="appGEO-structureItemHeaderMenu">
            </div>
        </div>
        <div class="appGEO-structureItemUnitFilterWrap">
            <div class="appGEO-structureItemUnitFilter">
                <input type="text" v-model.lazy="name" class="appTable-filterField" :placeholder="__('User name')">
                <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
            </div>

        </div>
        <div class="appGEO-structureItemContent">
            <div class="appGEO-structureItemContentWarning" v-if="since_creation < 30">
                {{ __('Wait please...') }}
            </div>
            <div v-else class="appGEO-structureItemContentUser" v-for="user of users.slice().sort((user1, user2) => {
                if(user1.title && user1.title.slug === 'sunit') return -1;
                if(user2.title && user2.title.slug === 'sunit') return 1;
                if(user1.title && !user2.title) return -1;
                if(user2.title && !user1.title) return 1;
                if(user1.status && user1.status.id === 1 && !(user2.status && user2.status.id === 1)) return -1;
                if(user2.status && user2.status.id === 1 && !(user1.status && user1.status.id === 1)) return 1;
                return 0;
            })" :class="{'userInStealthMode': user.hide_from_unit}">
                <div class="appGEO-structureItemContentUserName">
                    <avatar class="appLists-avatarImage" :src="user.image"></avatar>
                    <user-name :social="user.social_name" :spiritual="user.spiritual_name" :alias="user.unit_alias" :id="user.id"></user-name>
                </div>
                <div class="appGEO-structureItemContentUserTools">
                    <user-tools @edited="getData()" :id="user.id"></user-tools>
                </div>
                <div class="appGEO-structureItemContentUserSecretary" >
                    <object-dropdown v-if="user.title || (titles.length > 1 && (user.status ? user.status.id === 1 : false))" @input="titleWorks($event, user.id)" v-model="user.title" :options=" user.title ? titles : titles.slice(0, -1)" label="name" class="appGEO-structureItemContentUserSecretaryPost dhrtDropdown-menuAlignmentRight arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto"></object-dropdown>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: { Multiselect },

        props: ['unitId', 'admin'],

        data() {
            return {
                users: [],
                user: null,
                since_creation: 100,
                titles: [],
                acaryas: [],
                reg_statuses: {of_reg: this.__('Officially registered'), not_reg: this.__('Not registered'), um: this.__('UM communty')},
                status: null,

                name: null
            }
        },

        mounted() {
            this.getData();
        },

        watch: {
            name() {
                this.getData();
            }
        },

        methods: {
            getData() {
                axios.get('/api/unit-users', {params: {
                    unitId: this.unitId,
                    name: this.name ? this.name : null
                }}).then(response => {
                    this.users = response.data.data;
                    this.since_creation = response.data.since_creation;
                    this.$parent.unit_list = false;
                    this.$parent.bhukti_list = false;
                    let height = $('#unitAnchor').offset().top - $(this.$root.$refs.pageScroller).offset().top;
                    if(this.$parent.hand_call) {
                        if(this.$root.loading) `$(this.$root.$refs.pageScroller).animate({scrollTop: height},'slow');`
                        this.$parent.hand_call = false;
                    }
                    this.$root.loading = false;
                    this.titles = response.data.titles;
                    this.acaryas = response.data.acaryas;
                    this.status = response.data.status;
                    this.titles.push({
                        id: null,
                        name: this.__('Remove post')
                    });
                });
            },

            titleWorks(event, id) {
                let params = {
                    user_id: id,
                    title_id: event.id
                };

                axios.put('/api/user-title-works', {params: params}).then(response => {
                    this.getData();
                });
            }
        },


    }
</script>
