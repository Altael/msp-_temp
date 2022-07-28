<template>
    <div class="appGEO-structureItem">
        <div class="appGEO-structureItemHeader">
            <div class="appGEO-structureItemHeaderText">
                <div class="appIcons-grid msppIcons-grid"></div>
                <div>{{ __('Units') }}</div>
            </div>
            <div class="appGEO-structureItemHeaderMenu">
                <span class="appIcons msppIcons-plus" @click="create" v-if="menu"></span>
            </div>
        </div>
        <div class="appGEO-structureItemContent" id="unitAnchor">
            <div class="appGEO-structureItemContentItems" v-for="unit of units">
                <label for="appGEO-unitsCheck" @click="select(unit, true)" class="appGEO-structureItemContentItem" :class="{active: geo.unit && unit.id === geo.unit.id}">
                    <div class="appGEO-structureUnitInfo">
                        <div class="appGEO-structureUnitInfoMain">
                            <div class="appGEO-structureItemContentItemName">
                                <div class="appGEO-structureItemContentItemNameInfo">
                                    <span>{{ unit.name }}</span>
                                    <span class="appGEO-unitType">/&nbsp;{{ reg_statuses[unit.registration_status] }}&nbsp;/</span>
                                </div>
                                <div class="appGEO-unitAcarya">{{ unit.curator_acarya }}</div>
                            </div>
                            <div class="appGEO-structureItemContentItemCount" v-if="unit.users">{{ unit.users.length  }}</div>
                        </div>
                        <div class="appGEO-structureItemContentItemNotes">{{ unit.notes }}</div>
                    </div>
                    <action-dropdown v-if="menu">
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="edit(unit)">{{ __('Edit') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="destroyUnit(unit)" v-if="menu">{{ __('Remove') }}</a>
                    </action-dropdown>
                </label>
            </div>
            <modal-window id="appUnitModal" v-if="unit" :buttonList="['Close', 'Save']" :valid="!!unit.name" @close="unit = null" @save="save" :windowName="__('Unit')+' '+unit.name">
                <div class="appForm-group" v-if="menu">
                    <div class="appForm-groupTitle">{{ __('Name') }}</div>
                    <input class="appForm-input" type="text"  v-model="unit.name">
                </div>

                <div class="appForm-group" :class="{'disabled': !menu}">
                    <div class="appForm-groupTitle">{{ __('Acaryas') }}</div>
                    <multiselect
                            :multiple="true"
                            :internalSearch="false"
                            v-model="unit.acaryas"
                            :options="acaryas"
                            label="name"
                            track-by="id"
                    />
                </div>
                <!--<div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Members') }}</div>
                    <multiselect
                        :multiple="true"
                        :hideSelected="true"
                        v-model="unit.users"
                        :options="areaUsers"
                        label="name"
                        track-by="id"
                    />
                </div>-->
                <!--<div class="appForm-group" v-if="menu && unit.secretaries">
                    <div class="appForm-groupTitle">{{ __('Unit secretary') }}</div>
                    <multiselect
                        v-model="unit.secretary"
                        :options="unit.secretaries"
                        label="name"
                        track-by="id"
                    />
                </div>-->
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Notes') }}</div>
                    <textarea class="appForm-textarea" v-model="unit.notes"></textarea>
                </div>
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Registration status') }}</div>
                    <div class="dhrtRadio" v-if="menu || bp">
                        <label>
                            <input type="radio" class="dhrtRadio-noView" v-model="unit.registration_status" value="of_reg">
                            <span class="dhrtRadioView"></span>
                            <span>{{ __('Officially registered') }}</span>
                        </label>
                        <label>
                            <input type="radio" class="dhrtRadio-noView" v-model="unit.registration_status" value="not_reg">
                            <span class="dhrtRadioView"></span>
                            <span>{{ __('Not registered') }}</span>
                        </label>
                        <label>
                            <input type="radio" class="dhrtRadio-noView" v-model="unit.registration_status" value="um">
                            <span class="dhrtRadioView"></span>
                            <span>{{ __('UM communty') }}</span>
                        </label>
                    </div>
                    <div v-else>
                        {{ reg_statuses[unit.registration_status] }}
                    </div>
                </div>
            </modal-window>
        </div>
        <modal-window id="appUnitsModal-error" class="appModal-warning" v-if="errors" :buttonList="['Cancel']" nScroll @close="errors = null" @cancel="errors = null" :windowName="__('Warning!!!')">
            <div class="appForm-group">
                <div class="appModal-confirm">
                    <div>{{ __('Error has occured') }}:</div>
                    <template v-for="(error, name) in errors">
                        <div v-for="(errorText, id) in error">
                            {{ errorText }}
                        </div>
                    </template>
                </div>
            </div>
        </modal-window>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: { Multiselect },

        props: {
            districtAreaId: {
                type: Number
            },
            geo: {
                type: Object
            },
            menu: {
                type: Boolean
            },
            bp: {
                type: Boolean
            }
        },

        data() {
            return {
                units: [],
                unit: null,
                acaryas: [],
                areaUsers: [],
                errors: null,

                change: true,

                reg_statuses: {of_reg: this.__('Officially registered'), not_reg: this.__('Not registered'), um: this.__('UM communty')}
            }
        },

        mounted() {
            this.getData();
        },

        watch: {
            units(val) {
                if(this.change) {
                    if(this.geo.target && this.geo.target.unit) {
                        this.select(this.units.find(unit => {
                            return unit.id === this.geo.target.unit;
                        }));
                        this.$parent.geo.target = null;
                        this.$parent.geo.navigating = false;
                    } else this.select(val.length ? val[0] : null);
                    this.change = false;
                }
            }
        },

        computed: {

        },

        methods: {
            getData() {
                this.$root.loading = true;
                axios.get('/api/units', {params: {districtAreaId: this.districtAreaId}}).then(response => {
                    this.units = response.data.data;
                    this.acaryas = response.data.meta.acaryas;
                    this.areaUsers = response.data.meta.areaUsers;
                    this.$root.loading = false;
                });
            },

            create() {
                this.unit = {name: '', acaryas: [], users: [], secretary: null};
            },

            edit(unit) {
                this.unit = JSON.parse(JSON.stringify(unit));
            },

            select(unit, manual = false) {
                if(!this.geo.navigating || !manual) {
                    this.geo.unit = unit;
                    if(this.$parent.menu) {
                        $cookies.set('geo-navigation', {
                            sector: {id: this.geo.sector.id},
                            region: {id: this.geo.region.id},
                            diocese: {id: this.geo.diocese.id},
                            district: {id: this.geo.district.id},
                            area: {id: this.geo.area.id},
                            unit: {id: this.geo.unit.id}
                        });
                    } else {
                        $cookies.set('geo-navigation', {
                            district: {id: this.geo.district.id},
                            area: {id: this.geo.area.id},
                            unit: {id: this.geo.unit.id}
                        });
                    }
                }
            },

            save() {
                if (!this.unit.name) return;

                let payload = {
                    districtAreaId: this.districtAreaId,
                    name: this.unit.name,
                    acaryas: this.unit.acaryas,
                    users: this.unit.users,
                    notes: this.unit.notes,
                    secretaryId: this.unit.secretary ? this.unit.secretary.id : null,
                    registration_status: this.unit.registration_status
                };

                if (this.unit.id) {
                    axios.put('/api/units/' + this.unit.id, payload).then(() => {
                        this.unit = null;
                        this.getData();
                    });
                } else {
                    axios.post('/api/units', payload).then(response => {
                        this.units.push(response.data.status);
                        this.geo.unit = response.data.status;
                        this.unit = null;
                    });
                }
            },

            notify(unit) {
                window.location.href = '/notifications?type=unit&item=' + unit.id;
            },

            afterSave() {
                this.unit = null;
                this.getData();
            },

            destroyUnit(unit) {
                axios.delete('/api/units/' + unit.id).then(response => {
                    this.getData();
                });
            }
        },


    }
</script>
