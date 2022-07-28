<template>
    <div class="appEventsReport" :class="{'moreDetails': show_details}">

        <div class="appEventsReport-filters">
            <div class="appEventsReport-filtersHead">
                <div class="appEventsReport-filtersTitle">
                    {{ __('Filters') }}
                </div>
                <div class="appForm-group appEventsReport-clear" >
                    <div @click="clearFilters()">{{ __('Clear filters') }}</div>
                </div>
            </div>
            <div class="appEventsReport-filtersItems" v-if="master || bp">
                <div v-if="master" class="appForm-group appEventsReport-filtersItem">
                    <div class="appEventsReport-filtersItemTitle">
                        {{ __('Region') }}
                    </div>

                    <dropdown
                        search
                        :options="regions_list"
                        v-model="filters.region"
                    ></dropdown>
                </div>
                <div v-if="bhuktis_list.length > 2" class="appForm-group appEventsReport-filtersItem">
                    <div class="appEventsReport-filtersItemTitle">
                        {{ __('Bhukti') }}
                    </div>


                    <dropdown
                        search
                        :options="bhuktis_list"
                        v-model="filters.bhukti"
                    ></dropdown>
                </div>
                <div v-if="units_list.length > 2" class="appForm-group appEventsReport-filtersItem">
                    <div class="appEventsReport-filtersItemTitle">
                        {{ __('Unit') }}
                    </div>


                    <dropdown
                        search
                        :options="units_list"
                        v-model="filters.unit"
                    ></dropdown>
                </div>
            </div>
            <div class="appEventsReport-filtersDetails">
                <div class="appForm-group appEventsReport-more">
                    <label class="dhrtSwitch textLeft">
                        <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                               v-model="show_vip">
                        <span class="dhrtSwitchSpinner"></span>
                        <span class="dhrtSwitchSpinnerText">{{ __('Expanded') }}</span>
                    </label>
                </div>
                <div class="appForm-group appEventsReport-range">
                    <label class="dhrtSwitch textLeft">
                        <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                               v-model="show_pickr">
                        <span class="dhrtSwitchSpinner"></span>
                        <span class="dhrtSwitchSpinnerText">{{ __('Custom range') }}</span>
                    </label>
                    <flat-pickr v-if="show_pickr" :config="rangePickr" class="appForm-input"
                                v-model="manual_range"></flat-pickr>
                </div>
                <div class="appForm-group appEventsReport-more" v-if="show_vip">
                    <label class="dhrtSwitch textLeft">
                        <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                               v-model="show_all_events">
                        <span class="dhrtSwitchSpinner"></span>
                        <span class="dhrtSwitchSpinnerText">{{ __('More events') }}</span>
                    </label>
                </div>
                <div class="appForm-group appEventsReport-details" v-if="show_vip">
                    <label class="dhrtSwitch textLeft">
                        <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                               v-model="show_details">
                        <span class="dhrtSwitchSpinner"></span>
                        <span class="dhrtSwitchSpinnerText">{{ __('More details') }}</span>
                    </label>
                </div>
                <div class="appForm-group appEventsReport-details" v-if="show_details">
                    <label class="dhrtSwitch textLeft">
                        <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                               v-model="show_guests">
                        <span class="dhrtSwitchSpinner"></span>
                        <span class="dhrtSwitchSpinnerText">{{ __('Show guests') }}</span>
                    </label>
                </div>
                <div class="appForm-group appEventsReport-more">
                    <label class="dhrtSwitch textLeft">
                        <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                               v-model="mode_bool">
                        <span class="dhrtSwitchSpinner"></span>
                        <span class="dhrtSwitchSpinnerText">{{__('Months') }}</span>
                    </label>
                </div>
                <div class="appForm-group appEventsReport-empty">
                    <label class="dhrtSwitch textLeft">
                        <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                               v-model="show_empty">
                        <span class="dhrtSwitchSpinner"></span>
                        <span class="dhrtSwitchSpinnerText">{{ __('Show empty') }}</span>
                    </label>
                </div>

            </div>

        </div>

        <div class="appEventsReport-head unitsHead">
            <div class="appEventsReport-headRow region">{{ __('Region') }}</div>
            <div class="appEventsReport-headRow bhukti">{{ __('Bhukti') }}</div>
            <div class="appEventsReport-headRow unit">{{ __('Unit') }}</div>



            <div v-show="show_vip" class="appEventsReport-headRow event members" :class="{'three': show_details}">
                <div class="appEventsReport-headMonth" ref="leftCalendar">
                    <div data-input>{{ monthFormat(left_start) }}</div>
                </div>
                <div :class="{'threeWrap': show_details}">
                    <div class="sum" :title="__('All: init&notInit')" v-if="show_details">{{ __('Sum') }}</div>
                    <div class="init" :title="__('Initiated')" v-if="show_details">{{ __('Init') }}</div>
                    <div class="notInit" :title="__('Not initiated')" v-if="show_details">{{ __('Not init') }}</div>
                </div>
            </div>
            <div v-show="show_vip" class="appEventsReport-headRow event members" :class="{'three': show_details}">
                <div class="appEventsReport-headMonth" ref="rightCalendar">
                    <div data-input>{{ monthFormat(right_start) }}</div>
                </div>
                <div :class="{'threeWrap': show_details}">
                    <div class="sum" :title="__('All: init&notInit')" v-if="show_details">{{ __('Sum') }}</div>
                    <div class="init" :title="__('Initiated')" v-if="show_details">{{ __('Init') }}</div>
                    <div class="notInit" :title="__('Not initiated')" v-if="show_details">{{ __('Not init') }}</div>
                </div>
            </div>

            <div v-if="!show_vip" class="appEventsReport-headRow event dc2" :title="__('DC') + ': ' + __('DC+AK+SS')">
                <div>{{ __('DC') }}</div>
            </div>

            <div v-if="!show_vip" class="appEventsReport-headRow event km2" :title="__('KM')">
                <div>{{ __('KM') }}</div>
            </div>

            <div v-for="event in events" class="appEventsReport-headRow event"  :class="[{'three': show_details}, event.slug]" v-if="(show_all_events || event.vip) && show_vip">
                <div :title="event.name">{{ event.short_name }}</div>
                <div :class="{'threeWrap': show_details}">
                    <div class="sum" :title="event.short_name + ' - ' + __('All: init&notInit')" v-if="show_details">{{ __('Sum') }}</div>
                    <div class="init" :title="event.short_name + ' - ' + __('Initiated')" v-if="show_details">{{ __('Init') }}</div>
                    <div class="notInit" :title="event.short_name + ' - ' + __('Not initiated')" v-if="show_details">{{ __('Not init') }}</div>
                </div>
            </div>

            <div class="appEventsReport-headRow range" :title="__('Period')">{{ __('Period') }}</div>

            <div class="appEventsReport-headRow diagram" :title="__('Diagram')">
                <div>{{ __('Diagram') }}</div>
            </div>
        </div>

        <div class="appEventsReport-region totalSummary" v-if="tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power">
            <div class="appEventsReport-regionInfo">

            </div>
            <div class="appEventsReport-regionContent">
                <div class="appEventsReport-regionContentBhukti">
                    <div class="appEventsReport-regionContentBhuktiInfo">
                        <div class="bhuktiName">{{ __('Total by structure') }}</div>
                        <div class="bhuktiAc"></div>
                        <div class="bhuktiBP"></div>
                    </div>
                    <div class="appEventsReport-regionContentBhuktiContent appEventsReport-units">
                        <div class="appEventsReport-regionContentBhuktiContentUnit appEventsReport-unit">
                            <div class="appEventsReport-regionContentBhuktiContentUnitInfo">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoName">
                                    <!--unit info placeholder-->
                                </div>
                            </div>
                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn" v-if="show_vip"  :title="__('Active margiis') + ' - ' + __('All: init&notInit')">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoMargiisActive" >
                                    <!--left active margiis sum placeholder-->
                                </div>
                            </div>
                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn" v-if="show_details"  :title="__('Active margiis') + ' - ' + __('Initiated')">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoMargiisActive">
                                    <!--left active margiis init placeholder-->
                                </div>
                            </div>
                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn" v-if="show_details"  :title="__('Active margiis') + ' - ' + __('Not initiated')">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoMargiisActive">
                                    <!--left active margiis not init placeholder-->
                                </div>
                            </div>

                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn" v-if="show_vip" :title="__('Active margiis') + ' - ' + __('All: init&notInit')">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoMargiisActive" >
                                    <!--right active margiis sum placeholder-->
                                </div>
                            </div>
                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn activeMargiisMonth1" v-if="show_details" :title="__('Active margiis') + ' - ' + __('Initiated')">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoMargiisActive">
                                    <!--right active margiis init placeholder-->
                                </div>
                            </div>
                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn activeMargiisMonth2" v-if="show_details" :title="__('Active margiis') + ' - ' + __('Not initiated')">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoMargiisActive">
                                    <!--right active margiis not init placeholder-->
                                </div>
                            </div>

                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn dc2" v-if="!show_vip" :title="__('DC') + ': ' + __('DC+AK+SS')">
                                <div class="appEventsReport-regionContentBhuktiContentUnitColumnTop">
                                    <!--unit digital placeholder-->
                                    {{
                                        (tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.dc ?
                                    (tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.dc.ini.guests +
                                        tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.dc.ini.users +
                                        tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.dc.not_ini.guests +
                                        tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.dc.not_ini.users) : 0) +

                                        (tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.ak ?
                                    (tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.ak.ini.guests +
                                    tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.ak.ini.users +
                                    tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.ak.not_ini.guests +
                                    tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.ak.not_ini.users) : 0) +

                                        (tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.sadhana_sivir ?
                                    (tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.sadhana_sivir.ini.guests +
                                    tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.sadhana_sivir.ini.users +
                                    tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.sadhana_sivir.not_ini.guests +
                                    tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.sadhana_sivir.not_ini.users) : 0)
                                    }}
                                </div>
                            </div>

                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn km2" v-if="!show_vip" :title="__('KM')">
                                <div class="appEventsReport-regionContentBhuktiContentUnitColumnTop">
                                    {{
                                        tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.km ?
                                            (tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.km.ini.guests +
                                                tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.km.ini.users +
                                                tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.km.not_ini.guests +
                                                tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power.km.not_ini.users) : 0
                                    }}
                                </div>
                            </div>

                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn" :class="{'three': show_details}" v-for="event in events" v-if="event.slug !== 'active_members' && (show_all_events || vip_event(event.slug)) && show_vip">
                                <div class="appEventsReport-regionContentBhuktiContentUnitColumnTop" :class="{'threeWrap': show_details}">
                                    <div class="sum">
                                        <span class="all" :title="event.short_name + ' - ' + __('All: init&notInit') + ' ' + __('with Guests')">
                                            {{ tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug] ? tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].ini.guests + tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].ini.users + tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].not_ini.users + tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].not_ini.guests : 0 }}
                                            <span class="guests" :title="event.short_name + ' - ' + __('Guests only')" v-if="tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug] && (tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].ini.guests + tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].not_ini.guests) && show_details && show_guests">
                                                {{ tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug] ? tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].ini.guests + tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].not_ini.guests : 0 }}
                                            </span>
                                        </span>

                                    </div>
                                    <div class="init" v-if="show_details">
                                        <span class="all" :title="event.short_name + ' - ' + __('Initiated') + ' ' + __('with Guests')">
                                            {{ tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug] ? tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].ini.users + tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].ini.guests : 0 }}
                                            <span class="guests" :title="event.short_name + ' - ' + __('Guests only')" v-if="tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug] && (tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].ini.guests) && show_details && show_guests">
                                                {{ tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug] ? tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].ini.guests : 0 }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="notInit" v-if="show_details">
                                        <span class="all" :title="event.short_name + ' - ' + __('Not initiated') + ' ' + __('with Guests')">
                                            {{ tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug] ? tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].not_ini.users + tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].not_ini.guests : 0 }}
                                            <span class="guests" :title="event.short_name + ' - ' + __('Guests only')" v-if="tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug] && (tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].not_ini.guests) && show_details && show_guests">
                                                {{ tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug] ? tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power[event.slug].not_ini.guests : 0 }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="appEventsReport-regionContentBhuktiContentUnitRange">

                            </div>

                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn diagram">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="appEventsReport-region totalByPeriod">
            <div class="appEventsReport-regionInfo">

            </div>
            <div class="appEventsReport-regionContent">
                <div class="appEventsReport-regionContentBhukti">
                    <div class="appEventsReport-regionContentBhuktiInfo">
                        <div class="bhuktiName">...{{ __('by periods') }}</div>
                        <div class="bhuktiAc"></div>
                        <div class="bhuktiBP"></div>
                    </div>
                    <div class="appEventsReport-regionContentBhuktiContent appEventsReport-units">
                        <div class="appEventsReport-regionContentBhuktiContentUnit appEventsReport-unit">
                            <div class="appEventsReport-regionContentBhuktiContentUnitInfo">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoName"></div>
                            </div>
                            <div v-if="months_summary && show_vip" class="appEventsReport-regionContentBhuktiContentUnitColumn" :class="{'three': show_details}">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoMargiisActive"  :class="{'threeWrap': show_details}">
                                    <div class="sum">
                                        <span class="all" :title="tooltipMonthFormat(left_start) + ' ' + __('Active margiis') + ' - ' + __('All: init&notInit')">
                                            {{ months_summary.left.ini + months_summary.left.not_ini }}
                                        </span>
                                    </div>
                                    <div class="init" v-if="show_details">
                                        <span class="all" :title="tooltipMonthFormat(left_start) + ' ' + __('Active margiis') + ' - ' + __('Initiated')">
                                            {{ months_summary.left.ini }}
                                        </span>
                                    </div>
                                    <div class="notInit" v-if="show_details">
                                        <span class="all" :title="tooltipMonthFormat(left_start) + ' ' + __('Active margiis') + ' - ' + __('Not initiated')">
                                            {{ months_summary.left.not_ini }}
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div v-if="months_summary && show_vip" class="appEventsReport-regionContentBhuktiContentUnitColumn" :class="{'three': show_details}">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoMargiisActive" :class="{'threeWrap': show_details}">
                                    <div class="sum">
                                        <span class="all" :title="tooltipMonthFormat(right_start) + ' ' + __('Active margiis') + ' - ' + __('All: init&notInit')">
                                            {{ months_summary.right.ini + months_summary.right.not_ini }}
                                        </span>
                                    </div>
                                    <div class="init" v-if="show_details">
                                        <span class="all" :title="tooltipMonthFormat(right_start) + ' ' + __('Active margiis') + ' - ' + __('Initiated')">
                                            {{ months_summary.right.ini }}
                                        </span>
                                    </div>
                                    <div class="notInit" v-if="show_details">
                                        <span class="all" :title="tooltipMonthFormat(right_start) + ' ' + __('Active margiis') + ' - ' + __('Not initiated')">
                                            {{ months_summary.right.not_ini }}
                                        </span>
                                    </div>

                                    <!--                                    <span v-if="unit.active_members.right - unit.active_members.left">

                                                                        </span>
                                                                        <span class="diff" v-if="unit.active_members.right !== unit.active_members.left" :class="{'red': (unit.active_members.right - unit.active_members.left) < 0, 'green': (unit.active_members.right - unit.active_members.left) > 0}">
                                                                            <span v-if="(unit.active_members.right - unit.active_members.left) > 0">&plus;</span>
                                                                            <span>{{ unit.active_members.right - unit.active_members.left }}</span>
                                                                        </span>-->
                                </div>
                            </div>

                            <div v-if="!show_vip" class="dc2 appEventsReport-regionContentBhuktiContentUnitColumn">
                                <div class="appEventsReport-regionContentBhuktiContentUnitColumnTop" v-for="(range, index) in periods">
                                    <span class="all" :title="__('DC') + ': ' + __('DC+AK+SS')">
                                        {{ dc2(0, 0, 0, index, true) }}

                                        <template v-if="index < (Object.keys(periods).length - 1)">
                                            <span class="diff" v-if="dc2_delta(0, 0, 0, index, true)"
                                                  :class="{
                                            'red': (dc2_delta(0, 0, 0, index, true)) < 0,
                                            'green': (dc2_delta(0, 0, 0, index, true)) > 0
                                            }">
                                                <span v-if="(dc2_delta(0, 0, 0, index, true)) > 0">&plus;</span>
                                                <span>{{ dc2_delta(0, 0, 0, index, true) }}</span>
                                            </span>
                                        </template>
                                    </span>
                                </div>
                            </div>

                            <div v-if="!show_vip" class="appEventsReport-regionContentBhuktiContentUnitColumn">
                                <div class="appEventsReport-regionContentBhuktiContentUnitColumnTop" v-for="(range, index) in periods">
                                    <span class="all" :title="__('KM')">
                                        {{ km2(0, 0, 0, index, true) }}

                                        <template v-if="index < (Object.keys(periods).length - 1)">
                                            <span class="diff" v-if="km2_delta(0, 0, 0, index, true)"
                                                  :class="{
                                            'red': (km2_delta(0, 0, 0, index, true)) < 0,
                                            'green': (km2_delta(0, 0, 0, index, true)) > 0
                                            }">
                                                <span v-if="(km2_delta(0, 0, 0, index, true)) > 0">&plus;</span>
                                                <span>{{ km2_delta(0, 0, 0, index, true) }}</span>
                                            </span>
                                        </template>
                                    </span>
                                </div>
                            </div>

                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn" :class="{'three': show_details}" v-for="event in events" v-if="event.slug !== 'active_members' && (show_all_events || vip_event(event.slug)) && show_vip">
                                <div class="appEventsReport-regionContentBhuktiContentUnitColumnTop" :class="{'threeWrap': show_details}" v-for="(range,index) in periods">
                                    <div class="sum">
                                        <span class="all" :title="event.short_name + ' - ' + __('All: init&notInit') + ' ' + __('with Guests')">
                                            {{ events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0 }}

                                            <span class="guests" :title="event.short_name + ' - ' + __('Guests only')" v-if="show_guests && events_summary[event.slug] && events_summary[event.slug][rangeKeyFormat(range.day)] && events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests && show_details">
                                                {{ events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0 }}
                                            </span>
                                            <template v-if="index < (Object.keys(periods).length - 1)">
                                                        <span class="diff" v-if="(events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0)
                                                    -
                                                    (events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)] ? events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.users + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.guests + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.guests : 0 : 0)"
                                                              :class="{
                                                        'red': ((events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0)
                                                    -
                                                    (events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)] ? events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.users + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.guests + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.guests : 0 : 0)) < 0,
                                                        'green': ((events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0)
                                                    -
                                                    (events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)] ? events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.users + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.guests + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.guests : 0 : 0)) > 0
                                                    }">
                                                            <span v-if="((events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0)
                                                    -
                                                    (events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)] ? events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.users + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.guests + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.guests : 0 : 0)) > 0">&plus;</span>
                                                            <span>{{ (events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0)
                                                            -
                                                            (events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)] ? events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.users + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.guests + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.guests : 0 : 0) }}</span>
                                                        </span>
                                            </template>
                                        </span>

                                    </div>
                                    <div class="init" v-if="show_details">
                                        <span class="all" :title="event.short_name + ' - ' + __('Initiated') + ' ' + __('with Guests')">
                                            {{ events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests : 0 : 0 }}
                                            <span class="guests" :title="event.short_name + ' - ' + __('Guests only')" v-if="show_guests && events_summary[event.slug] && events_summary[event.slug][rangeKeyFormat(range.day)] && events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests && show_details">
                                                {{ events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].ini.guests : 0 : 0 }}
                                            </span>
                                        </span>

                                    </div>
                                    <div class="notInit" v-if="show_details">
                                        <span class="all" :title="event.short_name + ' - ' + __('Not initiated') + ' ' + __('with Guests')">
                                            {{ events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.users + events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0 }}
                                            <span class="guests" :title="event.short_name + ' - ' + __('Guests only')" v-if="events_summary[event.slug] && events_summary[event.slug][rangeKeyFormat(range.day)] && events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests && show_details">
                                                {{ events_summary[event.slug] ? events_summary[event.slug][rangeKeyFormat(range.day)] ? events_summary[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0 }}
                                            </span>
                                        </span>

                                    </div>

                                </div>
                            </div>

                            <div class="appEventsReport-regionContentBhuktiContentUnitRange">
                                <div class="appEventsReport-regionContentBhuktiContentUnitRangeTop" v-for="(period, key) in periods">
                                    {{ period.range }}
                                </div>
                            </div>

                            <div class="appEventsReport-regionContentBhuktiContentUnitColumn diagram">

                                <div class="appEventsReport-diagramWrap" @click="fancyDiagram(events_summary, __('Summary'))">
                                    <unit-diagram practice="dc" :full="false" :mode="mode" :unit="events_summary" :periods="periods"></unit-diagram>
                                    <unit-diagram practice="km" :full="false" :mode="mode" :unit="events_summary" :periods="periods"></unit-diagram>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="appEventsReport-region units" v-for="(region, region_name) in regions"
            v-if="verify_region(region, region_name)">
            <div class="appEventsReport-regionInfo">
                {{ region_name }}
            </div>
            <div class="appEventsReport-regionContent">
                <div class="appEventsReport-regionContentBhukti" v-for="(bhukti, bhukti_name) in region" v-if="verify_bhukti(bhukti, bhukti_name)">
                    <div class="appEventsReport-regionContentBhuktiInfo">
                        <div class="bhuktiName">{{ bhukti_name }}</div>
                        <div class="bhuktiAc">Ac.: {{ bhukti.acarya ? bhukti.acarya : __('No acarya assigned') }}</div>
                        <div class="bhuktiBP">BP: {{ bhukti.bp ? bhukti.bp : __('No BP assigned') }}</div>
                    </div>
                    <div class="appEventsReport-regionContentBhuktiContent appEventsReport-units">
                        <div class="appEventsReport-regionContentBhuktiContentUnit appEventsReport-unit" v-for="(unit, unit_name) in bhukti.units" v-if="(!filters.unit || new RegExp(units_list[filters.unit], 'i').test(unit_name)) && (show_empty || (typeof unit === 'object' && !Array.isArray(unit)))">
                            <div class="appEventsReport-regionContentBhuktiContentUnitInfo">
                                <div class="appEventsReport-regionContentBhuktiContentUnitInfoName">{{ unit_name }}</div>
                            </div>

                            <template v-if="typeof unit === 'object' && !Array.isArray(unit)">
                                <div v-if="show_vip" class="appEventsReport-regionContentBhuktiContentUnitColumn" :class="{'three': show_details}">
                                    <div class="appEventsReport-regionContentBhuktiContentUnitInfoMargiisActive"  :class="{'threeWrap': show_details}">
                                        <div class="sum">
                                            <span class="all" :title="tooltipMonthFormat(left_start) + ' ' + __('Active margiis') + ' - ' + __('All: init&notInit') + ' ' + __('with Guests')">
                                                {{ unit.active_members.left.ini + unit.active_members.left.not_ini }}
                                            </span>
                                        </div>
                                        <div class="init" v-if="show_details">
                                            <span class="all" :title="tooltipMonthFormat(left_start) + ' ' + __('Active margiis') + ' - ' + __('Initiated') + ' ' + __('with Guests')">
                                                {{ unit.active_members.left.ini }}
                                            </span>
                                        </div>
                                        <div class="notInit" v-if="show_details">
                                            <span class="all" :title="tooltipMonthFormat(left_start) + ' ' + __('Active margiis') + ' - ' + __('Not initiated') + ' ' + __('with Guests')">
                                                {{ unit.active_members.left.not_ini }}
                                            </span>
                                        </div>

                                    </div>
                                </div>
                                <div v-if="show_vip" class="appEventsReport-regionContentBhuktiContentUnitColumn" :class="{'three': show_details}">
                                    <div class="appEventsReport-regionContentBhuktiContentUnitInfoMargiisActive" :class="{'threeWrap': show_details}">
                                        <div class="sum">
                                            <span class="all" :title="tooltipMonthFormat(right_start) + ' ' + __('Active margiis') + ' - ' + __('All: init&notInit') + ' ' + __('with Guests')">
                                                {{ unit.active_members.right.ini + unit.active_members.right.not_ini }}
                                            </span>
                                        </div>
                                        <div class="init" v-if="show_details">
                                            <span class="all" :title="tooltipMonthFormat(right_start) + ' ' + __('Active margiis') + ' - ' + __('Initiated') + ' ' + __('with Guests')">
                                                {{ unit.active_members.right.ini }}
                                            </span>
                                        </div>
                                        <div class="notInit"  v-if="show_details">
                                            <span class="all" :title="tooltipMonthFormat(right_start) + ' ' + __('Active margiis') + ' - ' + __('Not initiated') + ' ' + __('with Guests')">
                                                {{ unit.active_members.right.not_ini }}
                                            </span>
                                        </div>

    <!--                                    <span v-if="unit.active_members.right - unit.active_members.left">

                                        </span>
                                        <span class="diff" v-if="unit.active_members.right !== unit.active_members.left" :class="{'red': (unit.active_members.right - unit.active_members.left) < 0, 'green': (unit.active_members.right - unit.active_members.left) > 0}">
                                            <span v-if="(unit.active_members.right - unit.active_members.left) > 0">&plus;</span>
                                            <span>{{ unit.active_members.right - unit.active_members.left }}</span>
                                        </span>-->
                                    </div>
                                </div>

                                <div class="appEventsReport-regionContentBhuktiContentUnitColumn DC2" v-if="!show_vip">
                                    <div class="appEventsReport-regionContentBhuktiContentUnitColumnTop" v-for="(range, index) in periods">
                                        <span class="all" :title="__('DC') + ': ' + __('DC+AK+SS')">
                                            {{ dc2(region_name, bhukti_name, unit_name, index) }}

                                            <template v-if="index < (Object.keys(periods).length - 1)">
                                                <span class="diff" v-if="dc2_delta(region_name, bhukti_name, unit_name, index)"
                                                      :class="{
                                                'red': (dc2_delta(region_name, bhukti_name, unit_name, index)) < 0,
                                                'green': (dc2_delta(region_name, bhukti_name, unit_name, index)) > 0
                                                }">
                                                    <span v-if="(dc2_delta(region_name, bhukti_name, unit_name, index)) > 0">&plus;</span>
                                                    <span>{{ dc2_delta(region_name, bhukti_name, unit_name, index) }}</span>
                                                </span>
                                            </template>
                                        </span>
                                    </div>
                                </div>

                                <div class="appEventsReport-regionContentBhuktiContentUnitColumn KM2" v-if="!show_vip">
                                    <div class="appEventsReport-regionContentBhuktiContentUnitColumnTop" v-for="(range, index) in periods">
                                        <span class="all" :title="__('KM')">
                                            {{ km2(region_name, bhukti_name, unit_name, index) }}

                                            <template v-if="index < (Object.keys(periods).length - 1)">
                                                <span class="diff" v-if="km2_delta(region_name, bhukti_name, unit_name, index)"
                                                      :class="{
                                                'red': (km2_delta(region_name, bhukti_name, unit_name, index)) < 0,
                                                'green': (km2_delta(region_name, bhukti_name, unit_name, index)) > 0
                                                }">
                                                    <span v-if="(km2_delta(region_name, bhukti_name, unit_name, index)) > 0">&plus;</span>
                                                    <span>{{ km2_delta(region_name, bhukti_name, unit_name, index) }}</span>
                                                </span>
                                            </template>
                                        </span>
                                    </div>
                                </div>

                                <div class="appEventsReport-regionContentBhuktiContentUnitColumn" :class="{'three': show_details}" v-for="(event, event_name) in events" v-if="event.slug !== 'active_members' && (show_all_events || vip_event(event.slug)) && show_vip">
                                        <div class="appEventsReport-regionContentBhuktiContentUnitColumnTop" :class="{'threeWrap': show_details}" v-for="(range, index) in periods">
                                            <div class="sum">
                                                <span class="all" :title="event.short_name + ' - ' + __('All: init&notInit') + ' ' + __('with Guests')">
                                                    {{ unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].ini.users + unit[event.slug][rangeKeyFormat(range.day)].ini.guests + unit[event.slug][rangeKeyFormat(range.day)].not_ini.users + unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0 }}

                                                    <span class="guests"  :title="event.short_name + ' - ' + __('All: init&notInit') + ' ' + __('Guests only')" v-if="show_guests && unit[event.slug] && unit[event.slug][rangeKeyFormat(range.day)] && unit[event.slug][rangeKeyFormat(range.day)].ini.guests + unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests && show_details">
                                                        {{ unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].ini.guests + unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0 }}
                                                    </span>
                                                    <template v-if="index < (Object.keys(periods).length - 1)">
                                                        <span class="diff" v-if="(unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].ini.users + unit[event.slug][rangeKeyFormat(range.day)].ini.guests + unit[event.slug][rangeKeyFormat(range.day)].not_ini.users + unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0)
                                                    -
                                                    (unit[event.slug] ? unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)] ? unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.users + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.guests + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.users + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.guests : 0 : 0)"
                                                              :class="{
                                                        'red': ((unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].ini.users + unit[event.slug][rangeKeyFormat(range.day)].ini.guests + unit[event.slug][rangeKeyFormat(range.day)].not_ini.users + unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0)
                                                    -
                                                    (unit[event.slug] ? unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)] ? unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.users + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.guests + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.users + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.guests : 0 : 0)) < 0,
                                                        'green': ((unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].ini.users + unit[event.slug][rangeKeyFormat(range.day)].ini.guests + unit[event.slug][rangeKeyFormat(range.day)].not_ini.users + unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0)
                                                    -
                                                    (unit[event.slug] ? unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)] ? unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.users + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.guests + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.users + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.guests : 0 : 0)) > 0
                                                    }">
                                                            <span v-if="((unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].ini.users + unit[event.slug][rangeKeyFormat(range.day)].ini.guests + unit[event.slug][rangeKeyFormat(range.day)].not_ini.users + unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0)
                                                    -
                                                    (unit[event.slug] ? unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)] ? unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.users + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.guests + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.users + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.guests : 0 : 0)) > 0">&plus;</span>
                                                            <span>{{ (unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].ini.users + unit[event.slug][rangeKeyFormat(range.day)].ini.guests + unit[event.slug][rangeKeyFormat(range.day)].not_ini.users + unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0)
                                                            -
                                                            (unit[event.slug] ? unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)] ? unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.users + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].ini.guests + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.users + unit[event.slug][rangeKeyFormat(periods[Number(index)+1].day)].not_ini.guests : 0 : 0) }}</span>
                                                        </span>
                                                </template>
                                                </span>
                                            </div>
                                            <div class="init" v-if="show_details">
                                                <span :title="event.short_name + ' - ' + __('Initiated') + ' ' + __('with Guests')">
                                                    {{ unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].ini.users + unit[event.slug][rangeKeyFormat(range.day)].ini.guests : 0 : 0 }}
                                                    <span class="guests"  :title="event.short_name + ' - ' + __('Initiated') + ' ' + __('Guests only')" v-if="show_guests && unit[event.slug] && unit[event.slug][rangeKeyFormat(range.day)] && unit[event.slug][rangeKeyFormat(range.day)].ini.guests && show_details">
                                                        {{ unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].ini.guests : 0 : 0 }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="notInit" v-if="show_details">
                                                <span class="all" :title="event.short_name + ' - ' + __('Not initiated') + __('with Guests')">
                                                    {{ unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].not_ini.users + unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0 }}
                                                    <span class="guests"  :title="event.short_name + ' - ' + __('Not initiated') + ' ' + __('Guests only')" v-if="show_guests && unit[event.slug] && unit[event.slug][rangeKeyFormat(range.day)] && unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests && show_details">
                                                        {{ unit[event.slug] ? unit[event.slug][rangeKeyFormat(range.day)] ? unit[event.slug][rangeKeyFormat(range.day)].not_ini.guests : 0 : 0 }}
                                                    </span>
                                                </span>

                                            </div>

                                        </div>
                                </div>

                                <div class="appEventsReport-regionContentBhuktiContentUnitRange">
                                    <div class="appEventsReport-regionContentBhuktiContentUnitRangeTop" v-for="(period, key) in periods">
                                        {{ period.range }}
                                    </div>
                                </div>

                                <div class="appEventsReport-regionContentBhuktiContentUnitColumn diagram">

                                    <div class="appEventsReport-diagramWrap" @click="fancyDiagram(unit, unit_name)">
                                        <unit-diagram practice="dc" :full="false" :mode="mode" :unit="unit" :periods="periods"></unit-diagram>
                                        <unit-diagram practice="km" :full="false" :mode="mode" :unit="unit" :periods="periods"></unit-diagram>
                                    </div>
                                </div>
                            </template>
                            <div v-else class="appEventsReport-regionContentBhuktiContentUnitColumn">{{ __('No programs recorded') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <modal-window id="appEventsReport-diagramWindow" v-if="diagram_info" nScroll @close="diagram_info = null" :windowName="diagram_target">
            <div class="appEventsReport-diagramBig">
                <unit-diagram practice="dc" :full="true" :mode="mode" :unit="diagram_info" :periods="periods"></unit-diagram>
                <unit-diagram practice="km" :full="true" :mode="mode" :unit="diagram_info" :periods="periods"></unit-diagram>
            </div>
        </modal-window>
    </div>
</template>
<script>
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

import monthSelectPlugin from 'flatpickr/dist/plugins/monthSelect';
require('flatpickr/dist/plugins/monthSelect/style.css');

import moment from 'moment';

export default {
    props: ['master', 'bp'],

    components: {flatPickr},

    data() {
        return {
            regions: {},
            filteredRegions: {},
            events_summary: {},
            tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power: {},
            months_summary: {},
            events: [],
            diagram_info: null,
            diagram_target: '',

            periods: {},

            left_period: 'default',
            left_start: moment().startOf('month').subtract(2, 'month').format('YYYY-MM-DD'),
            left_end: moment().endOf('month').subtract(2, 'month').format('YYYY-MM-DD'),

            right_period: 'default',
            right_start: moment().startOf('month').subtract(1, 'month').format('YYYY-MM-DD'),
            right_end: moment().endOf('month').subtract(1, 'month').format('YYYY-MM-DD'),

            filters: {
                region: 0,
                bhukti: 0,
                unit: 0
            },

            filters_copy: {
                region: 0,
                bhukti: 0,
                unit: 0
            },

            show_all_events: false,
            show_details: false,
            show_vip: false,
            show_guests: false,
            show_empty: false,

            pickr: null,
            calendarOpen: true,

            mode_bool: false,
            mode: 'week',

            regions_list: [],
            bhuktis_list: [],
            units_list: [],

            rangePickr: {
                mode: 'range',
                maxDate: 'today',
                locale: 'ru',
                dateFormat: 'd.m.y'
            },
            manual_range: "",
            show_pickr: false
        }
    },

    watch: {
        dates(val) {
            this.getData();
        },
        regions() {
            this.workRegions();
        },
        filters: {
            deep: true,
            handler() {
                if(this.filters_copy.region !== this.filters.region) {
                    this.filters.bhukti = 0;
                    this.filters.unit = 0;
                } else if(this.filters_copy.bhukti !== this.filters.bhukti) {
                    this.filters.unit = 0;
                }

                this.$nextTick(() => {
                    this.filters_copy = JSON.parse(JSON.stringify(this.filters));
                    this.workRegions();

                    this.getFilteredRegions();
                });
            }
        },
        mode_bool(val) {
            val ? this.mode = 'month' : this.mode = 'week'
        },
        mode() {
            this.manual_range = moment().startOf(this.mode).subtract(12, this.mode).format('DD.MM.YY') + ' — ' + moment().subtract(1, this.mode).endOf(this.mode).format('DD.MM.YY');
        },

        manual_range() {
            this.gatherData();
        }
    },

    beforeMount() {
        this.manual_range = moment().startOf(this.mode).subtract(12, this.mode).format('DD.MM.YY') + ' — ' + moment().subtract(1, this.mode).endOf(this.mode).format('DD.MM.YY');
    },

    mounted() {
        let that = this;
        this.leftPickr = flatpickr(this.$refs.leftCalendar, {
            maxDate: moment().format(),
            onChange: function(selectedDates, dateStr, instance) {
                that.left_start = moment(dateStr).startOf('month').format('YYYY-MM-DD');
                that.left_end = moment(dateStr).endOf('month').format('YYYY-MM-DD');
            },
            onOpen: function(selectedDates, dateStr, instance) {
                that.leftCalendarOpen = true;
            },
            onClose: function(selectedDates, dateStr, instance) {
                that.leftCalendarOpen = false;
            },
            wrap: true,
            disableMobile: true,
            plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Y-m-d", altFormat: "M Y"})]
        });
        this.rightPickr = flatpickr(this.$refs.rightCalendar, {
            maxDate: moment().format(),
            onChange: function(selectedDates, dateStr, instance) {
                that.right_start = moment(dateStr).startOf('month').format('YYYY-MM-DD');
                that.right_end = moment(dateStr).endOf('month').format('YYYY-MM-DD');
            },
            onOpen: function(selectedDates, dateStr, instance) {
                that.rightCalendarOpen = true;
            },
            onClose: function(selectedDates, dateStr, instance) {
                that.rightCalendarOpen = false;
            },
            wrap: true,
            disableMobile: true,
            plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Y-m-d", altFormat: "M Y"})]
        });
    },

    computed: {
        dates() {
            return this.left_start+this.left_end+this.right_start+this.right_end;
        }
    },

    methods: {
        fancyDiagram(unit, unit_name){
            this.diagram_info = JSON.parse(JSON.stringify(unit));
            this.diagram_target = unit_name;
        },

        dc2(r, b, u, i, summary = false) {
            let unit = {};
            if(!summary) {
                unit = this.regions[r][b].units[u];
            } else {
                unit = this.events_summary;
            }

            let period_key = this.rangeKeyFormat(this.periods[Number(i)].day);

            let sum = 0;

            if(unit.dc && unit.dc[period_key]) {
                sum += unit.dc[period_key].ini.guests;
                sum += unit.dc[period_key].ini.users;
                sum += unit.dc[period_key].not_ini.guests;
                sum += unit.dc[period_key].not_ini.users;
            }

            if(unit.ak && unit.ak[period_key]) {
                sum += unit.ak[period_key].ini.guests;
                sum += unit.ak[period_key].ini.users;
                sum += unit.ak[period_key].not_ini.guests;
                sum += unit.ak[period_key].not_ini.users;
            }

            if(unit.sadhana_sivir && unit.sadhana_sivir[period_key]) {
                sum += unit.sadhana_sivir[period_key].ini.guests;
                sum += unit.sadhana_sivir[period_key].ini.users;
                sum += unit.sadhana_sivir[period_key].not_ini.guests;
                sum += unit.sadhana_sivir[period_key].not_ini.users;
            }

            return sum;
        },

        km2(r, b, u, i, summary = false) {
            let unit = {};
            if(!summary) {
                unit = this.regions[r][b].units[u];
            } else {
                unit = this.events_summary;
            }

            let period_key = this.rangeKeyFormat(this.periods[Number(i)].day);

            let sum = 0;

            if(unit.km && unit.km[period_key]) {
                sum += unit.km[period_key].ini.guests;
                sum += unit.km[period_key].ini.users;
                sum += unit.km[period_key].not_ini.guests;
                sum += unit.km[period_key].not_ini.users;
            }

            return sum;
        },

        dc2_delta(r, b, u, i, summary = false) {
            return this.dc2(r, b, u, i, summary) - this.dc2(r, b, u, i+1, summary);
        },

        km2_delta(r, b, u, i, summary = false) {
            return this.km2(r, b, u, i, summary) - this.km2(r, b, u, i+1, summary);
        },

        clearFilters() {
            this.filters = {
                region: 0,
                bhukti: 0,
                unit: 0
            };
        },

        workRegions() {
            let bhuktis_list = [];
            let units_list = [];

            this.regions_list = Object.keys(this.regions);

            Object.entries(this.regions).forEach( r => {
                if(!this.filters.region || new RegExp(this.regions_list[this.filters.region - 1], 'i').test(r[0])) {
                    bhuktis_list = bhuktis_list.concat(Object.keys(r[1]));
                    /*Object.values(r[1]).forEach( b => {
                        if(b.units) units_list = units_list.concat(Object.keys(b.units));
                    });*/
                    Object.entries(r[1]).forEach( b => {
                        if(!this.filters.bhukti || new RegExp(this.bhuktis_list[this.filters.bhukti], 'i').test(b[0]))
                        if(b[1].units) units_list = units_list.concat(Object.keys(b[1].units));
                    });
                }
            });
            this.bhuktis_list = bhuktis_list;
            this.units_list = units_list;

            this.regions_list.unshift(this.__('All'));
            this.bhuktis_list.unshift(this.__('All'));
            this.units_list.unshift(this.__('All'));
        },

        getData() {
            this.$root.loading = true;
            axios.get('/statistics/report', {params: {
                periods: this.periods,
                mode: this.mode,

                left_start: this.left_start,
                left_end: this.left_end,
                right_start: this.right_start,
                right_end: this.right_end
            }}).then(response => {
                this.$root.loading = false;
                this.regions = response.data.regions;
                this.events = response.data.events;

                this.getFilteredRegions();
            }).catch(error => {
                this.$root.loading = false;
            });
        },

        getFilteredRegions() {
            let filtered_regions = {};
            let regions = JSON.parse(JSON.stringify(this.regions));

            let summary = {};
            let ttgl = {};
            let months_summary = {
                left: {
                    ini: 0,
                    not_ini: 0
                },
                right: {
                    ini: 0,
                    not_ini: 0
                }
            };

            if(regions)
            {
                for(let [r_k, r_v] of Object.entries(regions)) {
                    if((!this.filters.region || new RegExp(this.regions_list[this.filters.region], 'i').test(r_k)) && (typeof regions[r_k] === 'object' && !Array.isArray(regions[r_k]))) {
                        for (let [b_k, b_v] of Object.entries(regions[r_k])) {
                            if ((!this.filters.bhukti || new RegExp(this.bhuktis_list[this.filters.bhukti], 'i').test(b_k)) && (typeof regions[r_k][b_k].units === 'object' && !Array.isArray(regions[r_k][b_k].units))) {
                                for (let [u_k, u_v] of Object.entries(regions[r_k][b_k].units)) {
                                    if ((!this.filters.unit || new RegExp(this.units_list[this.filters.unit], 'i').test(u_k)) && (typeof regions[r_k][b_k].units[u_k] === 'object' && !Array.isArray(regions[r_k][b_k].units[u_k]))) {
                                        if (!filtered_regions[r_k]) {
                                            filtered_regions[r_k] = {};
                                        }
                                        if (!filtered_regions[r_k][b_k]) {
                                            filtered_regions[r_k][b_k] = {};
                                        }
                                        filtered_regions[r_k][b_k][u_k] = u_v;

                                        months_summary['left']['ini'] += u_v['active_members']['left']['ini'];
                                        months_summary['left']['not_ini'] += u_v['active_members']['left']['not_ini'];
                                        months_summary['right']['ini'] += u_v['active_members']['right']['ini'];
                                        months_summary['right']['not_ini'] += u_v['active_members']['right']['not_ini'];

                                        for(let [e_k, e_v] of Object.entries(regions[r_k][b_k].units[u_k])) {
                                            if(e_k !== 'active_members') {
                                                if(!summary[e_k]) summary[e_k] = {};
                                                for(let [p_k, p_v] of Object.entries(regions[r_k][b_k].units[u_k][e_k])) {
                                                    if(!summary[e_k][p_k]) summary[e_k][p_k] = {};
                                                    if(!summary[e_k][p_k]['ini']) summary[e_k][p_k]['ini'] = {}
                                                    if(!summary[e_k][p_k]['not_ini']) summary[e_k][p_k]['not_ini'] = {}

                                                    summary[e_k][p_k]['ini']['guests'] = summary[e_k][p_k]['ini']['guests'] ? summary[e_k][p_k]['ini']['guests'] + p_v['ini']['guests'] : p_v['ini']['guests'];
                                                    summary[e_k][p_k]['ini']['users'] = summary[e_k][p_k]['ini']['users'] ? summary[e_k][p_k]['ini']['users'] + p_v['ini']['users'] : p_v['ini']['users'];
                                                    summary[e_k][p_k]['not_ini']['guests'] = summary[e_k][p_k]['not_ini']['guests'] ? summary[e_k][p_k]['not_ini']['guests'] + p_v['not_ini']['guests'] : p_v['not_ini']['guests'];
                                                    summary[e_k][p_k]['not_ini']['users'] = summary[e_k][p_k]['not_ini']['users'] ? summary[e_k][p_k]['not_ini']['users'] + p_v['not_ini']['users'] : p_v['not_ini']['users'];

                                                    if(!ttgl[e_k]) ttgl[e_k] = {
                                                        ini: {
                                                            guests: 0,
                                                            users: 0
                                                        },
                                                        not_ini: {
                                                            guests: 0,
                                                            users: 0
                                                        }
                                                    };

                                                    ttgl[e_k]['ini']['guests'] += p_v['ini']['guests'];
                                                    ttgl[e_k]['ini']['users'] += p_v['ini']['users'];
                                                    ttgl[e_k]['not_ini']['guests'] += p_v['not_ini']['guests'];
                                                    ttgl[e_k]['not_ini']['users'] += p_v['not_ini']['users'];
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    console.log('test1');
                }
                console.log('test2');
            }

            this.tengen_toppa_mega_giga_drill_power_ranger_chicken_macnuggets_vodka_chrushevka_balalaika_summary_row_row_fight_the_power = ttgl;
            this.filteredRegions = filtered_regions;
            this.events_summary = summary;
            this.months_summary = JSON.parse(JSON.stringify(months_summary));
            console.log(months_summary);
            console.log(this.months_summary);
        },

        dateFormat(date) {
            return moment(date).format('DD.MM.YYYY')
        },

        monthFormat(date) {
            return moment(date).format('MMM');
        },

        tooltipMonthFormat(date) {
            return moment(date).format('MMM YY');
        },

        rangeFormat(day) {
            let range_start = moment(day).startOf(this.mode);
            let range_end = moment(day).endOf(this.mode);

            if(this.mode === 'week') {
                if(range_start.month() === range_end.month())
                    return range_start.format('DD') + '-' + range_end.format('DD MMM');
                else
                    return range_start.format('DD MMM') + ' - ' + range_end.format('DD MMM');
            } else {
                return range_start.format('MMM');
            }
        },

        rangeKeyFormat(day) {
            let result = moment(day).format('YYYY.MM.DD') + '_' + moment(day).endOf(this.mode).format('YYYY.MM.DD');

            return result;
        },

        vip_event(slug) {
            let result = false;

            this.events.map( e => {
                if(e.slug === slug && e.vip) result = true;
            });

            return result;
        },

        gatherData() {
            this.customRange();

            this.$nextTick(() => {
                this.getData();
            });
        },

        customRange() {
            let range = this.manual_range;

            if(range.length > 10) {
                let start = range.split(' — ')[0];
                let end = range.split(' — ')[1];

                let start_range = moment(start, 'DD.MM.YY');
                let end_range = moment(end, 'DD.MM.YY');

                if(start_range.format('YYYY-MM-DD') !== start_range.startOf(this.mode).format('YYYY-MM-DD')) {
                    start_range.startOf(this.mode).add(1, this.mode);
                }

                if(end_range.format('YYYY-MM-DD') !== end_range.endOf(this.mode).format('YYYY-MM-DD')) {
                    end_range.startOf(this.mode).subtract(1, this.mode);
                } else {
                    end_range.startOf(this.mode);
                }

                this.periods = [];

                let marker = moment(end_range.format('YYYY-MM-DD'));

                let day = null;

                do {
                    day = marker.format('YYYY-MM-DD');

                    this.periods.push({
                        day: day,
                        range: this.rangeFormat(day)
                    });

                    marker.subtract(1, this.mode);
                } while (start_range.isBefore(marker) || start_range.isSame(marker));
            }
        },

        verify_bhukti(bhukti, bhukti_name) {
            let basic_check = false;

            if((!this.filters.bhukti
                    || new RegExp(this.bhuktis_list[this.filters.bhukti], 'i').test(bhukti_name))
                && (!this.filters.unit || (bhukti.units && Object.keys(bhukti.units).filter( b => new RegExp(this.units_list[this.filters.unit], 'i').test(b)).length)))
            {
                basic_check = true;
            }

            let empty_check = false;
            if(typeof bhukti.units === 'object' && !Array.isArray(bhukti.units)) {
                if (Object.values(bhukti.units).some(unit => typeof unit === 'object' && !Array.isArray(unit))) {
                    empty_check = true;
                }
            }

            return basic_check && (empty_check || this.show_empty);
        },

        verify_region(region, region_name) {
            let basic_check = false;

            if((!this.filters.region
                || new RegExp(this.regions_list[this.filters.region], 'i').test(region_name))
            && (!this.filters.bhukti || Object.keys(region).filter( r => new RegExp(this.bhuktis_list[this.filters.bhukti], 'i').test(r)).length)
            && (!this.filters.unit || Object.values(region).filter( r => (r.units && Object.keys(r.units).filter( b => new RegExp(this.units_list[this.filters.unit], 'i').test(b)).length) ).length)) {
                basic_check = true;
            }

            let empty_check = false;

            if(Object.values(region).some( bhukti => ((typeof bhukti.units === 'object' && !Array.isArray(bhukti.units)) && Object.values(bhukti.units).some( unit => typeof unit === 'object' && !Array.isArray(unit))))) {
                empty_check = true;
            }

            return basic_check && (this.show_empty || empty_check);

        }
    }
}
</script>
