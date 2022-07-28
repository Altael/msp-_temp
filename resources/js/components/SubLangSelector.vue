<template>
    <div v-if="lang"
        class="appLang dhrtDropdown menuWidthAuto withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
        data-position="down" data-indent-down="16" data-indent-up="16">
        <div class="dhrtDropdown-back"></div>
        <a id="appStat" href="#appPageHeaderLanguage"
                         data-target="appPageHeaderLanguage" class="dhrtDropdown-link"
                         rel="nofollow" data-toggle="dhrtDropdown" role="button"
                         aria-haspopup="true" aria-expanded="false">
            <img :src="'/images/' + lang + '.png'" height="20">
            <slot></slot>
        </a>
        <div class="dhrtDropdown-menu" id="appPageHeaderLanguage"
             aria-labelledby="appPageHeaderLanguageLink">
            <a class="dhrtDropdown-item" v-for="locale of locales" @click.prevent="setLocale(locale)" :href="'/sub-locale/' + field + '/' + locale" v-if="lang !== locale">
                <img :src="'/images/' + locale + '.png'" height="20">
                {{ langs[locale] }}
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            field: {
                type: String,
                default: null
            },
            table: {
                type: String,
                default: "user_profiles"
            }
        },

        data() {
            return {
                lang: null,
                langs: {
                    'en': this.__('English'),
                    'ru': this.__('Russian'),
                    'uk': this.__('Ukrainian')
                },
                locales: []
            }
        },

        mounted() {
            this.getLocales();
        },

        methods: {
            getLocales() {
                axios.get('/get-locales/' + this.field).then( response => {
                    this.locales = response.data.locales;
                    this.locales.push('en');
                    this.lang = response.data.locale;
                });
            },

            setLocale(locale) {
                axios.post('/sub-locale/' + this.table + '/' + this.field + '/' + locale).then(response => {
                    this.getLocales();
                    this.$emit('changed');
                });
            }
        }
    }
</script>
