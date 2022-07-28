<template>

    <div class="appGEO-structureItem">
        <div class="appGEO-structureItemHeader">
            <div class="appGEO-structureItemHeaderText">
                <div class="appIcons-grid msppIcons-grid"></div>
                <div>{{ __('Sectors') }}</div>
            </div>
            <div class="appGEO-structureItemHeaderMenu">
                <span class="appIcons msppIcons-plus appGEO-iconPlus" @click="create" v-if="menu"></span>
            </div>
        </div>
        <div class="appGEO-structureItemContent">
            <div class="appGEO-structureItemContentItems" v-for="sector of sectors">
                <label for="appGEO-sectorsCheck" @click="select(sector, true)" class="appGEO-structureItemContentItem" :class="{active: geo.sector && sector.id === geo.sector.id}">
                    <div>
                        <div class="appGEO-structureItemContentItemName">{{ sector.name }}</div>
                        <div class="appGEO-structureItemContentItemNotes">{{ sector.notes }}</div>
                    </div>
                    <action-dropdown>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="notify(sector)">{{ __('Notify') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="edit(sector)">{{ __('Edit') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="destroySector(sector)">{{ __('Remove') }}</a>
                    </action-dropdown>
                </label>
            </div>
            <modal-window id="appSectorModal" v-if="sector" nScroll :buttonList="['Close', 'Save']" :valid="!!sector.name" @close="sector = null" @save="save" :windowName="__('Sector')">
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Name') }}</div>
                    <input class="appForm-input" type="text" v-model="sector.name">
                </div>

                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Notes') }}</div>
                    <textarea class="appForm-textarea" v-model="sector.notes"></textarea>
                </div>

                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Acaryas') }}</div>
                    <multiselect
                            :multiple="true"
                            v-model="sector.acaryas"
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
    import Textarea from "../../../../vue/src/views/forms/form-elements/textarea/Textarea";

    export default {
        components: {Textarea, Multiselect },

        props: ['geo', 'menu'],

        data() {
            return {
                sectors: [],
                sector: null,
                acaryas: []
            }
        },

        mounted() {
            this.getData();
        },

        watch: {
            sectors(val) {
                if (val.length) {
                    this.select(val[0]);
                }
            }
        },

        methods: {
            getData() {
                this.$root.loading = true;
                axios.get('/api/sectors').then(response => {
                    this.sectors = response.data.data;
                    this.acaryas = response.data.meta.acaryas;
                    this.$emit('loaded');
                    this.$root.loading = false;
                });
            },

            create() {
                this.sector = {name: '', acaryas: []};
            },

            edit(sector) {
                this.sector = JSON.parse(JSON.stringify(sector));
            },

            select(sector, manual = false) {
                if(!this.geo.navigating || !manual) this.geo.sector = sector;
            },

            save() {
                if (!this.sector.name) return;

                let payload = {
                    name: this.sector.name,
                    acaryas: this.sector.acaryas,
                    notes: this.sector.notes,
                };

                if (this.sector.id) {
                    axios.put('/api/sectors/' + this.sector.id, payload).then(() => { this.afterSave(); });
                } else {
                    axios.post('/api/sectors', payload).then(() => { this.afterSave(); });
                }
            },

            notify(sector) {
                window.location.href = '/notifications?type=sector&item=' + sector.id;
            },

            afterSave() {
                this.getData();
                this.sector = null;
            },

            destroySector(sector) {
                axios.delete('/api/sectors/' + sector.id).then(response => {
                    this.getData();
                });
            }
        }
    }
</script>
