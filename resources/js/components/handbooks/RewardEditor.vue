<template>
    <div class="appRewardEditor">
        <div class="appRewardEditor-pageTools">
            <div class="appRewardEditor-pageToolsButtons">
                <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" @click="create()">{{ __('Add') }}
                </div>
            </div>
            <div class="appRewardEditor-pageToolsPaginator">
                <pagination v-model="page" :total="total" :per-page="perPage"/>
            </div>
        </div>

        <div class="appTable">
            <div class="appTable-row appTable-head appRewardEditor-head">
                <div class="appTable-col appRewardEditor-id">
                    <div>{{ __('ID') }}</div>
                </div>
                <div class="appTable-col appRewardEditor-type">
                    <div class="appTable-colTop">
                        <div>{{ __('Type') }}</div>
                    </div>
                    <div class="appTable-filter_listFilter">
                        <dropdown v-model="filters.type"
                                  class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown dhrtDropdown-menuAlignmentLeft menuWidthAuto"
                                  :options='rewardTypes'/>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-date">
                    <div class="appTable-colTop" @click="sort('date')">
                        <div>{{ __('Day') }}</div>
                        <div class="appTable-sort" v-if="sortBy === 'date'">
                            <span class="msppIcons" :class="'msppIcons-sort-numeric-' + sortOrder"></span>
                        </div>
                    </div>
                    <div class="appTable-filter">
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-titleRu">
                    <div class="appTable-colTop">
                        <div>{{ __('Title (ru)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.titleRu" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-titleEn">
                    <div class="appTable-colTop">
                        <div>{{ __('Title (en)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.titleEn" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-titleUk">
                    <div class="appTable-colTop">
                        <div>{{ __('Title (uk)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-authorRu">
                    <div class="appTable-colTop">
                        <div>{{ __('Author (ru)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.authorRu" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-authorEn">
                    <div class="appTable-colTop">
                        <div>{{ __('Author (en)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.authorEn" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-authorUk">
                    <div class="appTable-colTop">
                        <div>{{ __('Author (uk)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-authorRu">
                    <div class="appTable-colTop">
                        <div>{{ __('Comment author (ru)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.audioAuthorRu" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-authorEn">
                    <div class="appTable-colTop">
                        <div>{{ __('Comment author (en)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.audioAuthorEn" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-authorUk">
                    <div class="appTable-colTop">
                        <div>{{ __('Comment author (uk)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-Ru">
                    <div class="appTable-colTop">
                        <div>{{ __('Svadhyaya (ru)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.ru" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-En">
                    <div class="appTable-colTop">
                        <div>{{ __('Svadhyaya (en)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.en" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-Uk">
                    <div class="appTable-colTop">
                        <div>{{ __('Svadhyaya (uk)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-placeRu">
                    <div class="appTable-colTop">
                        <div>{{ __('Place (ru)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.placeRu" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-placeEn">
                    <div class="appTable-colTop">
                        <div>{{ __('Place (en)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.placeEn" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-placeUk">
                    <div class="appTable-colTop">
                        <div>{{ __('Place (uk)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-dateRec">
                    <div class="appTable-colTop">
                        <div>{{ __('Rec.date (ru)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.recDateRu" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-dateRec">
                    <div class="appTable-colTop">
                        <div>{{ __('Rec.date (en)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.recDateEn" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-dateRec">
                    <div class="appTable-colTop">
                        <div>{{ __('Rec.date (uk)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.recDateEn" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-sourceRu">
                    <div class="appTable-colTop">
                        <div>{{ __('Source (ru)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.sourceRu" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-sourceEn">
                    <div class="appTable-colTop">
                        <div>{{ __('Source (en)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model="filters.sourceEn" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-sourceUk">
                    <div class="appTable-colTop">
                        <div>{{ __('Source (uk)') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appRewardEditor-tools">
                    <div class="appIcons msppIcons-tools appDiary-headIcon"></div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('Media') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('EN comment author (en)') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('EN comment author (ru)') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('EN comment author (uk)') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('RU comment author (en)') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('RU comment author (ru)') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('RU comment author (uk)') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('UK comment author (en)') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('UK comment author (ru)') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('UK comment author (uk)') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appRewardEditor-audio">
                    <div class="appTable-colTop">
                        <div>{{ __('Original comentary language') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>

            </div>
            <div class="appTable-body appRewardEditor-body">
                <div v-for="(puzzle, index) in puzzles" class="appTable-row">
                    <div class="appTable-col appRewardEditor-id">
                        {{ puzzle.id }}
                    </div>
                    <div class="appTable-col appRewardEditor-type">
                        <template v-if="rewardTypes[puzzle.type]">
                            {{ rewardTypes[puzzle.type] }}
                        </template>
                        <span v-else>
                            {{ __('Type') }}
                        </span>
                    </div>
                    <div class="appTable-col appRewardEditor-date">
                        <template v-if="puzzle.date">
                            {{ dateFormat(puzzle.date) }}
                        </template>
                        <span v-else>
                            {{ __('Day') }} {{ __('absent') }}
                        </span>

                    </div>
                    <div class="appTable-col appRewardEditor-titleRu">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.title_ru">
                                {{ puzzle.title_ru }}
                            </template>
                            <span v-else>
                                {{ __('Title (ru)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-titleEn">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.title_en">
                                {{ puzzle.title_en }}
                            </template>
                            <span v-else>
                                {{ __('Title (en)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-titleUk">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.title_uk">
                                {{ puzzle.title_uk }}
                            </template>
                            <span v-else>
                                {{ __('Title (uk)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-authorRu">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.author_ru">
                                {{ puzzle.author_ru }}
                            </template>
                            <span v-else>
                                {{ __('Author/ru') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-authorEn">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.author_en">
                                {{ puzzle.author_en }}
                            </template>
                            <span v-else>
                                {{ __('Author (en)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-authorUk">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.author_uk">
                                {{ puzzle.author_uk }}
                            </template>
                            <span v-else>
                                {{ __('Author (uk)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-Ru">
                        <div class="textOverflowRows">
                            <template v-if="puzzle.ru">
                                <div v-html="puzzle.ru"></div>
                            </template>
                            <span v-else>
                                {{ __('Text') }} /{{ __('Ru') }}/ {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-En">
                        <div class="textOverflowRows">
                            <template v-if="puzzle.en">
                                <div v-html="puzzle.en"></div>
                            </template>
                            <span v-else>
                                {{ __('Text') }} /{{ __('En') }}/ {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-Uk">
                        <div class="textOverflowRows">
                            <template v-if="puzzle.uk">
                                <div v-html="puzzle.uk"></div>
                            </template>
                            <span v-else>
                                {{ __('Text') }} /{{ __('Uk') }}/ {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-placeRu">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.place_ru">
                                {{ puzzle.place_ru }}
                            </template>
                            <span v-else>
                                {{ __('Place (ru)') }} {{ __('absent') }}
                            </span>

                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-placeEn">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.place_en">
                                {{ puzzle.place_en }}
                            </template>
                            <span v-else>
                                {{ __('Place (en)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-placeUk">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.place_uk">
                                {{ puzzle.place_uk }}
                            </template>
                            <span v-else>
                                {{ __('Place (uk)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-dateRec">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.record_date_ru">
                                {{ puzzle.record_date_ru }}
                            </template>
                            <span v-else>
                            {{ __('Rec.date (ru)') }} {{ __('absent') }}
                        </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-dateRec">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.record_date_en">
                                {{ puzzle.record_date_en }}
                            </template>
                            <span v-else>
                            {{ __('Rec.date (en)') }} {{ __('absent') }}
                        </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-dateRec">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.record_date_uk">
                                {{ puzzle.record_date_uk }}
                            </template>
                            <span v-else>
                            {{ __('Rec.date (uk)') }} {{ __('absent') }}
                        </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-sourceRu">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.source_ru">
                                {{ puzzle.source_ru }}
                            </template>
                            <span v-else>
                                {{ __('Source (ru)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-sourceEn">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.source_en">
                                {{ puzzle.source_en }}
                            </template>
                            <span v-else>
                                {{ __('Source (en)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-sourceUk">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.source_uk">
                                {{ puzzle.source_uk }}
                            </template>
                            <span v-else>
                                {{ __('Source (uk)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <action-dropdown menuAlignmentLeft>
                        <template #label><div class="appIcons msppIcons-tools appDiary-bodyIcon"></div></template>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item"
                           @click.prevent="edit(puzzle, index)">
                            {{ __('Edit') }}
                        </a>
                        <a href="#" rel="nofollow" class="dhrtDropdown-item"
                           @click.prevent="copy(puzzle)">
                            {{ __('Duplicate') }}
                        </a>
                        <a class="dhrtDropdown-item" rel="nofollow" href="#"
                           @click.prevent="destroyModal(puzzle, index)">
                            {{ __('Delete') }}
                        </a>
                    </action-dropdown>
                    <div class="appTable-col appRewardEditor-enCommentEn">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.en_comentary_seju_en">
                                {{ puzzle.en_comentary_seju_en }}
                            </template>
                            <span v-else>
                                {{ __('EN comment author (en)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-enCommentRu">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.en_comentary_seju_ru">
                                {{ puzzle.en_comentary_seju_ru }}
                            </template>
                            <span v-else>
                                {{ __('EN comment author (ru)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-enCommentUk">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.en_comentary_seju_uk">
                                {{ puzzle.en_comentary_seju_uk }}
                            </template>
                            <span v-else>
                                {{ __('EN comment author (uk)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-ruCommentEn">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.ru_comentary_seju_en">
                                {{ puzzle.ru_comentary_seju_en }}
                            </template>
                            <span v-else>
                                {{ __('RU comment author (en)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-ruCommentRu">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.ru_comentary_seju_ru">
                                {{ puzzle.ru_comentary_seju_ru }}
                            </template>
                            <span v-else>
                                {{ __('RU comment author (ru)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-ruCommentUk">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.ru_comentary_seju_uk">
                                {{ puzzle.ru_comentary_seju_uk }}
                            </template>
                            <span v-else>
                                {{ __('RU comment author (uk)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-ukCommentEn">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.uk_comentary_seju_en">
                                {{ puzzle.uk_comentary_seju_en }}
                            </template>
                            <span v-else>
                                {{ __('UK comment author (en)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-ukCommentRu">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.uk_comentary_seju_ru">
                                {{ puzzle.uk_comentary_seju_ru }}
                            </template>
                            <span v-else>
                                {{ __('UK comment author (ru)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-ukCommentUk">
                        <div class="textOverflowRow">
                            <template v-if="puzzle.uk_comentary_seju_uk">
                                {{ puzzle.uk_comentary_seju_uk }}
                            </template>
                            <span v-else>
                                {{ __('UK comment author (uk)') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appRewardEditor-originalLang">
                        <template v-if="langs[puzzle.original_comentary_lang]">
                            {{ langs[puzzle.original_comentary_lang] }}
                        </template>
                        <span v-else>
                            {{ __('Original comentary language') }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <pagination v-if="total >= 50" v-model="page" :total="total" :per-page="perPage"/>

        <fs-modal-window v-if="item && editor" id="appRewardEditorModal-itemEdit" @close="close" @enter="save()"
                      :valid="item.date && (item.en || item.ru) && !isProcessing"
                      @cancel="close" :buttonList="['Cancel', 'Save']" @save="save()"
                      :windowName="__(rewardTypes[item.type]) + ' ' +  dateFormat(item.date)">
            <div class="appRewardEditorModal-itemEditContent">
                <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                    <div class="appForm-groupTitle">{{ __('Date') }}</div>
                    <flat-pickr :config="datePickerConfig" class="appForm-input appDiaryModal-inputDate"
                                v-model="item.date"></flat-pickr>
                </div>
                <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                    <div class="appForm-groupTitle">{{ __('Type') }}</div>
                    <multiselect
                        v-model="typeHolder"
                        :options="types"
                        label="name"
                        track-by="slug"
                        :placeholder="__('Select option')"
                    />
                </div>
                <div class="appForm-group appRewardEditorModal-itemEdit-layout1" >
                    <div class="appForm-groupTitle">{{ __('Media') }}</div>
                    <template v-for="media of item.media">
                        <div class="textOverflowRow" v-html="media.path"></div>
                    </template>
                    <div class="dhrtModalWindow-footerButton" @click="media_editor = true">{{ __('Edit reward media') }}</div>
                </div>
                <div class="appForm-group appRewardEditorModal-itemEdit-layout1" >
                    <upload-file @media-uploaded="getMedia"></upload-file>
                    <add-web-file @saved="getMedia"></add-web-file>
                </div>
                <div class="appForm-group appRewardEditorModal-itemEdit-layout1">
                    <div class="appForm-groupTitle">{{ __('Original comentary language') }}</div>
                    <dropdown v-model="item.original_comentary_lang" :options="{en: __('English'), ru: __('Russian'), uk: __('Ukrainian')}"></dropdown>
                </div>

                <action-dropdown>
                    <template #label>
                        <img :src="'/images/' + editor_lang + '.png'" height="20">
                        {{ {'en': __('English'), 'ru': __('Russian'), 'uk': __('Ukrainian')}.editor_lang }}
                    </template>
                    <template #default>
                        <a class="dhrtDropdown-item" @click.prevent="editor_lang = 'en'" v-if="editor_lang !== 'en'">
                            <img src="/images/en.png" height="20">
                            {{ __('English') }}
                        </a>
                        <a class="dhrtDropdown-item" @click.prevent="editor_lang = 'ru'" v-if="editor_lang !== 'ru'">
                            <img src="/images/ru.png" height="20">
                            {{ __('Russian') }}
                        </a>
                        <a class="dhrtDropdown-item" @click.prevent="editor_lang = 'uk'" v-if="editor_lang !== 'uk'">
                            <img src="/images/uk.png" height="20">
                            {{ __('Ukrainian') }}
                        </a>
                    </template>
                </action-dropdown>

                <template>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Source (' + editor_lang + ')') }}</div>
                        <input type="text" name="sourceEn" v-model="item['source_' + editor_lang]" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('Title (' + editor_lang + ')') }}</div>
                        <input type="text" name="titleEn" v-model="item['title_' + editor_lang]" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout1">
                        <div class="appForm-groupTitle">{{ __({en: 'English', ru: 'Russian', uk: 'Ukrainian'}.editor_lang) }}</div>
                        <html-editor :airmode="false" class="appForm-input" height="70" v-model="item['' + editor_lang]" />
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Author (' + editor_lang + ')') }}</div>
                        <input type="text" name="middle_name" v-model="item['author_' + editor_lang]" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('Place (' + editor_lang + ')') }}</div>
                        <input type="text" name="middle_name" v-model="item['place_' + editor_lang]" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Rec.date (' + editor_lang + ')') }}</div>
                        <input type="text" name="recordDateEn" v-model="item['record_date_' + editor_lang]" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('EN comment author (' + editor_lang + ')') }}</div>
                        <input type="text" name="middle_name" v-model="item['en_comentary_seju_' + editor_lang]" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('RU comment author (' + editor_lang + ')') }}</div>
                        <input type="text" name="middle_name" v-model="item['ru_comentary_seju_' + editor_lang]" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('UA comment author (' + editor_lang + ')') }}</div>
                        <input type="text" name="middle_name" v-model="item['uk_comentary_seju_' + editor_lang]" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('RU translation author (' + editor_lang + ')') }}</div>
                        <input type="text" name="middle_name" v-model="item['ru_translator_' + editor_lang]" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('UA translation author (' + editor_lang + ')') }}</div>
                        <input type="text" name="middle_name" v-model="item['uk_translator_' + editor_lang]" class="appForm-input">
                    </div>
                </template>

                <!--
                <template v-if="editor_lang === 'en'">
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('Source (en)') }}</div>
                        <input type="text" name="sourceEn" v-model="item.source_en" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('Title (en)') }}</div>
                        <input type="text" name="titleEn" v-model="item.title_en" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout1">
                        <div class="appForm-groupTitle">{{ __('English') }}</div>
                        <html-editor :airmode="false" class="appForm-input" height="70" v-model="item.en" />
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('Author (en)') }}</div>
                        <input type="text" name="middle_name" v-model="item.author_en" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Place (en)') }}</div>
                        <input type="text" name="middle_name" v-model="item.place_en" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('Rec.date (en)') }}</div>
                        <input type="text" name="recordDateEn" v-model="item.record_date_en" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('EN comment author (en)') }}</div>
                        <input type="text" name="middle_name" v-model="item.en_comentary_seju_en" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('RU comment author (en)') }}</div>
                        <input type="text" name="middle_name" v-model="item.ru_comentary_seju_en" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('UA comment author (en)') }}</div>
                        <input type="text" name="middle_name" v-model="item.uk_comentary_seju_en" class="appForm-input">
                    </div>
                </template>
                <template v-if="editor_lang === 'ru'">
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Source (ru)') }}</div>
                        <input type="text" name="sourceRu" v-model="item.source_ru" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Title (ru)') }}</div>
                        <input type="text" name="titleRu" v-model="item.title_ru" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout1">
                        <div class="appForm-groupTitle">{{ __('Russian') }}</div>
                        <html-editor :airmode="false" class="appForm-input" height="70" v-model="item.ru" />
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Author (ru)') }}</div>
                        <input type="text" name="middle_name" v-model="item.author_ru" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('Place (ru)') }}</div>
                        <input type="text" name="middle_name" v-model="item.place_ru" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Rec.date (ru)') }}</div>
                        <input type="text" name="recordDateRu" v-model="item.record_date_ru" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('EN comment author (ru)') }}</div>
                        <input type="text" name="middle_name" v-model="item.en_comentary_seju_ru" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('RU comment author (ru)') }}</div>
                        <input type="text" name="middle_name" v-model="item.ru_comentary_seju_ru" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('UA comment author (ru)') }}</div>
                        <input type="text" name="middle_name" v-model="item.uk_comentary_seju_ru" class="appForm-input">
                    </div>
                </template>
                <template v-if="editor_lang === 'uk'">
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Source (uk)') }}</div>
                        <input type="text" name="sourceRu" v-model="item.source_uk" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('Title (uk)') }}</div>
                        <input type="text" name="titleEn" v-model="item.title_uk" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout1">
                        <div class="appForm-groupTitle">{{ __('Ukrainian') }}</div>
                        <html-editor :airmode="false" class="appForm-input" height="70" v-model="item.uk" />
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Author (uk)') }}</div>
                        <input type="text" name="middle_name" v-model="item.author_uk" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('Place (uk)') }}</div>
                        <input type="text" name="middle_name" v-model="item.place_uk" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Rec.date (uk)') }}</div>
                        <input type="text" name="recordDateRu" v-model="item.record_date_uk" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('EN comment author (uk)') }}</div>
                        <input type="text" name="middle_name" v-model="item.en_comentary_seju_uk" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2 appRewardEditorModal-itemEditNotFirst">
                        <div class="appForm-groupTitle">{{ __('RU comment author (uk)') }}</div>
                        <input type="text" name="middle_name" v-model="item.ru_comentary_seju_uk" class="appForm-input">
                    </div>
                    <div class="appForm-group appRewardEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('UA comment author (uk)') }}</div>
                        <input type="text" name="middle_name" v-model="item.uk_comentary_seju_uk" class="appForm-input">
                    </div>
                </template>
                -->
            </div>

        </fs-modal-window>
        <modal-window v-if="item && remove" @close="close" @no="close" @ok="destroy(item.id)"
                      :buttonList="['No', 'Ok']" :windowName="__('Confirmation')">
            <div class="appForm-group">
                <span>{{ __('Are you sure?') }}</span>
            </div>
        </modal-window>
        <fs-modal-window v-if="item && media_editor" id="appSamgiitEditorModal-itemEditMedia" @close="media_editor = false" @enter="media_editor = false"
                         :valid="!isProcessing"
                         :buttonList="['Close', 'Save']" @save="media_editor = false"
                         :windowName="__(rewardTypes[item.type]) + ' ' +  dateFormat(item.date) + ' ' + __('media')">
            <template v-for="(media, key) of item.media">
                <div class="appSamgiitEditorModal-itemEditMediaLine">
                    <span class="msppIcons" :class="{'msppIcons-video': media.type === 'video', 'msppIcons-music': media.type === 'audio'}"></span>
                    <span v-html="media.path" v-if="media.hidden"></span>
                    <template v-else>
                        <multiselect
                            v-model="item.media[key]"
                            :options="msp_media"
                            label="path"
                            track-by="id"
                        />
                        <dropdown v-model="item.media[key].lang" :options="langs"></dropdown>
                        <div @click="remove_media(key)">X</div>
                    </template>
                </div>
            </template>
            <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" @click="add_media()">{{ __('Add media') }}</div>
        </fs-modal-window>
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
        components: {
            Textarea,
            flatPickr,
            Multiselect
        },

        data() {
            return {
                page: 1,
                perPage: 25,
                total: 0,

                puzzles: [],
                item: null,
                itemIndex: null,
                editor: null,
                detail: null,
                remove: null,
                isProcessing: false,
                media_editor: false,
                editor_lang: 'en',

                datePickerConfig: {
                    disableMobile: "true",
                    altInput: true,
                    altFormat: 'd-m-y',
                    disable: [],
                    locale: 'ru'
                },

                types: [
                    {
                        'slug': 'svadhyaya',
                        'name': this.__("Svadhyaya")
                    },
                    {
                        'slug': 'daily',
                        'name': this.__("Daily quote")
                    },
                    {
                        'slug': 'quote',
                        'name': this.__("Diary quote")
                    },
                    {
                        'slug': 'story',
                        'name': this.__("Diary story")
                    }
                ],

                rewardTypes: {
                    null: this.__('All'),
                    'svadhyaya': this.__("Svadhyaya"),
                    'daily': this.__("Daily quote"),
                    'quote': this.__("Diary quote"),
                    'story': this.__("Diary story")
                },

                langs: {
                    all: this.__('All languages'),
                    en: this.__('English'),
                    ru: this.__('Russian'),
                    uk: this.__('Ukrainian')
                },

                typeHolder: null,

                sortBy: 'date',
                sortOrder: 'desc',

                filters: {
                    ru: '',
                    en: '',
                    titleRu: '',
                    titleEn: '',
                    sourceRu: '',
                    sourceEn: '',
                    placeRu: '',
                    placeEn: '',
                    authorRu: '',
                    authorEn: '',
                    audioAuthorRu: '',
                    audioAuthorEn: '',
                    recDate: '',
                    type: null
                },

                audio: [],
                video: []
            }
        },

        mounted() {
            this.getData();
            this.getMedia();
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },
            msp_media() {
                let media = this.audio.concat(this.video);

                media.forEach(media => {
                    this.$set(media, 'lang', 'all');
                });

                return media;
            }
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

            typeHolder() {
                if(this.typeHolder) {
                    this.item.type = this.typeHolder.slug;
                }
            },

            item() {
                if(!this.item) this.typeHolder = null;
                else this.typeHolder = {
                    'slug': this.item.type,
                    'name': this.rewardTypes[this.item.type]
                }
            }
        },

        methods: {
            getData() {
                let params = {
                    ru: this.filters.ru ? this.filters.ru : null,
                    en: this.filters.en ? this.filters.en : null,
                    type: this.filters.type ? this.filters.type : null,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,

                    take: this.perPage,
                    skip: this.skip,
                };

                axios.get('/puzzles', {params: params}).then(response => {
                    this.puzzles = response.data.puzzles;
                    this.total = response.data.total;
                });

            },

            getMedia() {
                this.getAudio();
                this.getVideo();
            },

            getAudio() {
                axios.get('/get-audio-files').then(response => {
                    this.audio = response.data.audio;
                });
            },

            getVideo() {
                axios.get('/get-video-files').then(response => {
                    this.video = response.data.video;
                });
            },

            remove_media(key) {
                this.item.media.splice(key, 1);
            },

            dateFormat(date) {
                return moment(date).format('DD.MM.YY');
            },

            create() {
                this.item = {
                    id: null,
                    date: null,
                    title_en: null,
                    title_ru: null,
                    source_en: null,
                    source_ru: null,
                    en: null,
                    ru: null,
                    author_en: null,
                    author_ru: null,
                    place_en: null,
                    place_ru: null,
                    record_date: null,
                    type: null,
                    media: [],
                    original_comentary_lang: 'en'
                };
                this.editor = 1;
            },

            copy(item) {
                this.item = JSON.parse(JSON.stringify(item));
                this.item.id = null;
                this.item.date = null;
                this.item.media.forEach( media => {
                    this.$set(media, 'lang', media.pivot.lang);
                });
                this.editor = 1;
            },

            add_media() {
                this.item.media.push({
                    id: null,
                    lang: 'all'
                });
            },

            save() {
                if (this.isProcessing) return;
                this.isProcessing = 1;
                axios.post('/puzzles', {puzzle: this.item}).then(response => {
                    this.isProcessing = 0;
                    this.getData();
                    this.close();
                }).catch(error => {
                    this.isProcessing = 0;
                });
            },

            destroy(id) {
                axios.delete('/puzzles/' + id).then(response => {
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
                this.item.media.forEach( media => {
                    this.$set(media, 'lang', media.pivot.lang);
                });
                this.editor = 1;
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
            }
        }
    }

</script>
