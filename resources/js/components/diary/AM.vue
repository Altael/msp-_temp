<template>
    <div id="amDiary" class="withoutSattvaPoints" :class="{'amDiary-edit': stage > 0 && stage < maxStage, 'summaryEdit' : stage === maxStage, 'summaryView': (stage === 0 && item), 'newDay': !item, 'settings': page.substring(0,8) === 'settings', 'withCustomNumpad': isNumpadShow}">
        <div class="amDiary-tools">
            <div class="amDiary-toolsItems">
                <div class="amDiary-toolsLeft appBtnLink">
                    <div class="amDiary-toolsSettingsLink" v-if="stage === 0" @click="page = 'settings'">
                        <span class="appIcons msppIcons-settings"></span>
                    </div>
                    <div class="amDiary-toolsLeftItem" v-if="page === 'settings'" @click="page = 'diary'">
                        <span class="appIcons msppIcons-chevron-left"></span> {{ __('Diary settings') }}
                    </div>
                    <div class="amDiary-toolsLeftItem" v-else-if="page === 'settingsStatistics'" @click="page = 'settings'">
                        <span class="appIcons msppIcons-chevron-left"></span> {{ __('Statistics') }}
                    </div>
                    <div class="amDiary-toolsLeftItem" v-else-if="page === 'settingsPractices'" @click="page = 'settings'">
                        <span class="appIcons msppIcons-chevron-left"></span> {{ __('Practices points') }}
                    </div>
                    <div class="amDiary-toolsLeftItem" v-else-if="page === 'settingsPoints'" @click="page = 'settings'">
                        <span class="appIcons msppIcons-chevron-left"></span> {{ __('Sattva indicator') }}
                    </div>
                    <div class="amDiary-toolsLeftItem" v-else-if="page === 'settingsPlan'" @click="page = 'settings'">
                        <span class="appIcons msppIcons-chevron-left"></span> {{ __('Practices plan') }}
                    </div>
                    <div class="amDiary-toolsLeftItem" v-else-if="stage === 0" @click="page = 'settingsStatistics'">
                        <div class="appIcons msppIcons-statistic appItemHidden" ></div>
                    </div>
                    <div class="amDiary-toolsLeftItem" v-else-if="stage !== maxStage" @click="stage--">
                        <span class="appIcons msppIcons-chevron-left"></span>
                    </div>
                </div>
                <template v-if="page === 'diary'">
                    <div class="amDiary-toolsCenter" ref="calendar">
                        <div data-input :style="{'pointer-events': {'true': 'auto', 'false': 'none'}[stage === 0]}">{{ dateFormat(dayKey) }}</div>
                        <div v-if="calendarOpen" class="msppIcons-chevron-up"></div>
                        <div v-else class="amDiary-toolsCalendarBtn msppIcons-chevron-down"></div>
                    </div>
                    <div class="amDiary-toolsRight">

                        <div class="amDiary-toolsRightAction Ready" v-if="item && (stage > 0 && stage < maxStage)" @click="save(true)">{{ __('Ready') }}</div>
                        <div class="amDiary-toolsRightAction Change" v-if="item && stage === 0" @click="edit()">{{ __('Change') }}</div>
                        <div class="amDiary-toolsRightAction Start" v-if="!item && stage === 0" @click="create(dayKey); stage = maxStage"><div class="msppIcons-add-circle"></div></div>
                        <div class="amDiary-toolsRightAction Finish" v-if="stage === maxStage" @click="save()">{{ __('Finish') }}</div>
                    </div>


                </template>
            </div>
        </div>
        <v-touch class="amDiaryTouch" @swipeleft="stage < (maxStage-1) && stage !== 0 ? stage++ : stage === 0 && index>0 ? index-- : stage" @swiperight="stage > 1 ? stage-- : stage === 0 ? index++ : stage">
            <div v-if="page ==='diary'" :class="'amDiaryStage' + (stage+1)">
                <div class="amDiary-progress" v-if="(stage < maxStage) && stage">
                    <div class="amDiary-progressSattva">
                        <div class="amDiary-progressSattvaText">
                            {{ __('sattva indicator') }}
                        </div>
                        <div class="amDiary-progressSattvaBar">
                            <div v-if="item" class="amDiary-progressSattvaBarItem" v-for="bar in 50" :class="[{
                                'long': bar === 1 || bar === 20 || bar === 34 || bar === 50,
                                'active': (bar / 50 * 100) <= (difficulty === 'hard' ?  ((points + 72) / 275 * 100) : ((points + 53.5) / 106 * 100))
                            }, sattvaBarColor(bar, 50)]"></div>
                        </div>
                        <div class="amDiary-progressSattvaPoints" v-if="item">
                            <!--<div class="amDiary-progressSattvaPointsValue">
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
                            <div class="amDiary-progressSattvaPointsValue">
                                {{ (difficulty === "hard" ?
                                Math.round(points + 53.5 + 5 + 7) :
                                Math.floor(points + 53.5 )) }}&nbsp;
                                {{__('out of') }}&nbsp;
                                {{ difficulty === "hard" ?
                                Math.floor(practicesList.total + 75 ) :
                                106
                                }}
                            </div>
                            <div class="amDiary-progressSattvaPointsText">
                                {{ __('practice points') }}
                            </div>
                        </div>
                    </div>
                    <div class="amDiary-progressBar">
                        <div class="amDiary-progressBarMeter" :style="{width: stage * 100 / maxStage + '%'}"></div>
                    </div>

                </div>
                <div class="amDiary-content">
                    <template v-if="item !== undefined && loaded">
                        <div class="amDiaryPage curPage " v-if="stage === 0 || stage === maxStage">
                            <template v-if="!item">
                                <div class="amDiaryPage1-image">
                                    <img src="/images/diary-image.png" alt="Diary">
                                </div>
                                <div class="amDiaryPage1-title">
                                    <div>{{ __('Fill out sadhana diary') }}</div>
                                    <div>{{ (locale == 'ru') ? 'за&nbsp;' : "" }}{{ relativeDay }}?</div>
                                </div>
                            </template>
                            <template v-else>
                                <div class="amDiarySummary" :class="{'amDiarySummary-edit': stage === maxStage}">
                                    <div class="amDiarySummary-graph">
                                        <div class="amDiarySummary-graphPercent">
                                            <div class="appProgressRadial" :class="'appProgressRadial-progress' + diaryPercent">
                                                <div class="appProgressRadial-overlay">
                                                    <div class="appProgressRadial-overlayPercent">{{ diaryPercent }}%</div>
                                                    <div class="appProgressRadial-overlayText">{{ __('sattva indicator') }}</div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="amDiarySummary-graphLine"></div>
                                        <div class="amDiarySummary-graphDays">
                                            <div class="amDiarySummary-graphDaysNum">{{ streak }}</div>
                                            <div class="amDiarySummary-graphDaysTxt">{{ rightDays(streak) }} {{ __('in a row') }}</div>
                                        </div>
                                    </div>
                                    <div class="amDiarySummary-text">
                                        <div class="amDiarySummary-textIndicator" :style="{backgroundImage: 'linear-gradient(90deg, #F58E56 ' +  diaryPercent  + '%, #F5C4AA ' +  diaryPercent  + '%)'}">
                                            {{ __('sattva indicator') }}: {{ diaryPercent }}%
                                        </div>
                                        <div class="amDiarySummary-textDays">
                                            {{ streak }} {{ rightDays(streak) }} {{ __('in a row') }}
                                        </div>
                                    </div>
                                    <div v-if="stage === 0" class="amDiarySummary-rank">
                                        <div class="amDiarySummary-rankStatus">{{ __('Status') }}: {{ __(rank) }}</div>
                                        <div class="amDiarySummary-rankLevel">{{ difficulty==='light' ? __('Light') : __('Hard') }} {{ __('level') }}</div>
                                    </div>
                                    <div v-if="stage === 0" class="amDiarySummary-Items">
                                        <div class="amDiarySummary-Item performed">
                                            {{ __('Total completed') }} <span>{{ completedPractices }}</span>&nbsp;<declension :amount="completedPractices" word="practices"></declension>
                                        </div>
                                        <div class="amDiarySummary-Item better" v-if="success >= 10 && !hideCommunity">
                                            {{ __('Your practice (sadhana) level today is higher that') }} <span>{{ success }}</span><span>%</span> {{ __('of active margiis') }}
                                        </div>
                                        <div class="amDiarySummary-Item public" v-if="!hideCommunity">
                                            {{ __('Diaries were filled today by') }} <span>{{ community }}</span> <declension :amount="community" word="people"></declension>
                                        </div>
                                    </div>
                                    <template v-if="stage === maxStage">
                                        <div class="amDiarySummary-Ending">

                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(1)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Awakening') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <template v-if="JSON.stringify(allMorning) === JSON.stringify([1, 1, 0])">{{ __('Guru Sakash') }} {{ __('and') }} {{ __('oaths') }}</template>
                                                        <template v-if="JSON.stringify(allMorning) === JSON.stringify([1, 0, 0])">{{ __('Guru Sakash') }}</template>
                                                        <template v-if="JSON.stringify(allMorning) === JSON.stringify([0, 0, 1])">{{ __('Phone-sakash') }} :-)</template>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(2)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Pancajania') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <template v-if="item.pancajania !== 'no'">{{ pancajaniaTitles[item.pancajania] }}</template>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(3)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Kiirtan') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <!--<span>{{ item.lalita_marmika_count === 2 ? item.lalita_marmika_count + __(' times') : item.lalita_marmika_count + __(' time') }},&nbsp;</span>-->
                                                        <span v-if="timeFormat(item.lalita_marmika_time)">{{ timeFormat(item.lalita_marmika_time) }} <declension :amount="timeFormat(item.lalita_marmika_time)" word="minutes"></declension></span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(4)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Meditation') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <!--<span>{{ item.meditation_count === 2 ? item.meditation_count + __(' times') : item.meditation_count + __(' time') }},&nbsp;</span>-->
                                                        <span v-if="timeFormat(item.meditation_time)">{{ timeFormat(item.meditation_time) }} <declension :amount="timeFormat(item.meditation_time)" word="minutes"></declension></span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(5)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Kaoshiki') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <!--<span>{{ item.kaosiki_count === 2 ? item.kaosiki_count + __(' times') : item.kaosiki_count + __(' time') }},&nbsp;</span>-->
                                                        <span v-if="timeFormat(item.kaosiki_time)">{{ timeFormat(item.kaosiki_time) }} <declension :amount="timeFormat(item.kaosiki_time)" word="minutes"></declension></span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(6)" v-if="sex !== 'female'">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Tandava') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <!--<span>{{ item.tandava_count === 2 ? item.tandava_count + __(' times') : item.tandava_count + __(' time') }},&nbsp;</span>-->
                                                        <span v-if="timeFormat(item.tandava_time)">{{ timeFormat(item.tandava_time) }} <declension :amount="timeFormat(item.tandava_time)" word="minutes"></declension></span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(7)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Asanas') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <span v-if="item.asanas !== 'no'">{{ asanaTitles[item.asanas] }}</span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(8)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Half bath') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <span v-if="item.vyapaka_shaoca !== 'no'">{{ vyapaka_shaocaTitles[item.vyapaka_shaoca] }}</span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(9)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Full Bath') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <span v-if="item.full_bath !== 'no'">{{ full_bathTitles[item.full_bath] }}</span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(10)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Svadhyaya') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <span v-if="item.svadhyaya !== '00:00:00'">{{ timeFormat(item.svadhyaya) }} <declension :amount="timeFormat(item.svadhyaya)" word="minutes"></declension></span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(11)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Karma Yoga') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <span v-if="item.karma_yoga !== '00:00:00'">{{ timeFormat(item.karma_yoga) }} <declension :amount="timeFormat(item.karma_yoga)" word="minutes"></declension></span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" @click="goTo(12)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Nutrition') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <span v-if="item.aharya !== 'no'">{{ aharyaTitles[item.aharya] }}</span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" v-if="showDC" @click="goTo(13)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('DC') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <span v-if="item.dharmacakra !== 'no'">{{ showDC ? dharmacakraTitles[item.dharmacakra] : dharmacakraTitles[lastDC.dharmacakra] }}</span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                            <div class="amDiarySummary-EndingStageLink" v-if="isFasting" @click="goTo(14)">
                                                <div class="amDiarySummary-EndingStageContent">
                                                    <div class="amDiarySummary-EndingStageLinkName">{{ __('Fasting') }}</div>
                                                    <div class="amDiarySummary-EndingStageLinkValue">
                                                        <span v-if="item.upavasa !== 'no'">{{ upavasaTitles[item.upavasa] }}</span>
                                                    </div>
                                                </div>
                                                <div class="amDiarySummary-EndingStageIcon"><span class="appIcons msppIcons-chevron-right"></span></div>
                                            </div>
                                        </div>
                                    </template>

                                    <div class="amDiarySummary-storyBtn" @click="isStory = true" v-show="(today_quote && diaryPercent < 60) || (today_story && diaryPercent >= 60)">
                                        <div class="amDiarySummary-separator"></div>
                                        <div class="amDiarySummary-storyBtnImg">
                                            <img src="/images/gift.png" alt="" height="75">
                                        </div>
                                        <div>{{ __('View gift') }}</div>
                                    </div>

                                </div>
                            </template>
                           <div class="amDiaryPage-button" :class="'amDiaryPage-button' + (stage+1)">
                                <!--<span v-if="item && stage === 0" @click="edit()">{{ __('Edit') }}</span>-->
                                <span v-if="!item && stage === 0" @click="create(dayKey)">{{ __('Start') }}</span>
                                <!--<span v-if="stage === maxStage" @click="save()">{{ __('Finish') }}</span>-->
                            </div>
                            <div v-if="stage === 0" class="amDiaryPage1-datePaginator">
                                <div class="amDiaryPage1-datePaginatorBtn amDiaryPage1-datePaginatorBtnLeft" @click="prevDay()">
                                </div>
                                <div class="amDiaryPage1-datePaginatorBtn amDiaryPage1-datePaginatorBtnRight" :class="{disabled: index === 0}" @click="nextDay()">
                                </div>
                            </div>
                        </div>
                        <template v-if="item">
                            <diary-edit-stage hasHelp practice="morning" key="morning" :curStage="stage" :stage="1">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">{{ __('How your morning started?') }}</div>
                                    <div class="dhrtRadio">
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="allMorning" :value="[1, 1, 0]">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && JSON.stringify(allMorning) === JSON.stringify([1, 1, 0])}">{{ __('Guru Sakash') }} {{ __('and') }} {{ __('oaths') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="allMorning" :value="[1, 0, 0]">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && JSON.stringify(allMorning) === JSON.stringify([1, 0, 0])}">{{ __('Guru Sakash') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="allMorning" :value="[0, 0, 1]">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && JSON.stringify(allMorning) === JSON.stringify([0, 0, 1])}">{{ __('Phone-sakash') }} :-)</span>
                                        </label>

                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="pancajania" key="pancajania" :curStage="stage" :stage="2">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">{{ __('Pancajania') }}</div>
                                    <div class="dhrtRadio">
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.pancajania" value="yes">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.pancajania === 'yes'}">{{ __('Yes') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.pancajania" value="yes_and_sleep">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.pancajania === 'yes_and_sleep'}">{{ __('Yes, but took a nap') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.pj_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.pj_nulify}" v-model="item.pancajania" value="no">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.pancajania === 'no'}">{{ __('No') }}</span>
                                        </label>


                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="kiirtan" key="kiirtan" :curStage="stage" :stage="3">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">{{ __('Kiirtan') }}</div>
                                    <!--<div class="dhrtRadio" :class="{'withCustomNumpad': isNumpadShow}">
                                        <label>
                                            <input @click="nextStageAnim; item.kiirtan_nulify = true; item.lalita_marmika_time = '00:00'" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.kiirtan_nulify}"  v-model.number="item.lalita_marmika_count" value="0">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim}">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" @click="isNumpadShow && item.lalita_marmika_count === 1 ? stage++ : stage" class="dhrtRadio-noView" v-model.number="item.lalita_marmika_count" value="1">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim}">{{ __('One time') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" @click="isNumpadShow && item.lalita_marmika_count === 2 ? stage++ : stage" class="dhrtRadio-noView" v-model.number="item.lalita_marmika_count" value="2">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim}">{{ __('Two times') }} {{ __('and counting') }}</span>
                                        </label>
                                    </div>-->
                                    <div class="dhrtRadio">
                                        <label>
                                            <input @click="item.lalita_marmika_count = 2; nextStageAnim()" type="radio" class="dhrtRadio-noView" v-model="item.lalita_marmika_time" :value="'01:00:00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.lalita_marmika_time === '01:00:00'}">{{ practicePoints.lalita_marmika_time.time * 60 / 4 * 4 }} <declension :amount="practicePoints.lalita_marmika_time.time * 60 / 4 * 4" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="item.lalita_marmika_count = 1.5; nextStageAnim()" type="radio" class="dhrtRadio-noView" v-model="item.lalita_marmika_time" :value="'00:45:00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.lalita_marmika_time === '00:45:00'}">{{ practicePoints.lalita_marmika_time.time * 60 / 4 * 3 }} <declension :amount="practicePoints.lalita_marmika_time.time * 60 / 4 * 3" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="item.lalita_marmika_count = 1; nextStageAnim()" type="radio" class="dhrtRadio-noView" v-model="item.lalita_marmika_time" :value="'00:30:00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.lalita_marmika_time === '00:30:00'}">{{ practicePoints.lalita_marmika_time.time * 60 / 4 * 2 }} <declension :amount="practicePoints.lalita_marmika_time.time * 60 / 4 * 2" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="item.lalita_marmika_count = 0.5; nextStageAnim()" type="radio" class="dhrtRadio-noView" v-model="item.lalita_marmika_time" :value="'00:15:00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.lalita_marmika_time === '00:15:00'}">{{ practicePoints.lalita_marmika_time.time * 60 / 4 * 1 }} <declension :amount="practicePoints.lalita_marmika_time.time * 60 / 4 * 1" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="item.kiirtan_nulify = true; item.lalita_marmika_count = 0; nextStageAnim()" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.kiirtan_nulify}"  v-model="item.lalita_marmika_time" :value="'00:00:00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.lalita_marmika_time === '00:00:00'}">{{ __('No') }}</span>
                                        </label>
                                    </div>
                                    <!--<custom-numpad :key="'lalita_marmika'" v-if="item.lalita_marmika_count" practice="lalita_marmika_time">
                                        <template #question>{{ __('How much time?') }}</template>
                                    </custom-numpad>-->
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="meditation" key="meditation" :curStage="stage" :stage="4">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">{{ __('Meditation') }}</div>
                                    <!--<div class="dhrtRadio" :class="{'withCustomNumpad': isNumpadShow}">
                                        <label>
                                            <input @click="nextStageAnim; item.meditation_nulify = true; item.meditation_time = '00:00'" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.meditation_nulify}" v-model.number="item.meditation_count" value="0">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim}">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" @click="isNumpadShow && item.meditation_count === 1 ? stage++ : stage" class="dhrtRadio-noView" v-model.number="item.meditation_count" value="1">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim}">{{ __('One time') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" @click="isNumpadShow && item.meditation_count === 2 ? stage++ : stage" class="dhrtRadio-noView" v-model.number="item.meditation_count" value="2">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim}">{{ __('Two times') }} {{ __('and counting') }}</span>
                                        </label>
                                    </div>-->
                                    <div class="dhrtRadio" :class="{'withCustomNumpad': isNumpadShow}">
                                        <label>
                                            <input @click="nextStageAnim(); item.meditation_count = 2" type="radio" class="dhrtRadio-noView" v-model="item.meditation_time" :value="'02:00:00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.meditation_time === '02:00:00'}">{{ practicePoints.meditation_time.time * 60 / 4 * 4 }} <declension :amount="practicePoints.meditation_time.time * 60 / 4 * 4" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.meditation_count = 1.5" type="radio" class="dhrtRadio-noView" v-model="item.meditation_time" :value="'01:30:00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.meditation_time === '01:30:00'}">{{ practicePoints.meditation_time.time * 60 / 4 * 3 }} <declension :amount="practicePoints.meditation_time.time * 60 / 4 * 3" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.meditation_count = 1" type="radio" class="dhrtRadio-noView" v-model="item.meditation_time" :value="'01:00:00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.meditation_time === '01:00:00'}">{{ practicePoints.meditation_time.time * 60 / 4 * 2 }} <declension :amount="practicePoints.meditation_time.time * 60 / 4 * 2" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.meditation_count = 0.5" type="radio" class="dhrtRadio-noView" v-model="item.meditation_time" :value="'00:30:00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.meditation_time === '00:30:00'}">{{ practicePoints.meditation_time.time * 60 / 4 * 1 }} <declension :amount="practicePoints.meditation_time.time * 60 / 4 * 1" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.meditation_nulify = true; item.meditation_count = 0" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.meditation_nulify}" v-model="item.meditation_time" :value="'00:00:00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.meditation_time === '00:00:00'}">{{ __('No') }}</span>
                                        </label>
                                    </div>
                                    <!--<custom-numpad :key="'meditation'" v-if="item.meditation_count" practice="meditation_time">
                                        <template #question>{{ __('How much time?') }}</template>
                                    </custom-numpad>-->
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="kaosiki" key="kaosiki" :curStage="stage" :stage="5">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">{{ __('Kaoshiki') }}</div>
                                    <!--<div class="dhrtRadio stage5" :class="{'withCustomNumpad': isNumpadShow}">
                                        <label>
                                            <input @click="nextStageAnim; item.kaosiki_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.kaosiki_nulify}" v-model.number="item.kaosiki_count" value="0">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim}">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" @click="isNumpadShow && item.kaosiki_count === 1 ? stage++ : stage" class="dhrtRadio-noView" v-model.number="item.kaosiki_count" value="1">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim}">{{ __('One time') }} {{ __('and counting') }}</span>
                                        </label>
                                    </div>-->
                                    <div class="dhrtRadio stage5">
                                        <label>
                                            <input @click="nextStageAnim(); item.kaosiki_time = '00:15'" type="radio" class="dhrtRadio-noView" v-model="item.kaosiki_count" :value="1">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.kaosiki_count === 1}">15 <declension :amount="15" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.kaosiki_time = '00:10'" type="radio" class="dhrtRadio-noView" v-model="item.kaosiki_count" :value="0.6">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.kaosiki_count === 0.6}">10 <declension :amount="10" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.kaosiki_time = '00:05'" type="radio" class="dhrtRadio-noView" v-model="item.kaosiki_count" :value="0.3">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.kaosiki_count === 0.3}">5 <declension :amount="5" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.kaosiki_nulify = true;  item.kaosiki_time = '00:00'" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.kaosiki_nulify}" v-model="item.kaosiki_count" :value="0">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.kaosiki_count === 0}">{{ __('No') }}</span>
                                        </label>
                                    </div>
                                    <!--<custom-numpad :key="'kaosiki'" v-if="item.kaosiki_count" practice="kaosiki_time">
                                        <template #question>{{ __('How much time?') }}</template>
                                    </custom-numpad>-->
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="tandava" key="tandava" :curStage="stage" :stage="6">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">{{ __('Tandava') }}</div>
                                    <!--<div class="dhrtRadio stage6" :class="{'withCustomNumpad': isNumpadShow}">
                                        <label>
                                            <input @click="nextStageAnim; item.tandava_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.tandava_nulify}" v-model.number="item.tandava_count" value="0">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim}">{{ __('No') }}</span>
                                        </label>
                                        <label>
                                            <input type="radio" @click="isNumpadShow && item.tandava_count === 1 ? stage++ : stage" class="dhrtRadio-noView" v-model.number="item.tandava_count" value="1">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim}">{{ __('One time') }} {{ __('and counting') }}</span>
                                        </label>
                                    </div>-->
                                    <div class="dhrtRadio stage6" :class="{'withCustomNumpad': isNumpadShow}">
                                        <label>
                                            <input @click="nextStageAnim(); item.tandava_time = '00:05'" type="radio" class="dhrtRadio-noView" v-model="item.tandava_count" :value="1">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.tandava_count === 1}">5 <declension :amount="5" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.tandava_time = '00:03'" type="radio" class="dhrtRadio-noView" v-model="item.tandava_count" :value="0.6">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.tandava_count === 0.6}">3 <declension :amount="3" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.tandava_time = '00:01'" type="radio" class="dhrtRadio-noView" v-model="item.tandava_count" :value="0.3">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.tandava_count === 0.3}">1 <declension :amount="1" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.tandava_nulify = true; item.tandava_time = '00:00'" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.tandava_nulify}" v-model="item.tandava_count" :value="0">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.tandava_count === 0}">{{ __('No') }}</span>
                                        </label>
                                    </div>
                                    <!--<custom-numpad :key="'tandava'" v-if="item.tandava_count" practice="tandava_time">
                                        <template #question>{{ __('How much time?') }}</template>
                                    </custom-numpad>-->
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="asanas" key="asanas" :curStage="stage" :stage="7">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">{{ __('Asanas') }}</div>
                                    <div class="dhrtRadio">
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.asanas" value="morning_and_evening">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.asanas === 'morning_and_evening'}">{{ __('Twice') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.asanas" value="evening">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.asanas === 'evening'}">{{ __('Evening') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.asanas" value="morning">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.asanas === 'morning'}">{{ __('Morning') }}</span>
                                        </label>
                                        <label v-if="!man">
                                            <input type="radio" @click="nextStageAnim(); stage++" class="dhrtRadio-noView" v-model="item.asanas" value="period">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.asanas === 'period'}">{{ __('Woman period') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.asana_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.asana_nulify}" v-model="item.asanas" value="no">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.asanas === 'no'}">{{ __('No') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="halfbath" key="halfbath" :curStage="stage" :stage="8">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">{{ __('Did you do half bath?') }}</div>
                                    <div class="dhrtRadio stage8">
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.vyapaka_shaoca" value="before_any">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.vyapaka_shaoca === 'before_any'}">{{ __('more then 6 times') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView"
                                                   v-model="item.vyapaka_shaoca" value="before_sadhana_and_eat_or_sleep">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.vyapaka_shaoca === 'before_sadhana_and_eat_or_sleep'}">{{ __('4-5 times') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.vyapaka_shaoca" value="before_all">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.vyapaka_shaoca === 'before_all'}">{{ __('2-3 times') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.hb_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.hb_nulify}" v-model="item.vyapaka_shaoca" value="no">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.vyapaka_shaoca === 'no'}">{{ __('No') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="fullbath" key="fullbath" :curStage="stage" :stage="9">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">
                                        {{ __('Full Bath') }}
                                    </div>
                                    <div class="dhrtRadio">
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.full_bath" value="cold">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.full_bath === 'cold'}">{{ __('Cold') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.full_bath" value="contrast">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.full_bath === 'contrast'}">{{ __('Contrast') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.full_bath" value="warm">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.full_bath === 'warm'}">{{ __('Warm') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.fb_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.fb_nulify}" v-model="item.full_bath" value="no">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.full_bath === 'no'}">{{ __('No') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="svadhyaya" key="svadhyaya" :curStage="stage" :stage="10">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">
                                        {{ __('Svadhyaya') }}
                                    </div>
                                    <div class="dhrtRadio">
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.svadhyaya" :value="'00:' + (practicePoints.svadhyaya.time * 60 / 3 * 3) + ':00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.svadhyaya === '00:' + (practicePoints.svadhyaya.time * 60 / 3 * 3) + ':00'}">{{ practicePoints.svadhyaya.time * 60 / 3 * 3 }}&nbsp;<declension :amount="practicePoints.svadhyaya.time * 60 / 3 * 3" word="minutes"></declension>&nbsp;{{ __('and counting') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.svadhyaya" :value="'00:' + (practicePoints.svadhyaya.time * 60 / 3 * 2) + ':00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.svadhyaya === '00:' + (practicePoints.svadhyaya.time * 60 / 3 * 2) + ':00'}">{{ practicePoints.svadhyaya.time * 60 / 3 * 2 }}&nbsp;<declension :amount="practicePoints.svadhyaya.time * 60 / 3 * 2" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.svadhyaya" :value="'00:' + (practicePoints.svadhyaya.time * 60 / 3 * 1) + ':00'">
                                            <!-- <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim">{{ practicePoints.svadhyaya.time * 60 / 3 * 1 }} {{ __('minutes') }}</span>-->
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.svadhyaya === '00:' + (practicePoints.svadhyaya.time * 60 / 3 * 1) + ':00'}">{{ practicePoints.svadhyaya.time * 60 / 3 * 1 }}&nbsp;<declension :amount="practicePoints.svadhyaya.time * 60 / 3 * 1" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.sva_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.sva_nulify}" v-model="item.svadhyaya" value="00:00:00">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.svadhyaya === '00:00:00'}">{{ __('No') }}</span>
                                        </label>
                                    </div></div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="karmayoga" key="karmayoga" :curStage="stage" :stage="11">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">
                                        {{ __('Karma Yoga') }}
                                    </div>
                                    <div class="dhrtRadio">
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.karma_yoga" :value="'00:' + (practicePoints.karma_yoga.time * 60 / 3 * 3) + ':00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.karma_yoga === '00:' + (practicePoints.karma_yoga.time * 60 / 3 * 3) + ':00'}">{{ practicePoints.karma_yoga.time * 60 / 3 * 3 }}&nbsp;<declension :amount="practicePoints.karma_yoga.time * 60 / 3 * 3" word="minutes"></declension>&nbsp;{{ __('and counting') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.karma_yoga" :value="'00:' + (practicePoints.karma_yoga.time * 60 / 3 * 2) + ':00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.karma_yoga === '00:' + (practicePoints.karma_yoga.time * 60 / 3 * 2) + ':00'}">{{ practicePoints.karma_yoga.time * 60 / 3 * 2 }}&nbsp;<declension :amount="practicePoints.karma_yoga.time * 60 / 3 * 2" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.karma_yoga" :value="'00:' + (practicePoints.karma_yoga.time * 60 / 3 * 1) + ':00'">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.karma_yoga === '00:' + (practicePoints.karma_yoga.time * 60 / 3 * 1) + ':00'}">{{ practicePoints.karma_yoga.time * 60 / 3 * 1 }}&nbsp;<declension :amount="practicePoints.karma_yoga.time * 60 / 3 * 1" word="minutes"></declension></span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.karma_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.karma_nulify}" v-model="item.karma_yoga" value="00:00:00">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.karma_yoga === '00:00:00'}">{{ __('No') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="nutrition" key="nutrition" :curStage="stage" :stage="12">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">{{ __('Nutrition') }}</div>
                                    <div class="dhrtRadio">
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.aharya" value="tamah">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.aharya === 'tamah'}">{{ __('Tamasika') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.aharya" value="rajah">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.aharya === 'rajah'}">{{ __('Rajasika') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.aharya" value="sattva_much">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.aharya === 'sattva_much'}">{{ __('Sattvika with overeaten') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.aharya" value="sattva_norm">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.aharya === 'sattva_norm'}">{{ __('Sattvika') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.food_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.food_nulify}" v-model="item.aharya" value="no">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.aharya === 'no'}">{{ __('No') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="dc" key="dc" :curStage="stage" :stage="13">
                                <div class="amDiaryPage-сontent">
                                    <div class="amDiaryPage-title">{{ __('Last dharmacakra') }}</div>
                                    <div class="dhrtRadio">
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.dharmacakra" value="had_duty">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.dharmacakra === 'had_duty'}">{{ __('Helped organize') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.dharmacakra" value="participated">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.dharmacakra === 'participated'}">{{ __('Participated') }}</span>
                                        </label>
                                        <label>
                                            <input @click="nextStageAnim(); item.dc_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.dc_nulify}" v-model="item.dharmacakra" value="no">
                                            <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.dharmacakra === 'no'}">{{ __('Didn\'t participate') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </diary-edit-stage>
                            <diary-edit-stage hasHelp practice="fasting" key="fasting" :curStage="stage" :stage="14" v-show="stage === 14 && isFasting">
                            <div class="amDiaryPage-сontent">
                                <div class="amDiaryPage-title">{{ __('Fasting') }}</div>
                                <div class="dhrtRadio">
                                    <label>
                                        <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.upavasa" value="dry">
                                        <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.upavasa === 'dry'}">{{ __('Dry fasting') }}</span>
                                    </label>
                                    <label>
                                        <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.upavasa" value="water">
                                        <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.upavasa === 'water'}">{{ __('Fasting with water') }}</span>
                                    </label>
                                    <label>
                                        <input @click="nextStageAnim" type="radio" class="dhrtRadio-noView" v-model="item.upavasa" value="juices_fruits">
                                        <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.upavasa === 'juices_fruits'}">{{ __('Fasting with juices and fruits') }}</span>
                                    </label>
                                    <label>
                                        <input @click="nextStageAnim(); item.fast_nulify = true" type="radio" class="dhrtRadio-noView" :class="{'not-nulified': !item.fast_nulify}" v-model="item.upavasa" value="no">
                                        <span class="dhrtRadio-label" :class="{'animate__animated animate__bounceOut': anim && item.upavasa === 'no'}">{{ __('No') }}</span>
                                    </label>
                                </div>
                            </div>
                        </diary-edit-stage>
                        </template>
                    </template>
                    <div v-else>
                        <div class="dhrtWaitAnimateLoader">
                            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-one"></div>
                            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-two"></div>
                            <div class="dhrtWaitAnimateLoader-inner dhrtWaitAnimateLoader-three"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="page === 'settings'" class="amDiary-settings">
                <div class="amDiary-settingsGroup">
                    <div class="amDiary-settingsGroupItem" @click="page = 'settingsPlan'">{{ __('Choose your practices plan') }}</div>
                </div>
                <!--<div class="amDiary-settingsGroup">
                    <div class="amDiary-settingsGroupTitle">{{ __('Information') }}</div>
                    <div class="amDiary-settingsGroupItem">{{ __('Instructions') }}</div>
                    <div class="amDiary-settingsGroupItem" @click="page = 'settingsPractices'">{{ __('Points for practices') }}</div>
                    <div class="amDiary-settingsGroupItem" @click="page = 'settingsPoints'">{{ __('Sattva indicator') }}</div>
                </div>-->
            </div>
            <div class="amDiary-practices" v-if="page === 'settingsPractices'">
                <div class="amDiary-practicesTitle">{{ __('All practices summary:') }} {{ practicesList.total }}</div>
                <div class="amDiary-practicesList">
                    <div class="amDiary-practicesListItem" v-for="(points, practice) in practicesList" v-if="practice !== 'total'">
                        {{ __(practicesTitles[practice]) }}: {{ points }}
                    </div>
                </div>
            </div>
            <div class="amDiary-statistics" v-if="page === 'settingsStatistics'">
                <div class="amDiary-statisticsSwitch">
                    <div class="amDiary-statisticsSwitchQuotes" :class="{'active': rewardsMode === 'quotes'}" @click="rewardsMode = 'quotes'">{{ __('Quotes') }}</div>
                    <div class="amDiary-statisticsSwitchStories" :class="{'active': rewardsMode === 'stories'}" @click="rewardsMode = 'stories'">{{ __('Stories') }}</div>
                </div>
                <div class="amDiary-statisticsRewardsList">
                    <div class="amDiary-statisticsRewardsListReward" v-for="reward of (rewardsMode === 'quotes' ? quotes : stories)">
                        {{ dateFormat(reward.date) }}
                        {{ reward.text }}
                        {{ reward.author }}
                    </div>
                </div>
            </div>
            <div class="amDiary-points" v-if="page === 'settingsPoints'">
                <div class="amDiary-pointsHead">
                    {{ __('Points') }}
                    {{ __('Name') }}
                    {{ __('Fill percent') }}
                </div>
                <div class="amDiary-pointsBody">
                    <div class="amDiary-pointsBodySattvaBarWrapper">
                        <div class="amDiary-pointsBodySattvaBar" v-for="bar in 169" :class="[{
                        'long': (bar - 1) % 6 === 0,
                        'active': true
                    }, sattvaBarColor(bar, 169)]"></div>
                    </div>
                    <div class="amDiary-pointsBodyTable">
                        <div class="amDiary-pointsBodyTableLine" v-for="rank in practiceRanks">
                            {{ Math.trunc(rank.points) }}
                            {{ rank.name }}
                            {{ Math.trunc(rank.percent * 100) }}%
                        </div>
                    </div>
                </div>
            </div>
            <div class="amDiary-plan dhrtRadio" v-if="page === 'settingsPlan'">
                <div class="amDiary-planItems">
                    <label class="amDiary-planItem">
                        <span class="dhrtRadio-label">{{ __('Light') }}</span>
                        <input type="radio" class="dhrtRadio-noView" v-model="difficulty" value="light">
                        <span class="dhrtRadioView"></span>
                    </label>
                    <label class="amDiary-planItem">
                        <span class="dhrtRadio-label">{{ __('Hard') }}</span>
                        <input type="radio" class="dhrtRadio-noView" v-model="difficulty" value="hard">
                        <span class="dhrtRadioView"></span>
                </label>
                </div>
                <div class="amDiary-settingsButtons" @click="page = 'diary'">
                    <div class="amDiary-btn">
                        {{ __('Save') }}
                    </div>
                </div>
            </div>
        </v-touch>

        <modal-window v-if="isStory"
                      @close="close"
                      @enter="close"
                      :buttonList="['Close']"
                      :windowName="(today_story && diaryPercent >= 60 && (!today_story.default || (today_story.default && today_quote.default))) ? __('Story') : __('Quote')" customId="amDiaryStoryModal">
            <div class="amDiaryStoryModal">
                <span v-if="today_story && diaryPercent >= 60 && (!today_story.default || (today_story.default && today_quote.default))" v-html="today_story[locale]"></span>
                <span v-else v-html="today_quote[locale]"></span>
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
                calendarOpen: false,
                loaded: false,

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
                practicesInfo: [],

                lastDC: null,
                isFasting: null,
                streak: 0,
                community: 0,
                success: 0,
                today_quote: null,
                today_story: null,
                hideCommunity: true,
                reward: null,

                quotes: [],
                stories: [],

                pickr: null,
                anim: false,
                animTime: 800
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
                    this.getCommunity(newDate);
                    this.hideCommunity = true;
                }
            });
            this.getData();
            this.getStreak();
            let that = this;
            this.pickr = flatpickr(this.$refs.calendar, {
                maxDate: moment().format(),
                onChange: function(selectedDates, dateStr, instance) {
                    that.index = moment().diff(moment(dateStr), 'days');
                },
                onOpen: function(selectedDates, dateStr, instance) {
                    that.calendarOpen = true;
                },
                onClose: function(selectedDates, dateStr, instance) {
                    that.calendarOpen = false;
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
                let max = this.difficulty === "hard" ?
                    274.5
                    : 106
                let percent = Math.round(100 * (this.points + (this.difficulty === "hard" ? 65.5 : 53.5)) / max);

                return percent;
            },
            dayKey() {
                return moment().subtract(this.index, 'days').format('YYYY-MM-DD');
            },
            dateDayFormat() {
                return moment().locale(this.locale).subtract(this.index, 'days').format('DD MMMM, dddd');
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
                    + (this.difficulty === "hard" ? this.svadhyayaPoints : -1)
                    + (this.difficulty === "hard" ? this.karmayogaPoints : -1)
                    + (this.difficulty === "hard" ? this.dancesPoints : -1)
                    + this.diaryPoints
                    + (this.difficulty === "hard" ? this.pancajaniaPoints : -2)
                    + (this.difficulty === "hard" ? this.asanasPoints : -10)
                    + (this.difficulty === "hard" ? this.halfbathPoints : -1)
                    + (this.difficulty === "hard" ? this.aharyaPoints : 0)
                    + (this.difficulty === "hard" ? this.fullbathPoints : -3)
                    + (this.difficulty === "hard" ? this.dharmacakraPoints : -10)
                    + (this.difficulty === "hard" ? this.upavasaPoints : -3)
                    + (this.difficulty === "hard" ? this.item.guru_sakash ? 5 : 0 : 0)
                    + (this.difficulty === "hard" ? this.item.phone_sakash ? -5 : 0 : 0)
                    + (this.difficulty === "hard" ? this.item.oaths ? 5 : 0 : 0)
                ;
                return Math.round(pointsSum * 100) / 100;
            },
            rank() {
                let points = this.difficulty === "hard" ? this.points : (this.points + 65.5) / 274.5 * 115.5 + 7 ;
                if (points < this.practiceRanks[0].points) return this.practiceRanks[0].name;
                for (let i = 0; i < this.practiceRanks.length - 1; i++) {
                    if (points >= this.practiceRanks[i].points && points < this.practiceRanks[i + 1].points)
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
            showDC() {
                let practice = this.dharmacakra;
                let practiceItem = this.item.dharmacakra;

                if(practiceItem === 'no' && this.lastDC !== null) {
                    let lastPracticeDate = moment(this.lastDC.date);
                    let lastPracticeStatus = this.lastDC.dharmacakra;

                    if( moment(this.item.date).isSameOrBefore(lastPracticeDate.add(6, 'days')) ) return false;
                }

                return true;
            },

            allMorning: {
                get() {
                  return [this.item.guru_sakash, this.item.oaths, this.item.phone_sakash];
                },
                set(newVal) {
                    this.item.guru_sakash = newVal[0];
                    this.item.oaths = newVal[1];
                    this.item.phone_sakash = newVal[2];
                }
            }
        },

        watch: {
            index() {
                this.item = this.items[this.dayKey];
            },

            chosenDateMonth() {
                this.getData();
            },

            stage(newStage, oldStage) {
                if(this.stage === 6 && this.sex === 'female') {
                    this.stage = 7;
                }
                if(this.stage === 13 && !this.showDC) {
                    this.stage++;
                }
                if(newStage === 6 && oldStage === 7 && this.sex === 'female') {
                    this.stage = 5;
                }
                if(newStage === this.maxStage && oldStage === (this.maxStage - 1)) {
                    this.stage = 0;
                    this.save(true);
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
            }
        },

        methods: {
            rightDays(x) {
                if(x > 10 && x < 20) return this.__('days  ');
                if(x%10 === 1) return this.__('day');
                if(x%10 === 0) return this.__('days  ');
                if(x%10 < 5) return this.__('days ');
                return this.__('days  ');
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
                        this.loaded = true;
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
                    this.today_quote = response.data.quote;
                    this.today_story = response.data.story;
                });
            },

            getStreak() {
                axios.get('/api/daily-practices?streak').then(response => {
                    this.streak = response.data.streak;
                });
            },

            getCommunity(date) {
                axios.get('/api/daily-practices?community&date=' + date).then(response => {
                    this.community = response.data.community;
                    this.success = Math.trunc(response.data.success);
                    this.hideCommunity = false;
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
                    'meditation_time': moment('00:00:00', 'HH:mm:ss').format('HH:mm:ss'),
                    'lalita_marmika_count': 0,
                    'lalita_marmika_time': moment('00:00:00', 'HH:mm:ss').format('HH:mm:ss'),
                    'asanas': 'no',
                    'kaosiki_count': 0,
                    'kaosiki_time': moment('00:00', 'HH:mm').format('HH:mm'),
                    'tandava_count': 0,
                    'tandava_time': moment('00:00', 'HH:mm').format('HH:mm'),
                    'vyapaka_shaoca': 'no',
                    'full_bath': 'no',
                    'svadhyaya': moment('00:00:00', 'HH:mm:ss').format('HH:mm:ss'),
                    'karma_yoga': moment('00:00:00', 'HH:mm:ss').format('HH:mm:ss'),
                    'aharya': 'no',
                    'dharmacakra': 'no',
                    'upavasa': 'no',
                    'points': 0,
                    'rank': null,
                    'pj_nulify': false,
                    'meditation_nulify': false,
                    'kiirtan_nulify': false,
                    'asana_nulify': false,
                    'kaosiki_nulify': false,
                    'tandava_nulify': false,
                    'hb_nulify': false,
                    'fb_nulify': false,
                    'sva_nulify': false,
                    'karma_nulify': false,
                    'food_nulify': false,
                    'dc_nulify': false,
                    'fast_nulify': false
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

                        let meditation_time = "00:00:00";

                        switch(true){
                            case meditation_time_sec === 0:
                                meditation_time = "00:00:00";
                                break;
                            case meditation_time_sec <= 1800:
                                meditation_time = "00:30:00";
                                break;
                            case meditation_time_sec <= 3600:
                                meditation_time = "01:00:00";
                                break;
                            case meditation_time_sec <= 5400:
                                meditation_time = "01:30:00";
                                break;
                            case meditation_time_sec > 5400:
                                meditation_time = "02:00:00";
                                break;
                        }


                        let kirtan_time = "00:00:00";

                        switch(true){
                            case kirtan_time_sec === 0:
                                kirtan_time = "00:00:00";
                                break;
                            case kirtan_time_sec <= 900:
                                kirtan_time = "00:15:00";
                                break;
                            case kirtan_time_sec <= 1800:
                                kirtan_time = "00:30:00";
                                break;
                            case kirtan_time_sec <= 2700:
                                kirtan_time = "00:45:00";
                                break;
                            case kirtan_time_sec > 2700:
                                kirtan_time = "01:00:00";
                                break;
                        }

                        let current_meditation_time_sec = moment(this.item.meditation_time, 'HH:mm:ss').hour() * 60 * 60 + moment(this.item.meditation_time, 'HH:mm:ss').minute() * 60;
                        let current_lalita_marmika_time_sec = moment(this.item.lalita_marmika_time, 'HH:mm:ss').hour() * 60 * 60 + moment(this.item.lalita_marmika_time, 'HH:mm:ss').minute() * 60;

                        if(meditation_count > this.item.meditation_count) {
                            this.item.meditation_count = meditation_count >= 2 ? 2 : meditation_count;
                        }

                        if(current_meditation_time_sec < meditation_time_sec) {
                            this.item.meditation_time = meditation_time;
                        }

                        if(kirtan_count > this.item.lalita_marmika_count) {
                            this.item.lalita_marmika_count = kirtan_count >= 2 ? 2 : kirtan_count;
                        }

                        if(current_lalita_marmika_time_sec < kirtan_time_sec) {
                            this.item.lalita_marmika_time = kirtan_time;
                        }
                    }).catch(error => {
                        console.log(error);
                    })
                }
            },

            save(reload = true) {
                if (this.isProcessing) return;
                if (reload) this.stage = 0;
                if (reload) {
                    this.item.pj_nulify = true;
                    this.item.meditation_nulify = true;
                    this.item.kiirtan_nulify = true;
                    this.item.asana_nulify = true;
                    this.item.kaosiki_nulify = true;
                    this.item.tandava_nulify = true;
                    this.item.hb_nulify = true;
                    this.item.fb_nulify = true;
                    this.item.sva_nulify = true;
                    this.item.karma_nulify = true;
                    this.item.food_nulify = true;
                    this.item.dc_nulify = true;
                    this.item.fast_nulify = true;
                }
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
            },

            nextStageAnim() {
                this.anim = true;
                setTimeout(() => {
                    this.stage++;
                    this.anim = false;
                }, this.animTime);
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
