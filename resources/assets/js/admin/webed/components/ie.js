WebEd.isIE = function (callback) {
    "use strict";
    var isIE8 = !!navigator.userAgent.match(/MSIE 8.0/);
    var isIE9 = !!navigator.userAgent.match(/MSIE 9.0/);
    var isIE10 = !!navigator.userAgent.match(/MSIE 10.0/);
    var isIE11 = !!navigator.userAgent.match(/rv:11.0/);

    if (isIE10) {
        $('html').addClass('ie10'); // detect IE10 version
    }

    if (isIE11) {
        $('html').addClass('ie11'); // detect IE11 version
    }

    if (isIE11 || isIE10 || isIE9 || isIE8) {
        $('html').addClass('ie'); // detect IE version
        if (typeof callback === 'function') {
            callback();
        }
    }
};
