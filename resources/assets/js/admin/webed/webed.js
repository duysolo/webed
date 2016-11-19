var WebEd = WebEd || {};

WebEd.scrollToTop = function (event) {
    "use strict";
    if (event) {
        event.preventDefault();
    }
    $('html, body').stop().animate({
        scrollTop: 0
    }, 800);
};

WebEd.showLoading = function () {
    $('body').addClass('on-loading');
};

WebEd.hideLoading = function () {
    $('body').removeClass('on-loading');
};

WebEd.initAjax = function () {
    "use strict";
    WebEd.confirmation();
    WebEd.tagsInput();
    WebEd.slimScroll($('.scroller'));
};
