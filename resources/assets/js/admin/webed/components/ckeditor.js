WebEd.ckeditor = function ($elements, config) {
    config = $.extend(true, {
        filebrowserBrowseUrl: FILE_MANAGER_URL + '?method=ckeditor',
        extraPlugins: 'codeTag,insertpre',
        allowedContent: true,
        height: '500px'
    }, config);
    $elements.ckeditor($.noop, config);
};
