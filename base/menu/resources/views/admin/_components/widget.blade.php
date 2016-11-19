<div class="box box-primary box-link-menus"
     data-type="{{ $type }}">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="icon-layers font-dark"></i>
            {{ $title }}
        </h3>
        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        @include('webed-menu::admin._components.checkboxes-list', $data)
    </div>
    <div class="box-footer text-right">
        <button class="btn btn-primary add-item"
                type="submit">
            <i class="fa fa-plus"></i> Add
        </button>
    </div>
</div>
