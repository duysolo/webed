@extends('webed-auth::admin._auth-actions')

@section('css')

@endsection

@section('js-init')

@endsection

@section('content')
    <!-- BEGIN LOGIN FORM -->
    <?php
    $errors = Session::get('errorMessages');
    if (!$errors) {
        $errors = Session::get('errors');
        if ($errors) {
            $errors = $errors->all();
        }
    }
    ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="/">Lara<b>WebEd</b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            @if($errors) @foreach($errors as $key => $row)
                <div class="note note-danger">
                    <p>{{ $row }}</p>
                </div>
            @endforeach @endif
            {!! Form::open() !!}
            <div class="form-group has-feedback">
                {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username']) !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    {!! form()->customCheckbox([
                        ['remember', 1, 'Remember me']
                    ]) !!}
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    {!! Form::button('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'type' => 'submit']) !!}
                </div>
                <!-- /.col -->
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- END LOGIN FORM -->
@endsection
