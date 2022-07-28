<template>
    <div v-if="lang"
        class="appLang dhrtDropdown menuWidthAuto withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown"
        data-position="down" data-indent-down="16" data-indent-up="16" ref="dropdown">
        <div class="dhrtDropdown-back"></div>
        <a id="appStat" href="#appPageHeaderLanguage" @click.prevent="label_click_processing()"
                         data-target="appPageHeaderLanguage" class="dhrtDropdown-link"
                         rel="nofollow" data-toggle="dhrtDropdown" role="button"
                         aria-haspopup="true" aria-expanded="false">
            <img :src="'/images/' + lang + '.png'" height="20">
            {{ {'en': __('English'), 'ru': __('Russian')}.lang }}
        </a>
        <div class="dhrtDropdown-menu" id="appPageHeaderLanguage"
             aria-labelledby="appPageHeaderLanguageLink">
            <a class="dhrtDropdown-item" href="/user-locale/en" v-if="lang !== 'en'">
                <img src="/images/en.png" height="20">
                {{ __('English') }}
            </a>
            <a class="dhrtDropdown-item" href="/user-locale/ru" v-if="lang !== 'ru'">
                <img src="/images/ru.png" height="20">
                {{ __('Russian') }}
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                lang: null
            }
        },

        methods: {
            label_click_processing() {
                var curItem = $(this.$refs.dropdown).closest('.dhrtDropdown-item, .dhrtDropdown');
                $('body').find('.dhrtDropdown.open').not(curItem).removeClass('open');
                if (!curItem.hasClass('openOnHover')) {
                    if (curItem.hasClass('dhrtDropdown-submenu')) {
                        $(this.$refs.dropdown).closest('.dhrtDropdown-menu').find(".open").removeClass('open');
                    }
                    if (!curItem.hasClass('open')) {
                        var dropdown = curItem.closest('.dhrtDropdown');
                        var indentUp = dropdown.data('indent-up') ? dropdown.data('indent-up') : 0;
                        var indentDown = dropdown.data('indent-down') ? dropdown.data('indent-down') : 0;
                        var menuRouteVertical = (dropdown.hasClass('dhrtDropdown-menuPositionDown') || dropdown.hasClass('dhrtDropdown-menuPositionUp'));
                        if (menuRouteVertical) {
                            var menu = dropdown.find('.dhrtDropdown-menu');
                            var menuHeight = menu.outerHeight(true);
                            var windowHeight = $(window).height();
                            var scrollTop = menu.offset().top;
                            var distanceDown = windowHeight - scrollTop + $(window).scrollTop() - menuHeight - indentDown;
                            var distanceUp = scrollTop + $(window).scrollTop() - menuHeight - indentUp;
                            if (distanceDown < 0) {
                                dropdown.removeClass("dhrtDropdown-menuPositionDown").addClass("dhrtDropdown-menuPositionUp");
                            } else {
                                if (dropdown.data("position") === 'down') {
                                    dropdown.removeClass("dhrtDropdown-menuPositionUp").addClass("dhrtDropdown-menuPositionDown");
                                }
                            }
                            if (distanceUp < 0) {
                                dropdown.removeClass("dhrtDropdown-menuPositionUp").addClass("dhrtDropdown-menuPositionDown");
                            } else {
                                if (dropdown.data("position") === 'up') {
                                    dropdown.removeClass("dhrtDropdown-menuPositionDown").addClass("dhrtDropdown-menuPositionUp");
                                }
                            }
                        }

                        var selectedItem = curItem.find(".dhrtDropdown-item.selected").length ? curItem.find(".dhrtDropdown-item.selected") : 0;

                        if (selectedItem) {
                            var positionTop = 0;
                            curItem.find(".dhrtDropdown-item").each(function (key, item) {
                                if (!$(item).hasClass('selected')) {
                                    positionTop += $(item).height();
                                } else {
                                    return false;
                                }
                            });
                            if (positionTop && positionTop > (menuHeight - 50)) {
                                menu.animate({
                                    scrollTop: positionTop
                                }, 500);
                            }
                        }
                    }
                    curItem.toggleClass('open');
                    this.is_open = curItem.hasClass('open');
                    this.$nextTick(() => {
                        $(this.$refs.search).focus();
                    });
                }
            }
        },

        mounted() {
            this.lang = $('html').attr('lang');

            let that = this;
            $('body').on('click', '.dhrtDropdown:not(.disabled) [data-toggle=dhrtDropdown]', function (event) {

            })
                .on('click', '.dhrtDropdown-back', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).closest('.dhrtDropdown').removeClass('open').find(".open").removeClass('open');
                    that.is_open = false;
                })
                .on('click', '.dhrtDropdown-menu a, .dhrtDropdown-menu .withoutLink', function () {
                    if (!$(this).closest('.dhrtDropdown-item').hasClass('dhrtDropdown-submenu') && !$(this).closest('.dhrtDropdown-item').hasClass('noClose') && !$(this).hasClass('dhrtDropdown-submenu')) {
                        $(this).closest('.dhrtDropdown').removeClass('open').find(".open").removeClass('open');
                        that.is_open = false;
                    }
                });
        }
    }
</script>
