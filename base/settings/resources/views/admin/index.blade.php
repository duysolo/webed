@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="layout-2columns sidebar-left">
        <div class="column left">
            <ul class="list-group">
                @php do_action('meta_boxes', 'top-sidebar', 'webed-settings.index') @endphp
                @foreach(cms_settings()->export() as $key => $row)
                    <li class="list-group-item
                        {{ (!Request::exists('_tab') && $loop->first === true) || Request::get('_tab') === $key ? 'active' : '' }}"
                        data-piority="{{ $row['piority'] or '' }}"
                        role="presentation">
                        <a href="{{ Request::url() }}?_tab={{ $key }}">
                            {{ $row['title'] }}
                        </a>
                    </li>
                @endforeach
                @php do_action('meta_boxes', 'bottom-sidebar', 'webed-settings.index') @endphp
            </ul>
        </div>
        <div class="column main">
            <div class="tab-content">
                @foreach(cms_settings()->export() as $key => $group)
                    @if((!Request::exists('_tab') && $loop->first === true) || Request::get('_tab') === $key)
                    <div class="tab-pane active">
                        {!! Form::open(['class' => 'js-validate-form']) !!}
                        {!! Form::hidden('_tab', $key) !!}
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    <i class="icon-layers font-dark"></i>
                                    {{ $group['title'] }}
                                </h3>
                            </div>
                            <div class="box-body">
                                @foreach($group['items'] as $setting)
                                    <div class="form-group" data-piority="{{ $setting['piority'] or '' }}">
                                        <label class="control-label block">{{ $setting['label'] or '' }}</label>
                                        {!! call_user_func_array([form(), $setting['type']], call_user_func($setting['params'])) !!}
                                        <span class="help-block">{{ $setting['helper'] or '' }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="box-footer">
                                {!! Form::button('Save change', [
                                    'class' => 'btn green pull-right',
                                    'type' => 'submit',
                                ]) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @endif
                @endforeach
                @php do_action('meta_boxes', 'main', 'webed-settings.index') @endphp
            </div>
        </div>
    </div>
@endsection
