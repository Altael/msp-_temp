<template>
    <div class="appLang amLangPage" :class="{'open': langPage}" v-if="lang">
        <a id="appStat" href="#appPageHeaderLanguage"
           @click.prevent="langPage = true"
           data-target="appPageHeaderLanguage" class="dhrtDropdown-link"
           rel="nofollow" data-toggle="dhrtDropdown" role="button"
           aria-haspopup="true" aria-expanded="false">
            <img :src="'/images/' + lang + '.png'" height="20">
            {{ {'en': __('English'), 'ru': __('Russian')}.lang }}
        </a>

        <div class="amPage amLangPageTransform">
            <div class="amPage-title" @click="langPage = false">
                {{ __('Interface language') }}
            </div>
            <div class="amPage-body">
                    <a class="amLangPageLanguage" href="/user-locale/en">
                        <span>{{ __('English') }}</span>
                        <span class="msppIcons msppIcons-check amLangPageLanguage-check" v-if="lang === 'en'"></span>
                    </a>
                    <a class="amLangPageLanguage" href="/user-locale/ru">
                        <span>{{ __('Russian') }}</span>
                        <span class="msppIcons msppIcons-check amLangPageLanguage-check" v-if="lang === 'ru'"></span>
                    </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                lang: null,
                langPage: false
            }
        },

        mounted() {
            this.lang = $('html').attr('lang');
        }
    }
</script>
