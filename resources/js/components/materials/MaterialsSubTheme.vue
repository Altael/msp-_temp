<template>
    <div class="appMaterialsSubTheme">
        <div class="appMaterials-container">
            <div class="appMaterials-item" v-for="(subTheme, id) in subThemes[theme.id]">
                <div class="appMaterials-itemTools">
                    <div class="dhrtDropdown menuWidthAuto">
                        <div class="dhrtDropdown-back"></div>
                        <a href="#" class="dhrtDropdown-link" rel="nofollow" data-toggle="dhrtDropdown">
                            <span class="appIcons msppIcons-more-vertical"></span>
                        </a>
                        <div class="dhrtDropdown-menu">
                            <a href="#" rel="nofollow" class="dhrtDropdown-item">{{ __('Edit') }}</a>
                            <a href="#" rel="nofollow" class="dhrtDropdown-item">{{ __('Remove') }}</a>
                        </div>
                    </div>
                </div>
                <div class="appMaterials-subThemeItemTitle">{{ subTheme.title }}</div>
                <div class="appMaterials-subThemeItemList">
                    <div class="appMaterials-listPoint" v-for="(topic, id2) in subThemes[theme.id][id].topics" @click="selectSubTheme(id, id2)">
                        <span class="appMaterials-listPointIcon"></span>
                        <span class="appMaterials-listPointText">{{ topic.title }}</span>
                    </div>
                </div>


            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
          theme: {
              type: Object,
              default: null
          }
        },

        data() {
            return {
                subThemes: {
                    0: [
                        {
                            title: 'Подтема второго уровня 1',
                            topics: [
                                {title: 'Тема медиаматериала 1', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какой-то вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'И еще одна большая статья', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какойто вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема медиаматериала 2', content: 'Текст статьи', img: 'placeholder-640x480'},
                            ]
                        },
                        {
                            title: 'Подтема второго уровня 2',
                            topics: [
                                {title: 'Тема медиаматериала 1', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какой-то вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'И еще одна большая статья', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какойто вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема медиаматериала 2', content: 'Текст статьи', img: 'placeholder-640x480'},
                            ]
                        },
                        {
                            title: 'Подтема второго уровня 3',
                            topics: [
                                {title: 'Тема медиаматериала 1', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какой-то вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'И еще одна большая статья', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какойто вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема медиаматериала 2', content: 'Текст статьи', img: 'placeholder-640x480'},
                            ]
                        }
                    ],
                    1: [
                        {
                            title: 'Подтема второго уровня 4',
                            topics: [
                                {title: 'Тема медиаматериала 1', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какой-то вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'И еще одна большая статья', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какойто вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема медиаматериала 2', content: 'Текст статьи', img: 'placeholder-640x480'},
                            ]
                        },
                        {
                            title: 'Подтема второго уровня 5',
                            topics: [
                                {title: 'Тема медиаматериала 1', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какой-то вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'И еще одна большая статья', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какойто вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема медиаматериала 2', content: 'Текст статьи', img: 'placeholder-640x480'},
                            ]
                        },
                        {
                            title: 'Подтема второго уровня 6',
                            topics: [
                                {title: 'Тема медиаматериала 1', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какой-то вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'И еще одна большая статья', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какойто вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема медиаматериала 2', content: 'Текст статьи', img: 'placeholder-640x480'},
                            ]
                        }
                    ],
                    2: [
                        {
                            title: 'Подтема второго уровня 7',
                            topics: [
                                {title: 'Тема медиаматериала 1', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какой-то вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'И еще одна большая статья', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какойто вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема медиаматериала 2', content: 'Текст статьи', img: 'placeholder-640x480'},
                            ]
                        },
                        {
                            title: 'Подтема второго уровня 8',
                            topics: [
                                {title: 'Тема медиаматериала 1', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какой-то вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'И еще одна большая статья', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какойто вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема медиаматериала 2', content: 'Текст статьи', img: 'placeholder-640x480'},
                            ]
                        },
                        {
                            title: 'Подтема второго уровня 9',
                            topics: [
                                {title: 'Тема медиаматериала 1', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какой-то вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'И еще одна большая статья', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Еще какойто вопрос', content: 'Текст статьи', img: 'placeholder-640x480'},
                                {title: 'Тема медиаматериала 2', content: 'Текст статьи', img: 'placeholder-640x480'},
                            ]
                        }
                    ]
                }
            }
        },

        mounted() {

        },

        methods: {
            selectSubTheme(id, id2) {
                this.$parent.page = 'topic';
                this.$parent.subTheme = this.subThemes[this.theme.id][id];
                this.$parent.topicIndex = id2;
            }
        }
    }

</script>
