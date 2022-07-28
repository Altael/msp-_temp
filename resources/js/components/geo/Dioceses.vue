<template>
    <div class="appGEO-structureItem">
        <div class="appGEO-structureItemHeader">
            <div class="appGEO-structureItemHeaderText">
                <div class="appIcons-grid msppIcons-grid"></div>
                <div>{{ __('Dioceses') }}</div>
            </div>
            <div class="appGEO-structureItemHeaderMenu">
                <span class="appIcons msppIcons-plus appGEO-iconPlus" @click="create" v-if="menu"></span>
            </div>
        </div>
        <div class="appGEO-structureItemContent">
            <div class="appGEO-structureItemContentItems" v-for="diocese of dioceses">
                <label for="appGEO-diocesesCheck" @click="select(diocese, true)" class="appGEO-structureItemContentItem" :class="{active: geo.diocese && diocese.id === geo.diocese.id}">
                    <div>
                        <div class="appGEO-structureItemContentItemName">{{ diocese.name }}</div>
                        <div class="appGEO-structureItemContentItemNotes">{{ diocese.notes }}</div>
                    </div>
                    <action-dropdown v-if="menu">
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="notify(diocese)">{{ __('Notify') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="edit(diocese)">{{ __('Edit') }}</a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item" @click="destroyDiocese(diocese)">{{ __('Remove') }}</a>
                    </action-dropdown>
                </label>
            </div>
            <modal-window id="appDioceseModal" v-if="diocese" :buttonList="['Close', 'Save']" nScroll :valid="!!diocese.name" @close="diocese = null" @save="save" :windowName="__('Diocese')">
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Name') }}</div>
                    <input class="appForm-input" type="text" v-model="diocese.name">
                </div>
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Notes') }}</div>
                    <textarea class="appForm-textarea" v-model="diocese.notes"></textarea>
                </div>
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Acaryas') }}</div>
                    <multiselect
                            :multiple="true"
                            v-model="diocese.acaryas"
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

        props: ['regionId', 'geo', 'menu'],

        data() {
            return {
                dioceses: [],
                diocese: null,
                acaryas: []
            }
        },

        mounted() {
            this.getData();
        },

        watch: {
            dioceses(val) {
                if(this.geo.target && this.geo.target.diocese) {
                    this.select(this.dioceses.find(diocese => {
                        return diocese.id === this.geo.target.diocese;
                    }));
                } else this.select(val.length ? val[0] : null);
            }
        },

        methods: {
            getData() {
                this.$root.loading = true;
                axios.get('/api/dioceses', {params: {regionId: this.regionId}}).then(response => {
                    this.dioceses = response.data.data;
                    this.acaryas = response.data.meta.acaryas;
                    this.$root.loading = false;
                });
            },

            create() {
                this.diocese = {name: '', acaryas: []};
            },

            edit(diocese) {
                this.diocese = JSON.parse(JSON.stringify(diocese));
            },

            select(diocese, manual = false) {
                if(!this.geo.navigating || !manual) this.geo.diocese = diocese;
            },

            save() {
                if (!this.diocese.name) return;

                let payload = {
                    regionId: this.regionId,
                    name: this.diocese.name,
                    acaryas: this.diocese.acaryas,
                    notes: this.diocese.notes
                };

                if (this.diocese.id) {
                    axios.put('/api/dioceses/' + this.diocese.id, payload).then(() => { this.afterSave(); });
                } else {
                    axios.post('/api/dioceses', payload).then(() => { this.afterSave(); });
                }
            },

            notify(diocese) {
                window.location.href = '/notifications?type=diocese&item=' + diocese.id;
            },

            afterSave() {
                this.getData();
                this.diocese = null;
                $(this.$refs.dialog).modal('hide');
            },

            destroyDiocese(diocese) {
                axios.delete('/api/dioceses/' + diocese.id).then(response => {
                    this.getData();
                });
            }
        }
    }
</script>
