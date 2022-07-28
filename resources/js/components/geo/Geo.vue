<template>
    <div class="appGEO">

        <div class="appGEO-bhuktis" :class="{'open': bhukti_list}" v-if="menu && !districts_cheater">
            <div class="appGEO-title">
                {{ __('Bhuktis') }}
            </div>
            <div class="appGEO-bhuktisTools">
                <div class="appGEO-bhuktisToolsCount">
                    <div class="appGEO-bhuktisInfo">
                        <div class="appGEO-bhuktisInfoBhuktis">
                            <span class="view768more">{{ __('Active') }}</span>
                            <span :title="__('Active') + ' ' + bhuktis_info.registered_bhuktis_count + ' ' + __('of') + ' ' + bhuktis_info.bhuktis_count +__('bhuktis')">{{ bhuktis_info.registered_bhuktis_count }} {{ __('of') }} {{ bhuktis_info.bhuktis_count }}</span>
                            <span class="view768more">{{ __('bhuktis') }}</span>
                        </div>
                        <div class="appGEO-bhuktisInfoUnits" v-if="bhuktis_info && bhuktis_info.units">
                            <div class="appGEO-bhuktisInfoUnitsMain">
                                <span class="appIcons msppIcons-cpu"></span>
                                <span :title="bhuktis_info.units.all + ' ' + __('units')">{{ bhuktis_info.units.all }}</span>
                                <span class="view768more"><declension :amount="bhuktis_info.units.all" word="units"></declension></span>
                            </div>
                            <div class="appGEO-bhuktisInfoUnitsReg" :class="{'notEmpty': bhuktis_info.units.of_reg || bhuktis_info.units.not_reg || bhuktis_info.units.um}">
                                <div v-if="bhuktis_info.units.of_reg" :title="bhuktis_info.units.of_reg + ' ' + __('reg.')">
                                    <span>{{ bhuktis_info.units.of_reg }}</span>
                                    <span class="view768more">{{ __('reg.') }}</span>
                                </div>
                                <div v-if="bhuktis_info.units.not_reg" :title="bhuktis_info.units.not_reg + ' ' + __('not reg.')">
                                    <span>{{ bhuktis_info.units.not_reg }}</span>
                                    <span class="view768more">{{ __('not reg.') }}</span>
                                </div>
                                <div v-if="bhuktis_info.units.um" :title="bhuktis_info.units.um + ' ' + __('KM only')">
                                    <span v-if="bhuktis_info.units.um">{{ bhuktis_info.units.um }}</span>
                                    <span class="view768more">{{ __('KM only') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="appGEO-bhuktisToolsButton" @click="bhukti_list = !bhukti_list">
                    <span class="appIcons msppIcons-chevrons-right" v-if="bhukti_list"></span>
                    <span class="appIcons msppIcons-chevrons-left" v-else></span>
                    <span>{{ __('List of Bhuktis') }}</span>
                </div>
            </div>
            <div class="appGEO-bhuktisContent">
                <div class="appGEO-bhuktisFilter" v-if="bhukti_list">
                    <input type="text" v-model.lazy="country_name" class="appTable-filterField" :placeholder="__('Country name')">
                    <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                </div>
                <div class="appGEO-bhuktisList">
                    <div class="appGEO-bhuktisCountry" v-for="(country, name) of bhuktis" v-if="!country_name || new RegExp(country_name, 'i').test(name)">
                        <div class="appGEO-bhuktisCountryHead" @click="bhukti_listing_works(name)" :class="{'opened': bhuktis_toggle[name]}">
                            <div class="appGEO-bhuktisCountryName">{{ name ? name : __('Country not defined') }}</div>
                            <div class="appGEO-bhuktisCountryInfo">
                                <div class="appGEO-bhuktisInfo">
                                    <div class="appGEO-bhuktisInfoBhuktis">
                                        <span class="view768more">{{ __('Active') }}</span>
                                        <span :title="__('Active') + ' ' + count_bhukti_works(country.bhuktis) + ' ' + __('of') + ' ' + country.bhuktis.length +__('bhuktis')">{{ count_bhukti_works(country.bhuktis) }} {{ __('of') }} {{ country.bhuktis.length }}</span>
                                        <span class="view768more">{{ __('bhuktis') }}</span>

                                    </div>
                                    <div class="appGEO-bhuktisInfoUnits">
                                        <div class="appGEO-bhuktisInfoUnitsMain">
                                            <span class="appIcons msppIcons-cpu"></span>
                                            <span :title="country.units.all + ' ' + __('units')">{{ country.units.all }}</span>
                                            <span class="view768more"><declension :amount="country.units.all" word="units"></declension></span>
                                        </div>
                                        <div class="appGEO-bhuktisInfoUnitsReg" :class="{'notEmpty': country.units.of_reg || country.units.not_reg || country.units.um}">
                                            <div v-if="country.units.of_reg" :title="country.units.of_reg + ' ' + __('reg.')">
                                                <span>{{ country.units.of_reg }}</span>
                                                <span class="view768more">{{ __('reg.') }}</span>
                                            </div>
                                            <div v-if="country.units.not_reg" :title="country.units.not_reg + ' ' + __('not reg.')">
                                                <span>{{ country.units.not_reg }}</span>
                                                <span class="view768more">{{ __('not reg.') }}</span>
                                            </div>
                                            <div v-if="country.units.um" :title="country.units.um + ' ' + __('KM only')">
                                                <span v-if="country.units.um">{{ country.units.um }}</span>
                                                <span class="view768more">{{ __('KM only') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="appGEO-bhuktisCountryBody" v-if="bhuktis_toggle[name]">
                            <div class="appGEO-bhukti" v-for="bhukti of country.bhuktis" :class="{'cickabelno': isBhuktiWorks(bhukti.name)}">
                                <div class="appGEO-bhuktiNameLink">
                                    <div class="appGEO-bhuktiLink"  @click="unlimitedBhuktiWorks(bhukti.name)">
                                        <div class="appIcons msppIcons-arrow-up-right" v-if="isBhuktiWorks(bhukti.name)"></div>
                                    </div>
                                    <div class="appGEO-bhuktiName">
                                        <div class="appGEO-bhuktiNameAcarya">
                                            <div class="appGEO-bhuktiNameText" @click="unlimitedBhuktiWorks(bhukti.name)">{{ bhukti.name }}</div>
                                            <object-dropdown search
                                                             class="appGEO-bhuktiAcaryaCurator withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto widthAuto"
                                                             :options="all_acaryas.filter(acarya => bhukti.acaryas.findIndex( e => e.id === acarya.id) === -1)"
                                                             @input="acaryaWorks(bhukti)"
                                                             v-model="bhukti.curator_acarya"
                                                             label="name"
                                                             placeholder="Choose curator acarya..."
                                                             :title="__('Curator acarya')"
                                            ></object-dropdown>
                                        </div>
                                        <div class="appGEO-bhuktiNameUnits"  @click="unlimitedBhuktiWorks(bhukti.name)">
                                            <div class="appIcons msppIcons-cpu"></div>
                                            <div class="appGEO-bhuktiNameUnitsText">
                                                <div>{{ bhukti.units }}&nbsp;<declension :amount="bhukti.units" word="units"></declension></div>
                                                <div class="appGEO-bhuktiNameUnitsReg">
                                                    <div v-if="bhukti.units_registration.of_reg">{{ bhukti.units_registration.of_reg }}&nbsp;<span>{{ __('reg.') }}</span></div>
                                                    <div v-if="bhukti.units_registration.not_reg">{{ bhukti.units_registration.not_reg }}&nbsp;<span>{{ __('not reg.') }}</span></div>
                                                    <div v-if="bhukti.units_registration.um">{{ bhukti.units_registration.um }}&nbsp;<span>{{ __('KM') }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="appGEO-bhuktiTools">
                                    <div class="appGEO-bhuktiBP">
                                        <div class="appGEO-bhuktiBPuser" v-for="(bhukti_bp, key) of bhukti.bps" >
                                            <div class="appGEO-bhuktiBPuserRank">
                                                <dropdown v-if="bhukti_bp.id" v-model="bhukti.bps[key].rank"
                                                          class="withArrow arrowBold menuWidthAuto arrowSmall dhrtDropdown-menuPositionDown"
                                                          :options="Object.keys(BP_ranks)
                                                                              .filter( index => index === 'ABP' ? (bhukti.bps.findIndex(i => i.rank === 'BP') === -1) || (bhukti.bps[key].rank === 'BP') : true )
                                                                              .reduce( (res, index) => (res[index] = BP_ranks[index], res), {} )"
                                                          @input="bhuktiPradhanWorks(bhukti)"></dropdown>
                                            </div>
                                            <object-dropdown :key="key"
                                                             search
                                                             class="appGEO-bhuktiBPuserName withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto"
                                                             :options="bps.filter(bp => bhukti.bps.findIndex( e => e.id === bp.id) === -1)"
                                                             @input="bhuktiPradhanWorks(bhukti)"
                                                             v-model="bhukti.bps[key]"
                                                             label="name"
                                                             placeholder="Choose BP"
                                                             :unpressable="bps && !bps.filter(bp => bhukti.bps.findIndex( e => e.id === bp.id) === -1).length"
                                                             :title="__('Delete')"
                                            ></object-dropdown>
                                            <div class="appGEO-bhuktiBPdel" @click="bhukti.bps.splice(key, 1); bhuktiPradhanWorks(bhukti)"  v-if="bhukti_bp.id">
                                                <span class="appIcons msppIcons-user-x"></span>
                                            </div>
                                        </div>
                                        <div class="appGEO-bhuktiBPnew" :title="__('Add')" @click="bhukti.bps.push({id: null, name: __('Choose BP'), rank: __('BP')})" v-if="bhukti.bps[0].id && bps.filter(bp => bhukti.bps.findIndex( e => e.id === bp.id) === -1 && bp.id !== null).length">
                                            <span class="appIcons msppIcons-user-plus"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="appGEO-unitList" :class="{'open': unit_list}" v-if="!districts_cheater">
            <div class="appGEO-title">
                {{ __('Units') }}
            </div>
            <div class="appGEO-unitListTools">
                <div class="appGEO-unitListToolsCount">
                    {{ Object.values(units).flat().length }} {{ __('units') }}
                </div>

                <div class="appGEO-unitListToolsButton" @click="unit_list = !unit_list">
                    <span class="appIcons msppIcons-chevrons-right" v-if="unit_list"></span>
                    <span class="appIcons msppIcons-chevrons-left" v-else></span>
                    <span>{{ __('List of Units') }}</span>
                </div>
            </div>
            <div class="appGEO-unitListItems">
                <div class="appGEO-unitListFilter" v-if="unit_list">
                    <input type="text" v-model.lazy="unit_name" @change="open_bhuktis()" class="appTable-filterField" :placeholder="__('unit name')">
                    <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                </div>
                <div class="appGEO-unitListBhukti" v-for="(units_in_bhukti, name) of units" v-if="units_in_bhukti.filter(unit_filter => unit_name ? new RegExp(unit_name, 'i').test(unit_filter.unit.name) : true).length">
                    <div class="appGEO-unitListBhuktiHead" :ref="name" @click="unit_listing_works(name)" :class="{'opened': units_toggle[name]}">
                        <div>
                            <div class="appGEO-unitListBhuktiName">{{ __('Bhukti') }} &laquo;{{ name }}&raquo;</div>
                            <div class="appGEO-bhuktiAcarya">{{ acaryas[name] }}</div>
                        </div>
                        <div class="appGEO-unitListBhuktiIcon">
                            <div class="appIcons msppIcons-chevron-down"></div>
                            <div class="appIcons msppIcons-chevron-up"></div>
                        </div>
                    </div>
                    <div class="appGEO-unitListBhuktiBody" v-if="units_toggle[name]">
                        <div class="appGEO-unitListItem" v-for="unit of units_in_bhukti.filter(unit_filter => unit_name ? new RegExp(unit_name, 'i').test(unit_filter.unit.name) : true)">
                            <div class="appGEO-unitListItemTitle itemsMarginRight8" @click="hand_call = true; unlimitedGeoWorks(unit)">
                                <div class="appGEO-unitListItemName">
                                    <div>{{ unit.unit.name }}&nbsp;({{ unit.members_count }})</div>
                                    <div class="appGEO-unitType">
                                        {{ reg_statuses[unit.registration_status] }}
                                    </div>
                                </div>
                                <div class="appGEO-unitListItemDash">
                                    &nbsp;&mdash;&nbsp;
                                </div>
                                <div class="appGEO-unitListItemStructureWrap itemsMarginRight8">
                                    <div class="appGEO-unitListItemStructure itemsMarginRight4">
                                        <div v-if="menu">{{ unit.sector.name }}&nbsp;&rarr;</div>
                                        <div v-if="menu">{{ unit.region.name }}&nbsp;&rarr;</div>
                                        <div v-if="menu">{{ unit.diocese.name }}&nbsp;&rarr;</div>
                                        <div>{{ unit.district.name }}&nbsp;&rarr;</div>
                                        <div>{{ unit.area.name }}</div>
                                    </div>
                                    <div class="appGEO-unitListItemLink">
                                        <div class="appIcons msppIcons-share-2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="appGEO-unitListOfficers">
                                <div class="appGEO-unitListOfficer" v-for="officer of unit.officers.slice().sort((user1, user2) => {
                                                                    if(user1.title && user1.title.slug === 'sunit') return -1;
                                                                    if(user2.title && user2.title.slug === 'sunit') return 1;
                                                                    else return 0;
                                                                })" v-if="unit.officers">
                                    <div class="appGEO-unitListOfficerInfo" >
                                        <avatar class="appLists-avatarImage" :src="officer.image"></avatar>
                                        <div class="appGEO-unitListOfficerInfoText">
                                            <div class="appGEO-unitListOfficerInfoNamePost" :title="officer.name">
                                                <div class="appGEO-unitListOfficerName">{{ officer.name }}</div>
                                                <div class="appGEO-unitListOfficerPost" v-if="officer.title">{{ officer.title.name }}</div>
                                            </div>
                                            <div class="appGEO-unitListOfficerInfoRoles" v-if="officerRoles(officer)">
                                                {{ officerRoles(officer) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="appGEO-unitListOfficerRoles">
                                        <template v-if="officerRoles(officer)">{{ officerRoles(officer) }}</template>
                                    </div>
                                    <div class="appGEO-unitListOfficerTools">
                                        <user-tools :id="officer.id"></user-tools>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="appGEO-structure">
            <div class="appGEO-title">
                {{ __('Structure AMPS') }}
            </div>
            <div class="appGEO-structureItems">
                <div class="appGEO-structureItemWrap sector" v-if="menu && !districts_cheater">
                    <input type="checkbox" id="appGEO-sectorsCheck" class="dhrtCheckbox-noView">
                    <sectors :geo="geo" :menu="menu" ref="sector"/>
                </div>
                <div class="appGEO-structureItemWrap region" v-if="menu && !districts_cheater">
                    <input type="checkbox" id="appGEO-regionsCheck" class="dhrtCheckbox-noView">
                    <regions :key="geo.sector.id"  v-if="geo.sector" :sector-id="geo.sector.id" :geo="geo" :menu="menu" ref="region"/>
                </div>
                <div class="appGEO-structureItemWrap diocese" v-if="menu && !districts_cheater">
                    <input type="checkbox" id="appGEO-diocesesCheck" class="dhrtCheckbox-noView">
                    <dioceses :key="geo.region.id" v-if="geo.region" :region-id="geo.region.id" :geo="geo" :menu="menu" ref="diocese"/>
                </div>
                <div class="appGEO-structureItemWrap district">
                    <input type="checkbox" id="appGEO-districtsCheck" class="dhrtCheckbox-noView" :checked="districts_cheater">
                    <districts :key="(!menu && bp || districts_cheater) ? null : geo.diocese.id" v-if="geo.diocese || (!menu  && bp) || districts_cheater" :diocese-id="(!menu && bp) || districts_cheater ? null : geo.diocese.id" :geo="geo" :menu="menu || districts_cheater" :bp="bp || districts_cheater" :districts_cheater="districts_cheater" ref="district"/>
                </div>
                <div class="appGEO-structureItemWrap area">
                    <input type="checkbox" id="appGEO-district-areasCheck" class="dhrtCheckbox-noView">
                    <district-areas :key="geo.district.id" v-if="geo.district && !districts_cheater" :district-id="geo.district.id" :geo="geo" :menu="menu" :bp="bp" ref="area"/>
                </div>
                <div class="appGEO-structureItemWrap units">
                    <input type="checkbox" id="appGEO-unitsCheck" class="dhrtCheckbox-noView">
                    <units :key="geo.area.id" v-if="geo.area" :district-area-id="geo.area.id" :geo="geo" :menu="menu || bp" :bp="bp" ref="unit"/>
                </div>
                <div class="appGEO-structureItemWrap unit" v-if="menu || bp">
                    <unit-users  :admin="admin" :key="geo.unit.id" v-if="geo.unit && geo.unit.id" :unit-id="geo.unit.id" :geo="geo" :menu="menu || bp" ref="users"/>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {

        props: {
            menu: {
                default: false,
                type: Boolean
            },

            bp: {
                default: false,
                type: Boolean
            },

            districts_cheater: {
                default: false,
                type: Boolean
            },

            admin: {
                default: false,
                type: Boolean
            }
        },

        data() {
            return {
                geo: {
                    sector: null,
                    region: null,
                    diocese: null,
                    district: null,
                    area: null,
                    unit: null,

                    target: {
                        sector: null,
                        region: null,
                        diocese: null,
                        district: null,
                        area: null,
                        unit: null
                    },

                    navigating: false,
                    navigating_type: 'unit'
                },

                BP_ranks: {BP: this.__('BP'), ABP: this.__('Acting BP'), TBP: this.__('Tech BP')},
                reg_statuses: {of_reg: this.__('Officially registered'), not_reg: this.__('Not registered'), um: this.__('UM communty')},

                units: [],
                acaryas: {},
                all_acaryas: [],
                bhuktis: [],
                bhuktis_info: {},
                bhuktis_copy: [],
                bhuktis_toggle: {},
                units_toggle: {},
                bps: [],
                unit_list: false,
                bhukti_list: false,
                unit_name: null,
                country_name: null,
                user: null,
                user_id: null,
                hand_call: false
            }
        },

        watch: {
            'geo.sector': function (val) { if (val === null) { this.geo.region = null; } },
            'geo.region': function (val) { if (val === null) { this.geo.diocese = null; } },
            'geo.diocese': function (val)  { if (val === null) { this.geo.district = null; } },
            'geo.district': function (val)  { if (val === null) { this.geo.area = null; } },
            'geo.area': function (val)  { if (val === null) { this.geo.unit = null; } },
            'geo.unit': function (val)  { if (val === null) { this.geo.unit = null; } },

            bhuktis: {
                deep: true,
                handler() {
                    if(this.bhuktis_copy.length) {
                        for(var i = 0; i < this.bhuktis.length; i++) {
                            if(this.bhuktis_copy[i].bp.id !== this.bhuktis[i].bp.id) {
                                this.bhuktiPradhanWorks(this.bhuktis[i]);
                                this.bhuktis_copy = JSON.parse(JSON.stringify(this.bhuktis));
                                break;
                            }
                        }
                    }
                }
            }
        },

        mounted() {
            if($cookies.isKey('geo-navigation')) {
                this.$root.loading = true;
            }
            this.getData();
            if(this.menu) this.getBhuktis();
        },

        methods: {
            afterEdit() {
                this.user = null;
                this.getData(true);
            },

            officerRoles(officer) {
                return officer.roles.map((role, key) => {
                    if(role.slug === 'sadhaka' || role.slug === 'sadhika' || role.slug === 'margii') officer.roles.splice(key, 1)
                    else return role.name
                }).join(', ');
            },

            getData(light = false) {
                axios.get('/api/geo-units').then(response => {
                    this.units = response.data.units;
                    this.acaryas = response.data.acaryas;
                    for (let bhukti in this.units) {
                        if(this.units.hasOwnProperty(bhukti)) this.units_toggle[bhukti] = false;
                    }
                    if(!light) {
                        if($cookies.isKey('geo-navigation')) {
                            if(this.menu) {
                                if(!$cookies.get('geo-navigation').sector) {
                                    $cookies.remove('geo-navigation');
                                    this.$root.loading = false;
                                    return;
                                }
                            } else {
                                if($cookies.get('geo-navigation').sector) {
                                    $cookies.remove('geo-navigation');
                                    this.$root.loading = false;
                                    return;
                                }
                            }
                            this.unlimitedGeoWorks($cookies.get('geo-navigation'));
                        }
                    }
                });
            },

            getBhuktis() {
                axios.get('/api/districts-full').then( response => {
                    this.bhuktis = JSON.parse(JSON.stringify(response.data.data));
                    this.all_acaryas = response.data.meta.all_acaryas;
                    this.bhuktis_info.registered_bhuktis_count = response.data.meta.registered_bhuktis;
                    this.bhuktis_info.bhuktis_count = response.data.meta.bhuktis;
                    this.bhuktis_info.units = response.data.meta.units;
                    this.bhuktis_copy = JSON.parse(JSON.stringify(response.data.data));
                    this.bps = response.data.meta.bps;
                    this.bps.forEach(bp => bp.rank = 'BP');
                    for (let bhukti in this.bhuktis) {
                        if(this.bhuktis.hasOwnProperty(bhukti) && !this.bhuktis_toggle[bhukti]) this.bhuktis_toggle[bhukti] = false;
                    }
                    this.$root.loading = false;
                });
            },

            unlimitedGeoWorks(unit, type = 'unit') {
                if(!this.districts_cheater) {
                    if(type === 'unit') {
                        if(this.menu) {
                            this.geo.target = {
                                sector: unit.sector.id,
                                region: unit.region.id,
                                diocese: unit.diocese.id,
                                district: unit.district.id,
                                area: unit.area.id,
                                unit: unit.unit.id
                            };
                        } else {
                            this.geo.target = {
                                district: unit.district.id,
                                area: unit.area.id,
                                unit: unit.unit.id
                            };
                        }
                    } else {
                        this.geo.target = {
                            sector: unit.sector.id,
                            region: unit.region.id,
                            diocese: unit.diocese.id,
                            district: unit.district.id
                        };
                    }

                    this.$root.loading = true;
                    this.unit_list = false;

                    this.geo.navigating = true;
                    this.geo.navigating_type = type;

                    if(this.menu) {
                        this.geo.sector = null;
                        this.$nextTick(() => {
                            this.geo.sector = this.$refs.sector.sectors.find(sector => {
                                return sector.id === unit.sector.id;
                            });
                        });
                    } else {
                        this.geo.district = null;
                        this.$nextTick(() => {
                            this.geo.district = this.$refs.district.districts.find(district => {
                                return district.id === unit.district.id;
                            });
                        });
                    }
                }
            },

            unlimitedBhuktiWorks(name) {
                if(this.$refs[name]) {
                    this.unit_list = true;
                    this.bhukti_list = false;
                    this.unit_listing_works(name);
                    this.$nextTick(() => {
                        let height = $(this.$refs[name][0]).offset().top - $(this.$root.$refs.pageScroller).offset().top + $(this.$root.$refs.pageScroller).scrollTop();
                        $(this.$root.$refs.pageScroller).animate({scrollTop: height},'slow');
                    });
                }
            },

            isBhuktiWorks(name) {
              return this.$refs[name];
            },

            bhuktiPradhanWorks(bhukti) {
                let data = {
                    bps: bhukti.bps,
                    bhukti_id: bhukti.id
                };
                this.$root.loading = true;
                axios.post('/api/districts/bp', data).then( response => {
                    this.getBhuktis();
                });
            },

            acaryaWorks(bhukti) {
                let data = {
                    id: bhukti.curator_acarya.id,
                    bhukti_id: bhukti.id
                };
                this.$root.loading = true;
                axios.post('/api/districts/acarya', data).then( response => {
                    this.getBhuktis();
                    this.getData();
                });
            },

            count_bhukti_works(bhuktis) {
                let filled = 0;

                bhuktis.map( bhukti => {
                    if(bhukti.bps[0].id) filled++;
                });

                return filled;
            },

            bhukti_listing_works(country) {
                this.$set(this.bhuktis_toggle, country, !this.bhuktis_toggle[country]);
                this.$forceUpdate();
            },

            unit_listing_works(bhukti) {
                this.$set(this.units_toggle, bhukti, !this.units_toggle[bhukti]);
                this.$forceUpdate();
            },

            open_bhuktis() {
                if(this.unit_name) {
                    for(let bhukti in this.units_toggle) {
                        this.units_toggle[bhukti] = true;
                    }
                } else {
                    for(let bhukti in this.units_toggle) {
                        this.units_toggle[bhukti] = false;
                    }
                }
                this.$forceUpdate();
            }
        }
    }
</script>
