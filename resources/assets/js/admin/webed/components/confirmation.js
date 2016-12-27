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
