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
                        Colors
                    </h3>
                </div>
                <div class="box-body">
                    @foreach($colors as $key => $color)
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <div class="color-demo tooltips" data-original-title="Click to view demos for this color" data-toggle="modal" data-target="#demo_modal_{{ $key }}">
                                <div class="small-box bg-{{ $key }}">
                                    <div class="inner">
                                        <h3>{{ $color }}</h3>
                                        <p>{{ $key }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="demo_modal_{{ $key }}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content c-square">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title bold uppercase font-{{ $key }}">{{ $key }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#{{ $key }}_tab_1_content" data-toggle="tab">Typography</a>
                                                    </li>
                                                    <li>
                                                        <a href="#{{ $key }}_tab_2_content" data-toggle="tab">Background &amp; Border</a>
                                                    </li>
                                                    <li>
                                                        <a href="#{{ $key }}_tab_3_content" data-toggle="tab">Buttons</a>
                                                    </li>
                                                    <li>
                                                        <a href="#{{ $key }}_tab_4_content" data-toggle="tab">Components</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="{{ $key }}_tab_1_content">
                                                        <h4>Text font</h4>
                                                        <div style="margin: 10px 0 30px 0">
                                                            <span class="font-{{ $key }} font-lg">Some sample text goes here...</span>
                                                            <br>
                                                            <span class="font-{{ $key }} font-lg sbold">Some sample text goes here...</span>
                                                            <br>
                                                            <span class="font-{{ $key }} font-lg bold uppercase">Some sample text goes here...</span>
                                                        </div>
                                                        <h4>Background matching text font</h4>
                                                        <div style="margin: 10px 0 30px 0; padding: 10px" class="bg-{{ $key }}">
                                                            <span class="bg-font-{{ $key }} font-lg">Some sample text goes here...</span>
                                                            <br>
                                                            <span class="bg-font-{{ $key }} font-lg sbold">Some sample text goes here...</span>
                                                            <br>
                                                            <span class="bg-font-{{ $key }} font-lg bold uppercase">Some sample text goes here...</span>
                                                        </div>
                                                        <h4>Icon font</h4>
                                                        <div style="margin: 10px 0 30px 0">
                                                            <i class="font-{{ $key }} font-lg icon-user"></i>&nbsp;
                                                            <i class="font-{{ $key }} font-lg icon-settings"></i>&nbsp;
                                                            <i class="font-{{ $key }} font-lg icon-calendar"></i>
                                                            <br>
                                                            <i class="font-{{ $key }} font-lg fa fa-bar-chart-o"></i>&nbsp;
                                                            <i class="font-{{ $key }} font-lg fa fa-code-fork icon-settings"></i>&nbsp;
                                                            <i class="font-{{ $key }} font-lg fa fa-cogs"></i>
                                                            <br>
                                                            <i class="font-{{ $key }} font-lg glyphicon glyphicon-star-empty"></i>&nbsp;
                                                            <i class="font-{{ $key }} font-lg glyphicon glyphicon-leaf"></i>&nbsp;
                                                            <i class="font-{{ $key }} font-lg glyphicon glyphicon-warning-sign"></i>
                                                            <br> </div>
                                                        <h4>Background matching icon font</h4>
                                                        <div style="margin: 10px 0 30px 0; padding: 10px" class="bg-{{ $key }}">
                                                            <i class="bg-font-{{ $key }} font-lg icon-user"></i>&nbsp;
                                                            <i class="bg-font-{{ $key }} font-lg icon-settings"></i>&nbsp;
                                                            <i class="bg-font-{{ $key }} font-lg icon-calendar"></i>
                                                            <br>
                                                            <i class="bg-font-{{ $key }} font-lg fa fa-bar-chart-o"></i>&nbsp;
                                                            <i class="bg-font-{{ $key }} font-lg fa fa-code-fork icon-settings"></i>&nbsp;
                                                            <i class="bg-font-{{ $key }} font-lg fa fa-cogs"></i>
                                                            <br>
                                                            <i class="bg-font-{{ $key }} font-lg glyphicon glyphicon-star-empty"></i>&nbsp;
                                                            <i class="bg-font-{{ $key }} font-lg glyphicon glyphicon-leaf"></i>&nbsp;
                                                            <i class="bg-font-{{ $key }} font-lg glyphicon glyphicon-warning-sign"></i>
                                                            <br> </div>
                                                        <h4>Class usage</h4> <code>class="font-{{ $key }}"</code> </div>
                                                    <div class="tab-pane" id="{{ $key }}_tab_2_content">
                                                        <div class="border-{{ $key }}"> Box with custom border color </div> <code>class="border-{{ $key }}"</code>
                                                        <div class="bg-{{ $key }} bg-font-{{ $key }}"> Box with custom background color </div> <code>class="bg-{{ $key }} bg-font-{{ $key }}"</code>
                                                    </div>
                                                    <div class="tab-pane" id="{{ $key }}_tab_3_content">
                                                        <a href="#" class="btn uppercase {{ $key }}">Button</a> &nbsp; <code>class="btn {{ $key }}"</code>
                                                        <br>
                                                        <a href="#" class="btn sbold uppercase btn-outline {{ $key }}">Button</a> &nbsp; <code>class="c-btn-border-1x c-btn-{{ $key }}"</code>
                                                        <br>
                                                        <a href="#" class="btn sbold uppercase btn-circle {{ $key }}">Button</a> &nbsp; <code>class="btn btn-circle {{ $key }}"</code>
                                                    </div>
                                                    <div class="tab-pane" id="{{ $key }}_tab_4_content">
                                                        <div class="small-box bg-{{ $key }}">
                                                            <div class="inner">
                                                                <h3>53<sup style="font-size: 17px">%</sup></h3>
                                                                <p>Bounce Rate</p>
                                                            </div>
                                                            <div class="icon">
                                                                <i class="ion fa fa-bars"></i>
                                                            </div>
                                                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline dark sbold uppercase" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
