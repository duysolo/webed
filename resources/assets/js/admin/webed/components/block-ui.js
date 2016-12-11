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
