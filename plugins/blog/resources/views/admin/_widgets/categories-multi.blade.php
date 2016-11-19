<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $title or 'Categories' }}</h3>
        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="multi-choices-widget">
            @if(isset($categories) && is_array($categories))
                @include('webed-blog::admin._widgets._categories-checkbox-option-line', [
                    'categories' => $categories,
                    'value' => (isset($value) ? $value : []),
                    'currentId' => null,
                    'name' => (isset($name) ? $name : '')
                ])
            @endif
        </div>
    </div>
</div>
