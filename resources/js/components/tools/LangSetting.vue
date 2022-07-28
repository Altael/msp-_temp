<template>
    <div class="appLang" :class="{'titleLeft': titleLeft, 'titleRight': titleRight}">
        <div class="appLangTitle">{{ {'en':'Language', 'ru':'Язык', 'uk':'Мова'}[locale] }}:</div>
        <action-dropdown class="appLangDropdown" withArrow menuAlignmentLeft arrowBold>
            <template #label>{{ locale }} {{ {'en': __('English'), 'ru': __('Russian'), 'uk': __('Ukrainian')}.locale }}</template>
            <a v-for="lang of langs" class="dhrtDropdown-item" @click.prevent="setLang(lang)" >
                <img :src="'/images/' + lang + '.png'" height="20">
                <span class="amSvadhyayaLang-itemText">{{ langs_names[lang] }}</span>
                <span v-if="locale === lang" class="appSvadhyayaLang-checked"></span>
            </a>
        </action-dropdown>
    </div>
</template>
<script>
    export default {
        props: {
            titleLeft: {
                type: Boolean,
                default: false
            },
            titleRight: {
                type: Boolean,
                default: false
            },
            value: String,
            langs: {
                type: Array,
                default: ['en', 'ru', 'uk']
            }
        },

        data() {
            return {
                locale: 'ru',
                langs_names: {
                    en: this.__('English'),
                    ru: this.__('Russian'),
                    uk: this.__('Ukrainian')
                }
            }
        },

        watch: {
            value() {
                this.locale = this.value;
            }
        },

        methods: {
            setLang(lang) {
                this.$set(this, 'locale', lang);
                this.$emit('input', lang);
            }
        }
    }
</script>
