@extends('webed-theme-DummyAlias::front._master')

@section('content')
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    {!! $object->content or '' !!}
                </div>
            </div>
        </div>
    </article>
@endsection
