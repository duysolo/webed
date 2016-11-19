@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="layout-1columns">
        <div class="column main">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i>
                        Cache management
                    </h3>
                </div>
                <div class="box-body">
                    <a href="{{ route('admin::webed-caching.clear-cms-cache.get') }}"
                       data-toggle="confirmation"
                       data-placement="right"
                       title="Are you sure?"
                       class="btn btn-danger">
                        Clear cms caching
                    </a>
                    <a href="{{ route('admin::webed-caching.refresh-compiled-views.get') }}"
                       data-toggle="confirmation"
                       data-placement="right"
                       title="Are you sure?"
                       class="btn btn-warning">
                        Refresh compiled views
                    </a>
                </div>
            </div>
            @php do_action('meta_boxes', 'main', 'webed-caching.index') @endphp
        </div>
    </div>
@endsection
