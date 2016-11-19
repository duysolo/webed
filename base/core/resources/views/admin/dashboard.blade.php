@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i>
                        Dashboard statistics
                    </h3>
                </div>
                <div class="box-body">
                    Comming soon!
                </div>
            </div>
        </div>
        @php do_action('meta_boxes', 'main', 'webed-dashboard.index') @endphp
    </div>
@endsection
