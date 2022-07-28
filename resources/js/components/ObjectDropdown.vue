<template>
    <div class="dhrtDropdown" data-position="down" data-indent-down="16" data-indent-up="16" ref="dropdown" :class="{'disabled': unpressable}">
        <div class="dhrtDropdown-back"></div>
        <input type="text" v-model="search_line" v-if="search && is_open" ref="search"/>
        <a v-else href="#" @click.prevent="label_click_processing()" class="dhrtDropdown-link" :class="{'placeholder': !selected, 'disabled': unpressable}" rel="nofollow" data-toggle="dhrtDropdown" role="button" aria-haspopup="true" aria-expanded="false">
            {{ selected !== null ? selected[label] : __(placeholder) }}
        </a>
        <div class="dhrtDropdown-menu">
            <a href="#" v-for="(value, key) of filtered_options" @click="set(key)" rel="nofollow" class="dhrtDropdown-item withoutLink">{{ value[label] }}</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            options: [Array, Object],
            label: String,
            placeholder: {
                type: String,
                default: "Select option"
            },
            search: {
                type: Boolean,
                default: false
            },
            search_label: {
                type: String,
                default: "name"
            },
            unpressable: {
                type: Boolean,
                default: false
            }
        },


        data() {
            return {
                search_line: null,
                is_open: false
            }
        },

        methods: {
            set (value) {
                this.$emit('input', this.options[value]);
                this.is_open = false;
            },

            close() {

            },

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

        computed: {
            selected() {
                return this.$attrs.value;
            },

            filtered_options() {
                if(this.search_line) {
                    let result = {}, key;

                    for (key in this.options) {
                        if(this.options.hasOwnProperty(key) && new RegExp(this.search_line, 'i').test(this.options[key][this.search_label])) {
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
            $('body').on('click', '.dhrtDropdown:not(.disabled) [data-toggle=dhrtDropdown]', function (event) {

            })
                .on('click', '.dhrtDropdown-back', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).closest('.dhrtDropdown').removeClass('open').find(".open").removeClass('open');
                    that.is_open = false;
                })
                .on('click', '.dhrtDropdown-menu a.withoutLink', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).closest('.dhrtDropdown').removeClass('open').find(".open").removeClass('open');
                    that.is_open = false;
                });
        }
    }
</script>
