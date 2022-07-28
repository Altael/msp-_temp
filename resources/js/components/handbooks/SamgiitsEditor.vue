<template>
    <div class="appSamgiitEditor" id="appSamgiits">
        <div class="appSamgiitEditor-pageTools">
            <div class="appSamgiitEditor-pageToolsButtons">
                <!--<div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" @click="create()">{{ __('Add') }}</div>-->
                <label class="dhrtSwitch textLeft">
                    <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                           v-model="detailed">
                    <span class="dhrtSwitchSpinner"></span>
                    <span class="dhrtSwitchSpinnerText">{{ __('Details') }}</span>
                </label>
            </div>
            <div class="appSamgiitEditor-pageToolsPaginator">
                <pagination v-model="page" :total="total" :per-page="perPage"/>
            </div>
        </div>

        <div class="appTable appSamgiitsList">
            <div class="appTable-row appTable-head appSamgiitsList-head">
                <div class="appTable-col appSamgiitsList-samgiita_number">
                    <div class="appTable-colTop">
                        <div>{{ __('Samgiit') }} {{ __('Number') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.samgiita_number" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-premium appTable-colInline">
                    <div>{{ __('Premium') }}</div>
                    <div class="appSamgiitsList-premiumCheck">
                        <input type="checkbox" v-model.lazy="filters.premium" class="appTable-filterField">
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-title">
                    <div class="appTable-colTop">
                        <div> {{ __('Title') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.title_" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-title">
                    <div class="appTable-colTop">
                        <div>{{ __('EN') }} {{ __('Title') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.title_en" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-title">
                    <div class="appTable-colTop">
                        <div>{{ __('RU') }} {{ __('Title') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.title_ru" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-title">
                    <div class="appTable-colTop">
                        <div>{{ __('UK') }} {{ __('Title') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.title_uk" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>

                <div class="appTable-col appSamgiitsList-transcription_en">
                    <div class="appTable-colTop">
                        <div>{{ __('Transcription') }} {{ __('EN') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.transcription_en" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-translation_en">
                    <div class="appTable-colTop">
                        <div>{{ __('Translation') }} {{ __('EN') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.translation_en" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-transcription_ru">
                    <div class="appTable-colTop">
                        <div>{{ __('Transcription') }} {{ __('RU') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.transcription_ru" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-translation_ru">
                    <div class="appTable-colTop">
                        <div>{{ __('Translation') }} {{ __('RU') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.translation_ru" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-translation_uk" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Translation') }} {{ __('UK') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.translation_uk" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-transcription_uk" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Transcription') }} {{ __('UK') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.transcription_uk" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-daymonth" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Day and month') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.daymonth" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-mp3" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('MP3') }}</div>
                    </div>
                    <div class="appTable-filter">

                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-samgiita_date" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Samgiit') }} {{ __('Date') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.samgiita_date" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-samgiita_theme" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Samgiit') }} {{ __('Theme') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.samgiita_theme" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-samgiita_lyrics" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Samgiit') }} {{ __('Lyrics') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.samgiita_lyrics" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-samgiita_music" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Samgiit') }} {{ __('Music') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.samgiita_music" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-sarkarverse_number" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Sarkarverse') }} {{ __('Number') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.sarkarverse_number" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-sarkarverse_date" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Sarkarverse') }} {{ __('Date') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.sarkarverse_date" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-sarkarverse_title" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Sarkarverse') }} {{ __('Title') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.sarkarverse_title" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-sarkarverse_theme" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Sarkarverse') }} {{ __('Theme') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.sarkarverse_theme" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-sarkarverse_lyrics" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Sarkarverse') }} {{ __('Lyrics') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.sarkarverse_lyrics" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
                <div class="appTable-col appSamgiitsList-sarkarverse_music" v-if="detailed">
                    <div class="appTable-colTop">
                        <div>{{ __('Sarkarverse') }} {{ __('Music') }}</div>
                    </div>
                    <div class="appTable-filter">
                        <input type="text" v-model.lazy="filters.sarkarverse_music" class="appTable-filterField">
                        <div class="appTable-filterIcon appTable-filter_listIcon msppIcons-filter"></div>
                    </div>
                </div>
            </div>
            <div class="appTable-body appSamgiitsList-body">
                <div v-for="(samgiit, index) in samgiits" class="appTable-row">
                    <div class="appTable-col appSamgiitsList-samgiita_number">
                        <div class="textOverflow">
                            <template v-if="samgiit.samgiita_number">
                                <p v-html="samgiit.samgiita_number"></p>
                            </template>
                            <span v-else>
                                {{ __('Samgiit') }} {{ __('Number') }} {{ __('absent') }}
                            </span>
                        </div>
                        <action-dropdown>
                            <a href="#" rel="nofollow" class="dhrtDropdown-item"
                               @click.prevent="edit(samgiit, index)">
                                {{ __('Edit') }}
                            </a>
                        </action-dropdown>
                    </div>
                    <div class="appTable-col appSamgiitsList-premium">
                        <div class="textOverflowRow">
                            <p>{{ samgiit.premium ? __('Premium song') : __('Not a premium song') }}</p>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-title">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.title">
                                <p v-html="samgiit.title"></p>
                            </template>
                            <span v-else>
                                {{ __('Title') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-title">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.title_en">
                                <p v-html="samgiit.title_en"></p>
                            </template>
                            <span v-else>
                                {{ __('EN') }} {{ __('Title') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-title">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.title_ru">
                                <p v-html="samgiit.title_ru"></p>
                            </template>
                            <span v-else>
                                {{ __('RU') }} {{ __('Title') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-title">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.title_uk">
                                <p v-html="samgiit.title_uk"></p>
                            </template>
                            <span v-else>
                                {{ __('UK') }} {{ __('Title') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>

                    <div class="appTable-col appSamgiitsList-transcription_en">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.transcription_en">
                                <p v-html="samgiit.transcription_en"></p>
                            </template>
                            <span v-else>
                                {{ __('Transcription') }} {{ __('EN') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-translation_en">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.translation_en">
                                <p v-html="samgiit.translation_en"></p>
                            </template>
                            <span v-else>
                                {{ __('Translation') }} {{ __('EN') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-transcription_ru">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.transcription_ru">
                                <p v-html="samgiit.transcription_ru"></p>
                            </template>
                            <span v-else>
                                {{ __('Transcription') }} {{ __('RU') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-translation_ru">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.translation_ru">
                                <p v-html="samgiit.translation_ru"></p>
                            </template>
                            <span v-else>
                                {{ __('Translation') }} {{ __('RU') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-translation_uk" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.translation_uk">
                                <p v-html="samgiit.translation_uk"></p>
                            </template>
                            <span v-else>
                                {{ __('Translation') }} {{ __('UK') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-transcription_uk" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.transcription_uk">
                                <p v-html="samgiit.transcription_uk"></p>
                            </template>
                            <span v-else>
                                {{ __('Transcription') }} {{ __('UK') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-daymonth" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.daymonth">
                                <p v-html="samgiit.daymonth"></p>
                            </template>
                            <span v-else>
                                {{ __('Day and month') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-mp3" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.media">
                                {{ samgiit.media[0].path }}
                            </template>
                            <span v-else>
                                {{ __('MP3') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-samgiita_date" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.samgiita_date">
                                <p v-html="samgiit.samgiita_date"></p>
                            </template>
                            <span v-else>
                                {{ __('Samgiit') }} {{ __('Date') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-samgiita_theme" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.samgiita_theme">
                                <p v-html="samgiit.samgiita_theme"></p>
                            </template>
                            <span v-else>
                                {{ __('Samgiit') }} {{ __('Theme') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-samgiita_lyrics" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.samgiita_lyrics">
                                <p v-html="samgiit.samgiita_lyrics"></p>
                            </template>
                            <span v-else>
                                {{ __('Samgiit') }} {{ __('Lyrics') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-samgiita_music" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.samgiita_music">
                                <p v-html="samgiit.samgiita_music"></p>
                            </template>
                            <span v-else>
                                {{ __('Samgiit') }} {{ __('Music') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-sarkarverse_number" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.sarkarverse_number">
                                <p v-html="samgiit.sarkarverse_number"></p>
                            </template>
                            <span v-else>
                                {{ __('Sarkarverse') }} {{ __('Number') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-sarkarverse_date" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.sarkarverse_date">
                                <p v-html="samgiit.sarkarverse_date"></p>
                            </template>
                            <span v-else>
                                {{ __('Sarkarverse') }} {{ __('Date') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-sarkarverse_title" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.sarkarverse_title">
                                <p v-html="samgiit.sarkarverse_title"></p>
                            </template>
                            <span v-else>
                                {{ __('Sarkarverse') }} {{ __('Title') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-sarkarverse_theme" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.sarkarverse_theme">
                                <p v-html="samgiit.sarkarverse_theme"></p>
                            </template>
                            <span v-else>
                                {{ __('Sarkarverse') }} {{ __('Theme') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-sarkarverse_lyrics" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.sarkarverse_lyrics">
                                <p v-html="samgiit.sarkarverse_lyrics"></p>
                            </template>
                            <span v-else>
                                {{ __('Sarkarverse') }} {{ __('Lyrics') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                    <div class="appTable-col appSamgiitsList-sarkarverse_music" v-if="detailed">
                        <div class="textOverflowRow">
                            <template v-if="samgiit.sarkarverse_music">
                                <p v-html="samgiit.sarkarverse_music"></p>
                            </template>
                            <span v-else>
                                {{ __('Sarkarverse') }} {{ __('Music') }} {{ __('absent') }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <pagination v-if="total >= 50" v-model="page" :total="total" :per-page="perPage"/>

        <fs-modal-window v-if="item && editor" id="appSamgiitEditorModal-itemEdit" @close="close" @enter="save()"
                      :valid="item.samgiita_number && (item.transcription_en || item.translation_en) && !isProcessing"
                      @cancel="close" :buttonList="['Cancel', 'Save']" @save="save()"
                      :windowName="item.title" :windowScrollTop="200">
            <div class="appSamgiitEditorModal-itemEditContent">
                <div class="appSamgiitEditor-pageTools">
                    <div class="appSamgiitEditor-pageToolsButtons">
                        <label class="dhrtSwitch textLeft">
                            <input type="checkbox" class="dhrtCheckbox-noView dhrtSwitchSpinnerCheckbox"
                                   v-model="detailed">
                            <span class="dhrtSwitchSpinner"></span>
                            <span class="dhrtSwitchSpinnerText">{{ __('Details') }}</span>
                        </label>
                    </div>
                    <div class="appSamgiitEditor-itemNumber">
                        <div class="appForm-groupTitle">{{ __('Samgiit') }} {{ __('Number') }}</div>
                        <input type="number" name="sourceRu" v-model="item.samgiita_number" class="appForm-input">
                    </div>
                    <div class="appSamgiitEditor-itemPremium">
                        <div class="appForm-groupTitle">{{ __('Premium') }}</div>
                        <input type="checkbox" name="sourceRu" v-model="item.premium" class="appForm-input">
                    </div>
                </div>
                <div class="appForm-group appSamgiitEditorModal-itemEdit-layout1">
                    <div class="appForm-groupTitle">{{ __('Title') }}</div>
                    <input type="text" name="sourceRu" v-model="item.title" class="appForm-input">
                </div>


                <div class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Title') }} {{ __('EN') }}</div>
                    <input type="text" name="sourceRu" v-model="item.title_en" class="appForm-input">
                </div>
                <div class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Title') }} {{ __('RU') }}</div>
                    <input type="text" name="sourceRu" v-model="item.title_ru" class="appForm-input">
                </div>
                <div class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Title') }} {{ __('UK') }}</div>
                    <input type="text" name="sourceRu" v-model="item.title_uk" class="appForm-input">
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

                <template v-if="editor_lang === 'ru'"> <!--ru-->
                    <div class="appForm-group appSamgiitEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Transcription') }} {{ __('RU') }}</div>
                        <html-editor class="appForm-input html" height="150" :airmode="false" v-model="item.transcription_ru" />
                    </div>
                    <div class="appForm-group appSamgiitEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Translation') }} {{ __('RU') }}</div>
                        <html-editor class="appForm-input html" height="150" :airmode="false" v-model="item.translation_ru" />
                    </div>
                </template>
                <template v-if="editor_lang === 'en'"> <!--en-->
                    <div class="appForm-group appSamgiitEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Transcription') }} {{ __('EN') }}</div>
                        <html-editor class="appForm-input html" height="150" :airmode="false" v-model="item.transcription_en" />
                    </div>
                    <div class="appForm-group appSamgiitEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Translation') }} {{ __('EN') }}</div>
                        <html-editor class="appForm-input html" height="150" :airmode="false" v-model="item.translation_en" />
                    </div>
                </template>
                <template v-if="editor_lang === 'uk'"> <!--uk-->
                    <div class="appForm-group appSamgiitEditorModal-itemEdit-layout2">
                        <div class="appForm-group8Title">{{ __('Translation') }} {{ __('UK') }}</div>
                        <html-editor class="appForm-input html" height="150" :airmode="false" v-model="item.translation_uk" />
                    </div>
                    <div class="appForm-group appSamgiitEditorModal-itemEdit-layout2">
                        <div class="appForm-groupTitle">{{ __('Transcription') }} {{ __('UK') }}</div>
                        <html-editor class="appForm-input html" height="150" :airmode="false" v-model="item.transcription_uk" />
                    </div>
                </template>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout1" >
                    <div class="appForm-groupTitle">{{ __('MP3') }}</div>
                    <template v-for="media of item.media">
                        <div v-if="media" class="textOverflowRow" v-html="media.path"></div>
                    </template>
                    <div class="dhrtModalWindow-footerButton" @click="media_editor = true">{{ __('Edit samgiit media') }}</div>
                </div>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout1" >
                    <upload-file @media-uploaded="getMedia"></upload-file>
                    <add-web-file @saved="getMedia"></add-web-file>
                </div>

                <!--<div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout2 appSamgiitEditorModal-itemEditNotFirst" >
                    <div class="appForm-groupTitle">{{ __('Samgiit') }} {{ __('Date') }}</div>
                    <template v-for="media of item.media">
                        <input type="text" name="sourceRu" v-model="media.path" class="appForm-input">
                    </template>
                </div>-->
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Samgiit') }} {{ __('Theme') }}</div>
                    <input type="text" name="sourceRu" v-model="item.samgiita_theme" class="appForm-input">
                </div>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Samgiit') }} {{ __('Lyrics') }}</div>
                    <input type="text" name="sourceRu" v-model="item.samgiita_lyrics" class="appForm-input">
                </div>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Samgiit') }} {{ __('Music') }}</div>
                    <input type="text" name="sourceRu" v-model="item.samgiita_music" class="appForm-input">
                </div>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Sarkarverse') }} {{ __('Number') }}</div>
                    <input type="number" name="sourceRu" v-model="item.sarkarverse_number" class="appForm-input">
                </div>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Sarkarverse') }} {{ __('Date') }}</div>
                    <input type="text" name="sourceRu" v-model="item.sarkarverse_date" class="appForm-input">
                </div>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Sarkarverse') }} {{ __('Title') }}</div>
                    <input type="text" name="sourceRu" v-model="item.sarkarverse_title" class="appForm-input">
                </div>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Sarkarverse') }} {{ __('Theme') }}</div>
                    <input type="text" name="sourceRu" v-model="item.sarkarverse_theme" class="appForm-input">
                </div>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Sarkarverse') }} {{ __('Lyrics') }}</div>
                    <input type="text" name="sourceRu" v-model="item.sarkarverse_lyrics" class="appForm-input">
                </div>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Sarkarverse') }} {{ __('Music') }}</div>
                    <input type="text" name="sourceRu" v-model="item.sarkarverse_music" class="appForm-input">
                </div>
                <div v-if="detailed" class="appForm-group appSamgiitEditorModal-itemEdit-layout3">
                    <div class="appForm-groupTitle">{{ __('Day and month') }}</div>
                    <input type="text" name="sourceRu" v-model="item.daymonth" class="appForm-input">
                </div>

            </div>

        </fs-modal-window>

        <fs-modal-window v-if="item && media_editor" id="appSamgiitEditorModal-itemEditMedia" @close="media_editor = false" @enter="save(false)"
                         :valid="!isProcessing"
                         :buttonList="['Close', 'Save']" @save="save(false)"
                         :windowName="item.samgiita_number + ' ' + __('media')">
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
    import 'flatpickr/dist/l10n/ru.js';

    import Multiselect from 'vue-multiselect';

    let moment = require('moment');

    import Textarea from "../../../../vue/src/views/forms/form-elements/textarea/Textarea";

    export default {
        props: ['samgiit'],

        components: {
            Textarea,
            flatPickr,
            Multiselect
        },

        data() {
            return {
                page: 1,
                perPage: 50,
                total: 0,
                detailed: false,

                samgiits: [],
                item: null,
                itemIndex: null,
                editor: null,
                media_editor: false,
                detail: null,
                remove: null,
                isProcessing: false,

                audio: [],
                video: [],

                datePickerConfig: {
                    disableMobile: "true",
                    altInput: true,
                    altFormat: 'd-m-y',
                    disable: [],
                    locale: 'ru'
                },

                sortBy: 'date',
                sortOrder: 'desc',

                editor_lang: 'en',

                filters: {
                    transcription_en: '',
                    translation_en: '',
                    daymonth: '',
                    title_en: '',
                    title_ru: '',
                    title_uk: '',
                    transcription_ru: '',
                    translation_ru: '',
                    translation_uk: '',
                    transcription_uk: '',
                    premium: false,
                    samgiita_number: '',
                    samgiita_date: '',
                    samgiita_title: '',
                    samgiita_theme: '',
                    samgiita_lyrics: '',
                    samgiita_music: '',
                    sarkarverse_number: '',
                    sarkarverse_date: '',
                    sarkarverse_title: '',
                    sarkarverse_theme: '',
                    sarkarverse_lyrics: '',
                    sarkarverse_music: ''
                }
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
                return this.audio.concat(this.video);
            }
        },

        watch: {
            page() {
                this.getData();
            },

            filters: {
                deep: true,
                handler() {
                    /*if (this.filters.type === "null") this.filters.type = null;*/
                    this.page = 1;
                    this.getData();
                }
            }
        },

        methods: {
            getData() {
                let params = {
                    transcription_en: this.filters.transcription_en ? this.filters.transcription_en : null,
                    translation_en: this.filters.translation_en ? this.filters.translation_en : null,
                    daymonth: this.filters.daymonth ? this.filters.daymonth : null,
                    title: this.filters.title ? this.filters.title : null,
                    transcription_ru: this.filters.transcription_ru ? this.filters.transcription_ru : null,
                    translation_ru: this.filters.translation_ru ? this.filters.translation_ru : null,
                    translation_uk: this.filters.translation_uk ? this.filters.translation_uk : null,
                    transcription_uk: this.filters.transcription_uk ? this.filters.transcription_uk : null,
                    premium: this.filters.premium ? this.filters.premium : null,
                    samgiita_number: this.filters.samgiita_number ? this.filters.samgiita_number : null,
                    samgiita_date: this.filters.samgiita_date ? this.filters.samgiita_date : null,
                    title_en: this.filters.title_en ? this.filters.title_en : null,
                    title_ru: this.filters.title_ru ? this.filters.title_ru : null,
                    title_uk: this.filters.title_uk ? this.filters.title_uk : null,
                    samgiita_theme: this.filters.samgiita_theme ? this.filters.samgiita_theme : null,
                    samgiita_lyrics: this.filters.samgiita_lyrics ? this.filters.samgiita_lyrics : null,
                    samgiita_music: this.filters.samgiita_music ? this.filters.samgiita_music : null,
                    sarkarverse_number: this.filters.sarkarverse_number ? this.filters.sarkarverse_number : null,
                    sarkarverse_date: this.filters.sarkarverse_date ? this.filters.sarkarverse_date : null,
                    sarkarverse_title: this.filters.sarkarverse_title ? this.filters.sarkarverse_title : null,
                    sarkarverse_theme: this.filters.sarkarverse_theme ? this.filters.sarkarverse_theme : null,
                    sarkarverse_lyrics: this.filters.sarkarverse_lyrics ? this.filters.sarkarverse_lyrics : null,
                    sarkarverse_music: this.filters.sarkarverse_music ? this.filters.sarkarverse_music : null,

                    samgiit: this.samgiit ? this.samgiit : null,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,

                    take: this.perPage,
                    skip: this.skip,
                };

                axios.get('/api/samgiits', {params: params}).then(response => {
                    this.samgiits = response.data.samgiits;
                    this.total = response.data.total;
                    if(this.samgiit) {
                        this.edit(this.samgiits[0], 0);
                    }
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

            dateFormat(date) {
                return moment(date).format('DD.MM.YY');
            },

            save(close = true) {
                if (this.isProcessing) return;
                this.isProcessing = 1;
                axios.post('/api/samgiits', {samgiit: this.item}).then(response => {
                    this.isProcessing = 0;
                    if(close) {
                        this.getData();
                        this.close();
                    }
                }).catch(error => {
                    this.isProcessing = 0;
                });
            },

            add_media() {
                this.item.media.push({
                    id: null,
                    hidden: 0
                });
            },

            remove_media(key) {
                this.item.media.splice(key, 1);
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
                this.media_editor = false;
            },

            edit(item, index) {
                this.item = JSON.parse(JSON.stringify(item));
                if(!this.item.mp3) {
                    this.item.mp3 = [];
                    this.item.mp3[0] = "";
                }
                this.itemIndex = index;
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
