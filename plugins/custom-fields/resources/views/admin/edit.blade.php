@extends('webed-core::admin._master')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/modules/custom-fields/edit-field-group.css') }}">
@endsection

@section('js')
    @include('webed-custom-fields::admin._script-templates.edit-field-group-items')
@endsection

@section('js-init')

@endsection

@section('content')
    {!! Form::open(['class' => 'js-validate-form form-update-field-group', 'url' => route('admin::custom-fields.field-group.edit.post', ['id' => $currentId])]) !!}
    <textarea name="rules"
              id="custom_fields_rules"
              class="form-control hidden"
              style="display: none !important;">{!! ((isset($object->rules) && $object->rules) ? $object->rules : '[]') !!}</textarea>
    <textarea name="group_items"
              id="custom_fields"
              class="form-control hidden"
              style="display: none !important;">{!! $customFieldItems or '[]' !!}</textarea>
    <textarea name="deleted_items"
              id="deleted_items"
              class="form-control hidden"
              style="display: none !important;"></textarea>
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i>
                        Basic information
                    </h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">
                            <b>Title</b>
                            <span class="required"> * </span>
                        </label>
                        <input required type="text"
                               name="title"
                               class="form-control"
                               value="{{ $object->title or '' }}"
                               autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            <b>Status</b>
                            <span class="required"> * </span>
                        </label>
                        <select name="status" class="form-control">
                            <option
                                value="activated" {{ (isset($object) && $object->status == 'activated') ? 'selected' : '' }}>
                                Activated
                            </option>
                            <option
                                value="disabled" {{ (isset($object) && $object->status == 'disabled') ? 'selected' : '' }}>
                                Disabled
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i>
                        Rules
                    </h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="custom-fields-rules">
                        <label class="control-label">
                            <b>Rules</b>
                            <span class="required"> * </span>
                            <span class="help-block">Show this field group if</span>
                        </label>
                        <div class="line-group-container"></div>
                        <div class="line">
                            <p class="mt20"><b>Or</b></p>
                            <a class="location-add-rule-or location-add-rule btn btn-info" href="#">
                                Add rule group
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="icon-layers font-dark"></i>
                Field group information
            </h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <div class="custom-fields-list">
                    <div class="nestable-group">
                        <div class="add-new-field">
                            <ul class="list-group field-table-header clearfix">
                                <li class="col-xs-4 list-group-item w-bold">Field Label</li>
                                <li class="col-xs-4 list-group-item w-bold">Field Name</li>
                                <li class="col-xs-4 list-group-item w-bold">Field Type</li>
                            </ul>
                            <div class="clearfix"></div>
                            <ul class="sortable-wrapper edit-field-group-items field-group-items"
                                id="custom_field_group_items"></ul>
                            <div class="text-right pt10">
                                <a class="btn red btn-add-field"
                                   title=""
                                   href="#">Add field</a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="form-group text-right mt40">
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-check"></i> Save
                </button>
                <button class="btn btn-success" type="submit" name="_continue_edit"
                        value="1">
                    <i class="fa fa-check"></i> Save & continue
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
