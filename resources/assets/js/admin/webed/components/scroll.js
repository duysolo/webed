WebEd.slimScroll = function ($element) {
    "use strict";
    if (!$().slimScroll) {
        return null;
    }

    $element.each(function () {
        if ($(this).attr("data-initialized")) {
            return null; // exit
        }
        var height;

        if ($(this).attr("data-height")) {
            height = $(this).attr("data-height");
        } else {
            height = $(this).css('height');
        }

        $(this).slimScroll({
            allowPageScroll: true, // allow page scroll when the element scroll is ended
            size: '7px',
            color: ($(this).attr("data-handle-color") ? $(this).attr("data-handle-color") : '#bbb'),
            wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
            railColor: ($(this).attr("data-rail-color") ? $(this).attr("data-rail-color") : '#eaeaea'),
            position: 'right',
            height: height,
            alwaysVisible: $(this).attr("data-always-visible") == "1",
            railVisible: $(this).attr("data-rail-visible") == "1",
            disableFadeOut: true
        });

        $(this).attr("data-initialized", "1");
    });
};

WebEd.destroySlimScroll = function ($element) {
    "use strict";
    if (!$().slimScroll) {
        return;
    }

    $element.each(function () {
        if ($(this).attr("data-initialized") === "1") { // destroy existing instance before updating the height
            $(this).removeAttr("data-initialized");
            $(this).removeAttr("style");

            var attrList = {};

            // store the custom attribures so later we will reassign.
            if ($(this).attr("data-handle-color")) {
                attrList["data-handle-color"] = $(this).attr("data-handle-color");
            }
            if ($(this).attr("data-wrapper-class")) {
                attrList["data-wrapper-class"] = $(this).attr("data-wrapper-class");
            }
            if ($(this).attr("data-rail-color")) {
                attrList["data-rail-color"] = $(this).attr("data-rail-color");
            }
            if ($(this).attr("data-always-visible")) {
                attrList["data-always-visible"] = $(this).attr("data-always-visible");
            }
            if ($(this).attr("data-rail-visible")) {
                attrList["data-rail-visible"] = $(this).attr("data-rail-visible");
            }

            $(this).slimScroll({
                wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
                destroy: true
            });

            var the = $(this);

            // reassign custom attributes
            $.each(attrList, function (key, value) {
                the.attr(key, value);
            });
        }
    });
};
