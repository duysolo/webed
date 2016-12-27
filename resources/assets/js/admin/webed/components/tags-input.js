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
