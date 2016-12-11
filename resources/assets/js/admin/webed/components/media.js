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
