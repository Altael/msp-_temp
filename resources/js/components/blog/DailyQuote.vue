<template>
    <div class="appBlogNewsModal-daily amWidth">
        <div class="appBlogNewsModal-dailyImgBack">
            <img src="/images/lines.svg" alt="lines">
        </div>
        <div class="appBlogNewsModal-dailyLineBtn">
            <div class="appBlogNewsModal-dailyLine"></div>
            <div class="appBlogNewsModal-dailyClose" @click="$parent.modal = null">×</div>
        </div>
        <div class="appBlogNewsModal-dailyCard">
            <div class="appBlogNewsModal-dailyPlaceWrap">
                <img class="appBlogNewsModal-dailyImgTop" src="/images/flower.svg" alt="Flower">
                <div class="appBlogNewsModal-dailyPlaceOut">
                    <div class="appBlogNewsModal-dailyPlace">
                        <div class="appBlogNewsModal-dailyCardTextWrap">
                            <div class="dhrtScroll-wrapperOuter">
                                <div class="dhrtScroll-wrapperInner">
                                    <div class="appBlogNewsModal-dailyCardText" v-html="daily.text"></div>
                                </div>
                            </div>

                        </div>

                        <div class="appBlogNewsModal-dailySignature">
                            <div class="appBlogNewsModal-dailyAuthor">{{ daily.place }}</div>
                            <div class="appBlogNewsModal-dailyDate">{{ daily.record_date }}</div>
                        </div>
                    </div>
                </div>
                <img class="appBlogNewsModal-dailyImgBottom" src="/images/flower.svg" alt="Flower">
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        props: ['daily'],

        data() {
            return {}
        },

        mounted() {
            document.body.classList.add('toolbarNone');

        },

        beforeDestroy() {
            document.body.classList.remove('toolbarNone');
        }
    }
</script>
