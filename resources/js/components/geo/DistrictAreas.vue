<template>

    <div class="appGEO-structureItem">
        <div class="appGEO-structureItemHeader">
            <div class="appGEO-structureItemHeaderText">
                <div class="appIcons-grid msppIcons-grid"></div>
                <div>{{ __('Areas') }}</div>
            </div>
            <div class="appGEO-structureItemHeaderMenu">
                <span class="appIcons msppIcons-plus appGEO-iconPlus" @click="create" v-if="menu"></span>
            </div>
        </div>
        <div class="appGEO-structureItemContent">
            <div class="appGEO-structureItemContentItems" v-for="area of areas">
                <label for="appGEO-district-areasCheck" @click="select(area, true)" class="appGEO-structureItemContentItem" :class="{active: geo.area && area.id === geo.area.id}">
                    <div>
                        <div class="appGEO-structureItemContentItemName">{{ area.name }}</div>
                        <div class="appGEO-structureItemContentItemNotes">{{ area.notes }}</div>
                    </div>
                    <action-dropdown v-if="menu">
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="notify(area)" v-if="menu">{{ __('Notify') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="edit(area)">{{ __('Edit') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="destroyArea(area)">{{ __('Remove') }}</a>
                    </action-dropdown>
                </label>
            </div>

            <modal-window id="appAreaModal" v-if="area" nScroll :buttonList="['Close', 'Save']" :valid="!!area.name && !error" @close="area = null" @save="save" :windowName="__('Area')">
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Name') }}</div>
                    <input class="appGEO-AreaNameInput appForm-input" type="text" v-model="area.name" ref="address" :class="{'is-valid': area.place_id && !error, 'is-invalid': error}">
                </div>

                <div class="appForm-group" v-if="menu">
                    <div class="appForm-groupTitle">{{ __('Acaryas') }}</div>
                    <multiselect
                            :multiple="true"
                            v-model="area.acaryas"
                            :options="acaryas"
                            label="name"
                            track-by="id"
                    />
                </div>
                <div class="appForm-group" v-if="area.units">
                    <div class="appForm-groupTitle">{{ __('Default unit') }}</div>
                    <multiselect
                        v-model="area.unit"
                        :options="area.units"
                        label="name"
                        track-by="id"
                    />
                </div>
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Notes') }}</div>
                    <textarea class="appForm-textarea" v-model="area.notes"></textarea>
                </div>
            </modal-window>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: { Multiselect },

        props: ['districtId', 'geo', 'menu', 'bp'],

        data() {
            return {
                areas: [],
                area: null,
                error: false,
                acaryas: [],

                change: true
            }
        },

        mounted() {
            this.getData();
        },

        watch: {
            areas(val) {
                if(this.change) {
                    if(this.geo.target && this.geo.target.area) {
                        this.select(this.areas.find(area => {
                            return area.id === this.geo.target.area;
                        }));
                    } else {
                        this.select(val.length ? val[0] : null);
                        this.$root.loading = false;
                    }
                    this.change = false;
                }
            },

            area(val) {
                if (val) {
                    this.$nextTick(() => {
                        this.initAutocomplete();
                    });
                }
            }
        },

        methods: {
            getData() {
                this.$root.loading = true;
                axios.get('/api/district-areas', {params: {districtId: this.districtId}}).then(response => {
                    this.areas = response.data.data;
                    this.acaryas = response.data.meta.acaryas;
                    this.$root.loading = true;
                });
            },

            create() {
                this.area = {
                    name: '',
                    place_id: '',
                    type: '',
                    acaryas: [],
                    unit: null
                };
            },

            edit(area) {
                this.area = JSON.parse(JSON.stringify(area));
                            },

            select(area, manual = false) {
                if(!this.geo.navigating || !manual) this.geo.area = area;
            },

            save() {
                if (!this.area.name) return;

                let payload = {
                    districtId: this.districtId,
                    name: this.area.name,
                    placeId: this.area.place_id,
                    type: this.area.type,
                    acaryas: this.area.acaryas,
                    notes: this.area.notes,
                    default_unit_id: this.area.unit
                };

                if (this.area.id) {
                    axios.put('/api/district-areas/' + this.area.id, payload).then(() => { this.afterSave(); });
                } else {
                    axios.post('/api/district-areas', payload).then(() => { this.afterSave(); });
                }
            },

            notify(area) {
                window.location.href = '/notifications?type=district_area&item=' + area.id;
            },

            afterSave() {
                this.getData();
                this.area = null;
            },

            destroyArea(area) {
                axios.delete('/api/district-areas/' + area.id).then(response => {
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
                    fields: ['name', 'place_id', 'types']
                });

                autocomplete.addListener('place_changed', () => {
                    let address = autocomplete.getPlace();

                    let type = filter[address.types[0]];

                    if (type === undefined) {
                        this.area.place_id = null;
                        this.area.type = null;
                        this.error = true;
                    } else {
                        this.area.type = type;
                        this.area.name = address.name;
                        this.area.place_id = address.place_id;
                        this.error = false;
                    }
                });
            }
        },


    }
</script>

<style>
    .pac-container {
        z-index: 9999 !important;
    }
</style>
