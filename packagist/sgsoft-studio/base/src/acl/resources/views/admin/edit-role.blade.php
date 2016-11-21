@extends('webed-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.js-validate-form').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {},
                rules: {
                    name: {
                        minlength: 3,
                        maxlength: 100,
                        required: true
                    },
                    slug: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    }
                },

                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label.closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
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
                        <i class="icon-layers font-dark"></i> Role information
                    </h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['class' => 'js-validate-form', 'url' => route('admin::acl-roles.edit.post', ['id' => $currentId])]) !!}
                    <div class="form-group">
                        <label class="control-label">Name<span class="required"> * </span></label>
                        <input type="text"
                               name="name"
                               value="{{ $object->name or '' }}"
                               class="form-control"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Alias<span class="required"> * </span></label>
                        <input type="text" name="slug"
                               value="{{ $object->slug or '' }}"
                               {{ $currentId ? 'disabled' : '' }}
                               class="form-control"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Related permissions<span class="required"> * </span></label>
                        <div class="scroller form-control height-auto" style="max-height: 400px;"
                             data-always-visible="1" data-rail-visible1="1">
                            <div class="p10">
                                @foreach($permissions as $key => $row)
                                    <div class="checkbox-group">
                                        <label class="mt-checkbox mt-checkbox-outline">
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   {{ in_array($row->id, $checkedPermissions) || $superAdminRole ? 'checked' : '' }}
                                                   value="{{ $row->id or '' }}">
                                            {{ $row->name or '' }}
                                            <small><b>&nbsp;({{ $row->module or '' }})</b></small>
                                            <span></span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-check"></i> Save
                        </button>
                        <button class="btn btn-success" type="submit" name="_continue_edit"
                                value="1">
                            <i class="fa fa-check"></i> Save & continue
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @php do_action('meta_boxes', 'main', 'acl-roles.edit', (isset($object) ? $object : null)) @endphp
        </div>
    </div>
@endsection
