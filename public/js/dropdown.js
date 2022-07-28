var dhrtDropdown = function() {

    var mainDropdown = function() {
        $(document).ready(function () {
            $('body').on('click', '.dhrtDropdown:not(.disabled) [data-toggle=dhrtDropdown]', function (event) {
                event.preventDefault();
                event.stopPropagation();
                var curItem = $(this).closest('.dhrtDropdown-item, .dhrtDropdown');
                var curDropdown = $(this).closest('.dhrtDropdown.open');
                $('body').find('.dhrtDropdown.open').not(curDropdown).removeClass('open');
                if (!curItem.hasClass('openOnHover')) {
                    if (curItem.hasClass('dhrtDropdown-submenu')) {
                        $(this).closest('.dhrtDropdown-menu').find(".open").removeClass('open');
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
                                if (dropdown.data("position") == 'down') {
                                    dropdown.removeClass("dhrtDropdown-menuPositionUp").addClass("dhrtDropdown-menuPositionDown");
                                }
                            }
                            if (distanceUp < 0) {
                                dropdown.removeClass("dhrtDropdown-menuPositionUp").addClass("dhrtDropdown-menuPositionDown");
                            } else {
                                if (dropdown.data("position") == 'up') {
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

            });

            $('body').on('click', '.dhrtDropdown-back', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).closest('.dhrtDropdown').removeClass('open').find(".open").removeClass('open');
            });

            $('body').on('click', '.dhrtDropdown-menu a, .dhrtDropdown-menu .withoutLink', function () {
                if (!$(this).closest('.dhrtDropdown-item').hasClass('dhrtDropdown-submenu') && !$(this).closest('.dhrtDropdown-item').hasClass('noClose') && !$(this).hasClass('dhrtDropdown-submenu')) {
                    $(this).closest('.dhrtDropdown').removeClass('open').find(".open").removeClass('open');
                }
            });
        });
    };

    var init = function () {
        mainDropdown();
    };

    return {
        init: init
    };
}();

$(function() {
    dhrtDropdown.init();
});
