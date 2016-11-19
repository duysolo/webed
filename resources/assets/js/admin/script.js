$(document).ready(function(){
    "use strict";
    /**
     * Detect IE
     */
    WebEd.isIE(function(){
        /**
         * Callback
         */
    });

    /**
     * Add csrf token to ajax request
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    /**
     * Handle select media box
     */
    WebEd.handleSelectMediaBox();

    WebEd.tabChangeUrl();

    /**
     * Init layout
     */
    WebEd.initAjax();
});

$(window).load(function () {
    "use strict";
    /*Hide loading state*/
    WebEd.hideLoading();
});
