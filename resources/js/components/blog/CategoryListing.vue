<template>
    <div id="amCategories" class="amPage">
        <div class="amPage-title" v-if="!only_posts" @click="back()" :class="{'withoutLink': !(parent || link === 'education')}">
            {{ __(name) }}
        </div>

        <div class="amCategories-content">
            <div class="amCategories-items">
                <a :href="'/' + link + '/' + sub.slug" class="amCategories-item withSevronRight" v-for="sub of subs" v-if="!only_posts">
                    <div class="amCategories-itemTitle  textOverflowRow">
                            {{ sub.name }}
                    </div>
                    <div class="amCategories-itemSubtitle textOverflowRows">
                        {{  sub.description }}
                    </div>
                </a>
                <a :href="'/' + link + '/post/' + post.slug" class="amCategories-item withSevronRight" v-for="post of posts">
                    <div class="amCategories-itemTitle">
                        {{ post.title }}
                    </div>
                    <div class="amCategories-itemSubtitle">
                        {{  post.subtitle }}
                    </div>
                </a>
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
                default: ''
            },
            only_posts: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                total: 0,

                filters: {},

                posts: [],
                subs: [],
                parent: null,
                name: null,
                link: 'category'
            }
        },

        mounted() {
            this.link = $('html').attr('data-link');
            this.getData();
        },

        watch: {
            filters: {
                deep: true,
                handler() {
                    //if(this.filters.type === "null") this.filters.type = null;
                    this.getData();
                }
            },
        },

        methods: {
            getData() {
                let params = {
                    //type: this.filters.type ? this.filters.type : null,
                };

                axios.get('/posts-data/' + this.category + '?posts=solo', {params: params}).then(response => {
                    this.parent = response.data.parent;
                    this.subs = response.data.subs;
                    this.posts = response.data.posts;
                    this.total = response.data.total;
                    this.locale = response.data.locale;
                    this.name = response.data.name;
                });
            },

            dateFormat(date) {
                return moment(date).locale(this.locale).format('DD MMM' + this.__(' in ') + 'HH:mm')
            },

            back() {
                if(this.parent || this.link === 'education') window.history.back();
            }
        }
    }

</script>
