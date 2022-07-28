<template>
    <div class="appAvatar" :class="{'widthMoreHeight': w >= h, 'heightMoreWidth': h > w}">
        <img :src="src && loaded ? src : 'images/no-avatar.jpg'">
        <!--<slim-cropper :options="slimOptions">
            <input type="file" name="slim"/>
        </slim-cropper>-->
    </div>
</template>

<script>
    import Slim from '../../../public/assets/slim-cropper/slim/slim.vue';

    function slimInit (data, slim) {

    }

    function slimService (formdata, progress, success, failure, slim) {
        axios.post('/post-image', formdata).then(response => {

        });
    }

    export default {
        components: {
            'slim-cropper': Slim
        },

        props: {
            src: {
                type: String,
                default: ''
            },
            id: {
                type: Number,
                default: null
            },
            system: {
                type: Boolean,
                default: false
            }
        },

        data () {
            return {
                image: null,
                h: 0,
                w: 0,
                loaded: false,

                slimOptions: {
                    initialImage: require('../../../public/assets/slim-cropper/example/media/dune.jpg'),
                    service: slimService,
                    didInit: slimInit
                }
            }
        },

        mounted() {
            this.image = new Image();

            this.image.addEventListener("load", () => {
                this.h = this.image.height;
                this.w = this.image.width;
            }, false);
            this.image.onload = () => {
                this.loaded = true;
            }
            this.image.onerror = () => {
                this.loaded = false;
            }

            if(this.id) {
                this.getData();
            } else if(this.src) {
                this.image.src = this.src;
            }
        },

        methods: {
            getData() {
                let params = {
                    id: this.id,
                    system: this.system
                };

                axios.get('/get-user-avatar', {params: params}).then(response => {
                    this.image.src = response.data.src;
                })
            }
        }
    }
</script>

<style>
    .widthMoreHeight img {
        height: 100%;
        width: auto;
    }
    .heightMoreWidth img {
        width: 100%;
        height: auto;
    }
</style>
