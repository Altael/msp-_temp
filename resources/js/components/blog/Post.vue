<template>
    <div id="amPost" class="amPage" v-if="post" :class="post_class">
        <div class="amPage-title" @click="back">
            {{ __(post.title) }}
        </div>

        <div class="amPost-content amPage-content">
            <img class="appPost-item" v-if="post.image" :src="'../img/' + post.image">
            <span class="appPost-body" v-html="post.body"></span>
            <div class="appBlogList-itemVideo " v-if="post.video" >
                <div class="iframeResponsive" v-if="youTube(post)">
                    <iframe :src="post.video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <template v-else>
                    <video :src="'/media/' + post.video" controls></video>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    let moment = require('moment');

    export default {
        props: ['post_slug', 'post_class'],

        data() {
            return {
                post: null
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getData() {
                axios.get('/post-data/' + this.post_slug).then(response => {
                    this.post = response.data.post;
                });
            },

            DateTimeFormat(dateTime) {
                return moment(dateTime).format('HH:mm DD-MM-YYYY')
            },

            youTube(post) {
                return post.video.startsWith('https');
            },

            back() {
                window.history.back();
            }
        }
    }
</script>
