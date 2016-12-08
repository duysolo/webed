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
                        url: '{!! route('admin::webed-backup.index.post') !!}',
                        method: 'POST'
                    },
                    columns: {!! $dataTableHeadings or '[]' !!}
                }
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
                        Medias & database backups
                    </h3>
                    <div class="box-tools">
                        <a class="btn btn-transparent green btn-sm"
                           data-toggle="confirmation"
                           data-placement="left"
                           href="{{ route('admin::webed-backup.create.get', ['type' => 'database']) }}">
                            <i class="fa fa-plus"></i> Database
                        </a>
                        <a class="btn btn-transparent yellow-lemon btn-sm"
                           data-toggle="confirmation"
                           data-placement="left"
                           href="{{ route('admin::webed-backup.create.get', ['type' => 'medias']) }}">
                            <i class="fa fa-plus"></i> Medias
                        </a>
                        <a class="btn btn-transparent purple btn-sm"
                           data-toggle="confirmation"
                           data-placement="left"
                           href="{{ route('admin::webed-backup.create.get') }}">
                            <i class="fa fa-plus"></i> Medias & Database
                        </a>
                        <a class="btn btn-transparent red-sunglo btn-sm"
                           data-toggle="confirmation"
                           data-placement="left"
                           href="{{ route('admin::webed-backup.delete-all.get') }}">
                            <i class="fa fa-trash"></i> Delete all backups
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    @include('webed-core::admin._components.datatables', (isset($dataTableColumns) ? $dataTableColumns : []))
                </div>
            </div>
        </div>
    </div>
@endsection
