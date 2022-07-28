<template>

    <div class="amUnitPrograms">
        <div :title="__('Backward')" class="amPage-title" v-if="am" @click="back">
            {{ __('Unit programs') }}
        </div>
        <div class="amUnitPrograms-pageTools">

            <div class="amUnitPrograms-pageToolsPaginator" v-if="total">
                <pagination v-model="page" :total="total" :per-page="perPage"/>
            </div>
            <div class="amUnitPrograms-pageToolsButtons">
                <template v-if="(secretary || programmer) && chosen_unit && main_unit && chosen_unit.id === main_unit.id">
                    <a href="#" class="amUnitPrograms-pageToolsButtonsItem appIcon msppIcons-file-plus" @click.prevent="create()" :title="__('Add unit program')"></a>
                    <a class="amUnitPrograms-pageToolsButtonsItem appIcon msppIcons-file-text" href="/programs"></a>
                </template>
            </div>
        </div>


        <div class="amUnitPrograms-unitSelector" v-if="available_units.length > 1">
            <div class="amUnitPrograms-unitSelectorTitle">
                <div>{{ __('Select unit') }}</div>
            </div>
            <div class="amUnitPrograms-unitSelectorInput">
                <object-dropdown search
                                 class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto widthAuto"
                                 :options="available_units"
                                 v-model="chosen_unit"
                                 label="name"
                                 :placeholder="__('Choose unit...')"
                                 :title="__('Unit')"
                ></object-dropdown>
            </div>
        </div>

        <div class="appTable">
            <div class="appTable-row appTable-head amUnitPrograms-head">
                <div class="appTable-col amUnitPrograms-type">
                    <div class="appTable-colTop">
                        <div>{{ __('Program') }}</div>
                    </div>
                    <div class="appTable-filter_listFilter">
                        <dropdown v-model="filters.program"
                                  class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown dhrtDropdown-menuAlignmentLeft menuWidthAuto"
                                  :options="programs"
                                  search
                        />
                    </div>
                </div>
                <div class="appTable-col amUnitPrograms-date">
                    <div class="appTable-colTop" @click="sort('date')">
                        <div>{{ __('Day') }}</div>
                        <div class="appTable-sort" v-if="sortBy === 'date'">
                            <span class="msppIcons" :class="'msppIcons-sort-numeric-' + sortOrder"></span>
                        </div>
                    </div>
                    <div class="appTable-filter">
                    </div>
                </div>

            </div>
            <div class="appTable-body amUnitPrograms-body">
                <div v-for="(unit_program, index) in unit_programs" class="appTable-row">
                    <div class="appTable-col amUnitPrograms-type">
                        <template v-if="unit_program.program.name">
                            {{ unit_program.program.name }}
                        </template>
                        <span v-else>
                            {{ __('Type') }}
                        </span>

                    </div>
                    <div class="amUnitPrograms-membersCount">
                        <div class="amUnitPrograms-membersCountVal">
                            {{ unit_program.users ? unit_program.users.length + unit_program.initiated_guests + unit_program.not_initiated_guests : '&nbsp;' }}
                        </div>
                    </div>
                    <div class="appTable-col amUnitPrograms-date">
                        <template v-if="unit_program.date">
                            {{ dateFormat(unit_program.date) }}
                        </template>
                        <span v-else>
                            {{ __('Day') }} {{ __('absent') }}
                        </span>

                    </div>
                    <div class="appTable-col amUnitPrograms-tools">
                        <action-dropdown>
                            <a href="#" rel="nofollow" class="dhrtDropdown-item"
                               @click.prevent="details(unit_program, index)">
                                {{ __('Details') }}
                            </a>
                            <template v-if="secretary || programmer">
                                <a href="#" rel="nofollow" class="dhrtDropdown-item"
                                   @click.prevent="edit(unit_program, index)">
                                    {{ __('Edit') }}
                                </a>
                                <a class="dhrtDropdown-item" rel="nofollow" href="#"
                                   @click.prevent="destroyModal(unit_program, index)">
                                    {{ __('Delete') }}
                                </a>
                            </template>
                        </action-dropdown>
                    </div>
                    <div class="appTable-col amUnitPrograms-members">
                        <template v-if="unit_program.users">
                            <div class="amUnitPrograms-member" v-for="member of unit_program.users" v-if="!member.hide_from_unit || (secretary || programmer)" :class="{'userInStealthMode': member.hide_from_unit}">
                                <avatar class="amUnitPrograms-memberAvatar" :src="member.image ? member.image : '/images/no-avatar.jpg'" :title="member.name"></avatar>
                            </div>
                        </template>
                        <span v-else>
                            {{ __('Empty') }}
                        </span>
                    </div>

                </div>

            </div>
        </div>
        <pagination v-if="total >= 50" v-model="page" :total="total" :per-page="perPage"/>

        <fs-modal-window v-if="item && detail" id="amUnitProgramsModal-itemDetails" @close="close"
                         @cancel="close" :buttonList="['Cancel']"
                         :windowName="title">
            <div class="amUnitProgramsModal-itemEditContent">
                <!--<div class="appForm-group amUnitProgramsModal-itemEditProgram">
                    <div class="amUnitProgramsModal-itemEditTitle">{{ __('Type') }}</div>
                    <span v-html="item.program.name"></span>
                </div>
                <div class="appForm-group amUnitProgramsModal-itemEditDate" v-if="item.program">
                    <div class="amUnitProgramsModal-itemEditTitle">{{ __('Date') }}</div>
                    <span>{{ dateFormat(item.date) }}</span>
                </div>-->
                <div class="appForm-group amUnitProgramsModal-itemEditInitiatedGuests" v-if="item.program">
                    <div class="amUnitProgramsModal-itemEditTitle">{{ __('Amount of initiated guests') }}</div>
                    <span v-html="item.initiated_guests"></span>
                </div>
                <div class="appForm-group amUnitProgramsModal-itemEditNotInitiatedGuests" v-if="item.program">
                    <div class="amUnitProgramsModal-itemEditTitle">{{ __('Amount of not initiated guests') }}</div>
                    <span v-html="item.not_initiated_guests"></span>
                </div>
                <div class="appForm-group">
                    <div class="appForm-groupTitle">{{ __('Participants') }}</div>
                    <div class="amUnitProgramsModal-members">
                        <label class="amUnitProgramsModal-member" v-for="member in item.users" :key="member.id" v-if="!member.hide_from_unit || (secretary || programmer)" :class="{'userInStealthMode': member.hide_from_unit}">
                            <div class="amUnitProgramsModal-memberView">
                                <avatar class="amUnitPrograms-memberAvatar" :src="member.image ? member.image : '/images/no-avatar.jpg'" :title="member.name"></avatar>
                                <div class="amUnitPrograms-memberName textOverflowRow">{{ member.name }}<span v-if="member.unit_alias">({{ member.unit_alias }})</span></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </fs-modal-window>

        <fs-modal-window v-if="item && editor" id="amUnitProgramsModal-itemEdit" @close="close" @enter="save()"
                         :valid="item.date && (item.en || item.ru) && !isProcessing"
                         @cancel="close" :buttonList="['Cancel', 'Save']" @save="save()"
                         :windowName="title">
            <div class="amUnitProgramsModal-itemEditContent">
                <div class="appForm-group amUnitProgramsModal-itemEditProgram">
                    <div class="amUnitProgramsModal-itemEditTitle">{{ __('Type') }}</div>
                    <object-dropdown class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto dhrtDropdown-menuAlignmentLeft"
                                     search
                                     v-model="item.program"
                                     :options='programs_object'
                                     label="name"
                    />

                </div>
                <div class="appForm-group amUnitProgramsModal-itemEditDate" v-if="item.program">
                    <div class="amUnitProgramsModal-itemEditTitle">{{ __('Date') }}</div>
                    <flat-pickr :config="datePickerConfig" class="appForm-input appDiaryModal-inputDate"
                                v-model="item.date"></flat-pickr>
                </div>
                <div class="appForm-group amUnitProgramsModal-itemEditInitiatedGuests" v-if="item.program">
                    <div class="amUnitProgramsModal-itemEditTitle fldTitle">{{ __('Amount of initiated guests') }}</div>
                    <div><input type="number" class="appForm-input" v-model="item.initiated_guests"></div>
                </div>
                <div class="appForm-group amUnitProgramsModal-itemEditNotInitiatedGuests" v-if="item.program">
                    <div class="amUnitProgramsModal-itemEditTitle fldTitle">{{ __('Amount of not initiated guests') }}</div>
                    <input type="number" class="appForm-input" v-model="item.not_initiated_guests">
                </div>
                <div class="amUnitProgramsModal-itemEditParticipants appForm-group">
                    <label class="dhrtSwitch textLeft">
                        <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                               v-model="chosen_open">
                        <span class="dhrtSwitchSpinner"></span>
                        <span class="dhrtSwitchSpinnerText">{{ __('Program participants') }}</span>
                    </label>
                    <div class="amUnitProgramsModal-members" v-if="chosen_open">
                        <label class="amUnitProgramsModal-member" v-for="member in item.users" :key="member.id">
                            <input type="checkbox" v-model="item.users" :value="member">
                            <div class="amUnitProgramsModal-memberView">
                                <avatar class="amUnitPrograms-memberAvatar" :src="member.image ? member.image : '/images/no-avatar.jpg'" :title="member.name"></avatar>
                                <div class="amUnitPrograms-memberName textOverflowRow">{{ member.name }}<span v-if="member.unit_alias">({{ member.unit_alias }})</span></div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="appForm-group amUnitProgramsModal-itemEditUsers" v-if="item.program && item.date">
                    <div class="amUnitProgramsModal-membersFilterStatus">
                        <div class="appForm-groupTitle">{{ __('Participants filter') }}</div>
                        <div class="amUnitProgramsModal-membersFilterStatusBtn" @click="statusesFilter = true">
                            {{ __('Open') }}
                        </div>
                    </div>

                    <div class="amUnitProgramsModal-membersFilterName appTable-filter">
                        <div class="appForm-groupTitle">{{ __('Member name') }}</div>
                        <div class="amUnitProgramsModal-memberName">
                            <input type="text" v-model="filters.name" class="appTable-filterField">
                            <span @click="filters.name = null">&times;</span>
                        </div>
                    </div>
                    <div class="amUnitProgramsModal-members">
                        <label class="amUnitProgramsModal-member" v-for="member in members" v-if="!item.users.some(participant => participant.id === member.id)">
                                <input type="checkbox" v-model="item.users" :value="member">
                                <div class="amUnitProgramsModal-memberView">
                                    <avatar class="amUnitPrograms-memberAvatar" :src="member.image ? member.image : '/images/no-avatar.jpg'" :title="member.name"></avatar>
                                    <div class="amUnitPrograms-memberName textOverflowRow">{{ member.name }}<span v-if="member.unit_alias">({{ member.unit_alias }})</span></div>
                                </div>
                        </label>
                    </div>
                </div>
            </div>

        </fs-modal-window>

        <modal-window v-if="item && remove" @close="close" @no="close" @ok="destroy(item.id)"
                      :buttonList="['No', 'Ok']" :windowName="__('Confirmation')">
            <div class="appForm-group">
                <span>{{ __('Are you sure?') }}</span>
            </div>
        </modal-window>
        <statuses-filter @loaded="statuses_loaded = true" v-show="statusesFilter" @close="statusesFilter = false" v-model="filters.statuses"></statuses-filter>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js'

    import Multiselect from 'vue-multiselect'

    let moment = require('moment');

    import Textarea from "../../../../vue/src/views/forms/form-elements/textarea/Textarea";

    export default {
        props: ['secretary', 'programmer'],

        components: {
            Textarea,
            flatPickr,
            Multiselect
        },

        data() {
            return {
                page: 1,
                perPage: 100,
                total: 0,

                unit_programs: [],
                item: null,
                itemIndex: null,
                editor: null,
                detail: false,
                remove: null,
                isProcessing: false,
                statusesFilter: false,
                statuses_loaded: false,
                chosen_open: false,

                programs: [],
                programs_object: [],
                members: [],

                sortBy: 'date',
                sortOrder: 'desc',

                available_units: [],
                main_unit: null,
                chosen_unit: null,

                filters: {
                    program: null,
                    name: null,
                    statuses: []
                },
                am: false
            }
        },

        mounted() {
            this.am = $('html').attr('data-am') === "1";
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },

            title() {
                let title = '';

                if(this.item.program) {
                    title += this.item.program.name;
                }
                if(this.item.date) {
                    title += ' ' + this.dateFormat(this.item.date)
                }

                return title;
            },

            datePickerConfig() {
                let programs = this.unit_programs;
                let that = this;
                return {
                    disableMobile: "true",
                    altInput: true,
                    altFormat: 'd-m-y',
                    /*disable: [
                        function (date) {
                            let search = false;
                            programs.find(program => {
                                if(
                                    moment(program.date).isoWeek() === moment(date).isoWeek() &&
                                    program.program.slug === that.item.program.slug &&
                                    moment(that.item.date).isoWeek() !== moment(date).isoWeek()
                                ) {
                                    search = true;
                                }
                            });
                            return search;
                        }
                    ],*/
                    locale: 'ru'
                }
            },
        },

        watch: {
            page() {
                this.getData();
            },

            filters: {
                deep: true,
                handler() {
                    if (this.filters.type === "null") this.filters.type = null;
                    this.page = 1;
                    this.getData();
                }
            },

            statuses_loaded() {
                this.getData();
            },

            chosen_unit(new_value, old_value) {
                if(!old_value) return;
                this.getData();
            }
        },

        methods: {
            getData() {
                if(this.$root.loading = false) return;
                this.$root.loading = true;
                let params = {
                    type: this.filters.type ? this.filters.type : null,
                    name: this.filters.name ? this.filters.name : null,
                    statuses: this.filters.statuses.length ? this.filters.statuses : null,
                    unit_id: this.chosen_unit ? this.chosen_unit.id : null,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,

                    take: this.perPage,
                    skip: this.skip,
                };
                if(this.statuses_loaded){
                    axios.get('/unit-programs-api', {params: params}).then(response => {
                        this.unit_programs = response.data.unit_programs;
                        this.total = response.data.total;
                        this.programs = response.data.programs;
                        this.programs_object = response.data.programs_object;
                        this.programs['null'] = this.__('All');
                        this.members = response.data.members;
                        this.available_units = response.data.available_units;
                        this.main_unit = response.data.main_unit;
                        if(!this.chosen_unit) this.chosen_unit = response.data.main_unit;

                        this.$root.loading = false;
                    }).catch(error => {
                        this.$root.loading = false;
                    });
                }
            },

            dateFormat(date) {
                return moment(date).format('DD.MM.YY');
            },

            create() {
                this.item = {
                    id: null,
                    date: null,
                    program: null,
                    users: [],
                    initiated_guests: 0,
                    not_initiated_guests: 0
                };
                this.editor = 1;
            },

            save() {
                if (this.isProcessing) return;
                this.isProcessing = 1;
                axios.post('/unit-programs-api', {unit_program: this.item}).then(response => {
                    this.isProcessing = 0;
                    this.getData();
                    this.close();
                }).catch(error => {
                    this.isProcessing = 0;
                });
            },

            destroy(id) {
                axios.delete('/unit-programs-api/' + id).then(response => {
                    this.getData();
                    this.remove = null;
                });
            },

            destroyModal(item, index) {
                this.remove = 1;
                this.item = JSON.parse(JSON.stringify(item));
                this.itemIndex = index;
            },

            close() {
                this.item = null;
                this.editor = null;
                this.detail = null;
                this.remove = null;
            },

            edit(item, index) {
                this.item = JSON.parse(JSON.stringify(item));
                this.itemIndex = index;
                this.editor = 1;
            },

            details(item, index) {
                this.item = JSON.parse(JSON.stringify(item));
                this.itemIndex = index;
                this.detail = true;
            },

            sort(column) {
                if (this.sortBy === column) {
                    this.sortOrder = this.sortOrder === 'desc' ? 'asc' : 'desc';
                } else {
                    this.sortOrder = 'desc';
                    this.sortBy = column;
                }

                this.$nextTick(() => {
                    this.getData();
                });
            },

            back() {
                window.history.back();
            }
        }
    }

</script>
