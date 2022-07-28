<template>
    <div class="appBlogEdu">
        <div class="appEduStories appEduCategory appEduCategory-rules">
            <div class="dhrtHorizontalScroll-wrapperOuter">
                <div class="appEduStories-items dhrtHorizontalScroll-wrapperInner">
                    <div class="appEduCategory-itemWrap">
                        <a href="/education/post/pravila-dlya-sadhak" class="appEduStories-item">
                            <span class="appEduStories-itemIcon appIcons msppIcons-sadhaka-rules"></span>
                            <span class="appEduStories-itemName">Правила для садхак</span>
                        </a>
                    </div>
                    <div class="appEduCategory-itemWrap">
                        <a href="/education/jivan-veda" class="appEduStories-item">
                            <span class="appEduStories-itemIcon appIcons msppIcons-vibrations"></span>
                            <span class="appEduStories-itemName">Джама Нияма</span>
                        </a>
                    </div>
                    <div class="appEduCategory-itemWrap">
                        <a href="/education/16-pounds" class="appEduStories-item">
                            <span class="appEduStories-itemIcon appIcons msppIcons-pounds"></span>
                            <span class="appEduStories-itemName">16 пунктов поведения</span>
                        </a>
                    </div>
                    <div class="appEduCategory-itemWrap">
                        <a href="/education/40-rules" class="appEduStories-item">
                            <span class="appEduStories-itemIcon appIcons msppIcons-pravil"></span>
                            <span class="appEduStories-itemName">Обществ. нормы</span>
                        </a>
                    </div>
                    <div class="appEduCategory-itemWrap">
                        <a href="/education/15-sil" class="appEduStories-item">
                            <span class="appEduStories-itemIcon appIcons msppIcons-sil"></span>
                            <span class="appEduStories-itemName">15 шил</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="appEduCategory appEduCategory-courses">
            <div class="appEduCategory-head">
                <div class="appEduCategory-title">{{ __('Cources') }}</div>
                <a href="/education/courses" @click.prevent="fullscreen_courses = true" class="appEduCategory-list">
                    <span class="appEduCategory-listText">{{ __('All') }}</span>
                    <span class="appEduCategory-listIcon appIcons msppIcons-chevron-right"></span>
                </a>
                <!--<posts category="courses"></posts>-->
            </div>
            <div class="dhrtHorizontalScroll-wrapperOuter">
                <div class="appEduCategory-items dhrtHorizontalScroll-wrapperInner">
                    <div class="appEduCategory-itemWrap" v-for="i of 3" v-if="courses[courses.length - i]">
                        <a :href="'/education/' + courses[courses.length - i].slug" class="appEduCategory-coursesItem">
                            <div class="appEduCategory-coursesItemName">{{ courses[courses.length - i].name }}</div>
                            <div class="appEduCategory-coursesItemText textOverflowRows">{{ courses[courses.length - i].description }}</div>
                            <div class="appEduCategory-coursesItemSpeaker">{{ __('Speaker') }}: {{ courses[courses.length - i].author_name }} </div>
                        </a>
                    </div>
                </div>
            </div>
            <!--<div class="dhrtHorizontalScroll-wrapperOuter">
                <div class="appEduCategory-items dhrtHorizontalScroll-wrapperInner">
                    <div class="appEduCategory-itemWrap">
                        <a href="/education/prarambika-darsanika" class="appEduCategory-coursesItem">
                            <div class="appEduCategory-coursesItemName">Основы философии</div>
                            <div class="appEduCategory-coursesItemText textOverflowRows">Ананда Марга йоги</div>
                            <div class="appEduCategory-coursesItemSpeaker">{{ __('Speaker') }}: Дада Сиддхартха </div>
                        </a>
                    </div>
                    <div class="appEduCategory-itemWrap">
                        <a href="/education/intro-to-dc" class="appEduCategory-coursesItem">
                        <div class="appEduCategory-coursesItemName">Коллективная медитация</div>
                        <div class="appEduCategory-coursesItemText textOverflowRows">Для тех, кто недавно получил инициацию</div>
                        <div class="appEduCategory-coursesItemSpeaker">{{ __('Speaker') }}: Дада Сиддхартха </div>
                    </a>
                    </div>
                    <div class="appEduCategory-itemWrap">
                        <a href="/education/biopsylogos" class="appEduCategory-coursesItem">
                        <div class="appEduCategory-coursesItemName">Биопсихология йоги</div>
                        <div class="appEduCategory-coursesItemText textOverflowRows">Знание о чакрах помогает понимать психологию людей. Слабые чакры не дают человеку контролировать свои эмоции. Знание о чакрах поможет вам понять свои слабые стороны и даст вам практики для работы с чакрами.</div>
                        <div class="appEduCategory-coursesItemSpeaker">{{ __('Speaker') }}: Дада Садананда </div>
                    </a>
                    </div>
                </div>
            </div>-->
        </div>

        <div class="appEduCategory appItemHidden appEduCategory-articles">
            <div class="appEduCategory-head">
                <div class="appEduCategory-title">{{ __('Articles') }}</div>
                <div class="appEduCategory-list">
                    <span class="appEduCategory-listText">{{ __('All') }}</span>
                    <span class="appEduCategory-listIcon appIcons msppIcons-chevron-right"></span>
                </div>
                <!--<posts category="articles"></posts>-->
            </div>
            <div class="dhrtHorizontalScroll-wrapperOuter">
                <div class="appEduCategory-items dhrtHorizontalScroll-wrapperInner">
                <div class="appEduCategory-itemWrap">
                    <div class="appEduCategory-articlesItem">
                        <img class="appEduCategory-articlesItemImg" src="/images/placeholder-640x480.jpg" alt="">
                        <div class="appEduCategory-articlesItemWrap">
                            <div class="appEduCategory-articlesItemName">Чем полезно голодание?</div>
                            <div class="appEduCategory-articlesItemText">Практика лечебного голодания известна с
                                давних
                                времен. И йоги активно используют этот инструмент…
                            </div>
                        </div>
                    </div>
                    <div class="appEduCategory-articlesItem">
                        <img class="appEduCategory-articlesItemImg" src="/images/placeholder-640x480.jpg" alt="">
                        <div class="appEduCategory-articlesItemWrap">
                            <div class="appEduCategory-articlesItemName">Влияние разума на пищу, и влияние пищи на
                                разум
                            </div>
                            <div class="appEduCategory-articlesItemText">Сегодня у нас заключительный теоретический
                                класс о
                                питании.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="appEduCategory-itemWrap">
                    <div class="appEduCategory-articlesItem">
                        <img class="appEduCategory-articlesItemImg" src="/images/placeholder-640x480.jpg" alt="">
                        <div class="appEduCategory-articlesItemWrap">
                            <div class="appEduCategory-articlesItemName">Чем полезно голодание?</div>
                            <div class="appEduCategory-articlesItemText">Практика лечебного голодания известна с
                                давних
                                времен. И йоги активно используют этот инструмент…
                            </div>
                        </div>
                    </div>
                    <div class="appEduCategory-articlesItem">
                        <img class="appEduCategory-articlesItemImg" src="/images/placeholder-640x480.jpg" alt="">
                        <div class="appEduCategory-articlesItemWrap">
                            <div class="appEduCategory-articlesItemName">Влияние разума на пищу, и влияние пищи на
                                разум
                            </div>
                            <div class="appEduCategory-articlesItemText">Сегодня у нас заключительный теоретический
                                класс о
                                питании.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <div class="appEduCategory appEduCategory-videos">
            <div class="appEduCategory-head">
                <div class="appEduCategory-title">{{ __('Videos') }}</div>
                <a href="/education/videos" @click.prevent="fullscreen_videos = true" class="appEduCategory-list">
                    <span class="appEduCategory-listText">{{ __('All') }}</span>
                    <span class="appEduCategory-listIcon appIcons msppIcons-chevron-right"></span>
                </a>
                <!--<posts category="videos"></posts>-->
            </div>

            <div class="dhrtHorizontalScroll-wrapperOuter">
                <div class="appEduCategory-items dhrtHorizontalScroll-wrapperInner">
                    <div class="appEduCategory-itemWrap" v-for="i of 3" v-if="videos[videos.length - i]">
                        <div class="appEduCategory-videosItem">
                            <!--<img class="appEduCategory-videosItemImg" src="/images/placeholder-640x480.jpg" alt="">-->
                            <div class="appEduCategory-videosItemImg">
                                <iframe :src="videos[videos.length - i].video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="appEduCategory-videosItemName textOverflowRows">{{ videos[videos.length - i].title }}</div>
                            <div class="appEduCategory-videosItemText">{{ videos[videos.length - i].subtitle }}</div>
                        </div>
                    </div>
                </div>
                <!--<div class="appEduCategory-items dhrtHorizontalScroll-wrapperInner">
                    <div class="appEduCategory-itemWrap">
                        <div class="appEduCategory-videosItem">
                            &lt;!&ndash;<img class="appEduCategory-videosItemImg" src="/images/placeholder-640x480.jpg" alt="">&ndash;&gt;
                            <div class="appEduCategory-videosItemImg">
                                <iframe src="https://www.youtube.com/embed/wimh4gPHnOg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="appEduCategory-videosItemName textOverflowRow">Преданность</div>
                            <div class="appEduCategory-videosItemText">Дада Иштамая, 2020</div>
                        </div>
                    </div>
                    <div class="appEduCategory-itemWrap">
                        <div class="appEduCategory-videosItem">
                            &lt;!&ndash;<img class="appEduCategory-videosItemImg" src="/images/placeholder-640x480.jpg" alt="">&ndash;&gt;
                            <div class="appEduCategory-videosItemImg">
                                <iframe src="https://www.youtube.com/embed/CJi1ZWBkGUc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>

                            <div class="appEduCategory-videosItemName textOverflowRow">Тантра и ее влияние на общество</div>
                            <div class="appEduCategory-videosItemText">Дада Индраджит, 2020</div>
                        </div>
                    </div>
                    <div class="appEduCategory-itemWrap">
                        <div class="appEduCategory-videosItem">
                            &lt;!&ndash;<img class="appEduCategory-videosItemImg" src="/images/placeholder-640x480.jpg" alt="">&ndash;&gt;
                            <div class="appEduCategory-videosItemImg">
                                <iframe src="https://www.youtube.com/embed/T9Lhu4J0WT8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>

                            <div class="appEduCategory-videosItemName textOverflowRow">Развитие организаций</div>
                            <div class="appEduCategory-videosItemText">Дада Гунатмананда, 2020</div>
                        </div>
                    </div>
                </div>-->
            </div>

        </div>

        <div class="appEduCategory appEduCategory-books">
            <div class="appEduCategory-head">
                <div class="appEduCategory-title">{{ __('Books') }}</div>
                <div @click.prevent="fullscreen_books = true" class="appEduCategory-list">
                    <span class="appEduCategory-listText">{{ __('All') }}</span>
                    <span class="appEduCategory-listIcon appIcons msppIcons-chevron-right"></span>
                </div>
                <!--<posts category="books"></posts>-->
            </div>
            <div class="dhrtHorizontalScroll-wrapperOuter">
                <div class="appEduCategory-items dhrtHorizontalScroll-wrapperInner">
                    <template v-for="book of books">
                        <div class="appEduCategory-itemWrap">
                            <div class="appEduCategory-booksItem">
                                <a @click.prevent="select(book)" class="appEduCategory-booksItem">
                                    <div class="appEduCategory-booksItemImg" :style="'background: center / cover no-repeat url(/media/' + book.thumbnail + ')'" :title="book.title"></div>
                                    <div class="appEduCategory-booksItemText textOverflowRows">{{ book.title }}</div>
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!--<posts category="podcasts"></posts>
        <posts category="basics"></posts>-->

        <fs-modal-window v-if="book" id="appEduModal-book" @close="close"
                         @ok="close" :buttonList="['ok']"
                         :windowName="book.title" class="amModal">
            <div class="appEduCategory-bookInfo">
                <div class="appEduCategory-bookImg">
                    <img :src="'/media/' + book.thumbnail" :alt="book.title">
                </div>


                <div class="appEduCategory-bookText">
                    <div class="appEduCategory-bookTitle">
                        {{ book.title }}
                    </div>
                    <div class="appEduCategory-bookPrice" @click="goTo(book.link)">
                        <span class="appIcon msppIcons-shopping-cart"></span>
                        <span>{{ book.price }}</span>
                    </div>
                </div>
            </div>
            <div class="appEduCategory-bookDescription">
                {{ book.description }}
            </div>

        </fs-modal-window>

        <fs-modal-window v-if="fullscreen_books" id="appEduModal-books" @close="close"
                         @ok="close" :buttonList="['ok']"
                         :windowName="__('Books')"  class="amModal">
            <div class="appEduCategory-booksItems">
                <template v-for="book of books">
                    <div class="appEduCategory-booksItem" @click="fullscreen_books = false; select(book)">
                        <div class="appEduCategory-booksItemImage" :style="'background: center / cover no-repeat url(/media/' + book.thumbnail + ')'" :title="book.title"></div>
                        <div class="appEduCategory-booksItemText">{{ book.title }}</div>
                    </div>
                </template>
            </div>
        </fs-modal-window>

        <fs-modal-window v-if="fullscreen_courses" id="appEduModal-courses" @close="close"
                         @ok="close" :buttonList="['ok']"
                         :windowName="__('Courses')"  class="amModal">
            <div class="appEduCategory-itemWrap" v-for="course of courses">
                <a :href="'/education/' + course.slug" class="appEduCategory-coursesItem">
                    <div class="appEduCategory-coursesItemName">{{ course.name }}</div>
                    <div class="appEduCategory-coursesItemText textOverflowRows">{{ course.description }}</div>
                    <div class="appEduCategory-coursesItemSpeaker">{{ __('Speaker') }}: {{ course.author_name }} </div>
                </a>
            </div>
        </fs-modal-window>

        <fs-modal-window v-if="fullscreen_videos" id="appEduModal-videos" @close="close"
                         @ok="close" :buttonList="['ok']"
                         :windowName="__('Videos')"  class="amModal">
            <div class="appEduCategory-itemWrap" v-for="video of videos">
                <div class="appEduCategory-videosItem">
                    <!--<img class="appEduCategory-videosItemImg" src="/images/placeholder-640x480.jpg" alt="">-->
                    <div class="appEduCategory-videosItemImg">
                        <iframe :src="video.video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="appEduCategory-videosItemName textOverflowRows">{{ video.title }}</div>
                    <div class="appEduCategory-videosItemText">{{ video.subtitle }}</div>
                </div>
            </div>
        </fs-modal-window>
    </div>
</template>

<script>
import FullscreenModalWindow from "../FullscreenModalWindow";
export default {
    components: {FullscreenModalWindow},
    data()  {
        return {
            books: [],
            courses: [],
            videos: [],
            book: null,
            fullscreen_books: false,
            fullscreen_courses: false,
            fullscreen_videos: false
        }
    },

    mounted() {
        this.getBooks();
        this.getCourses();
        this.getVideos();
    },

    methods: {
        getBooks() {
            axios.get('/get-books').then( response => {
                this.books = response.data.books;
            });
        },

        getCourses() {
            axios.get('/posts-data/courses?posts=solo&subs=true').then ( response => {
                this.courses = response.data.subs;
            });
        },

        getVideos() {
            axios.get('/posts-data/videos?posts=solo').then( response => {
                this.videos = response.data.posts;
            });
        },

        close() {
            this.book = null;
            this.fullscreen_books = false;
            this.fullscreen_courses = false;
            this.fullscreen_videos = false;
        },

        select(book) {
            this.book = book;
        },

        goTo(link) {
            window.open(link);
        }
    }
}
</script>
