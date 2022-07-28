<template>

    <div class="appGEO-structureItem">
        <div class="appGEO-structureItemHeader">
            <div class="appGEO-structureItemHeaderText">
                <div class="appIcons-grid msppIcons-grid"></div>
                <div>{{ __('Districts') }} ({{ __('Bhukti') }})</div>
            </div>
            <div class="appGEO-structureItemHeaderMenu">
                <span class="appIcons msppIcons-plus appGEO-iconPlus" @click="create" v-if="menu"></span>
            </div>
        </div>
        <div v-if="districts_cheater">
            <input type="checkbox" v-model="filters.empty_country"> {{ __('Show only bhuktis with empty country field') }}
        </div>
        <div class="appGEO-structureItemContent" id="districtAnchor">
            <div class="appGEO-structureItemContentItems" v-for="district of districts">
                <label for="appGEO-districtsCheck" @click="select(district, true)" class="appGEO-structureItemContentItem" :class="{active: geo.district && district.id === geo.district.id}">
                    <div>
                        <div class="appGEO-structureItemContentItemName">{{ district.name }}</div>
                        <div class="appGEO-structureItemContentItemNotes">{{ district.notes }}</div>
                    </div>
                    <action-dropdown v-if="menu">
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="notify(district)">{{ __('Notify') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="edit(district)">{{ __('Edit') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="destroyDistrict(district)">{{ __('Remove') }}</a>
                    </action-dropdown>
                </label>
            </div>

            <modal-window :key="district.id" id="appDistrictModal" class="appGEO-districtEdit" v-if="district" :buttonList="['Close', 'Save']" :valid="!!district.name" @close="district = null" @save="save" :windowName="__('District')">
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Name') }}</div>
                    <input class="appForm-input" type="text" v-model="district.name">
                    <div class="appGEO-districtEditNotice" >{{ district.sector ? district.sector.name : '' }} -> {{ district.region ? district.region.name : '' }} -> {{ district.diocese ? district.diocese.name : '' }}</div>
                </div>

                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Country') }}</div>
                    <input class="appGEO-districtEditCountryInput appForm-input" type="text" v-model="district.country" ref="address" :class="{'is-valid': district.place_id && !error, 'is-invalid': error}">
                </div>

                <div class="appForm-group appGEO-districtEditSwitch">
                    <div class="appGEO-districtEditSwitchBtn left" @click="prev()">
                        <span class="appIcons msppIcons-arrow-left-circle"></span>
                        <span>{{ __('Prev.') }}</span>
                        <span class="appHotkeys">&and;&larr;</span>
                    </div>
                    <div class="appGEO-districtEditSwitchBtn right" @click="next()">
                        <span class="appHotkeys">&and;&rarr;</span>
                        <span>{{ __('Next.') }}</span>
                        <span class="appIcons msppIcons-arrow-right-circle"></span>
                    </div>
                </div>

                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Acaryas') }}</div>
                    <multiselect
                            :multiple="true"
                            v-model="district.acaryas"
                            :options="acaryas"
                            label="name"
                            track-by="id"
                    />
                </div>
                <!--<div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Bhukti Pradhan') }}</div>
                    <multiselect
                        v-model="district.bp"
                        :options="bps"
                        label="name"
                        track-by="id"
                    />
                </div>-->
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Notes') }}</div>
                    <textarea class="appForm-textarea" v-model="district.notes"></textarea>
                </div>
            </modal-window>
            <confirm-pop-up ref="confirm"></confirm-pop-up>

        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: { Multiselect },

        props: ['dioceseId', 'geo', 'menu', 'bp', 'districts_cheater'],

        data() {
            return {
                districts: [],
                district: null,
                acaryas: [],
                error: false,
                bps: [],
                map: {},
                inited: false,

                filters: {
                    empty_country: false
                }
            }
        },

        mounted() {
            this.getData();
            $('html').keydown((e) => {
                this.map[e.keyCode] = true;
                if(this.map[17] && this.map[39]) this.next();
                if(this.map[17] && this.map[37]) this.prev();
                if(this.map[17] && this.map[13]) this.save();
            });
            $('html').keyup(e => {
                this.map[e.keyCode] = false;
            });
        },

        computed: {
            chosen_district_id() {
                return this.districts.indexOf( this.geo.district);
            }
        },

        watch: {
            districts(val) {
                if(this.geo.target && this.geo.target.district) {
                    this.select(this.districts.find(district => {
                        return district.id === this.geo.target.district;
                    }));
                } else {
                    this.select(val.length ? val[0] : null)
                }
            },

            district(val) {
                if (val) {
                    this.$nextTick(() => {
                        if(!this.inited) this.initAutocomplete();
                    });
                }
            },

            filters: {
                deep: true,
                handler() {
                    this.getData()
                }
            }
        },

        methods: {
            getData() {
                this.$root.loading = true;
                axios.get('/api/districts', {params: {
                    dioceseId: this.dioceseId,
                    empty_country: this.filters.empty_country ? this.filters.empty_country : null
                }}).then(response => {
                    this.districts = response.data.data;
                    if(!this.bp) {
                        this.acaryas = response.data.meta.acaryas;
                        this.bps = response.data.meta.bps;
                    }
                    this.$root.loading = false;
                });
            },

            create() {
                this.district = {name: '', acaryas: [], bp: null};
            },

            edit(district) {
                this.district = JSON.parse(JSON.stringify(district));
            },

            select(district, manual = false) {
                if(!this.geo.navigating || !manual) this.geo.district = district;
            },

            save() {
                if (!this.district.name) return;

                let payload = {
                    dioceseId: this.dioceseId,
                    name: this.district.name,
                    acaryas: this.district.acaryas,
                    notes: this.district.notes,
                    bpId: this.district.bp ? this.district.bp.id : null,
                    country_id: this.district.place_id
                };

                if (this.district.id) {
                    axios.put('/api/districts/' + this.district.id, payload).then(() => { this.afterSave(); });
                } else {
                    axios.post('/api/districts', payload).then(() => { this.afterSave(); });
                }
            },

            notify(district) {
                window.location.href = '/notifications?type=district&item=' + district.id;
            },

            afterSave() {
                if(!this.districts_cheater) {
                    this.getData();
                    this.district = null;
                } else {
                    this.$refs.confirm.blink();
                }
            },

            destroyDistrict(district) {
                axios.delete('/api/districts/' + district.id).then(response => {
                    this.getData();
                });
            },

            initAutocomplete() {
                let filter = {
                    'locality': 'city',
                    'administrative_area_level_1': 'region',
                    'administrative_area_level_2': 'region',
                    'country': 'country',
                };


                let autocomplete = new google.maps.places.Autocomplete(this.$refs.address, {
                    types: ['geocode'],
                    fields: ['name', 'place_id', 'types'],
                    language: 'uk'
                });

                autocomplete.addListener('place_changed', () => {
                    let address = autocomplete.getPlace({
                        fields: ['type', 'name', 'place_id']
                    });

                    let type = filter[address.types[0]];

                    if (type === undefined) {
                        this.district.place_id = null;
                        this.error = true;
                    } else {
                        this.district.country = address.name;
                        this.district.place_id = address.place_id;
                        this.error = false;
                    }
                });
            },

            prev() {
                this.district = (this.chosen_district_id > 0 ? this.districts[this.chosen_district_id-1] : this.districts[0]); this.select(this.chosen_district_id > 0 ? this.districts[this.chosen_district_id-1] : this.districts[0], true)
            },

            next() {
                this.district = (this.chosen_district_id < this.districts.length-1 ? this.districts[this.chosen_district_id+1] : this.districts[this.districts.length-1]); this.select(this.chosen_district_id < this.districts.length-1 ? this.districts[this.chosen_district_id+1] : this.districts[this.districts.length-1], true)
            }
        },


    }
</script>
