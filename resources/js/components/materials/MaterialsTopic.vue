<template>
    <div class="appMaterialsTopic">
        <div class="appMaterials-container">
            <div class="appMaterials-item appMaterials-topicItem">
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
                    <div class="appMaterials-listPoint" v-for="(topic, id) in subTheme.topics" :class="{selected: id === topicIndex}" @click="selectTopic(id)">
                        <span class="appMaterials-listPointIcon"></span>
                        <span class="appMaterials-listPointText">{{ topic.title }}</span>
                    </div>
                </div>

            </div>
            <div class="appMaterials-item appMaterials-topicItemBig">
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

                <div class="appMaterials-topicItemTitle">{{ subTheme.topics[topicIndex].title }}</div>
                <div class="appMaterials-topicItemText">
                    {{ subTheme.topics[topicIndex].content }}
                </div>
                <div class="appMaterials-topicItemImg">
                    <img :src="'/images/'+subTheme.topics[topicIndex].img+'.jpg'" alt="Yoga">
                </div>
                <div class="appMaterials-topicItemPages">
                    <div class="appMaterials-pageBack" @click="prevTopic">
                        <template v-if="topicIndex > 0">
                            <span class="appIcons msppIcons-chevron-left appMaterials-iconsChevronLeft"></span>
                            <span>{{ __('Previous') }}</span>
                        </template>
                    </div>
                    <div class="appMaterials-pageNext" @click="nextTopic">
                        <template v-if="topicIndex < subTheme.topics.length-1">
                            <span>{{ __('Next') }}</span>
                            <span class="appIcons msppIcons-chevron-right appMaterials-iconsChevronRight"></span>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            subTheme: {
                type: Object,
                default: null
            },
            topicIndex: {
                type: Number,
                default: null
            }
        },

        data() {
            return {

            }
        },

        mounted() {

        },

        methods: {
            selectTopic(id) {
                this.$parent.topicIndex = id;
            },

            prevTopic() {
                if(this.topicIndex > 0) this.$parent.topicIndex--;
            },

            nextTopic() {
                if(this.topicIndex < this.subTheme.topics.length-1) this.$parent.topicIndex++;
            }
        }
    }

</script>
