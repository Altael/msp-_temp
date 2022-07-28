<template>
    <div class="dhrtDropdown menuWidthAuto dhrtDropdown-menuPositionDown" :class="{'arrowBold': arrowBold, 'arrowSmall': arrowSmall, 'withArrow': withArrow, 'dhrtDropdown-menuAlignmentLeft': menuAlignmentLeft}" data-position="down" data-indent-down="16" data-indent-up="16" ref="dropdown">
        <div class="dhrtDropdown-back"></div>
        <a href="#" @click.prevent="label_click_processing" class="dhrtDropdown-link"
           rel="nofollow" data-toggle="dhrtDropdown" role="button" aria-haspopup="true"
           aria-expanded="false">
            <slot name="label" v-if="slots.label"></slot>
            <span class="appIcons msppIcons-more-vertical" v-else></span>
        </a>
        <div class="dhrtDropdown-menu">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            withArrow: {
                type: Boolean,
                default: false
            },

            arrowBold: {
                type: Boolean,
                default: false
            },

            arrowSmall: {
                type: Boolean,
                default: false
            },

            menuAlignmentLeft: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                slots: {
                    label: false
                }
            }
        },

        methods: {
            set (new_value) {
                this.$emit('input', new_value);
            },

            label_click_processing() {
                var curItem = $(this.$refs.dropdown).closest('.dhrtDropdown-item, .dhrtDropdown');
                var curDropdown = $(this.$refs.dropdown).closest('.dhrtDropdown.open');
                $('body').find('.dhrtDropdown.open').not(curDropdown).removeClass('open');
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

                            console.log(positionTop);
                        }
                    }
                    curItem.toggleClass('open');
                }
            }
        },

        computed: {
            filtered_options() {
                if(this.search_line) {
                    let result = {}, key;

                    for (key in this.options) {
                        if(this.options.hasOwnProperty(key) && new RegExp(this.search_line, 'i').test(this.options[key])) {
                            result[key] = this.options[key];
                        }
                    }

                    return result;
                } else {
                    return this.options;
                }
            }
        },

        mounted() {
            let that = this;

            for(let slot in this.slots) {
                this.slots[slot] = this.$slots[slot];
            }

            $('body').on('click', '.dhrtDropdown:not(.disabled) [data-toggle=dhrtDropdown]', function (event) {

            })
                .on('click', '.dhrtDropdown-back', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).closest('.dhrtDropdown').removeClass('open').find(".open").removeClass('open');
                })
                .on('click', '.dhrtDropdown-menu a, .dhrtDropdown-menu .withoutLink', function () {
                    if (!$(this).closest('.dhrtDropdown-item').hasClass('dhrtDropdown-submenu') && !$(this).closest('.dhrtDropdown-item').hasClass('noClose') && !$(this).hasClass('dhrtDropdown-submenu')) {
                        $(this).closest('.dhrtDropdown').removeClass('open').find(".open").removeClass('open');
                    }
                });
        }
    }
</script>
