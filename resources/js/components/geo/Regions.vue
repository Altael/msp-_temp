<template>

    <div class="appGEO-structureItem">
        <div class="appGEO-structureItemHeader">
            <div class="appGEO-structureItemHeaderText">
                <div class="appIcons-grid msppIcons-grid"></div>
                <div>{{ __('Regions') }}</div>
            </div>
            <div class="appGEO-structureItemHeaderMenu">
                <span class="appIcons msppIcons-plus appGEO-iconPlus" @click="create" v-if="menu"></span>
            </div>
        </div>
        <div class="appGEO-structureItemContent">
            <div class="appGEO-structureItemContentItems" v-for="region of regions">
                <label for="appGEO-regionsCheck" @click="select(region, true)" class="appGEO-structureItemContentItem" :class="{active: geo.region && region.id === geo.region.id}">
                    <div>
                        <div class="appGEO-structureItemContentItemName">{{ region.name }}</div>
                        <div class="appGEO-structureItemContentItemNotes">{{ region.notes }}</div>
                    </div>
                    <action-dropdown v-if="menu">
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="notify(region)">{{ __('Notify') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="edit(region)">{{ __('Edit') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="destroyRegion(region)">{{ __('Remove') }}</a>
                    </action-dropdown>
                </label>
            </div>
            <modal-window id="appRegionModal" v-if="region" :buttonList="['Close', 'Save']" nScroll :valid="!!region.name" @close="region = null" @save="save" :windowName="__('Region')">
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Name') }}</div>
                    <input class="appForm-input" type="text" v-model="region.name">
                </div>
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Notes') }}</div>
                    <textarea class="appForm-textarea" v-model="region.notes"></textarea>
                </div>
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Acaryas') }}</div>
                    <multiselect
                            :multiple="true"
                            v-model="region.acaryas"
                            :options="acaryas"
                            label="name"
                            track-by="id"
                    />
                </div>
            </modal-window>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: { Multiselect },

        props: ['geo', 'sectorId', 'menu'],

        data() {
            return {
                regions: [],
                region: null,
                acaryas: []
            }
        },

        mounted() {
            this.getData();
        },

        watch: {
            regions(val) {
                if(this.geo.target && this.geo.target.region) {
                    this.select(this.regions.find(region => {
                        return region.id === this.geo.target.region;
                    }));
                } else this.select(val.length ? val[0] : null);
            }
        },

        methods: {
            getData() {
                this.$root.loading = true;
                axios.get('/api/regions', {params: {sectorId: this.sectorId}}).then(response => {
                    this.regions = response.data.data;
                    this.acaryas = response.data.meta.acaryas;
                    this.$root.loading = false;
                });
            },

            create() {
                this.region = {name: '', acaryas: []};
            },

            edit(region) {
                this.region = JSON.parse(JSON.stringify(region));
            },

            select(region, manual = false) {
                if(!this.geo.navigating || !manual) this.geo.region = region;
            },

            save() {
                if (!this.region.name) return;

                let payload = {
                    sectorId: this.sectorId,
                    name: this.region.name,
                    acaryas: this.region.acaryas,
                    notes: this.region.notes
                };

                if (this.region.id) {
                    axios.put('/api/regions/' + this.region.id, payload).then(() => { this.afterSave(); });
                } else {
                    axios.post('/api/regions', payload).then(() => { this.afterSave(); });
                }
            },

            notify(region) {
                window.location.href = '/notifications?type=region&item=' + region.id;
            },

            afterSave() {
                this.getData();
                this.region = null;
                $(this.$refs.dialog).modal('hide');
            },

            destroyRegion(region) {
                axios.delete('/api/regions/' + region.id).then(response => {
                    this.getData();
                });
            }
        }
    }
</script>
