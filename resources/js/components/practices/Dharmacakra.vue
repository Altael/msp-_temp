<template>
    <div id="amDCPage">
        <div class="amDCPage-settings" @click="settings = true">
            <div class="msppIcons msppIcons-settings"></div>
        </div>
        <div class="amDCPage-content">
            <div class="amDCPage-items">
                <div class="amDCPage-bookmarkAnchor"><a id="samgiits"></a></div>
                <div class="amDCPage-item amDCPage-samgiits">
                    <prabhat-samgiits :ps="ps" :ml="ml" :tl="tl"></prabhat-samgiits>
                </div>
                <div class="amDCPage-bookmarkAnchor"><a id="kiirtan"></a></div>
                <div class="amDCPage-item amDCPage-kiirtan appItemHidden">
                    <template v-if="!kirtan">
                        {{ __('Minutes to kirtan') }}
                        <input type="number" v-model="kirtan_minutes">
                        <div @click="startKirtanTimer">{{ __('Start') }}</div>
                    </template>
                    <template v-if="kirtan">
                        {{ Math.trunc(kirtan_timer / 60) }}:{{ kirtan_timer % 60 }}
                    </template>
                </div>
                <div class="amDCPage-bookmarkAnchor"><a id="samgacchadvam"></a></div>
                <div v-if="mantras.samgacchadvam" class="amDCPage-item amDCPage-mantra amDCPage-samgacchadvam" :class="{'open': mantras_state.samgacchadvam}">
                    <div class="amDCPage-mantraTitle" @click="mantras_state.samgacchadvam = !mantras_state.samgacchadvam">
                        {{ mantras.samgacchadvam.title }}
                    </div>
                    <template v-if="mantras_state.samgacchadvam">
                        <div class="amDCPage-mantraTranscription" v-html="mantras.samgacchadvam.transcription"></div>
                        <div class="amDCPage-mantraTranslation" v-html="mantras.samgacchadvam.translation"></div>
                        <div class="amDCPage-mantraAudio" v-for="song of JSON.parse(mantras.samgacchadvam.mp3)">
                            <audio-player :file="'../mantras/' + song"></audio-player>
                        </div>
                    </template>
                </div>
                <div class="amDCPage-bookmarkAnchor"><a id="meditation"></a></div>
                <div class="amDCPage-item amDCPage-meditation appItemHidden">
                    <template v-if="!meditation">
                        {{ __('Minutes to meditate') }}
                        <input type="number" v-model="meditation_minutes">
                        <div @click="startMeditationTimer">{{ __('Start') }}</div>
                    </template>
                    <template v-if="meditation">
                        {{ Math.trunc(meditation_timer / 60) }}:{{ meditation_timer % 60 }}
                    </template>
                </div>
                <div class="amDCPage-bookmarkAnchor"><a id="nityam_shudam"></a></div>
                <div v-if="mantras.nityam_shudam" class="amDCPage-item amDCPage-mantra amDCPage-nityam_shudam" :class="{'open': mantras_state.nityam_shudam}">
                    <div class="amDCPage-mantraTitle" @click="mantras_state.nityam_shudam = !mantras_state.nityam_shudam">
                        {{ mantras.nityam_shudam.title }}
                    </div>
                    <template v-if="mantras_state.nityam_shudam">
                        <div class="amDCPage-mantraTranscription" v-html="mantras.nityam_shudam.transcription"></div>
                        <div class="amDCPage-mantraTranslation" v-html="mantras.nityam_shudam.translation"></div>
                        <div class="amDCPage-mantraAudio" v-for="song of JSON.parse(mantras.nityam_shudam.mp3)">
                            <audio-player :file="'../mantras/' + song"></audio-player>
                        </div>
                    </template>
                </div>
                <div class="amDCPage-bookmarkAnchor"><a id="guru_puja"></a></div>
                <div v-if="mantras.guru_puja" class="amDCPage-item amDCPage-mantra amDCPage-guru_puja" :class="{'open': mantras_state.guru_puja}">
                    <div class="amDCPage-mantraTitle" @click="mantras_state.guru_puja = !mantras_state.guru_puja">
                        {{ mantras.guru_puja.title }}
                    </div>
                    <template v-if="mantras_state.guru_puja">
                        <div class="amDCPage-mantraTranscription" v-html="mantras.guru_puja.transcription"></div>
                        <div class="amDCPage-mantraTranslation" v-html="mantras.guru_puja.translation"></div>
                        <div class="amDCPage-mantraAudio" v-for="song of JSON.parse(mantras.guru_puja.mp3)">
                            <audio-player :file="'../mantras/' + song"></audio-player>
                        </div>
                    </template>
                </div>
                <div class="amDCPage-bookmarkAnchor"><a id="pranama"></a></div>
                <div v-if="mantras.pranama" class="amDCPage-item amDCPage-mantra amDCPage-pranama" :class="{'open': mantras_state.pranama}">
                    <div class="amDCPage-mantraTitle" @click="mantras_state.pranama = !mantras_state.pranama">
                        {{ mantras.pranama.title }}
                    </div>
                    <template v-if="mantras_state.pranama">
                        <div class="amDCPage-mantraTranscription" v-html="mantras.pranama.transcription"></div>
                        <div class="amDCPage-mantraTranslation" v-html="mantras.pranama.translation"></div>
                        <div class="amDCPage-mantraAudio" v-for="song of JSON.parse(mantras.pranama.mp3)">
                            <audio-player :file="'../mantras/' + song"></audio-player>
                        </div>
                    </template>
                </div>
                <div class="amDCPage-bookmarkAnchor"><a id="supreme_command"></a></div>
                <div v-if="mantras.supreme_command" class="amDCPage-item amDCPage-mantra amDCPage-supreme_command" :class="{'open': mantras_state.supreme_command}">
                    <div class="amDCPage-mantraTitle" @click="mantras_state.supreme_command = !mantras_state.supreme_command">
                        {{ mantras.supreme_command.title }}
                    </div>
                    <template v-if="mantras_state.supreme_command">
                        <div class="amDCPage-mantraTranslation" v-html="mantras.supreme_command.translation"></div>
                    </template>
                </div>
                <div class="amDCPage-bookmarkAnchor"><a id="svadhyaya"></a></div>
                <div v-if="svadhyaya" class="amDCPage-item amDCPage-svadhyaya" :class="{'open': mantras_state.svadyaya}">
                    <span class="amDCPage-mantraTitle" @click="mantras_state.svadyaya = !mantras_state.svadyaya">{{ __('Svadhyaya') }}</span>
                    <svadhyaya></svadhyaya>
                </div>
            </div>
            <div class="amDCPage-bookmarks">
                <a href="#samgiits" class="amDCPage-bookmark" title="Prabhat samgiit">
                    <div class="msppIcons-circle"></div>
                </a>
                <a href="#kiirtan" class="amDCPage-bookmark appItemHidden" title="Kiirtan">
                    <div class="msppIcons-codesandbox"></div>
                </a>
                <a href="#samgacchadvam" class="amDCPage-bookmark" title="Samgacchadhvam">
                    <div class="msppIcons-command"></div>
                </a>
                <a href="#meditation" class="amDCPage-bookmark appItemHidden" title="Meditation">
                    <div class="msppIcons-cpu"></div>
                </a>
                <a href="#nityam_shudam" class="amDCPage-bookmark" title="Nityam shudham">
                    <div class="msppIcons-disc"></div>
                </a>
                <a href="#guru_puja" class="amDCPage-bookmark" title="Guru Pudja">
                    <div class="msppIcons-DC"></div>
                </a>
                <a href="#pranama" class="amDCPage-bookmark" title="Pranama Mantra">
                    <div class="msppIcons-guru"></div>
                </a>
                <a href="#supreme_command" class="amDCPage-bookmark" title="Supreme command">
                    <div class="msppIcons-feather"></div>
                </a>
                <a href="#svadhyaya" class="amDCPage-bookmark" title="Svadhyaya">
                    <div class="msppIcons-book1"></div>
                </a>
            </div>
        </div>

        <fs-modal-window v-show="settings" id="amDCPageModal-settings" @close="close"
                         @cancel="close" :windowName="__('Settings')">
            <settings-panel :tl="tl" :ml="ml" @saved="refresh" entity="user"></settings-panel>
        </fs-modal-window>
    </div>
</template>

<script>
    let moment = require('moment');

    export default {

    props: ['ps', 'ml', 'tl'],

    data() {
        return {
            mantras: [],
            mantras_state: {
                samgacchadvam: false,
                nityam_shudam: false,
                guru_puja: false,
                pranama: false,
                supreme_command: false,
                svadyaya: false
            },

            kirtan: 0,
            kirtan_timer: 0,
            kirtan_minutes: 0,

            meditation: 0,
            meditation_timer: 0,
            meditation_minutes: 0,

            svadhyaya: null,
            settings: false,
            settings_changed: false,
            settings_data: null,

            locale: 'ru'
        }
    },

    computed: {
        today() {
            return moment().format('MMMM Do');
        }
    },

    watch: {

    },

    mounted() {
        this.getMantras();
        this.getSettings();
        /*$('.amDCPage-bookmark').click(function() {
            let id = $(this).attr('href');
            let top = $(id).offset().top - 100;
            $('body,html').animate({scrollTop: top}, 1500);
        })*/
    },

    methods: {
        getMantras() {
            let params = {
                type: "dc"
            }

            axios.get('/get-mantras', {params: params}).then( response => {
                this.mantras = response.data.mantras;
            });
        },

        getSettings() {
            axios.get('/settings/user').then(response => {
                this.settings_data = response.data.settings;
                this.locale = response.data.settings.dc_main_lang;
            });
        },

        startMeditationTimer() {
            this.meditation_timer = this.meditation_minutes * 60;
            this.meditation = 1;

            setInterval(() => {
                if(this.meditation_timer > 0)  this.meditation_timer--;
                else this.meditation = 2;
            }, 1000);
        },

        startKirtanTimer() {
            this.kirtan_timer = this.kirtan_minutes * 60;
            this.kirtan = 1;

            setInterval(() => {
                if(this.kirtan_timer > 0)  this.kirtan_timer--;
                else this.kirtan = 2;
            }, 1000);
        },

        getSvadhyaya() {
            axios.get('/reward/svadhyaya').then(response => {
                this.svadhyaya = response.data.svadhyaya;
            });
        },

        close() {
            this.settings = false;
        },

        refresh() {
            document.location.reload();
        }
    }
}
</script>
