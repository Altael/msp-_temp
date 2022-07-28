<template>
    <div class="appDiaryRecord" :class="{'appDiaryRecord-edit': stage > 0 && stage < maxStage}">

        <div class="appDiaryRecord-tools">
            <div class="appDiaryRecord-toolsItems">
                <template v-if="page === 'diary'">
                    <div class="appDiaryRecord-toolsLeft appBtnLink appItemHidden" v-if="stage === 0">
                        <div class="appIcons msppIcons-statistic" @click="page = 'statistics'"></div>
                    </div>
                    <div class="appDiaryRecord-toolsLeft appBtnLink" v-else @click="stage--">
                        <span class="appIcons msppIcons-chevron-left"></span>
                    </div>
                    <div class="appDiaryRecord-toolsCenter" ref="calendar">
                        <div data-input :style="{'pointer-events': {'true': 'auto', 'false': 'none'}[stage === 0 || stage === maxStage]}">{{ dateFormat(dayKey) }}</div>
                    </div>
                    <div class="appDiaryRecord-toolsRight appBtnLink" v-if="stage === 0">
                        <div class="appIcons msppIcons-settings" @click="page = 'settings'"></div>
                    </div>
                    <div class="appDiaryRecord-toolsRight appBtnLink ready" v-else @click="save(true)">
                        <span>&times;</span>
                    </div>
                </template>
                <div class="appDiaryRecord-toolsLeft appBtnLink" v-if="page === 'settings'" @click="page = 'diary'">
                    <span class="appIcons msppIcons-chevron-left"></span> {{ __('Diary settings') }}
                </div>
                <div class="appDiaryRecord-toolsLeft appBtnLink" v-if="page === 'statistics'" @click="page = 'diary'">
                    <span class="appIcons msppIcons-chevron-left"></span> {{ __('Statistics') }}
                </div>
                <div class="appDiaryRecord-toolsLeft appBtnLink" v-if="page === 'practices'" @click="page = 'settings'">
                    <span class="appIcons msppIcons-chevron-left"></span> {{ __('Practices points') }}
                </div>
                <div class="appDiaryRecord-toolsLeft appBtnLink" v-if="page === 'points'" @click="page = 'settings'">
                    <span class="appIcons msppIcons-chevron-left"></span> {{ __('Sattva indicator') }}
                </div>
            </div>
        </div>
        <v-touch @swipeleft="stage < (maxStage-1) && stage !== 0 ? stage++ : stage === 0 && index>0 ? index-- : stage" @swiperight="stage > 1 ? stage-- : stage === 0 ? index++ : stage">
            <div v-if="page ==='diary'" :class="'appDiaryRecordPage' + (stage+1)">
                <div class="appDiaryRecord-progress">
                    <div class="appDiaryRecord-progressBar">
                        <div class="appDiaryRecord-progressMeter" :style="{width: stage * 100 / maxStage + '%'}"></div>
                    </div>
                    <div class="appDiaryRecord-progressSattva">
                        <div class="appDiaryRecord-progressSattvaBarWrapper">
                            <div v-if="item" class="appDiaryRecord-progressSattvaBar" v-for="bar in 50" :class="[{
                                'long': bar === 1 || bar === 20 || bar === 34 || bar === 50,
                                'active': (bar / 50 * 100) <= ((points + 61) / 261 * 100)
                            }, sattvaBarColor(bar, 50)]"></div>
                        </div>
                        <div class="appDiaryRecord-progressSattvaPoints" v-if="item">
                            <!--<div class="appDiaryRecord-progressSattvaPointsValue">
                                <template v-if="stage === 1">{{ numberFormat(diaryPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.diary) }}</template>
                                <template v-if="stage === 2">{{ numberFormat(pancajaniaPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.pancajania) }}</template>
                                <template v-if="stage === 3">{{ numberFormat(lalitaPoints) + numberFormat(lalitaCountPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.lalita_marmika) }}</template>
                                <template v-if="stage === 4">{{ numberFormat(meditationPoints) + numberFormat(meditationCountPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.meditation) }}</template>
                                <template v-if="stage === 5 || stage === 6">{{ numberFormat(dancesPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.dances) }}</template>
                                <template v-if="stage === 7">{{ numberFormat(asanasPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.asanas) }}</template>
                                <template v-if="stage === 8">{{ numberFormat(halfbathPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.halfbath) }}</template>
                                <template v-if="stage === 9">{{ numberFormat(fullbathPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.fullbath) }}</template>
                                <template v-if="stage === 10">{{ numberFormat(svadhyayaPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.svadhyaya) }}</template>
                                <template v-if="stage === 11">{{ numberFormat(karmayogaPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.karma_yoga) }}</template>
                                <template v-if="stage === 12">{{ numberFormat(aharyaPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.aharya) }}</template>
                                <template v-if="stage === 13">{{ numberFormat(dharmacakraPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.dharmacakra) }}</template>
                                <template v-if="stage === 14 && isFasting">{{ numberFormat(upavasaPoints) }} {{ __('out of') }} {{ numberFormat(practicesList.upavasa) }}</template>
                            </div>-->
                            <div class="appDiaryRecord-progressSattvaPointsValue">
                                <template v-if="item">
                                    {{ (difficulty === "hard" ? Math.floor(points + 53.5) : Math.floor(points + 53.5 + 32)) }}&nbsp;{{__('out of') }}&nbsp;{{ difficulty === "hard" ? Math.floor(practicesList.total + 53.5) : Math.floor(practicesList.meditation + practicesList.lalita_marmika + parseInt(practicesList.diary) + 53.5) }}
                                </template>
                            </div>
                            <div class="appDiaryRecord-progressSattvaPointsText">
                                {{ __('practice points') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="appDiaryRecord-content"  :class="{'appDiaryStatus-super': item && diaryPercent>1 && stage === 0}">
                    <template v-if="item !== undefined">
                        <div class="appDiaryRecordPageWrapper" :class="{'withCustomNumpad': isNumpadShow}">
                            <div class="appDiaryRecordPage" v-if="stage === 0 || stage === maxStage">
                                <template v-if="!item">
                                    <div class="appDiaryRecordPage1-image">
                                        <img src="/images/diary-image.png" alt="Diary">
                                    </div>
                                    <div class="appDiaryRecordPage1-title">
                                        <div>{{ __('Fill out sadhana diary') }}</div>
                                        <div>{{ (locale == 'ru') ? 'за&nbsp;' : "" }}{{ relativeDay }}?</div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="appDiaryRecordEdit-summary" :class="{'summaryEdit' : stage === maxStage}">
                                        <div class="appDiaryRecordEdit-summaryGraph">
                                            <div class="appDiaryRecordEdit-summaryGraphPercent">
                                                <div class="appProgressRadial" :class="'appProgressRadial-progress' + diaryPercent">
                                                    <div class="appProgressRadial-overlay">
                                                        <div class="appProgressRadial-overlayPercent">{{ diaryPercent }}%</div>
                                                        <div class="appProgressRadial-overlayText">{{ __('Sattva indicator') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="appDiaryRecordEdit-summaryGraphLine"></div>
                                            <div class="appDiaryRecordEdit-summaryGraphDays">
                                                <div class="appDiaryRecordEdit-summaryGraphDaysNum">{{ streak }}</div>
                                                <div class="appDiaryRecordEdit-summaryGraphDaysTxt">{{ __('days in a row') }}</div>
                                            </div>
                                        </div>
                                        <div v-if="stage === 0" class="appDiaryRecordEdit-summaryGraphRank">
                                            {{ __('Status') }}: {{ __(rank) }}
                                        </div>
                                        <div class="appDiaryRecordEdit-summaryContent">
                                            <div v-if="stage === 0" class="appDiaryRecordEdit-summaryItems">
                                                <div class="appDiaryRecordEdit-summaryBtnStoryWrapper" v-if="reward">
                                                    <div class="appDiaryRecordEdit-summaryBtnStory appBtn " @click="isStory = true">
                                                        <div><img src="/images/gift.png" alt=""></div>
                                                        <div>{{ __('View gift') }}</div>
                                                    </div>
                                                </div>
                                                <div class="appDiaryRecordEdit-summaryItemSeparator"></div>
                                                <div class="appDiaryRecordEdit-summaryItem performed">
                                                    {{ __('Total completed') }} <span>{{ completedPractices }}</span> {{ __('practices') }}
                                                </div>
                                                <div class="appDiaryRecordEdit-summaryItem better" v-if="success >= 10">
                                                    {{ __('Your practice (sadhana) level today is higher that') }} <span>{{ success }}</span><span>%</span> {{ __('of active margiis') }}
                                                </div>
                                                <div class="appDiaryRecordEdit-summaryItem public">
                                                    <span>{{ community }}</span> {{ __('people have filled out the diary with you (in 24 hours)') }}
                                                </div>
                                            </div>
                                            <template v-if="stage === maxStage">
                                                <div class="appDiaryRecordEdit-summaryEnding">
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard'" @click="goTo(1)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryMorningPractices">
                                                                <div class="appCheckbox">
                                                                    <label>
                                                                        <input type="checkbox" class="appCheckbox-noView" v-model="item.guru_sakash">
                                                                        <span class="appCheckboxView"></span>
                                                                        <span class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Guru Sakash') }}</span>
                                                                    </label>
                                                                </div>
                                                                <div class="appCheckbox">
                                                                    <label>
                                                                        <input type="checkbox" class="appCheckbox-noView" v-model="item.phone_sakash">
                                                                        <span class="appCheckboxView"></span>
                                                                        <span class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Phone Sakash') }}</span>
                                                                    </label>
                                                                </div>
                                                                <div class="appCheckbox">
                                                                    <label>
                                                                        <input type="checkbox" class="appCheckbox-noView" v-model="item.oaths">
                                                                        <span class="appCheckboxView"></span>
                                                                        <span class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Oaths') }}</span>
                                                                    </label>
                                                                </div>
                                                                <div class="appCheckbox appItemHidden">
                                                                    <label>
                                                                        <input type="checkbox" class="appCheckbox-noView" v-model="item.guru_mantra">
                                                                        <span class="appCheckboxView"></span>
                                                                        <span class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Guru mantra') }}</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard'" @click="goTo(2)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Pancajania') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                {{ pancajaniaTitles[item.pancajania] }}
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" @click="goTo(3)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Kiirtan') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ item.lalita_marmika_count === 2 ? item.lalita_marmika_count + __(' times') : item.lalita_marmika_count + __(' time') }},&nbsp;</span>
                                                                <span>{{ timeFormat(item.lalita_marmika_time) }} {{ __('minutes') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" @click="goTo(4)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Meditation') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ item.meditation_count === 2 ? item.meditation_count + __(' times') : item.meditation_count + __(' time') }},&nbsp;</span>
                                                                <span>{{ timeFormat(item.meditation_time) }} {{ __('minutes') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard'" @click="goTo(5)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Kaoshiki') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ item.kaosiki_count === 2 ? item.kaosiki_count + __(' times') : item.kaosiki_count + __(' time') }},&nbsp;</span>
                                                                <span>{{ timeFormat(item.kaosiki_time) }} {{ __('minutes') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" @click="goTo(6)" v-if="sex !== 'female' && difficulty === 'hard'">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Tandava') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ item.tandava_count === 2 ? item.tandava_count + __(' times') : item.tandava_count + __(' time') }},&nbsp;</span>
                                                                <span>{{ timeFormat(item.tandava_time) }} {{ __('minutes') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard'" @click="goTo(7)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Asanas') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ asanaTitles[item.asanas] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard'" @click="goTo(8)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Half bath') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ vyapaka_shaocaTitles[item.vyapaka_shaoca] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard'" @click="goTo(9)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Full Bath') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ full_bathTitles[item.full_bath] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard'" @click="goTo(10)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Svadhyaya') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ timeFormat(item.svadhyaya) }} {{ __('minutes') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard'" @click="goTo(11)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Karma Yoga') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ timeFormat(item.karma_yoga) }} {{ __('minutes') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard'" @click="goTo(12)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Nutrition') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ aharyaTitles[item.aharya] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard'" @click="goTo(13)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('DC') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ dharmacakraTitles[item.dharmacakra] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                    <div class="appDiaryRecordEdit-summaryEndingStageLink" v-if="difficulty === 'hard' && isFasting" @click="goTo(14)">
                                                        <div class="appDiaryRecordEdit-summaryEndingStageContent">
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkName">{{ __('Fasting') }}</div>
                                                            <div class="appDiaryRecordEdit-summaryEndingStageLinkValue">
                                                                <span>{{ upavasaTitles[item.upavasa] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="appDiaryRecordEdit-summaryEndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                    </div>
                                </template>
                                <div v-if="stage === 0" class="appDiaryRecordPage1-datePaginator">
                                    <div class="appDiaryRecordPage1-datePaginatorBtn appDiaryRecordPage1-datePaginatorBtnLeft appBtn" @click="prevDay()">
                                    </div>
                                    <div class="appDiaryRecordPage1-datePaginatorBtn appDiaryRecordPage1-datePaginatorBtnRight appBtn" :class="{disabled: index === 0}" @click="nextDay()">
                                    </div>
                                </div>
                                <div class="appDiaryRecordPage1-button">
                                    <span v-if="item && stage === 0" @click="edit()">{{ __('Edit') }}</span>
                                    <span v-if="!item && stage === 0" @click="create(dayKey)">{{ __('Start') }}</span>
                                    <span v-if="stage === maxStage" @click="save()">{{ __('Finish') }}</span>
                                </div>
                            </div>

                            <diary-edit-stage hasHelp :key="index" v-if="stage === 1">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('How your morning started?') }}</div>
                                    <div class="dhrtCheckbox stage1">
                                        <label class="appDiaryRecordPage-guruSakash">
                                            <input type="checkbox" class="appCheckbox-noView" v-model="item.guru_sakash">
                                            <span class="appCheckboxView"></span>
                                            <span class="appCheckbox-label">{{ __('Guru Sakash') }}</span>
                                        </label>
                                        <label class="appDiaryRecordPage-phoneSakash">
                                            <input type="checkbox" class="appCheckbox-noView" v-model="item.phone_sakash">
                                            <span class="appCheckboxView"></span>
                                            <span class="appCheckbox-label">{{ __('Phone Sakash') }}</span>
                                        </label>
                                        <label class="appDiaryRecordPage-Oaths">
                                            <input type="checkbox" class="appCheckbox-noView" v-model="item.oaths">
                                            <span class="appCheckboxView"></span>
                                            <span class="appCheckbox-label">{{ __('Oaths') }}</span>
                                        </label>
                                        <label class="appDiaryRecordPage-GuruMantrs appItemHidden">
                                            <input type="checkbox" class="appCheckbox-noView" v-model="item.guru_mantra">
                                            <span class="appCheckboxView"></span>
                                            <span class="appCheckbox-label">{{ __('Guru mantra') }}</span>
                                        </label>
                                        <label class="appDiaryRecordPage-morningAll">
                                            <input type="checkbox" class="appCheckbox-noView" v-model="allMorning">
                                            <span class="appCheckboxView"></span>
                                            <span class="appCheckbox-label">{{ __('Check all') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <template #help>
                                    Гуру Сакаш – короткая медитация, выполняемая сразу после пробуждения. <br><br>Панчаджанья – утренняя практика коллективной или индивидуальной медитации, выполняемая в 05:00.
                                </template>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 2">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('Pancajania') }}</div>
                                    <div class="dhrtCheckbox">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.pancajania" value="no">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.pancajania" value="yes_and_sleep">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Yes, but took a nap') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.pancajania" value="yes">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Yes') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 3">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('Kiirtan') }}</div>
                                    <div class="dhrtCheckbox" :class="{'withCustomNumpad': isNumpadShow}">
                                        <label>
                                            <input type="radio" class="appRadio-noView"  v-model.number="item.lalita_marmika_count" value="0">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model.number="item.lalita_marmika_count" value="1">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('One time') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model.number="item.lalita_marmika_count" value="2">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Two times') }} {{ __('and counting') }}</span>
                                        </label>
                                    </div>
                                    <custom-numpad :key="'lalita_marmika'" v-if="item.lalita_marmika_count" practice="lalita_marmika_time">
                                        <template #question>{{ __('How much time?') }}</template>
                                    </custom-numpad>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 4">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('Meditation') }}</div>
                                    <div class="dhrtCheckbox" :class="{'withCustomNumpad': isNumpadShow}">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model.number="item.meditation_count" value="0">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model.number="item.meditation_count" value="1">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('One time') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model.number="item.meditation_count" value="2">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Two times') }} {{ __('and counting') }}</span>
                                        </label>
                                    </div>
                                    <custom-numpad :key="'meditation'" v-if="item.meditation_count" practice="meditation_time">
                                        <template #question>{{ __('How much time?') }}</template>
                                    </custom-numpad>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 5">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('Kaoshiki') }}</div>
                                    <div class="dhrtCheckbox stage5" :class="{'withCustomNumpad': isNumpadShow}">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model.number="item.kaosiki_count" value="0">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model.number="item.kaosiki_count" value="1">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('One time') }} {{ __('and counting') }}</span>
                                        </label>
                                    </div>
                                    <custom-numpad :key="'kaosiki'" v-if="item.kaosiki_count" practice="kaosiki_time">
                                        <template #question>{{ __('How much time?') }}</template>
                                    </custom-numpad>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 6">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('Tandava') }}</div>
                                    <div class="dhrtCheckbox stage6" :class="{'withCustomNumpad': isNumpadShow}">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model.number="item.tandava_count" value="0">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model.number="item.tandava_count" value="1">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('One time') }} {{ __('and counting') }}</span>
                                        </label>
                                    </div>
                                    <custom-numpad :key="'tandava'" v-if="item.tandava_count" practice="tandava_time">
                                        <template #question>{{ __('How much time?') }}</template>
                                    </custom-numpad>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 7">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('Asanas') }}</div>
                                    <div class="dhrtCheckbox">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.asanas" value="no">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.asanas" value="morning">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Morning') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.asanas" value="evening">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Evening') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.asanas" value="morning_and_evening">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Twice') }}</span>
                                        </label>
                                        <label v-if="!man">
                                            <input type="radio" class="appRadio-noView" v-model="item.asanas" value="period">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Woman period') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 8">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('Did you do half bath?') }}</div>
                                    <div class="dhrtCheckbox stage8">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.vyapaka_shaoca" value="no">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.vyapaka_shaoca" value="before_all">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Before everything') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView"
                                                   v-model="item.vyapaka_shaoca" value="before_sadhana_and_eat_or_sleep">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Before sadhana and either eating or sleeping') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.vyapaka_shaoca" value="before_any">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Before eating, sadhana or sleeping') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 9">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">
                                        {{ __('Full Bath') }}
                                    </div>
                                    <div class="dhrtCheckbox">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.full_bath" value="no">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.full_bath" value="warm">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Warm') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.full_bath" value="cold">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Cold') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.full_bath" value="contrast">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Contrast') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 10">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">
                                        {{ __('Svadhyaya') }}
                                    </div>
                                    <div class="dhrtCheckbox">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.svadhyaya" value="00:00:00">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.svadhyaya" :value="'00:' + (practicePoints.svadhyaya.time * 60 / 3 * 1) + ':00'">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ practicePoints.svadhyaya.time * 60 / 3 * 1 }} {{ __('minutes') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.svadhyaya" :value="'00:' + (practicePoints.svadhyaya.time * 60 / 3 * 2) + ':00'">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ practicePoints.svadhyaya.time * 60 / 3 * 2 }} {{ __('minutes') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.svadhyaya" :value="'00:' + (practicePoints.svadhyaya.time * 60 / 3 * 3) + ':00'">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ practicePoints.svadhyaya.time * 60 / 3 * 3 }} {{ __('minutes') }} {{ __('and counting') }}</span>
                                        </label>
                                    </div></div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 11">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">
                                        {{ __('Karma Yoga') }}
                                    </div>
                                    <div class="dhrtCheckbox">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.karma_yoga" value="00:00:00">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.karma_yoga" :value="'00:' + (practicePoints.karma_yoga.time * 60 / 3 * 1) + ':00'">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ practicePoints.karma_yoga.time * 60 / 3 * 1 }} {{ __('minutes') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.karma_yoga" :value="'00:' + (practicePoints.karma_yoga.time * 60 / 3 * 2) + ':00'">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ practicePoints.karma_yoga.time * 60 / 3 * 2 }} {{ __('minutes') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.karma_yoga" :value="'00:' + (practicePoints.karma_yoga.time * 60 / 3 * 3) + ':00'">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ practicePoints.karma_yoga.time * 60 / 3 * 3 }} {{ __('minutes') }} {{ __('and counting') }}</span>
                                        </label>
                                    </div></div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 12">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('Nutrition') }}</div>
                                    <div class="dhrtCheckbox">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.aharya" value="no">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.aharya" value="sattva_norm">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Sattvika') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.aharya" value="sattva_much">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Sattvika with overeaten') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.aharya" value="rajah">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Rajasika') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.aharya" value="tamah">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Tamasika') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 13">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('Last dharmacakra') }}</div>
                                    <div class="dhrtCheckbox">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.dharmacakra" value="participated">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Participated') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.dharmacakra" value="had_duty">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Helped organize') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.dharmacakra" value="no">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Didn\'t participate') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp :key="index" v-if="stage === 14 && isFasting">
                                <div class="appDiaryRecordPageContent">
                                    <div class="appDiaryRecordPage-title">{{ __('Fasting') }}</div>
                                    <div class="dhrtCheckbox">
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.upavasa" value="no">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.upavasa" value="dry">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Dry fasting') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.upavasa" value="water">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Fasting with water') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="appRadio-noView" v-model="item.upavasa" value="juices_fruits">
                                            <span class="appRadioView"></span>
                                            <span class="appCheckbox-label">{{ __('Fasting with juices and fruits') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                        </div>
                    </template>

                </div>
            </div>
        </v-touch>
        <div v-if="page === 'settings'" class="appDiaryRecord-settings">
            <!--<div class="appDiaryRecord-settingsGroup">
                <div class="appDiaryRecord-settingsGroupItem">{{ __('Choose practices') }}</div>
            </div>
            <div class="appDiaryRecord-settingsGroup">
                <div class="appDiaryRecord-settingsGroupTitle">{{ __('Information') }}</div>
                <div class="appDiaryRecord-settingsGroupItem">{{ __('Instructions') }}</div>
                <div class="appDiaryRecord-settingsGroupItem" @click="page = 'practices'">{{ __('Points for practices') }}</div>
                <div class="appDiaryRecord-settingsGroupItem" @click="page = 'points'">{{ __('Sattva indicator') }}</div>
            </div>-->
            <div class="appDiaryRecord-content">
                <div class="appDiaryRecord-settingsPlan">
                    <div class="appDiaryRecordPage-title">{{ __('Choose your practices plan') }}</div>
                    <div class="dhrtCheckbox">
                        <label>
                            <input type="radio" class="appRadio-noView" v-model="difficulty" value="light">
                            <span class="appRadioView"></span>
                            <span class="appCheckbox-label">{{ __('Light') }}</span>
                        </label>
                        <label>
                            <input type="radio" class="appRadio-noView" v-model="difficulty" value="hard">
                            <span class="appRadioView"></span>
                            <span class="appCheckbox-label">{{ __('Hard') }}</span>
                        </label>
                    </div>
                </div>
            </div>

        </div>
        <div class="appDiaryRecord-practices" v-if="page === 'practices'">
            <div class="appDiaryRecord-practicesTitle">{{ __('All practices summary:') }} {{ practicesList.total }}</div>
            <div class="appDiaryRecord-practicesList">
                <div class="appDiaryRecord-practicesListItem" v-for="(points, practice) in practicesList" v-if="practice !== 'total'">
                    {{ __(practicesTitles[practice]) }}: {{ points }}
                </div>
            </div>
        </div>
        <div class="appDiaryRecord-statistics" v-if="page === 'statistics'">
            <div class="appDiaryRecord-statisticsSwitch">
                <div class="appDiaryRecord-statisticsSwitchQuotes" :class="{'active': rewardsMode === 'quotes'}" @click="rewardsMode = 'quotes'">{{ __('Quotes') }}</div>
                <div class="appDiaryRecord-statisticsSwitchStories" :class="{'active': rewardsMode === 'stories'}" @click="rewardsMode = 'stories'">{{ __('Stories') }}</div>
            </div>
            <div class="appDiaryRecord-statisticsRewardsList">
                <div class="appDiaryRecord-statisticsRewardsListReward" v-for="reward of (rewardsMode === 'quotes' ? quotes : stories)">
                    {{ dateFormat(reward.date) }}
                    {{ reward.text }}
                    {{ reward.author }}
                </div>
            </div>
        </div>
        <div class="appDiaryRecord-points" v-if="page === 'points'">
            <div class="appDiaryRecord-pointsHead">
                {{ __('Points') }}
                {{ __('Name') }}
                {{ __('Fill percent') }}
            </div>
            <div class="appDiaryRecord-pointsBody">
                <div class="appDiaryRecord-pointsBodySattvaBarWrapper">
                    <div class="appDiaryRecord-pointsBodySattvaBar" v-for="bar in 169" :class="[{
                        'long': (bar - 1) % 6 === 0,
                        'active': true
                    }, sattvaBarColor(bar, 169)]"></div>
                </div>
                <div class="appDiaryRecord-pointsBodyTable">
                    <div class="appDiaryRecord-pointsBodyTableLine" v-for="rank in practiceRanks">
                        {{ Math.trunc(rank.points) }}
                        {{ rank.name }}
                        {{ Math.trunc(rank.percent * 100) }}%
                    </div>
                </div>
            </div>
        </div>
        <modal-window v-if="isStory"
                      @close="close"
                      @enter="close"
                      :buttonList="['Close']"
                      :windowName="__('Story')" customId="appDiaryRecordStoryModal">
            <div class="appDiaryRecordStoryModal">
                <span v-html="reward[locale]"></span>
            </div>
        </modal-window>

    </div>
</template>

<script>
    let moment = require('moment');

    import VueTouch from 'vue-touch';

    export default {
        props: ['locale', 'man'],

        data() {
            return {
                page: 'diary',
                rewardsMode: 'quotes',
                straightForward: true,
                difficulty: "light",

                index: 0,
                stage: 0,
                isStory: false,
                items: [],
                item: null,
                process: null,
                sex: 'male',
                mobile: false,
                isNumpadShow: false,

                asanaTitles: {},
                pancajaniaTitles: {},
                vyapaka_shaocaTitles: {},
                full_bathTitles: {},
                aharyaTitles: {},
                dharmacakraTitles: {},
                upavasaTitles: {},
                practicesTitles: {},

                practicePoints: [],
                practiceRanks: [],
                aharya: [],
                asanas: [],
                dharmacakra: [],
                fullbath: [],
                halfbath: [],
                pancajania: [],
                upavasa: [],
                practicesList: [],

                lastDC: null,
                isFasting: null,
                streak: 0,
                community: 0,
                success: 0,
                reward: null,

                quotes: [],
                stories: [],

                pickr: null,
                allMorning: false
            }
        },

        mounted() {
            this.getLists();
            this.getPoints();
            this.$watch('item.date', function (newDate, oldDate) {
                if(this.item && this.item.date) {
                    this.getFasting(newDate);
                    this.getDC(newDate);
                    this.getReward(newDate);
                }
            });
            this.getData();
            this.getStreak();
            this.getCommunity();
            let that = this;
            this.pickr = flatpickr(this.$refs.calendar, {
                maxDate: moment().format(),
                onChange: function(selectedDates, dateStr, instance) {
                    that.index = moment().diff(moment(dateStr), 'days');
                },
                wrap: true,
                disableMobile: true
            });
            this.getQuotes();
            this.getStories();
        },

        computed: {
            maxStage() {
                return this.isFasting ? 15 : 14;
            },
            diaryPercent() {
                let max = this.difficulty === "hard" ? 261 : this.practicesList.meditation + this.practicesList.lalita_marmika + parseInt(this.practicesList.diary) + 53.5
                let percent = Math.round(100 * (this.points + 53.5 + (this.difficulty === "hard" ? 0 : 32)) / max);

                return percent;
            },
            dayKey() {
                return moment().subtract(this.index, 'days').format('YYYY-MM-DD');
            },
            dateDayFormat() {
                return moment().locale(this.locale).subtract(this.index, 'days').format('DD MMM dddd');
            },
            relativeDay() {
                switch(this.index) {
                    case 0:
                        return this.__('today');
                    case 1:
                        return this.__('yesterday');
                    default:
                        return this.dateDayFormat;
                }
            },
            chosenDateMonth() {
                return moment(this.dayKey).month();
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

            completedPractices() {
                let result = 0;

                if (this.item.guru_sakash) result++;
                if (this.item.oaths) result++;
                if (this.item.guru_mantra) result++;
                if (this.item.pancajania !== 'no') result++;
                if (this.item.meditation_count !== 0) result++;
                if (this.item.lalita_marmika_count !== 0) result++;
                if (this.item.asanas !== 'no') result++;
                if (this.item.kaosiki_count !== 0) result++;
                if (this.item.tandava_count !== 0) result++;
                if (this.item.vyapaka_shaoca !== 'no') result++;
                if (this.item.full_bath !== 'no') result++;
                if (this.item.svadhyaya !== '00:00' && this.item.svadhyaya !== '00:00:00') result++;
                if (this.item.karma_yoga !== '00:00' && this.item.karma_yoga !== '00:00:00') result++;
                if (this.item.aharya !== 'no') result++;
                if (this.item.dharmacakra !== 'no') result++;
                if (this.item.upavasa !== 'no') result++;

                return result;
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
                /*let practice = this.practicePoints.diary;

                if (this.item.diary) {
                    return parseFloat(practice['points']);
                } else {
                    return parseFloat(practice['fee']);
                }*/

                return 6.5;
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

        watch: {
            index() {
                this.item = this.items[this.dayKey];
                this.allMorning = false;
            },

            chosenDateMonth() {
                this.getData();
            },

            allMorning(newVal, oldVal) {

                this.item.guru_sakash = this.allMorning;
                this.item.phone_sakash = this.allMorning;
                this.item.oaths = this.allMorning;
                this.item.guru_mantra = this.allMorning;

            },

            stage(newStage, oldStage) {
                if(this.stage === 6 && this.sex === 'female') {
                    this.stage = 7;
                }
                if(this.difficulty === 'light') {
                    if(this.stage === 1 || this.stage === 2) this.stage = 3;
                    if(this.stage > 4) this.stage = this.maxStage;
                }
                this.saveCookie();
                let reload = false;
                if(newStage === 0) {
                    this.$root.diaryEdit = false;
                } else {
                    this.$root.diaryEdit = true;
                }
                if(oldStage === 0 && newStage === this.maxStage) return;
                if(newStage === 0) reload = true;
                this.save(reload);
            },

            items(newVal, oldVal) {
                if(newVal && !oldVal.length) {
                    if($cookies.isKey('diary')) {
                        let diaryInfo = $cookies.get('diary');
                        this.index = diaryInfo.dayIndex;
                        this.$nextTick(() => {
                            if(!this.item) {
                                this.create(this.dayKey);
                            }
                            this.stage = diaryInfo.stage;
                        });
                    }
                }
            },

            difficulty(newVal, oldVal) {
                axios.post('/set-practices-difficulty', {'diff': newVal}).then( response => {

                });
            },

            'item': {
                handler: function() {

                },
                deep: true
            }
        },

        methods: {
            testS() {
                alert('test');
            },

            getData() {
                axios.get('/api/daily-practices?alt&date=' + moment().subtract(this.index, 'days').format('YYYY-MM-DD')).then(response => {
                    this.items = response.data.items;
                    this.sex = response.data.meta.sex;
                    this.mobile = response.data.meta.mobile_connected;
                    this.item = this.items[this.dayKey];
                    this.difficulty = response.data.meta.difficulty;
                    this.$nextTick(() => {
                        $('.appDiaries [title]').tooltip();
                    });
                });
            },

            getQuotes() {
                axios.get('/reward/quote').then(response => {
                    this.quotes = response.data.owned_quotes;
                });
            },

            getStories() {
                axios.get('/reward/story').then(response => {
                    this.stories = response.data.owned_stories;
                });
            },

            dateFormat(date) {
                return moment(date).format('DD.MM.YYYY')
            },

            prevDay() {
                this.index++;
            },

            nextDay() {
                if(this.index>0) this.index--;
            },

            close() {
                this.isStory = false;
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
                    this.practicesList = response.data.practices;
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
                    this.practicesTitles = response.data.practiceTitles;
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

            getReward(date) {
                axios.get('/api/daily-practices?reward&date=' + date).then(response => {
                    this.reward = response.data.reward;
                });
            },

            getStreak() {
                axios.get('/api/daily-practices?streak').then(response => {
                    this.streak = response.data.streak;
                });
            },

            getCommunity() {
                axios.get('/api/daily-practices?community').then(response => {
                    this.community = response.data.community;
                    this.success = Math.trunc(response.data.success);
                });
            },

            create(date) {
                this.item = {
                    'id': null,
                    'date': moment(date).format('YYYY-MM-DD'),
                    'diary': false,
                    'diary_text': '',
                    'guru_sakash': false,
                    'oaths': false,
                    'guru_mantra': false,
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
                this.getUM();
                this.stage = 1;
                this.process = "creating";
            },

            getUM() {
                let day = this.item.date;
                if(this.mobile) {
                    axios.get('/get-user-practices?start=' + day + '&end=' + day).then(response => {
                        let practices = response.data[0];

                        let meditation_time_sec = practices.practices.meditation;
                        let meditation_count = practices.practices_t.meditation;
                        let kirtan_time_sec = practices.practices.kirtan;
                        let kirtan_count = practices.practices_t.kirtan;

                        let meditation_time = moment(Math.trunc(meditation_time_sec / 3600) + ':' + Math.trunc((meditation_time_sec % 3600) / 60), 'HH:mm').format('HH:mm');
                        let kirtan_time = moment(Math.trunc(kirtan_time_sec / 3600) + ':' + Math.trunc((kirtan_time_sec % 3600) / 60), 'HH:mm').format('HH:mm');

                        let current_meditation_time_sec = moment(this.item.meditation_time, 'HH:mm:ss').hour() * 60 * 60 + moment(this.item.meditation_time, 'HH:mm:ss').minute() * 60;
                        let current_lalita_marmika_time_sec = moment(this.item.lalita_marmika_time, 'HH:mm:ss').hour() * 60 * 60 + moment(this.item.lalita_marmika_time, 'HH:mm:ss').minute() * 60;



                        if(meditation_count) {
                            this.item.meditation_count = meditation_count >= 2 ? 2 : meditation_count;
                            if(current_meditation_time_sec < meditation_time_sec) {
                                if(meditation_time !== '00:00') this.item.meditation_time = meditation_time;
                            }
                        }

                        if(kirtan_count) {
                            this.item.lalita_marmika_count = kirtan_count >= 2 ? 2 : kirtan_count;
                            if(current_lalita_marmika_time_sec < meditation_time_sec) {
                                if(kirtan_time !== '00:00') this.item.lalita_marmika_time = kirtan_time;
                            }
                        }
                    }).catch(error => {
                        console.log(error);
                    })
                }
            },

            save(reload = true) {
                if (this.isProcessing) return;
                if (reload) this.stage = 0;
                this.item.rank = this.rank;
                this.item.points = this.points;
                if (!this.isProcessing) {
                    this.isProcessing = 1;
                    axios.post('/api/daily-practices', {item: this.item}).then(response => {
                        this.items[this.item.date] = JSON.parse(JSON.stringify(this.item));
                        this.item = this.items[this.dayKey]
                        this.editor = null;
                        this.detail = null;
                        if(reload) this.process = null;
                        this.isProcessing = null;
                        if(reload) this.deleteCookie();
                        this.getStreak();
                        this.getCommunity();
                    }).catch(error => {
                        console.log(error);
                    });
                }
            },

            edit() {
                this.getUM();
                this.stage = this.maxStage;
            },

            timeFormat(time) {
                return moment.duration(time).asMinutes();
            },

            proceed() {
                /*if(this.process === "creating") this.stage++;
                else this.stage = this.maxStage;*/
                this.stage++;
            },

            goTo(stage) {
                this.processing = "editing";
                this.stage = stage;
            },

            saveCookie() {
                $cookies.set('diary', {
                    stage: this.stage,
                    dayIndex: this.index
                }, '1d');
            },

            deleteCookie() {
                $cookies.remove('diary');
            },

            sattvaBarColor(index, max) {
                if(index / max < 0.40) return 'red';
                if(index / max < 0.68) return 'yellow';
                return 'green';
            },

            numberFormat(x) {
                return Math.round(x%1 + Math.trunc(x))
            }
        }
    }
</script>

<style>
    input[type='date'] {
        transform: scale(0);
        position: absolute;
    }
</style>
