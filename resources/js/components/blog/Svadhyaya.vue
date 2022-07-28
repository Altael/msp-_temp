<template>
    <div class="amWidth" v-show="svadhyaya" :class="{'appBlogNewsModal-svadhyaya': show_interface, 'amDCPage-svadhyaya': !show_interface}">
        <div class="appBlogNewsModal-svadhyayaLineBtn amWidth" v-if="show_interface">
            <lang-setting id="amSvadhyayaLang" v-model="locale" :langs="available_langs"></lang-setting>
            <div class="appBlogNewsModal-svadhyayaLine"></div>
            <div class="btnClose" @click="$parent.modal = null"></div>
        </div>
        <div class="amSvadhyaya-content">
            <div class="amSvadhyaya-contentHead">
                <div class="amSvadhyaya-contentHeadBtn left" @click="prevSvadhyaya">&larr;</div>
                <div v-if="show_interface" class="amSvadhyaya-contentHeadTitle" v-html="svadhyaya['title_' + locale]"></div>
                <div class="amSvadhyaya-contentHeadBtn right" @click="nextSvadhyaya">&rarr;</div>
            </div>

            <div class="appBlogNewsModal-svadhyayaText" v-html="svadhyaya[locale]"></div>

            <div class="appBlogNewsModal-svadhyayaWrap">
                <div class="appBlogNewsModal-svadhyayaSource">{{ svadhyaya['source_' + locale] }}</div>
                <div class="appBlogNewsModal-svadhyayaAuthor">{{ svadhyaya['author_' + locale] }}</div>
                <div class="appBlogNewsModal-svadhyayaDate">{{ svadhyaya['record_date_' + locale] }}</div>
                <div class="appBlogNewsModal-svadhyayaPlace">{{ svadhyaya['place_' + locale] }}</div>
            </div>

            <div class="appBlogNewsModal-svadhyayaExplain">
                <template v-for="lang of {uk: ['uk', 'ru', 'en'], ru: ['ru', 'en'], en: ['en']}[locale]" v-if="there_is[lang]">
                    <template v-if="svadhyaya[svadhyaya['original_comentary_lang'] + '_comentary_seju_' + lang]">
                        <div class="appBlogNewsModal-svadhyayaTitle">
                            <div>{{ {
                                uk: 'Пояснення свадх\'яї від',
                                ru: 'Пояснение свадхьяи от',
                                en: 'Svadhyaya explanation by'
                                }[lang] }}</div>
                            <div>
                                {{ svadhyaya[svadhyaya['original_comentary_lang'] + '_comentary_seju_' + lang] }}
                                <template v-if="svadhyaya['original_comentary_lang'] !== lang && svadhyaya[lang + '_comentary_seju_' + lang]">
                                    {{ ' (' + {uk: 'укр.озвуч. ', ru: 'рус.озвуч. ', en: 'en.narrat. '}[lang] + svadhyaya[lang + '_comentary_seju_' + lang] + ')' }}
                                </template>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="appBlogNewsModal-svadhyayaTitle">
                            <div>
                                {{ {
                                uk: 'Пояснення свадх\'яї',
                                ru: 'Пояснение свадхьяи',
                                en: 'Svadhyaya explanation'
                                }[lang] }}
                            </div>
                        </div>
                    </template>
                    <div class="appBlogNewsModal-svadhyayaAudio" v-for="media of svadhyaya.media" v-if="media.pivot.lang === lang">
                    <template v-if="media.type === 'audio'">
                        <audio-player :file="media.path"></audio-player>
                    </template>
                    <template v-else>
                        <!--<info :with-text="false" title="Svadhyaya" icon="msppIcons-arrow-up-right">
                            <div class="infoBlock-video">
                                <div class="iframeResponsive">
                                    <video controls :src="'media/' + media.path"></video>
                                </div>
                            </div>
                        </info>-->
                        <div class="iframeResponsive">
                            <video controls :src="'media/' + media.path" ></video>
                        </div>
                    </template>
                </div>
                </template>
            </div>

            <div class="appBlogNewsModal-svadhyayaStatistics">
                <template v-if="index === 0">
                    <div>
                        {{ __('Today') + ' ' + __('svadhyaya was opened')  + ' ' + statistics.day_all + ' (' + statistics.day_unique + ') ' + __('times')}}
                    </div>
                </template>
                <div>
                    {{ index === 0 ? __('Svadhyaya opened this week') : (__('Svadhyaya opened') + ' ' + index * -1 + ' ' + __('week(-s) ago')) }}: {{ statistics.week_all + ' (' + statistics.week_unique + ')' }} {{ __('times') }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let moment = require('moment');

    export default {
        props: {
            show_interface: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                locale: 'ru',
                svadhyaya: {},
                index: 0,
                settings_data: null,
                statistics: {
                    day_all: 0,
                    day_unique: 0,
                    week_all: 0,
                    week_unique: 0,
                }
            }
        },

        mounted() {
            this.getSvadhyaya();
            this.getSettings();
            this.getStatistics();
        },

        computed: {
            there_is() {
                let is_there = {
                    en: false,
                    ru: false,
                    uk: false
                };
                if(this.svadhyaya && this.svadhyaya.media) {

                    this.svadhyaya.media.forEach(media => {
                        if(media.pivot.lang === 'en') is_there.en = true;
                    })

                    this.svadhyaya.media.forEach(media => {
                        if(media.pivot.lang === 'ru') is_there.ru = true;
                    })

                    this.svadhyaya.media.forEach(media => {
                        if(media.pivot.lang === 'uk') is_there.uk = true;
                    })
                }
                return is_there;
            },

            available_langs() {
                let langs = ['en'];

                if(this.svadhyaya.ru) langs.push('ru');
                if(this.svadhyaya.uk) langs.push('uk');

                return langs;
            }
        },

        watch: {
            locale() {
                if(this.settings_data) {
                    this.settings_data.dc_main_lang = this.locale;
                    axios.post('/settings/user', {settings: this.settings_data}).then( response => {

                    });
                }
                if(this.locale === 'uk' && !this.svadhyaya.uk) this.locale = 'ru';
                if(this.locale === 'ru' && !this.svadhyaya.ru) this.locale = 'en';
                this.$forceUpdate;
            },
            index() {
                this.getSvadhyaya();
                this.getStatistics();
            }
        },

        methods: {
            getSettings() {
                axios.get('/settings/user').then(response => {
                    if(this.$route.query.ml) {
                        this.locale = this.$route.query.ml;
                    } else {
                        this.locale = response.data.settings.dc_main_lang;
                    }
                    this.$nextTick(() => {
                        this.settings_data = response.data.settings;
                    });
                });
            },

            getSvadhyaya() {
                axios.get('/reward/svadhyaya', {params: {index: this.index}}).then(response => {
                    this.svadhyaya = response.data.svadhyaya;
                }).catch( respomse => {

                });
            },

            getStatistics() {
                let params = {};

                params = {
                    type: 'svadhyaya-open',
                    start: moment().format('YYYY.MM.DD'),
                    end: moment().format('YYYY.MM.DD'),
                };
                axios.get('/api/log-show', {params}).then(response => {
                    this.statistics.day_all = response.data.events.length;
                    this.$forceUpdate();
                });

                params = {
                    type: 'svadhyaya-open',
                    start: moment().format('YYYY.MM.DD'),
                    end: moment().format('YYYY.MM.DD'),
                    unique: true
                };
                axios.get('/api/log-show', {params}).then(response => {
                    this.statistics.day_unique = response.data.events.length;
                    this.$forceUpdate();
                });

                params = {
                    type: 'svadhyaya-open',
                    start: moment().startOf('week').subtract(this.index * -1, 'weeks').format('YYYY.MM.DD'),
                    end: moment().endOf('week').subtract(this.index * -1, 'weeks').format('YYYY.MM.DD'),
                };
                axios.get('/api/log-show', {params}).then(response => {
                    this.statistics.week_all = response.data.events.length;
                    this.$forceUpdate();
                });

                params = {
                    type: 'svadhyaya-open',
                    start: moment().startOf('week').subtract(this.index * -1, 'weeks').format('YYYY.MM.DD'),
                    end: moment().endOf('week').subtract(this.index * -1, 'weeks').format('YYYY.MM.DD'),
                    unique: true
                };
                axios.get('/api/log-show', {params}).then(response => {
                    this.statistics.week_unique = response.data.events.length;
                    this.$forceUpdate();
                });
            },

            prevSvadhyaya() {
                this.index--;
            },

            nextSvadhyaya() {
                if(this.index < 0) this.index++;
            }
        }
    }

</script>
