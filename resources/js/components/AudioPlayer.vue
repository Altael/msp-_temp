<template>
    <div class="audioPlayer">
        <audio :src="src" class="audioPlayer-main" ref="player"></audio>

        <div class="audioPlayer-custom">
            <div class="audioPlayer-customButton">
                <div class="audioPlayer-customButtonPlay" v-if="!playing" @click="play"></div>
                <div class="audioPlayer-customButtonPause" v-if="playing" @click="stop"></div>
            </div>
            <div class="audioPlayer-customTrackName">{{ name }}</div>
            <vue-range-slider :min="0" :max="1" :step="0.01" v-model="elapsed" ref="slider"
                              :height="4"
                              :width="'100%'"
                              :tooltip-style="{'display': 'none'}"
                              :process-style="{'background-color': '#fff'}"
                              :bg-style="{'background-color': '#6F6F6F'}"
            ></vue-range-slider>
            <div class="audioPlayer-customTime">
                <template v-if="remaining">-{{ remaining }}</template>
                <template v-else>{{ formatTime(duration) }}</template>
            </div>
        </div>
    </div>
</template>

<script>
    import 'vue-range-component/dist/vue-range-slider.css'
    import VueRangeSlider from 'vue-range-component'

    export default {
        components: {
            VueRangeSlider
        },

        props: {
            file: {
                type: String,
                default: null
            },
            type: {
                type: String,
                default: 'file'
            }
        },

        data() {
            return {
                playing: false,

                remaining: 0,
                elapsed: 0,
                duration: 0,
                name: '',
                show_player_info: false,

                main: true
            }
        },

        watch: {
            elapsed(value) {
                if(this.main === true) this.player.currentTime = this.player.duration * value;
                else this.main = true;
            },

            remaining() {
                this.$refs.slider.getStaticData();
            }
        },

        mounted() {
            this.setupPlayer();
        },

        computed: {
            player() {
                return this.$refs.player;
            },

            src() {
                return this.type === 'link' ? this.file : '/media/' + this.file
            },

            /*file_name() {

                return this.file.match(/\/([\s\S]+?)\./);
            }*/
        },

        methods: {
            play() {
                this.player.play();
            },

            stop() {
                this.player.pause();
                this.playing = false;
            },

            setupPlayer() {
                this.player.onplay = () => {
                    this.playing = true;
                };

                this.player.onplaying = () => {
                    this.playing = true;
                };

                this.player.onpause = () => {
                    this.stop();
                };

                this.player.ontimeupdate = () => {
                    let seconds = this.player.duration - this.player.currentTime
                    this.remaining = this.formatTime(seconds);
                    this.main = false;
                    this.$refs.slider.setValue(this.player.currentTime / this.player.duration);
                };

                this.show_player_info = true;
            },

            formatTime(time) {
                var date = new Date(0);
                date.setSeconds(time);
                return date.toISOString().substr(14, 5);
            }
        }
    }

</script>

<style>
    .audioPlayer-custom {
        position: relative;
    }
</style>
