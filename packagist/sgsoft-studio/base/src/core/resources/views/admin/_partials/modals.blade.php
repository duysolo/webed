{{--BEGIN Select media modal--}}
<div class="modal fade" id="select_media_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Browse medias</h4>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom mb0">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#select_media_modal_uploaded_files" data-toggle="tab">Uploaded files</a>
                        </li>
                        <li class="external-image">
                            <a href="#select_media_modal_external_image" data-toggle="tab">External image</a>
                        </li>
                        <li class="external-file">
                            <a href="#select_media_modal_external_file" data-toggle="tab">External file</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="select_media_modal_uploaded_files">
                            <div class="iframe-container embed-responsive embed-responsive-16by9"></div>
                        </div>
                        <div class="tab-pane select-media-modal-external-asset" id="select_media_modal_external_image">
                            <div class="container-fluid">
                                <div class="form-group margin-top-20">
                                    <label for="select_media_external_image"><b>External image</b></label>
                                    <input type="text" value="" placeholder="Paste your link here"
                                           id="select_media_external_image" class="form-control input-asset">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn green">Add</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane select-media-modal-external-asset" id="select_media_modal_external_file">
                            <div class="container-fluid">
                                <div class="form-group margin-top-20">
                                    <label for="select_media_external_file"><b>External asset</b></label>
                                    <input type="text" value="" placeholder="Paste your link here"
                                           id="select_media_external_file" class="form-control input-asset">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn green">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--END Select media modal--}}
