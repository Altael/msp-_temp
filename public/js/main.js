$(document).ready(function(){

    $("#appMobileMenu-chk").click(function() {
        if(!$('body').hasClass('sadvipraLayout')) $("body").toggleClass("noScroll");
    })

});
