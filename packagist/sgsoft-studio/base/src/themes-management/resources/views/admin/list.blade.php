@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')
    <script>
        $(window).load(function () {
            WebEd.DataTableAjax.init($('table.datatables'), {
                dataTableParams: {
                    ajax: {
                        url: '{!! route('admin::themes.index.post') !!}',
                        method: 'POST'
                    },
                    columns: {!! $dataTableHeadings or '[]' !!}
                },
                ajaxActionsSuccess: function ($btn, data) {
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                },
            });
        });
    </script>
@endsection

@section('content')
    <div class="layout-1columns">
        <div class="column main">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i>
                        Themes list
                    </h3>
                </div>
                <div class="box-body">
                    @include('webed-core::admin._components.datatables', (isset($dataTableColumns) ? $dataTableColumns : []))
                </div>
            </div>
            @php do_action('meta_boxes', 'main', 'webed-themes-management.index') @endphp
        </div>
    </div>
@endsection
