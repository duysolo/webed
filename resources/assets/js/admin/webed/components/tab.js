WebEd.tabChangeUrl = function () {
    $('body').on('click', '.tab-change-url a[data-toggle="tab"]', function (event) {
        window.history.pushState('', '', $(this).attr('href'));
    });
};
