<template>
    <div class="samgiits">
        <div class="samgiits-title">
            <div>
                <template v-if="dc_page">{{ __('Prabhat Samgiits') }}</template>
            </div>
            <div class="samgiits-tools">

                <a :href="current_page" v-if="filters.favorites || filters.premium || filters.today" class="samgiits-link linkTransition">
                    <span class="appIcon msppIcons-rotate-ccw" :title="__('Set default')"></span>
                </a>
                <div v-if="samgiits_page" class="samgiits-settings" @click="settings = true">
                    <div class="msppIcons msppIcons-settings"></div>
                </div>
                <div v-if="samgiits.length" class="samgiits-itemCopyLink linkTransition" @click="copy_link()">
                    <template v-if="copied" >
                        <span class="appIcon msppIcons-copy" :title="__('Link is copied')"></span>
                    </template>
                    <template v-else>
                        <span class="appIcon msppIcons-share-2" :title="__('Copy link to this list')"></span>
                    </template>
                </div>
            </div>
        </div>
        <div v-if="samgiit_tools">
            <div class="samgiits-itemChoose">

                <div class="samgiits-itemChooseFieldWrapper">
                    <div class="msppIcons msppIcons-search" v-if="!samgiits.length" @click="search()"></div>
                    <div class="msppIcons msppIcons-x" v-else @click="samgiits = []; filters.samgits = null; chosen_samgiit = null"></div>
                    <input class="samgiits-itemChooseField" type="text" v-model.lazy="filters.samgits" :placeholder="__('Number or word of Prabhat Samgiit')">
                </div>
                <div class="samgiits-itemChooseButtons">
                    <div class="samgiits-itemChooseButton" :class="{ 'active': filters.favorites }" @click="getFavoriteSamgiits" :title="__('Favorite samgiits')">
                        <div class="msppIcons msppIcons-heart-empty"></div>
                    </div>
                    <div class="samgiits-itemChooseButton" :class="{ 'active': filters.premium }" @click="getPremiumSamgiits" :title="__('Premium samgiits')">
                        <div class="msppIcons msppIcons-sunrise"></div>
                    </div>
                    <div class="samgiits-itemChooseButton" :class="{ 'active': filters.today }" @click="getTodaySamgiits" :title="__('Day samgiits')">
                        <div class="msppIcons msppIcons-calendar"></div>
                    </div>
                </div>
            </div>

        </div>

        <div v-else>
            <div class="samgiits-itemMore" @click="samgiit_tools = true">
                <span class="appIcons msppIcons-external-link"></span>&nbsp;{{ __('More Prabhat Samgiits') }}
            </div>

        </div>
        <div v-if="samgiits.length" class="samgiits-itemCopy" @click="copy_link()">
            <template v-if="copied" >
                <span class="appIcon msppIcons-copy"></span>&nbsp;<span>{{ __('Link is copied') }}</span>
            </template>
            <template v-else>
                <span class="appIcon msppIcons-share-2"></span>&nbsp;<span>{{ __('Copy link to this list') }}</span>
            </template>
        </div>
        <div class="samgiits-list" v-show="samgiits.length || filters.today">
            <div class="amBlock amBlock-title samgiits-listTitle">
                <div class="samgiits-listTitleDaySamgiits" v-show="filters.today">
                    <div>{{ __('Samgiits written on') + '&nbsp;' + today }}</div>
                    <div ref="calendar">
                        <div :title="__('Choose')" data-input>
                            <span class="appIcons msppIcons-date"></span>
                        </div>
                    </div>
                </div>
                <div v-show="filters.premium">
                    {{ __('Premium samgiits') }}
                </div>
                <div v-show="filters.favorites">
                    {{ __('Favorite samgiits') }}
                </div>
                <div v-if="!filters.favorites && !filters.premium && !filters.today && !samgiits_page">
                    {{ __('Samgiits for DC') }}
                </div>
            </div>
            <template>
                <div class="samgiits-item" v-if="samgiits.length" v-for="(samgiit, index) of samgiits" >
                    <!--<div class="amDCPage-bookmarkAnchor"><a :id=("samgiit" + samgiit.samgiita_number)></a></div>-->
                    <template v-if="!expand_samgiits[index]">
                        <div class="samgiits-itemTitle withSevronRight" @click="mess_with_samgiit_expand(index)">
                            {{ samgiit.samgiita_number }} {{ samgiit.title }}
                        </div>
                        <span class="samgiits-itemFavorite" @click="favorite(samgiit)" :class="{'marked': samgiit.favorite}">
                                    <span class="msppIcons msppIcons-heart-empty"></span>
                                    <span class="msppIcons msppIcons-heart-full"></span>
                                </span>
                    </template>
                    <template v-else>
                        <div class="samgiits-itemExpand">
                            <div class="samgiits-itemTitleWrapper">
                                <span class="samgiits-itemTitle withSevronLeft" @click="mess_with_samgiit_expand(index)">
                                    {{ samgiit.samgiita_number }} {{ samgiit.title }}
                                </span>
                                <span class="samgiits-itemFavorite" style="z-index: 1000" @click="favorite(samgiit)" :class="{'marked': samgiit.favorite}">
                                    <span class="msppIcons msppIcons-heart-empty"></span>
                                    <span class="msppIcons msppIcons-heart-full"></span>
                                </span>
                            </div>
                            <div class="samgiits-itemTitleSub">{{ __('Translation of samgiit') }}</div>
                            <div class="samgiits-itemText" v-html="samgiit.translation"></div>
                            <div class="samgiits-itemTitleSub">{{ __('Text of samgiit') }}</div>
                            <div class="samgiits-itemText" v-html="samgiit.transcription"></div>
                            <div class="samgiits-itemAudio" v-if="samgiit.mp3" v-for="mp3 of samgiit.mp3">
                                <audio-player :type="{'url': 'link', 'file':'file'}[mp3.source]" :file="mp3.path"></audio-player>
                            </div>
                        </div>
                    </template>
                </div>
                <div v-else>
                    {{ __('No matches') }}
                </div>
            </template>
        </div>
        <fs-modal-window v-show="settings" id="amDCPageModal-settings" @close="settings = false"
                         @cancel="settings = false" :windowName="__('Settings')">
            <settings-panel :tl="tl" :ml="ml" @saved="refresh" entity="user"></settings-panel>
        </fs-modal-window>
    </div>
</template>
<script>
    let moment = require('moment');

    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import 'flatpickr/dist/l10n/ru.js'

    export default {
        props: ['ps', 'ml', 'tl'],

        components: {flatPickr},

        data() {
            return {
                samgiits: [],
                expand_samgiits: [],

                filters: {
                    samgits: null,

                    today: false,
                    favorites: false,
                    premium: false,
                    random: false,

                    date: null
                },

                datePickerConfig: {
                    disableMobile: "true",
                    altInput: true,
                    altFormat: 'd-m-y',
                    dateFormat: "Y-m-d",
                    locale: 'ru'
                },

                samgiit_tools: false,
                samgiits_page: false,
                dc_page: false,
                copied: false,
                watch_filter_samgiits: false,
                settings: false,

                pickr: {}
            }
        },

        mounted() {
            if(window.location.pathname === '/prabhat-samgiits') {
                this.samgiit_tools = true;
                this.samgiits_page = true;
            }
            if(window.location.pathname === '/dc') {
                this.dc_page = true;
            }
            if(this.ps) {
                let numbers = this.ps.split(',');

                if(numbers.length === 1) {
                    this.filters.samgits = numbers[0];
                    this.getSamgiits(true);
                } else {
                    numbers.forEach(number => {
                        this.filters.samgits = number;
                        this.getSamgiits(true);
                    })
                    this.filters.samgits = numbers.join(',');
                }
            }
            else if(typeof(this.$route.query.today) !== 'undefined') {
                this.getTodaySamgiits();
            } else if(typeof(this.$route.query.premium) !== 'undefined') {
                this.getPremiumSamgiits();
            }else if(typeof(this.$route.query.favorites) !== 'undefined') {
                this.getFavoriteSamgiits();
            } else if(!this.samgiits_page) {
                this.filters.random = true;
                this.getSamgiits();
            }
            let that = this;
            this.pickr = flatpickr(this.$refs.calendar, {
                onChange: function(selectedDates, dateStr, instance) {
                    that.filters.date = moment(dateStr).format('DDMM');
                },
                wrap: true,
                disableMobile: true
            });
        },

        watch: {
            'filters.samgits'(newVer, oldVer) {
                console.log(oldVer + ', ' + newVer);
                if(this.watch_filter_samgiits) {
                    if(this.ps) {
                        this.ps = null;
                        this.filters.samgits = null;
                    } else if(this.filters.samgits) {
                        this.filters.premium = false;
                        this.filters.favorites = false;
                        this.filters.today = false;
                        this.filters.random = false;

                        this.expand_samgiits = [];
                        this.getSamgiits();
                    } else if(oldVer === null) {
                        this.filters.random = true;
                        this.getSamgiits();
                    }
                }
            },

            'filters.date'() {
                this.getSamgiits();
            }
        },

        computed: {
            today() {
                return this.filters.date ? moment(this.filters.date, 'DDMM').format('DD.MM') : moment().format('DD.MM');
            },
            current_page() {
                return window.location.pathname;
            }
        },

        methods: {
            getSamgiits(add = false) {
                let params = {
                    samgits: this.filters.samgits ? this.filters.samgits : null,

                    today: this.filters.today ? this.filters.today : null,
                    favorites: this.filters.favorites ? this.filters.favorites : null,
                    premium: this.filters.premium ? this.filters.premium : null,
                    random: this.filters.random ? this.filters.random : null,

                    date: this.filters.date ? this.filters.date : null,

                    ml: this.ml ? this.ml : null,
                    tl: this.tl ? this.tl : null,
                }

                axios.get('/get-samgits', {params: params}).then( response => {
                    if(add) {
                        this.samgiits = this.samgiits.concat(response.data.samgiits);
                        response.data.samgiits.forEach(samgiit => {
                            this.expand_samgiits.push(true);
                        });
                    } else {
                        this.samgiits = response.data.samgiits;
                        response.data.samgiits.forEach(samgiit => {
                            this.expand_samgiits.push(false);
                        });
                    }
                    this.watch_filter_samgiits = true;
                })
            },

            getTodaySamgiits() {
                this.filters.samgits = null;
                this.filters.today = true;
                this.filters.favorites = false;
                this.filters.premium = false;
                this.filters.random = false;

                this.expand_samgiits = [];
                this.getSamgiits();
            },

            getFavoriteSamgiits() {
                this.filters.samgits = null;
                this.filters.today = false;
                this.filters.favorites = true;
                this.filters.premium = false;
                this.filters.random = false;

                this.expand_samgiits = [];
                this.getSamgiits();
            },

            getPremiumSamgiits() {
                this.filters.samgits = null;
                this.filters.today = false;
                this.filters.favorites = false;
                this.filters.premium = true;
                this.filters.random = false;

                this.expand_samgiits = [];
                this.getSamgiits();
            },

            favorite(samgit) {
                axios.put('/favorite/' + samgit.id).then(response => {
                    samgit.favorite = !samgit.favorite;
                });
            },

            search() {
                if(this.filters.samgits) {
                    this.expand_samgiits = [];
                    this.getSamgiits();
                }
            },

            copy_link() {
                let $tmp = $("<textarea>");
                let args = this.samgiits.map(samgiit => samgiit.id).join(',')

                $("body").append($tmp);
                $tmp.val(window.location.origin + window.location.pathname + '?ps=' + args).select();
                document.execCommand("copy");
                $tmp.remove();

                this.copied = true;

                setTimeout(() => {
                    this.copied = false;
                }, 3000);
            },

            mess_with_samgiit_expand(index) {
                this.$set(this.expand_samgiits, index, !this.expand_samgiits[index]);
            },

            refresh() {
                document.location.reload();
            }
        }
    }
</script>

