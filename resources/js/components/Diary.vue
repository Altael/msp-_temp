<template>
    <div class="appDiary">
        <div class="appDiary-tools">
            <div class="appDiary-add">
                <a v-if="app === 'am' && less768" href="/diary-record">
                    <div class="appIcons msppIcons-plus"></div>
                </a>
                <div v-else @click="create">
                    <div class="appIcons msppIcons-plus"></div>
                </div>
            </div>
        </div>
        <div class="appDiary-navPanel">
            <div class="appDiary-navPanelName" v-if="foreign">
                {{ userName }}
            </div>
            <pagination v-model="page" :total="total" :per-page="perPage"/>
        </div>
        <div class="appPageContent">
            <div class="appTable appDiaries">
                <div class="appTable-row appTable-head appDiary-tableHead">
                    <div class="appTable-col appDiary-date">
                        <div :title=" __('Date') " class="appIcons msppIcons-date appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h1=__('Date') }}</div>
                    </div>
                    <div class="appTable-col appDiary-rank">
                        <div :title=" __('Rank') "
                             class="appIcons msppIcons-award appDiary-rank appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h17=__('Rank') }}</div>
                    </div>
                    <div class="appTable-col appDiary-guru">
                        <div :title=" __('Guru Sakash') " class="appIcons msppIcons-guru appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h2=__('Guru Sakash') }}</div>
                    </div>
                    <div class="appTable-col appDiary-pancajania">
                        <div :title=" __('Pancajania') " class="appIcons msppIcons-clock appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h3=__('Pancajania') }}</div>
                    </div>
                    <div class="appTable-col appDiary-diary">
                        <div :title=" __('Diary') " class="appIcons msppIcons-book appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h4=__('Diary') }}</div>
                    </div>
                    <div class="appTable-col appDiary-meditation">
                        <div :title=" __('Meditation') " class="appIcons msppIcons-meditation appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h5=__('Meditation') }}</div>
                    </div>
                    <div class="appTable-col appDiary-lalita">
                        <div :title=" __('Lalita Marmika') " class="appIcons msppIcons-lalita appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h6=__('Lalita Marmika') }}</div>
                    </div>
                    <div class="appTable-col appDiary-asanas">
                        <div :title=" __('Asanas') " class="appIcons msppIcons-asanas appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h7=__('Asanas') }}</div>
                    </div>
                    <div class="appTable-col appDiary-kaosiki">
                        <div :title=" __('Kaosiki') " class="appIcons msppIcons-kaoshiki appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h8=__('Kaosiki') }}</div>
                    </div>
                    <div class="appTable-col appDiary-tandava" v-if="man">
                        <div :title=" __('Tandava') " class="appIcons msppIcons-tandava appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h9=__('Tandava') }}</div>
                    </div>
                    <div class="appTable-col appDiary-shaoca">
                        <div :title=" __('Half bath') " class="appIcons msppIcons-shaoca appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h10=__('Half bath') }}</div>
                    </div>
                    <div class="appTable-col appDiary-fullBath">
                        <div :title=" __('Full Bath') " class="appIcons msppIcons-shower appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h11=__('Full Bath') }}</div>
                    </div>
                    <div class="appTable-col appDiary-svadhyaya">
                        <div :title=" __('Svadhyaya') " class="appIcons msppIcons-svadhyaya appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h12=__('Svadhyaya') }}</div>
                    </div>
                    <div class="appTable-col appDiary-karmayoga">
                        <div :title=" __('Karma Yoga') " class="appIcons msppIcons-karmayoga appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h13=__('Karma Yoga') }}</div>
                    </div>
                    <div class="appTable-col appDiary-aharya">
                        <div :title=" __('Nutrition') " class="appIcons msppIcons-aharya appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h14=__('Nutrition') }}</div>
                    </div>
                    <div class="appTable-col appDiary-dharmacakra">
                        <div :title=" __('DC') " class="appIcons msppIcons-DC appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h15=__('DC') }}</div>
                    </div>
                    <div class="appTable-col appDiary-upavasa">
                        <div :title=" __('Fasting') " class="appIcons msppIcons-upavasa appDiary-headIcon"></div>
                        <div class="appDiary-colName">{{ h16=__('Fasting') }}</div>
                    </div>
                    <div class="appTable-col appDiary-tools">
                        <div class="appIcons msppIcons-tools appDiary-headIcon"></div>
                    </div>
                </div>

                <div class="appTable-body">
                    <div v-for="(item, index) of items" class="appTable-row appDiary-tableBody">

                        <div class="appTable-col appDiary-date">
                            <div :title="__('Date')" class="appIcons msppIcons-date appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h1 }}:&nbsp;</div>
                            <div>{{ dateFormat(item.date) }}</div>
                        </div>
                        <div class="appTable-col appDiary-rank">
                            <div :title=" __('Rank') " class="appIcons msppIcons-award appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h17 }}:&nbsp;</div>
                            <div>{{ __(item.rank) }} ({{ item.points }})</div>
                        </div>
                        <div class="appTable-col appDiary-guru">
                            <div :title=" __('Guru Sakash') " class="appIcons msppIcons-guru appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h2 }}:&nbsp;</div>
                            <div class="appIcons"
                                 :class="{ 'msppIcons-check' : item.guru_sakash, 'msppIcons-x' : !item.guru_sakash }"></div>
                        </div>
                        <div class="appTable-col appDiary-pancajania">
                            <div :title=" __('Pancajania') " class="appIcons msppIcons-clock appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h3 }}:&nbsp;</div>
                            <div v-if="item.pancajania==='no'" class="appIcons msppIcons-x"></div>
                            <div v-else>{{ pancajaniaTitles[item.pancajania] }}</div>
                        </div>
                        <div class="appTable-col appDiary-diary">
                            <div :title=" __('Diary') " class="appIcons msppIcons-book appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h4 }}:&nbsp;</div>
                            <div class="appIcons"
                                 :class="{ 'msppIcons-check' : item.diary, 'msppIcons-x' : !item.diary }"></div>
                        </div>
                        <div class="appTable-col appDiary-meditation">
                            <div :title=" __('Meditation') "
                                 class="appIcons msppIcons-meditation appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h5 }}:&nbsp;</div>
                            <div v-if="!item.meditation_count" class="appIcons msppIcons-x"></div>
                            <div v-else> {{ item.meditation_count }}
                                <template v-if="timeFormat(item.meditation_time)==0">(<span
                                    class="appIcons msppIcons-minus"></span>)
                                </template>
                                <template v-else>{{ "(" + timeFormat(item.meditation_time) + ")" }}</template>
                            </div>
                        </div>
                        <div class="appTable-col appDiary-lalita">
                            <div :title=" __('Lalita Marmika') "
                                 class="appIcons msppIcons-lalita appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h6 }}:&nbsp;</div>
                            <div v-if="!item.lalita_marmika_count" class="appIcons msppIcons-x"></div>
                            <div v-else> {{ item.lalita_marmika_count }}
                                <template v-if="timeFormat(item.lalita_marmika_time)==0">(<span
                                    class="appIcons msppIcons-minus"></span>)
                                </template>
                                <template v-else>{{ "(" + timeFormat(item.lalita_marmika_time) + ")" }}</template>
                            </div>
                        </div>
                        <div class="appTable-col appDiary-asanas">
                            <div :title=" __('Asanas') " class="appIcons msppIcons-asanas appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h7 }}:&nbsp;</div>
                            <div v-if="item.asanas==='no'" class="appIcons msppIcons-x"></div>
                            <div v-else>{{ asanaTitles[item.asanas] }}</div>
                        </div>
                        <div class="appTable-col appDiary-kaosiki">
                            <div :title=" __('Kaosiki') " class="appIcons msppIcons-kaoshiki appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h8 }}:&nbsp;</div>
                            <div v-if="!item.kaosiki_count" class="appIcons msppIcons-x"></div>
                            <div v-else> {{ item.kaosiki_count }}
                                <template v-if="timeFormat(item.kaosiki_time)==0">(<span
                                    class="appIcons msppIcons-minus"></span>)
                                </template>
                                <template v-else>{{ "(" + timeFormat(item.kaosiki_time) + ")" }}</template>
                            </div>
                        </div>
                        <div class="appTable-col appDiary-tandava" v-if="man">
                            <div :title=" __('Tandava') " class="appIcons msppIcons-tandava appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h9 }}:&nbsp;</div>
                            <div v-if="!item.tandava_count" class="appIcons msppIcons-x"></div>
                            <div v-else> {{ item.tandava_count }}
                                <template v-if="timeFormat(item.tandava_time)==0">(<span
                                    class="appIcons msppIcons-minus"></span>)
                                </template>
                                <template v-else>{{ "(" + timeFormat(item.tandava_time) + ")" }}</template>
                            </div>
                        </div>
                        <div class="appTable-col appDiary-shaoca">
                            <div :title=" __('Half bath') " class="appIcons msppIcons-shaoca appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h10 }}:&nbsp;</div>
                            <div class="appDiary-tableBodyText">
                                <div v-if="item.vyapaka_shaoca==='no'" class="appIcons msppIcons-x"></div>
                                <div v-else>{{ vyapaka_shaocaTitles[item.vyapaka_shaoca] }}</div>
                            </div>
                        </div>
                        <div class="appTable-col appDiary-fullBath">
                            <div :title=" __('Full Bath') " class="appIcons msppIcons-shower appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h11 }}:&nbsp;</div>
                            <div v-if="item.full_bath==='no'" class="appIcons msppIcons-x"></div>
                            <div v-else>{{ full_bathTitles[item.full_bath] }}</div>
                        </div>
                        <div class="appTable-col appDiary-svadhyaya">
                            <div :title=" __('Svadhyaya') " class="appIcons msppIcons-svadhyaya appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h12 }}:&nbsp;</div>
                            <div v-if="timeFormat(item.svadhyaya)==0" class="appIcons msppIcons-minus"></div>
                            <div v-else>{{ timeFormat(item.svadhyaya) }}</div>
                        </div>
                        <div class="appTable-col appDiary-karmayoga">
                            <div :title=" __('Karma Yoga') "
                                 class="appIcons msppIcons-karmayoga appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h13 }}:&nbsp;</div>
                            <div v-if="timeFormat(item.karma_yoga)==0" class="appIcons msppIcons-minus"></div>
                            <div v-else>{{ timeFormat(item.karma_yoga) }}</div>
                        </div>
                        <div class="appTable-col appDiary-aharya">
                            <div :title=" __('Nutrition') " class="appIcons msppIcons-aharya appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h14 }}:&nbsp;</div>
                            <div v-if="item.aharya==='no'" class="appIcons msppIcons-x"></div>
                            <div v-else>{{ aharyaTitles[item.aharya] }}</div>
                        </div>
                        <div class="appTable-col appDiary-dharmacakra">
                            <div :title=" __('DC') " class="appIcons msppIcons-DC appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h15 }}:&nbsp;</div>
                            <div v-if="item.dharmacakra==='no'" class="appIcons msppIcons-x"></div>
                            <div v-else>{{ dharmacakraTitles[item.dharmacakra] }}</div>
                        </div>
                        <div class="appTable-col appDiary-upavasa">
                            <div :title=" __('Fasting') " class="appIcons msppIcons-upavasa appDiary-bodyIcon"></div>
                            <div class="appDiary-colMobileTitle appDiary-tableBodyTitle">{{ h16 }}:&nbsp;</div>
                            <div v-if="item.upavasa==='no'" class="appIcons msppIcons-x"></div>
                            <div v-else>{{ upavasaTitles[item.upavasa] }}</div>
                        </div>

                        <div class="appTable-col appDiary-tools">
                            <action-dropdown>
                                <a class="dhrtDropdown-item" rel="nofollow" href="#"
                                   @click.prevent="details(item, index)">
                                    {{ __('Details') }}
                                </a>
                                <a href="#" rel="nofollow" class="dhrtDropdown-item" v-if="allowToEdit(item.date)"
                                   @click.prevent="edit(item, index)">
                                    {{ __('Edit') }}
                                </a>
                                <a class="dhrtDropdown-item" rel="nofollow" href="#"
                                   @click.prevent="destroyModal(item, index)">
                                    {{ __('Delete') }}
                                </a>
                            </action-dropdown>
                        </div>
                    </div>
                </div>

                <div v-if="total >= perPage" class="appTable-row appTable-head appDiary-tableHead">
                    <div class="appTable-col appDiary-date">
                        <div :title=" __('Date') " class="appIcons msppIcons-date appDiary-date appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h1=__('Date') }}</div>
                    </div>
                    <div class="appTable-col appDiary-guru">
                        <div :title=" __('Guru Sakash') "
                             class="appIcons msppIcons-guru appDiary-guruIcon appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h2=__('Guru Sakash') }}</div>
                    </div>
                    <div class="appTable-col appDiary-pancajania">
                        <div :title=" __('Pancajania') "
                             class="appIcons msppIcons-clock appDiary-pancajaniaIcon appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h3=__('Pancajania') }}</div>
                    </div>
                    <div class="appTable-col appDiary-diary">
                        <div :title=" __('Diary') "
                             class="appIcons msppIcons-diary appDiary-diaryIcon appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h4=__('Diary') }}</div>
                    </div>
                    <div class="appTable-col appDiary-meditation">
                        <div :title=" __('Meditation') "
                             class="appIcons msppIcons-meditation appDiary-meditationIcon appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h5=__('Meditation') }}</div>
                    </div>
                    <div class="appTable-col appDiary-lalita">
                        <div :title=" __('Lalita Marmika') "
                             class="appIcons msppIcons-lalita appDiary-iconLalita appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h6=__('Lalita Marmika') }}</div>
                    </div>
                    <div class="appTable-col appDiary-asanas">
                        <div :title=" __('Asanas') "
                             class="appIcons msppIcons-asanas appDiary-iconAsanas appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h7=__('Asanas') }}</div>
                    </div>
                    <div class="appTable-col appDiary-kaosiki">
                        <div :title=" __('Kaoshiki') "
                             class="appIcons msppIcons-kaoshiki appDiary-iconKaoshiki appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h8=__('Kaosiki') }}</div>
                    </div>
                    <div class="appTable-col appDiary-tandava" v-if="man">
                        <div :title=" __('Tandava') "
                             class="appIcons msppIcons-tandava appDiary-iconTandava appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h9=__('Tandava') }}</div>
                    </div>
                    <div class="appTable-col appDiary-shaoca">
                        <div :title=" __('Half bath') "
                             class="appIcons msppIcons-shaoca appDiary-iconShaoca appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h10=__('Half bath') }}</div>
                    </div>
                    <div class="appTable-col appDiary-fullBath">
                        <div :title=" __('Full Bath') "
                             class="appIcons msppIcons-shower appDiary-iconShower appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h11=__('Full Bath') }}</div>
                    </div>
                    <div class="appTable-col appDiary-svadhyaya">
                        <div :title=" __('Svadhyaya') "
                             class="appIcons msppIcons-svadhyaya appDiary-iconSvadhyaya appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h12=__('Svadhyaya') }}</div>
                    </div>
                    <div class="appTable-col appDiary-karmayoga">
                        <div :title=" __('Karma Yoga') "
                             class="appIcons msppIcons-karmayoga appDiary-iconKarmayoga appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h13=__('Karma Yoga') }}</div>
                    </div>
                    <div class="appTable-col appDiary-aharya">
                        <div :title=" __('Nutrition') "
                             class="appIcons msppIcons-aharya appDiary-iconAharya appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h14=__('Nutrition') }}</div>
                    </div>
                    <div class="appTable-col appDiary-dharmacakra">
                        <div :title=" __('DC') " class="appIcons msppIcons-DC appDiary-iconDC appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h15=__('DC') }}</div>
                    </div>
                    <div class="appTable-col appDiary-upavasa">
                        <div :title=" __('Fasting') "
                             class="appIcons msppIcons-upavasa appDiary-iconUpavasa appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h16=__('Fasting') }}</div>
                    </div>
                    <div class="appTable-col appDiary-rank">
                        <div :title=" __('Rank') " class="appIcons msppIcons-award appDiary-rank appDiary-icon"></div>
                        <div class="appDiary-colName">{{ h17=__('Rank') }}</div>
                    </div>
                    <div class="appTable-col appDiary-tools">
                        <div class="appIcons msppIcons-tools appDiary-icon"></div>
                    </div>
                </div>
            </div>
        </div>
        <pagination v-if="total >= perPage" v-model="page" :total="total" :per-page="perPage"/>


        <modal-window v-if="item && editor" @close="close" @enter="save()" :valid="item.date && !isProcessing"
                      @cancel="close" :buttonList="['Cancel', 'Save']" @save="save()"
                      :windowName="__(rank)+' ('+points+')'" customId="appDiaryModal">
            <!--'date',-->
            <div class="appForm-group appDiaryModal-date">
                <div class="appForm-groupTitle">{{ __('Date') }}</div>
                <flat-pickr :config="datePickerConfig" class="appForm-input appDiaryModal-inputDate"
                            v-model="item.date"></flat-pickr>
            </div>
            <!--'diary',-->
            <div class="appForm-group appDiaryModal-diary">
                <label class="dhrtSwitch textLeft appDiaryModal-switchDiary">
                    <input type="checkbox" class="dhrtSwitch-noView dhrtSwitchSpinnerCheckbox" v-model="item.diary">
                    <span class="dhrtSwitchSpinner" :title="__('Filled out the paper version')"></span>
                    <span class="dhrtSwitchSpinnerText">{{ __('Diary') }}</span>
                </label>
                <textarea class="appForm-textarea appDiaryModal-textareaDiaryText" :placeholder="__('Today notes')"
                          v-model="item.diary_text"></textarea>
            </div>
            <!--'guru_sakash',-->
            <div class="appForm-group appDiaryModal-guruSakash">
                <label class="dhrtSwitch textLeft appDiaryModal-switchGuruSakash">
                    <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                           v-model="item.guru_sakash">
                    <span class="dhrtSwitchSpinner"></span>
                    <span class="dhrtSwitchSpinnerText">{{ __('Guru Sakash') }}</span>
                </label>
            </div>
            <!--'pancajania',-->
            <div class="appForm-group appDiaryModal-pancajania">
                <div class="appForm-groupTitle">{{ __('Pancajania') }}</div>
                <div class="dhrtRadio">
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.pancajania" value="yes">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Yes') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.pancajania" value="yes_and_sleep">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Yes, but took a nap') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.pancajania" value="no">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('No') }}</span>
                    </label>
                </div>
            </div>
            <!--'lalita_marmika',-->
            <div class="appForm-group appDiaryModal-lalitaMarmikaCount">
                <div class="appForm-groupTitle">{{ __('Lalita Marmika') }}</div>
                <div class="appForm-inline">
                    <div class="appForm-inputSpinnerWrap">
                        <div class="appForm-inputSpinnerBody withBorder">
                            <span class="appForm-inputSpinnerBtn"
                                  @click="decreaseByValue(item, 'lalita_marmika_count', 1)">&#45;</span>
                            <input class="appForm-inputSpinner appDiaryModal-inputLalitaMarmikaCount" type="number"
                                   v-model.number="item.lalita_marmika_count" readonly="readonly">
                            <span class="appForm-inputSpinnerBtn"
                                  @click="increaseByValue(item, 'lalita_marmika_count', 1)">&#43;</span>
                        </div>
                        <div class="appForm-inputSpinnerNote">{{__('Amount')}}</div>
                    </div>
                    <div class="appForm-inputSpinnerWrap">
                        <div class="appForm-inputSpinnerBody withBorder">
                            <span class="appForm-inputSpinnerBtn" @click="decreaseTime(item, 'lalita_marmika_time', 5)">&#45;5</span>
                            <span class="appForm-inputSpinnerBtn" @click="decreaseTime(item, 'lalita_marmika_time', 1)">&#45;</span>
                            <flat-pickr :config="practiceTimePicker" v-model="item.lalita_marmika_time"></flat-pickr>
                            <span class="appForm-inputSpinnerBtn" @click="increaseTime(item, 'lalita_marmika_time', 1)">&#43;</span>
                            <span class="appForm-inputSpinnerBtn" @click="increaseTime(item, 'lalita_marmika_time', 5)">5&#43;</span>
                        </div>
                        <div class="appForm-inputSpinnerNote">{{__('Time')}} | {{ __('hours') }}:{{ __('minutes') }}
                        </div>
                    </div>
                </div>
            </div>
            <!--'meditation',-->
            <div class="appForm-group appDiaryModal-meditationCount">
                <div class="appForm-groupTitle">{{ __('Meditation') }}</div>
                <div class="appForm-inline">
                    <div class="appForm-inputSpinnerWrap">
                        <div class="appForm-inputSpinnerBody withBorder">
                            <span class="appForm-inputSpinnerBtn" @click="decreaseByValue(item, 'meditation_count', 1)">&#45;</span>
                            <input class="appForm-inputSpinner appDiaryModal-inputMeditationCount" type="number"
                                   v-model.number="item.meditation_count" readonly="readonly">
                            <span class="appForm-inputSpinnerBtn" @click="increaseByValue(item, 'meditation_count', 1)">&#43;</span>
                        </div>
                        <div class="appForm-inputSpinnerNote">{{__('Amount')}}</div>
                    </div>
                    <div class="appForm-inputSpinnerWrap">
                        <div class="appForm-inputSpinnerBody withBorder">
                            <span class="appForm-inputSpinnerBtn" @click="decreaseTime(item, 'meditation_time', 5)">&#45;5</span>
                            <span class="appForm-inputSpinnerBtn" @click="decreaseTime(item, 'meditation_time', 1)">&#45;</span>
                            <flat-pickr :config="practiceTimePicker" v-model="item.meditation_time"></flat-pickr>
                            <span class="appForm-inputSpinnerBtn" @click="increaseTime(item, 'meditation_time', 1)">&#43;</span>
                            <span class="appForm-inputSpinnerBtn" @click="increaseTime(item, 'meditation_time', 5)">5&#43;</span>
                        </div>
                        <div class="appForm-inputSpinnerNote">{{__('Time')}} | {{ __('hours') }}:{{ __('minutes') }}
                        </div>
                    </div>
                </div>
            </div>
            <!--'kaosiki',-->
            <div class="appForm-group appDiaryModal-kaosikiCount">
                <div class="appForm-groupTitle">{{ __('Kaoshiki') }}</div>
                <div class="appForm-inline">
                    <div class="appForm-inputSpinnerWrap">
                        <div class="appForm-inputSpinnerBody withBorder">
                            <span class="appForm-inputSpinnerBtn" @click="decreaseByValue(item, 'kaosiki_count', 1)">&#45;</span>
                            <input class="appForm-inputSpinner appDiaryModal-inputKaosikiCount" type="number"
                                   v-model.number="item.kaosiki_count" readonly="readonly">
                            <span class="appForm-inputSpinnerBtn" @click="increaseByValue(item, 'kaosiki_count', 1)">&#43;</span>
                        </div>
                        <div class="appForm-inputSpinnerNote">{{__('Amount')}}</div>
                    </div>
                    <div class="appForm-inputSpinnerWrap">
                        <div class="appForm-inputSpinnerBody withBorder">
                            <span class="appForm-inputSpinnerBtn"
                                  @click="decreaseTime(item, 'kaosiki_time', 5)">&#45;5</span>
                            <span class="appForm-inputSpinnerBtn"
                                  @click="decreaseTime(item, 'kaosiki_time', 1)">&#45;</span>
                            <flat-pickr :config="practiceTimePicker" v-model="item.kaosiki_time"></flat-pickr>
                            <span class="appForm-inputSpinnerBtn"
                                  @click="increaseTime(item, 'kaosiki_time', 1)">&#43;</span>
                            <span class="appForm-inputSpinnerBtn"
                                  @click="increaseTime(item, 'kaosiki_time', 5)">5&#43;</span>
                        </div>
                        <div class="appForm-inputSpinnerNote">{{__('Time')}} | {{ __('hours') }}:{{ __('minutes') }}
                        </div>
                    </div>
                </div>
            </div>
            <!--'tandava',-->
            <div class="appForm-group appDiaryModal-tandavaCount" v-if="man">
                <div class="appForm-groupTitle">{{ __('Tandava') }}</div>
                <div class="appForm-inline">
                    <div class="appForm-inputSpinnerWrap">
                        <div class="appForm-inputSpinnerBody withBorder">
                            <span class="appForm-inputSpinnerBtn" @click="decreaseByValue(item, 'tandava_count', 1)">&#45;</span>
                            <input class="appForm-inputSpinner appDiaryModal-inputTandavaCount" type="number"
                                   v-model.number="item.tandava_count" readonly="readonly">
                            <span class="appForm-inputSpinnerBtn" @click="increaseByValue(item, 'tandava_count', 1)">&#43;</span>
                        </div>
                        <div class="appForm-inputSpinnerNote">{{__('Amount')}}</div>
                    </div>
                    <div class="appForm-inputSpinnerWrap">
                        <div class="appForm-inputSpinnerBody withBorder">
                            <span class="appForm-inputSpinnerBtn"
                                  @click="decreaseTime(item, 'tandava_time', 5)">&#45;5</span>
                            <span class="appForm-inputSpinnerBtn"
                                  @click="decreaseTime(item, 'tandava_time', 1)">&#45;</span>
                            <flat-pickr :config="practiceTimePicker" v-model="item.tandava_time"></flat-pickr>
                            <span class="appForm-inputSpinnerBtn"
                                  @click="increaseTime(item, 'tandava_time', 1)">&#43;</span>
                            <span class="appForm-inputSpinnerBtn"
                                  @click="increaseTime(item, 'tandava_time', 5)">5&#43;</span>
                        </div>
                        <div class="appForm-inputSpinnerNote">{{__('Time')}} | {{ __('hours') }}:{{ __('minutes') }}
                        </div>
                    </div>
                </div>
            </div>
            <!--'asanas',-->
            <div class="appForm-group appDiaryModal-asanas">
                <div class="appForm-groupTitle">{{ __('Did asanas today?') }}</div>
                <div class="dhrtRadio">
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.asanas" value="morning">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Morning') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.asanas" value="evening">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Evening') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.asanas" value="morning_and_evening">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Twice') }}</span>
                    </label>
                    <label v-if="!man">
                        <input type="radio" class="dhrtRadio-noView" v-model="item.asanas" value="period">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Woman period') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.asanas" value="no">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('No') }}</span>
                    </label>
                </div>
            </div>
            <!--'vyapaka_shaoca',-->
            <div class="appForm-group appDiaryModal-vyapakaShaoca">
                <div class="appForm-groupTitle">{{ __('Did you do half bath?') }}</div>
                <div class="dhrtRadio">
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.vyapaka_shaoca" value="before_all">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Before everything') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.vyapaka_shaoca"
                               value="before_sadhana_and_eat_or_sleep">
                        <span class="dhrtRadioView"></span>
                        <span class="appDiaryModal-vyapakaShaocHeight">{{ __('Before sadhana and either eating or sleeping') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.vyapaka_shaoca" value="before_any">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Before eating, sadhana or sleeping') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.vyapaka_shaoca" value="no">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('No') }}</span>
                    </label>
                </div>
            </div>
            <!--'full_bath',-->
            <div class="appForm-group appDiaryModal-fullBath">
                <div class="appForm-groupTitle">{{ __('Full Bath') }}</div>
                <div class="dhrtRadio">
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.full_bath" value="warm">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Warm') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.full_bath" value="cold">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Cold') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.full_bath" value="contrast">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Contrast') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.full_bath" value="no">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('No') }}</span>
                    </label>
                </div>
            </div>
            <!--'svadhyaya',-->
            <div class="appForm-group appForm-inline appDiaryModal-svadhyaya">
                <div class="appForm-groupTitle appDiaryModal-svadhyayaTitle">{{ __('Svadhyaya') }}</div>
                <div class="appForm-inputSpinnerWrap">
                    <div class="appForm-inputSpinnerBody">
                        <span class="appForm-inputSpinnerBtn" @click="decreaseTime(item, 'svadhyaya', 5)">&#45;5</span>
                        <span class="appForm-inputSpinnerBtn" @click="decreaseTime(item, 'svadhyaya', 1)">&#45;</span>
                        <flat-pickr :config="practiceTimePicker" v-model="item.svadhyaya"></flat-pickr>
                        <span class="appForm-inputSpinnerBtn" @click="increaseTime(item, 'svadhyaya', 1)">&#43;</span>
                        <span class="appForm-inputSpinnerBtn" @click="increaseTime(item, 'svadhyaya', 5)">5&#43;</span>
                    </div>
                    <div class="appForm-inputSpinnerNote">{{__('Time')}} | {{ __('hours') }}:{{ __('minutes') }}</div>
                </div>
            </div>
            <!--'karma_yoga',-->
            <div class="appForm-group appForm-inline appDiaryModal-karmaYoga">
                <div class="appForm-groupTitle appDiaryModal-karmaYogaTitle">{{ __('Karma Yoga') }}</div>
                <div class="appForm-inputSpinnerWrap">
                    <div class="appForm-inputSpinnerBody">
                        <span class="appForm-inputSpinnerBtn" @click="decreaseTime(item, 'karma_yoga', 5)">&#45;5</span>
                        <span class="appForm-inputSpinnerBtn" @click="decreaseTime(item, 'karma_yoga', 1)">&#45;</span>
                        <flat-pickr :config="practiceTimePicker" v-model="item.karma_yoga"></flat-pickr>
                        <span class="appForm-inputSpinnerBtn" @click="increaseTime(item, 'karma_yoga', 1)">&#43;</span>
                        <span class="appForm-inputSpinnerBtn" @click="increaseTime(item, 'karma_yoga', 5)">5&#43;</span>
                    </div>
                    <div class="appForm-inputSpinnerNote">{{__('Time')}} | {{ __('hours') }}:{{ __('minutes') }}</div>
                </div>
            </div>
            <!--'aharya',-->
            <div class="appForm-group appDiaryModal-aharya">
                <div class="appForm-groupTitle">{{ __('Nutrition') }}</div>
                <div class="dhrtRadio">
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.aharya" value="sattva_norm">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Sattvika') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.aharya" value="sattva_much">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Sattvika with overeaten') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.aharya" value="rajah">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Rajasika') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.aharya" value="tamah">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Tamasika') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.aharya" value="no">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('No') }}</span>
                    </label>
                </div>
            </div>
            <!--'dharmacakra',-->
            <div class="appForm-group appDiaryModal-dharmacakra">
                <div class="appForm-groupTitle">{{ __('Last dharmacakra') }}</div>
                <div class="dhrtRadio">
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.dharmacakra" value="participated">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Participated') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.dharmacakra" value="had_duty">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Helped organize') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.dharmacakra" value="no">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Didn\'t participate') }}</span>
                    </label>
                </div>
            </div>
            <!--'upavasa',-->
            <div class="appForm-group appDiaryModal-upavasa" v-if="isFasting">
                <div class="appForm-groupTitle">{{ __('Fasting') }}</div>
                <div class="dhrtRadio">
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.upavasa" value="dry">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Dry fasting') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.upavasa" value="water">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Fasting with water') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.upavasa" value="juices_fruits">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Fasting with juices and fruits') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="item.upavasa" value="no">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('No') }}</span>
                    </label>
                </div>
            </div>
        </modal-window>
        <modal-window v-if="item && detail" @close="close" @ok="close" :buttonList="['Ok']"
                      :windowName="dateFormat(item.date)+' - '+__(item.rank)+' ('+item.points+')'">
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Guru Sakash') }}</div>
                <span class="appIcons"
                      :class="{ 'msppIcons-check' : item.guru_sakash, 'msppIcons-x' : !item.guru_sakash }"></span>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Pancajania') }}</div>
                <span v-if="item.pancajania==='no'" class="appIcons msppIcons-x"></span>
                <template v-else><span>{{ pancajaniaTitles[item.pancajania] }}</span></template>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Diary') }}</div>
                <span class="appIcons" :class="{ 'msppIcons-check' : item.diary, 'msppIcons-x' : !item.diary }"></span>
            </div>
            <div class="appForm-group appForm-inline appDiaryModal-notes">
                <div class="appForm-groupTitle">{{ __('Diary notes') }}</div>
                <span class="appDiaryModal-notesText">{{ item.diary_text }}</span>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Meditation') }}</div>
                <span>
                    <span v-if="!item.meditation_count" class="appIcons msppIcons-x"></span>
                    <template v-else><span> {{ item.meditation_count }}</span>
                        <template v-if="timeFormat(item.meditation_time)==0">(<span
                            class="appIcons msppIcons-minus"></span>)</template>
                    <template v-else><span>{{ "(" + timeFormat(item.meditation_time) + ")" }}</span></template>
                    </template>
                </span>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Lalita Marmika') }}</div>
                <span>
                    <span v-if="!item.lalita_marmika_count" class="appIcons msppIcons-x"></span>
                    <template v-else><span> {{ item.lalita_marmika_count }}</span>
                        <template v-if="timeFormat(item.lalita_marmika_time)==0">(<span
                            class="appIcons msppIcons-minus"></span>)</template>
                    <template v-else><span>{{ "(" + timeFormat(item.lalita_marmika_time) + ")" }}</span></template>
                    </template>
                </span>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Asanas') }}</div>
                <span v-if="item.asanas==='no'" class="appIcons msppIcons-x"></span>
                <template v-else><span>{{ asanaTitles[item.asanas] }}</span></template>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Kaosiki') }}</div>
                <span>
                    <span v-if="!item.kaosiki_count" class="appIcons msppIcons-x"></span>
                    <template v-else><span> {{ item.kaosiki_count }}</span>
                        <template v-if="timeFormat(item.kaosiki_time)==0">(<span class="appIcons msppIcons-minus"></span>)</template>
                    <template v-else><span>{{ "(" + timeFormat(item.kaosiki_time) + ")" }}</span></template>
                    </template>
                </span>
            </div>
            <div class="appForm-group appForm-inline" v-if="man">
                <div class="appForm-groupTitle">{{ __('Tandava') }}</div>
                <span>
                    <span v-if="!item.tandava_count" class="appIcons msppIcons-x"></span>
                    <template v-else><span> {{ item.tandava_count }}</span>
                        <template v-if="timeFormat(item.tandava_time)==0">(<span class="appIcons msppIcons-minus"></span>)</template>
                    <template v-else><span>{{ "(" + timeFormat(item.tandava_time) + ")" }}</span></template>
                    </template>
                </span>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Half bath') }}</div>
                <span v-if="item.vyapaka_shaoca==='no'" class="appIcons msppIcons-x"></span>
                <template v-else><span class="appDiaryModal-halfBathText">{{ vyapaka_shaocaTitles[item.vyapaka_shaoca] }}</span></template>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Full Bath') }}</div>
                <span v-if="item.full_bath==='no'" class="appIcons msppIcons-x"></span>
                <template v-else><span>{{ full_bathTitles[item.full_bath] }}</span></template>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Svadhyaya') }}</div>
                <span v-if="timeFormat(item.svadhyaya)==0" class="appIcons msppIcons-minus"></span>
                <template v-else><span>{{ timeFormat(item.svadhyaya) }}</span></template>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Karma Yoga') }}</div>
                <span v-if="timeFormat(item.karma_yoga)==0" class="appIcons msppIcons-minus"></span>
                <template v-else><span>{{ timeFormat(item.karma_yoga) }}</span></template>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Nutrition') }}</div>
                <span v-if="item.aharya==='no'" class="appIcons msppIcons-x"></span>
                <template v-else><span>{{ aharyaTitles[item.aharya] }}</span></template>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('DC') }}</div>
                <span v-if="item.dharmacakra==='no'" class="appIcons msppIcons-x"></span>
                <template v-else>{{ dharmacakraTitles[item.dharmacakra] }}</template>
            </div>
            <div class="appForm-group appForm-inline">
                <div class="appForm-groupTitle">{{ __('Fasting') }}</div>
                <span v-if="item.upavasa==='no'" class="appIcons msppIcons-x"></span>
                <template v-else>{{ upavasaTitles[item.upavasa] }}</template>
            </div>
        </modal-window>
        <modal-window v-if="item && remove" @close="close" @no="close" @ok="destroy(item, itemIndex)"
                      :buttonList="['No', 'Ok']" :windowName="__('Confirmation')">
            <div class="appForm-group">
                <span>{{ __('Are you sure?') }}</span>
            </div>
        </modal-window>

    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js'

    import Textarea from "../../../vue/src/views/forms/form-elements/textarea/Textarea";

    import JQuery from 'jquery';

    let $ = JQuery;

    let moment = require('moment');
    export default {

        props: {
            userId: {
                type: Number
            },
            man: {
                type: Boolean,
                default: false
            },
            new: {
                type: Boolean,
                default: false
            },
            app: {
                type: String,
                default: "app"
            }
        },

        components: {
            flatPickr,
            Textarea
        },

        data() {
            return {
                less768: window.matchMedia("(max-width: 768px)").matches,

                total: 0,
                perPage: 50,
                page: 1,
                items: [],
                item: null,
                editor: null,
                detail: null,
                remove: null,
                itemIndex: null,
                foreign: false,
                userName: null,

                asanaTitles: {},
                pancajaniaTitles: {},
                vyapaka_shaocaTitles: {},
                full_bathTitles: {},
                aharyaTitles: {},
                dharmacakraTitles: {},
                upavasaTitles: {},

                practicePoints: [],
                practiceRanks: [],
                aharya: [],
                asanas: [],
                dharmacakra: [],
                fullbath: [],
                halfbath: [],
                pancajania: [],
                upavasa: [],

                doneDates: [],
                lastDC: null,

                datePickerConfig: {
                    disableMobile: "true",
                    altInput: true,
                    altFormat: 'd-m-y',
                    minDate: new Date().fp_incr(-3),
                    maxDate: moment.now(),
                    disable: [],
                    locale: 'ru'
                },

                practiceTimePicker: {
                    enableTime: true,
                    time_24hr: true,
                    disableMobile: true,
                    noCalendar: true,
                    static: true
                },

                isProcessing: null,
                isFasting: null
            }
        },

        mounted() {
            this.getLists();
            this.getPoints();
            this.$watch('item.date', function (newDate, oldDate) {
                if(this.item && this.item.date) {
                    this.getFasting(newDate);
                    this.getDC(newDate);
                }
            });
            this.getData();
            this.$nextTick(() => {
                if(this.new === 'true') {
                    this.create();
                }
            });
        },

        watch: {
            item(value) {
                if (!value) this.itemIndex = null;
            },

            page() {
                this.getData();
            }
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },

            points() {
                let pointsSum = this.meditationPoints
                    + this.meditationCountPoints
                    + this.lalitaPoints
                    + this.lalitaCountPoints
                    + this.svadhyayaPoints
                    + this.karmayogaPoints
                    + this.dancesPoints
                    + this.diaryPoints
                    + this.pancajaniaPoints
                    + this.asanasPoints
                    + this.halfbathPoints
                    + this.aharyaPoints
                    + this.fullbathPoints
                    + this.dharmacakraPoints
                    + this.upavasaPoints;
                return Math.round(pointsSum * 100) / 100;
            },
            rank() {
                if (this.points < 0) return this.practiceRanks[0].name;
                for (let i = 0; i < this.practiceRanks.length - 1; i++) {
                    if (this.points >= this.practiceRanks[i].points && this.points < this.practiceRanks[i + 1].points)
                        return this.practiceRanks[i].name;
                }
                return this.practiceRanks[this.practiceRanks.length - 1].name;
            },

            meditationPoints() {
                let timeValue = this.item.meditation_time;
                let practice = this.practicePoints.meditation_time;

                let timeInHours = moment(timeValue, 'HH:mm:ss').get('minute') / 60 + moment(timeValue, 'HH:mm:ss').get('hour');
                let timeRoundedToTwo = Math.round(timeInHours * 100) / 100;
                let coefficientTime = practice['time'];
                let coefficientPoints = practice['points'];
                let points = coefficientPoints / (coefficientTime / timeRoundedToTwo);

                if (points === 0) return parseFloat(practice['fee']);
                if (points < coefficientPoints) return points;
                return parseFloat(coefficientPoints);
            },
            meditationCountPoints() {
                let countValue = this.item.meditation_count;
                let practice = this.practicePoints.meditation;

                let coefficientTimes = practice['time'];
                let coefficientPoints = practice['points'];
                let points = coefficientPoints / (coefficientTimes / countValue);

                if (points === 0) return parseFloat(practice['fee']);
                if (points < coefficientPoints) return points;
                return parseFloat(coefficientPoints);
            },
            lalitaPoints() {
                let timeValue = this.item.lalita_marmika_time;
                let practice = this.practicePoints.lalita_marmika_time;

                let timeInHours = moment(timeValue, 'HH:mm:ss').get('minute') / 60 + moment(timeValue, 'HH:mm:ss').get('hour');
                let timeRoundedToTwo = Math.round(timeInHours * 100) / 100;
                let coefficientTime = practice['time'];
                let coefficientPoints = practice['points'];
                let points = coefficientPoints / (coefficientTime / timeRoundedToTwo);

                if (points === 0) return parseFloat(practice['fee']);
                if (points < coefficientPoints) return points;
                return parseFloat(coefficientPoints);
            },
            lalitaCountPoints() {
                let countValue = this.item.lalita_marmika_count;
                let practice = this.practicePoints.lalita_marmika;

                let coefficientTimes = practice['time'];
                let coefficientPoints = practice['points'];
                let points = coefficientPoints / (coefficientTimes / countValue);

                if (points === 0) return parseFloat(practice['fee']);
                if (points < coefficientPoints) return points;
                return parseFloat(coefficientPoints);
            },
            svadhyayaPoints() {
                let timeValue = this.item.svadhyaya;
                let practice = this.practicePoints.svadhyaya;

                let timeInHours = moment(timeValue, 'HH:mm:ss').get('minute') / 60 + moment(timeValue, 'HH:mm:ss').get('hour');
                let timeRoundedToTwo = Math.round(timeInHours * 100) / 100;
                let coefficientTime = practice['time'];
                let coefficientPoints = practice['points'];
                let points = coefficientPoints / (coefficientTime / timeRoundedToTwo);

                if (points === 0) return parseFloat(practice['fee']);
                if (points < coefficientPoints) return points;
                return parseFloat(coefficientPoints);
            },
            karmayogaPoints() {
                let timeValue = this.item.karma_yoga;
                let practice = this.practicePoints.karma_yoga;

                let timeInHours = moment(timeValue, 'HH:mm:ss').get('minute') / 60 + moment(timeValue, 'HH:mm:ss').get('hour');
                let timeRoundedToTwo = Math.round(timeInHours * 100) / 100;
                let coefficientTime = practice['time'];
                let coefficientPoints = practice['points'];
                let points = coefficientPoints / (coefficientTime / timeRoundedToTwo);

                if (points === 0) return parseFloat(practice['fee']);
                if (points < coefficientPoints) return points;
                return parseFloat(coefficientPoints);
            },
            dancesPoints() {
                let timeValue = this.item.kaosiki_time;
                let timeInHours = moment(timeValue, 'HH:mm:ss').get('minute') / 60 + moment(timeValue, 'HH:mm:ss').get('hour');
                timeValue = this.item.tandava_time;
                timeInHours += moment(timeValue, 'HH:mm:ss').get('minute') / 60 + moment(timeValue, 'HH:mm:ss').get('hour');

                let practice = this.practicePoints.dances;

                let timeRoundedToTwo = Math.round(timeInHours * 100) / 100;
                let coefficientTime = practice['time'];
                let coefficientPoints = practice['points'];
                let points = coefficientPoints / (coefficientTime / timeRoundedToTwo);

                if (points === 0) return parseFloat(practice['fee']);
                if (points < coefficientPoints) return points;
                return parseFloat(coefficientPoints);
            },
            diaryPoints() {
                let practice = this.practicePoints.diary;

                if (this.item.diary) {
                    return parseFloat(practice['points']);
                } else {
                    return parseFloat(practice['fee']);
                }
            },
            pancajaniaPoints() {
                let practice = this.pancajania;
                let practiceItem = this.item.pancajania;

                return parseFloat(practice[practiceItem].points);
            },
            asanasPoints() {
                let practice = this.asanas;
                let practiceItem = this.item.asanas;

                return parseFloat(practice[practiceItem].points);
            },
            halfbathPoints() {
                let practice = this.halfbath;
                let practiceItem = this.item.vyapaka_shaoca;

                return parseFloat(practice[practiceItem].points);
            },
            aharyaPoints() {
                let practice = this.aharya;
                let practiceItem = this.item.aharya;

                return parseFloat(practice[practiceItem].points);
            },
            fullbathPoints() {
                let practice = this.fullbath;
                let practiceItem = this.item.full_bath;

                return parseFloat(practice[practiceItem].points);
            },
            dharmacakraPoints() {
                let practice = this.dharmacakra;
                let practiceItem = this.item.dharmacakra;

                if(practiceItem === 'no' && this.lastDC !== null) {
                    let lastPracticeDate = moment(this.lastDC.date);
                    let lastPracticeStatus = this.lastDC.dharmacakra;

                    if( moment(this.item.date).isSameOrBefore(lastPracticeDate.add(6, 'days')) ) return parseFloat(practice[lastPracticeStatus].points);
                }

                return parseFloat(practice[practiceItem].points);
            },
            upavasaPoints() {
                let practice = this.upavasa;
                let practiceItem = this.item.upavasa;

                return parseFloat(practice[practiceItem].points);
            },
        },

        methods: {
            allowToEdit(date) {
                return !moment(date).isBefore(moment().subtract(4, 'days'));
            },

            decreaseByValue(item, name, value) {
                if (item[name] - value <= 0) item[name] = 0;
                else item[name] -= value;
            },

            increaseByValue(item, name, value) {
                item[name] += value;
            },

            increaseTime(item, name, value) {
                var d = moment(item[name], 'HH:mm:ss');
                d.add(value, 'm');
                item[name] = d.format('HH:mm:ss');
            },

            decreaseTime(item, name, value) {
                var d = moment(item[name], 'HH:mm:ss');
                if (d.minutes() - value <= 0 && d.hours() === 0) {
                    d.minutes(0);
                } else {
                    d.subtract(value, 'm');
                }
                item[name] = d.format('HH:mm:ss');
            },

            timeChange(time) {
                return moment(time, 'HH:mm:ss').format('HH:mm');
            },

            dateFormat(date) {
                return moment(date).format('DD.MM.YY');
            },
            dateNow() {
                return moment();
            },

            timeFormat(time) {
                if (moment(time, 'HH:mm:ss').hours()) return moment(time, 'HH:mm:ss').format('HH:mm');
                return moment(time, "HH:mm:ss").format('mm');
            },

            getData() {
                let params = {
                    user: this.userId,
                    take: this.perPage,
                    skip: this.skip
                };

                axios.get('/api/daily-practices', {params: params}).then(response => {
                    if(response.data.status !== 'ok') window.location.assign("/");
                    this.items = response.data.items;
                    this.total = response.data.meta.total;
                    this.foreign = response.data.meta.foreign;
                    this.doneDates = response.data.meta.doneDates;
                    this.userName = response.data.meta.name;

                    this.$nextTick(() => {
                        $('.appDiaries [title]').tooltip();
                    });
                });
            },

            getPoints() {
                axios.get('/api/daily-practices?practices').then(response => {
                    this.practiceRanks = response.data.ranks;
                    this.practicePoints = response.data.points;

                    this.aharya = response.data.aharya;
                    this.asanas = response.data.asanas;
                    this.dharmacakra = response.data.dharmacakra;
                    this.fullbath = response.data.fullbath;
                    this.halfbath = response.data.halfbath;
                    this.pancajania = response.data.pancajania;
                    this.upavasa = response.data.upavasa;
                });
            },

            getLists() {
                axios.get('/api/daily-practices?lists').then(response => {
                    this.asanaTitles = response.data.asanaTitles;
                    this.pancajaniaTitles = response.data.pancajaniaTitles;
                    this.vyapaka_shaocaTitles = response.data.vyapaka_shaocaTitles;
                    this.full_bathTitles = response.data.full_bathTitles;
                    this.aharyaTitles = response.data.aharyaTitles;
                    this.dharmacakraTitles = response.data.dharmacakraTitles;
                    this.upavasaTitles = response.data.upavasaTitles;
                });
            },

            getFasting(date) {
                axios.get('/api/daily-practices?fasting&date=' + date).then(response => {
                    if (response.data !== 2) {
                        this.item.upavasa = response.data;
                        this.isFasting = 0;
                    } else if (this.item) {
                        this.item.upavasa = 'no';
                        this.isFasting = 1;
                    }
                });
            },

            getDC(date) {
                axios.get('/api/daily-practices?dharmacakra&date=' + date).then(response => {
                    this.lastDC = response.data.lastDC;
                });
            },

            create() {
                let item = {
                    'id': null,
                    'date': null,
                    'diary': false,
                    'diary_text': '',
                    'guru_sakash': false,
                    'pancajania': 'no',
                    'meditation_count': 0,
                    'meditation_time': moment('00:00', 'HH:mm').format('HH:mm'),
                    'lalita_marmika_count': 0,
                    'lalita_marmika_time': moment('00:00', 'HH:mm').format('HH:mm'),
                    'asanas': 'no',
                    'kaosiki_count': 0,
                    'kaosiki_time': moment('00:00', 'HH:mm').format('HH:mm'),
                    'tandava_count': 0,
                    'tandava_time': moment('00:00', 'HH:mm').format('HH:mm'),
                    'vyapaka_shaoca': 'no',
                    'full_bath': 'no',
                    'svadhyaya': moment('00:00', 'HH:mm').format('HH:mm'),
                    'karma_yoga': moment('00:00', 'HH:mm').format('HH:mm'),
                    'aharya': 'no',
                    'dharmacakra': 'no',
                    'upavasa': 'no',
                    'points': 0,
                    'rank': null
                };
                this.datePickerConfig.disable = JSON.parse(JSON.stringify(this.doneDates));
                this.editor = 1;

                this.item = item;
            },

            save() {
                if (!this.item.date || this.isProcessing) return;
                this.item.rank = this.rank;
                this.item.points = this.points;
                if (!this.isProcessing) {
                    this.isProcessing = 1;
                    axios.post('/api/daily-practices', {item: this.item}).then(response => {
                        if (this.itemIndex) {
                            this.items[this.itemIndex] = JSON.parse(JSON.stringify(this.item));
                        } else {
                            this.getData();
                        }
                        this.item = null;
                        this.editor = null;
                        this.detail = null;
                        this.isProcessing = null;
                    }).catch(error => {
                        console.log(error);
                    });
                }
            },

            edit(item, index) {
                this.datePickerConfig.disable = JSON.parse(JSON.stringify(this.doneDates));
                this.item = JSON.parse(JSON.stringify(item));
                let enableDate = this.datePickerConfig.disable.indexOf(this.item.date);
                if (enableDate > -1) this.datePickerConfig.disable.splice(enableDate, 1);
                this.itemIndex = index;
                this.editor = 1;
            },

            details(item, index) {
                this.detail = 1;
                this.item = JSON.parse(JSON.stringify(item));
                this.itemIndex = index;
            },

            close() {
                this.item = null;
                this.editor = null;
                this.detail = null;
                this.remove = null;
            },

            destroyModal(item, index) {
                this.remove = 1;
                this.item = JSON.parse(JSON.stringify(item));
                this.itemIndex = index;
            },
            destroy(item, index) {
                axios.delete('/api/daily-practices/' + item.id).then(() => {
                    this.items.splice(index, 1);
                    this.remove = null;
                    this.getData();
                });
            },
        }
    }
</script>
