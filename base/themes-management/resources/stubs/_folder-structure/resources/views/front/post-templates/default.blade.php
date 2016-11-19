@extends('webed-theme-DummyAlias::front._master')

@section('content')
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    {!! $object->content or '' !!}
                    <hr>
                    @foreach($relatedPosts as $post)
                        @if(!$loop->first) <br> @endif
                            <i class="fa fa-hand-o-right"></i>
                            <a class="link-black"
                               href="{{ route('public.get-by-slug-with-suffix.get', [$post->slug]) }}">
                                {{ $post->title }}
                            </a>
                    @endforeach
                </div>
            </div>
        </div>
    </article>
@endsection
