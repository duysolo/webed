/**
 * Works same as array_get function of Laravel
 * @param array
 * @param key
 * @param defaultValue
 * @returns {*}
 */
var array_get = function (array, key, defaultValue) {
    "use strict";

    if (typeof defaultValue === 'undefined') {
        defaultValue = null;
    }

    var result;

    try {
        result = array[key];
    } catch (err) {
        result = defaultValue;
    }

    if(result === null) {
        result = defaultValue;
    }

    return result;
};

/**
 * Get the array/object length
 * @param array
 * @returns {number}
 */
var array_length = function (array) {
    "use strict";

    return _.size(array);
};

/**
 * Get the first element.
 * Passing n will return the first n elements of the array.
 * @param array
 * @param n
 * @returns {*}
 */
var array_first = function (array, n) {
    "use strict";

    return _.first(array, n);
};

/**
 * Get the first element.
 * Passing n will return the last n elements of the array.
 * @param array
 * @param n
 * @returns {*}
 */
var array_last = function (array, n) {
    "use strict";

    return _.last(array, n);
};


/**
 * Works same as dd function of Laravel
 */
var dd = function () {
    "use strict";
    console.log.apply(console, arguments);
};

/**
 * Json encode
 * @param object
 */
var json_encode = function (object) {
    "use strict";
    if (typeof object === 'undefined') {
        object = null;
    }
    return JSON.stringify(object);
};

/**
 * Json decode
 * @param jsonString
 * @param defaultValue
 * @returns {*}
 */
var json_decode = function (jsonString, defaultValue) {
    "use strict";
    if (typeof jsonString === 'string') {
        var result;
        try {
            result = $.parseJSON(jsonString);
        } catch (err) {
            result = defaultValue;
        }
        return result;
    }
    return jsonString;
};

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

/**
 * Block UI
 * @param options
 */
WebEd.blockUI = function (options) {
    "use strict";
    options = $.extend(true, {
        animate: false,
        iconOnly: true,
        textOnly: true,
        boxed: true,
        message: 'Loading...',
        target: undefined,
        zIndex: 1000,
        centerY: false,
        overlayColor: '#555',
    }, options);

    var html = '';
    if (options.animate) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '">' + '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>';
    } else if (options.iconOnly) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="' + WebEd.settings.adminTheme.getGlobalImagePath() + 'loading-spinner-grey.gif" align=""></div>';
    } else if (options.textOnly) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
    } else {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="' + WebEd.settings.adminTheme.getGlobalImagePath() + 'loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
    }

    if (options.target) { // element blocking
        var el = $(options.target);
        if (el.height() <= ($(window).height())) {
            options.cenrerY = true;
        }
        el.block({
            message: html,
            baseZ: options.zIndex,
            centerY: options.cenrerY,
            css: {
                top: '10%',
                border: '0',
                padding: '0',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: options.overlayColor,
                opacity: options.boxed ? 0.05 : 0.1,
                cursor: 'wait'
            }
        });
    } else { // page blocking
        $.blockUI({
            message: html,
            baseZ: options.zIndex,
            css: {
                border: '0',
                padding: '0',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: options.overlayColor,
                opacity: options.boxed ? 0.05 : 0.1,
                cursor: 'wait'
            }
        });
    }
};

/**
 * Unblock UI
 * @param $target
 */
WebEd.unblockUI = function ($target) {
    "use strict";
    if(!$target instanceof jQuery) {
        $target = $($target);
    }
    $target.unblock({
        onUnblock: function() {
            $target.css('position', '');
            $target.css('zoom', '');
        }
    });
    $.unblockUI();
};

WebEd.ckeditor = function ($elements, config) {
    config = $.extend(true, {
        filebrowserBrowseUrl: FILE_MANAGER_URL + '?method=ckeditor',
        extraPlugins: 'codeTag,insertpre',
        allowedContent: true,
        autoParagraph: false,
        height: '500px'
    }, config);
    $elements.ckeditor($.noop, config);
};

WebEd.confirmation = function () {
    if (!$().confirmation) {
        return;
    }
    $('[data-toggle=confirmation]').confirmation({
        container: 'body',
        btnOkClass: 'btn btn-sm green',
        btnCancelClass: 'btn btn-sm red-sunglo',
        //placement: 'left',
        btnOkLabel: 'OK',
        btnCancelLabel: 'Cancel',
        popout: true,
        singleton: true
    });
};


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

WebEd.handleSelectMediaBox = function () {
    "use strict";
    var $body = $('body');
    $body.on('click', '.show-add-media-popup', function (event) {
        event.preventDefault();
        var $isFileBrowser = '';
        var fileType = 'image';

        document.currentMediaBox = $(this).closest('.select-media-box');
        document.mediaModal = $('#select_media_modal');

        if ($(this).hasClass('select-file-box')) {
            $isFileBrowser = '&type=file';
            fileType = 'file';
        }
        if (fileType == 'file') {
            document.mediaModal.find('.nav-tabs .external-image').hide();
            document.mediaModal.find('.nav-tabs .external-file').show();
        } else {
            document.mediaModal.find('.nav-tabs .external-image').show();
            document.mediaModal.find('.nav-tabs .external-file').hide();
        }

        $('#select_media_modal .modal-body .iframe-container').html('<iframe src="' + FILE_MANAGER_URL + '?method=standalone' + $isFileBrowser + '"></iframe>');
        document.mediaModal.modal('show');
    });
    $body.on('click', '.select-media-box .remove-image', function (event) {
        event.preventDefault();
        document.currentMediaBox = $(this).closest('.select-media-box');
        document.currentMediaBox.find('img.img-responsive').attr('src', '/admin/images/no-image.png');
        document.currentMediaBox.find('.input-file').val('');
    });
    $body.on('click', '.select-media-modal-external-asset .btn', function (event) {
        event.preventDefault();
        var $current = $(this);
        var $textField = $current.closest('.select-media-modal-external-asset').find('.input-asset');
        var url = $textField.val();
        var fileType = ($current.closest('.select-media-modal-external-asset').attr('id') == 'select_media_modal_external_file') ? 'file' : 'image';

        var $modal = document.mediaModal;
        var $target = document.currentMediaBox;
        if (fileType == 'file') {
            $target.find('a .title').html(url);
        } else {
            $target.find('.img-responsive').attr('src', url);
        }

        $target.find('.input-file').val(url);
        $modal.find('iframe').remove();
        $modal.modal('hide');
        $textField.val('');
    });
};

WebEd.showNotification = function (message, type, options) {
    "use strict";
    options = options || {};

    switch (type) {
        case 'success': {
            type = 'lime';
        }
            break;
        case 'info': {
            type = 'teal';
        }
            break;
        case 'warning': {
            type = 'tangerine';
        }
            break;
        case 'danger': {
            type = 'ruby';
        }
            break;
        case 'error': {
            type = 'ruby';
        }
            break;
        default: {
            type = 'ebony';
        }
            break;
    }
    $.notific8('zindex', 11500);

    var settings = $.extend(true, {
        theme: type,
        sticky: false,
        horizontalEdge: 'bottom',
        verticalEdge: 'right',
        life: 10000
    }, options);

    if (message instanceof Array) {
        message.forEach(function (value) {
            $.notific8($.trim(value), settings);
        });
    }
    else {
        $.notific8($.trim(message), settings);
    }
};

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

WebEd.settings = function () {
    "use strict";
    var assetsPath = BASE_URL + 'admin/';

    var globalImgPath = assetsPath + 'images/global/';

    var globalPluginsPath = BASE_URL + 'admin/plugins/';

    return {
        adminTheme: {
            getAssetPath: function () {
                return assetsPath;
            },
            getGlobalImagePath: function () {
                return globalImgPath;
            },
            getPluginsPath: function () {
                return globalPluginsPath;
            },
        }
    }
}();

WebEd.stringToSlug = function (text, separator) {
    "use strict";
    separator = separator || '-';
    return text.toString()
        /*To lower case*/
        .toLowerCase()
        /*Vietnamese string*/
        .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
        .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
        .replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
        .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
        .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
        .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
        .replace(/đ/gi, 'd')
        /*Replace spaces with -*/
        .replace(/\s+/g, separator)
        /*Remove all non-word chars*/
        .replace(/[^\w\-]+/g, '')
        /*Replace multiple - with single -*/
        .replace(/\-\-+/g, separator)
        /*Trim - from start of text*/
        .replace(/^-+/, '')
        /*Trim - from end of text*/
        .replace(/-+$/, '');
};

WebEd.tabChangeUrl = function () {
    $('body').on('click', '.tab-change-url a[data-toggle="tab"]', function (event) {
        window.history.pushState('', '', $(this).attr('href'));
    });
};

WebEd.tagsInput = function ($element, options) {
    "use strict";
    options = $.extend(true, {
        'tagClass': 'label label-default'
    }, options);
    if(!$element || !$element instanceof jQuery) {
        $element = $('.js-tags-input');
    }
    if($element.length) {
        $element.tagsinput(options);
    }
};

//# sourceMappingURL=webed-core.js.map
