<template>
    <div class="appMaterials">

        <div class="appMaterials-themeOutput" v-if="theme">
            <span class="appIcons msppIcons-chevron-right appMaterials-ThemeOutputIcon"></span>
            <span class="appMaterials-ThemeOutputText">{{ theme.title }}</span>
        </div>
        <div class="appMaterials-searchBtn">
            <div class="dhrtSearch appMaterials-search">
                <input type="text" class="dhrtSearchField">
                <span class="appIcons msppIcons-search dhrtSearchField-icon"></span>
            </div>
            <div class="appMaterials-btnAdd" @click="createMaterial">
                <span class="appIcons msppIcons-plus appMaterials-iconPlus"></span>
                <span>{{ __('Add') }}</span>
            </div>
        </div>

        <materials-theme v-if="page === 'theme'"></materials-theme>
        <materials-sub-theme v-if="page === 'sub-theme' && theme" :theme='theme'></materials-sub-theme>
        <materials-topic v-if="page === 'topic' && subTheme" :subTheme="subTheme"
                         :topicIndex="topicIndex"></materials-topic>

        <modal-window v-if="create" @close="create = null" @cancel="create = null" @create="createMaterial(create)"
                      :buttonList="['Cancel', 'Create']" :windowName="__('Create material')">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Theme') }}</div>
                <multiselect
                    v-model="create.theme"
                    :options="themes"
                    label="name"
                    track-by="id"
                    :placeholder="__('Choose theme')"
                />
            </div>
            <div class="appForm-group" v-if="create.theme.id === 0">
                <div class="appForm-groupTitle">{{ __('New theme') }}</div>
                <input type="text" v-model="create.theme.name" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Sub-theme') }}</div>
                <multiselect
                    v-model="create.sub_theme"
                    :options="sub_themes"
                    label="name"
                    track-by="id"
                    :placeholder="__('Choose sub-theme')"
                />
            </div>
            <div class="appForm-group" v-if="create.sub_theme.id === 0">
                <div class="appForm-groupTitle">{{ __('New sub-theme') }}</div>
                <input type="text" v-model="create.sub_theme.name" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Topic\'s name') }}</div>
                <input type="text" v-model="create.topic_name" class="appForm-input">
            </div>
            <div class="appForm-group">
                <html-editor v-model="create.topic_content"></html-editor>
            </div>
        </modal-window>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: {Multiselect},

        data() {
            return {
                page: 'theme',
                themes: [
                    {id: 0, name: 'Новая тема'},
                    {id: 1, name: 'Theme 1'},
                    {id: 2, name: 'Theme 2'},
                    {id: 3, name: 'Theme 3'},
                ],
                theme: null,
                sub_themes: [
                    {id: 0, name: 'Новая подтема'},
                    {id: 1, name: 'Sub-theme 1'},
                    {id: 2, name: 'Sub-theme 2'},
                    {id: 3, name: 'Sub-theme 3'},
                ],
                subTheme: null,
                topicIndex: null,
                create: null
            }
        },

        mounted() {

        },

        methods: {
            createMaterial() {
                this.create = {
                    theme: {
                        id: null,
                        name: ''
                    },
                    sub_theme: {
                        id: null,
                        name: ''
                    },
                    topic_name: '',
                    topic_content: '',
                    topic_img: ''
                }
            },

            save() {

            }
        }
    }

</script>
