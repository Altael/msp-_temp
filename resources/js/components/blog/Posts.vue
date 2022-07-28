<template>
    <div class="appBlog">

        <div class="appBlogList" :class="'appBlogListCategory-' + category">
            <div class="appBlogList-items" v-if="posts.length">
                <div v-for="post of posts" class="appBlogList-item" :postlink="'/post/' + post.slug">
                    <div :id="post.slug"></div>
                    <div class="appBlogList-itemInfo">
                        <div class="appBlogList-itemInfoWrap">
                            <avatar class="appBlogNews-avatar" :src="post.author_avatar ? '/images/CategoryAvatars/' + post.author_avatar : '/images/no-avatar.jpg'"></avatar>
                            <div>
                                <div class="appBlogList-itemInfoTitle">{{ post['author_name_' + locale] }}</div>
                                <div class="appBlogList-itemInfoTime">{{ dateFormat(post.posted_at) }}</div>
                            </div>
                        </div>
                        <div class="appBlogList-itemBody">
                            <input type="checkbox" :id="'readMore-button-' + post.id">
                            <label class="appBlogList-itemBodyLink" v-if="post_chars(post.body) > 80" :for="'readMore-button-' + post.id">{{ __('Read more') }}...</label>
                            <div class="appBlogList-itemBodyText">
                                <div class="appBlogList-itemBodyTextContent" v-html="post.body"></div>
                            </div>
                        </div>

                    </div>
                    <div class="appBlogList-itemVideo " v-if="post.video" >
                        <div class="iframeResponsive" v-if="youTube(post)">
                            <iframe :src="post.video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <template  v-else>
                            <video :src="'/media/' + post.video" controls></video>
                        </template>
                    </div>
                    <label class="appBlogList-itemImg" v-if="!post.video && post.image_large && post_chars(post.body) > 80" :for="'readMore-button-' + post.id">
                        <img
                            :src="'../img/' + post.image_large"
                            :alt="post.image_large">
                    </label>
                    <div class="appBlogList-audio" v-if="post.audio">
                        <audio-player v-if="post.audio" :file="post.audio"></audio-player>
                        <!--<audio :src="'/media/' + post.audio" controls preload="auto"></audio>-->
                    </div>
                    <div class="appBlogList-itemIcons">
                        <div class="appBlogList-itemIcon" @click.prevent="like(post.id)"  :class="{ 'liked': post.liked }">
                            <span v-if="post.liked" class="appIcons msppIcons-heart-full" :class="{ 'animate__animated animate__heartBeat': post.liked }"></span>
                            <span v-else class="appIcons msppIcons-heart-empty" :class="{ 'animate__animated animate__flash': !post.liked }"></span>
                            <span>{{ post.likes ? post.likes : '' }}</span>
                        </div>
                        <!--<div class="appBlogList-itemIcon">
                            <span class="appIcons msppIcons-message-circle"></span>
                            <span>{{ post.comments }}</span>
                        </div>-->
                    </div>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    let moment = require('moment');

    export default {
        props: {
            category: {
                type: String,
                default: null
            },
            post: {
                type: String,
                default: null
            }
        },

        data() {
            return {
                total: 0,

                filters: {},

                posts: [],
                subs: [],
                parent: null
            }
        },

        mounted() {
            this.getData();
        },

        watch: {
            filters: {
                deep: true,
                handler() {
                    //if(this.filters.type === "null") this.filters.type = null;
                    this.getData();
                }
            }
        },

        methods: {
            getData() {
                let params = {
                    //type: this.filters.type ? this.filters.type : null,
                };

                axios.get('/posts-data/' + this.category + '?posts=all', {params: params}).then(response => {
                    this.parent = response.data.parent;
                    this.subs = response.data.subs;
                    this.posts = response.data.posts;
                    this.total = response.data.total;
                    this.locale = response.data.locale;

                    if(this.post) {
                        $(document).ready(() => {
                            this.$nextTick(() => {
                                let top = $('#' + this.post).offset().top - 25;
                                $('.dhrtScroll-wrapperInner').scrollTop(top);
                            });
                        });
                    }
                });
            },

            dateFormat(date) {
                return moment(date).locale(this.locale).format('DD MMM' + this.__(' in ') + 'HH:mm')
            },

            like(post_id) {
                axios.put('like/' + post_id).then(response => {
                    this.getData();
                });
            },

            youTube(post) {
                return post.video.startsWith('https');
            },

            post_chars(value) {
                if(value) return this.stripHtml(value).length;
            },

            stripHtml(html) {
                let tmp = document.createElement("DIV");
                tmp.innerHTML = html;
                return tmp.textContent || tmp.innerText || "";
            }
        }
    }

</script>
