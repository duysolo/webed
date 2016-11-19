@extends('webed-theme-clean-blog::front._master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                @if(isset($posts)) @foreach($posts as $post)
                    <div class="post-preview">
                        <a href="{{ route('public.get-by-slug-with-suffix.get', [$post->slug]) }}"
                           title="{{ $post->title or '' }}">
                            <h2 class="post-title">
                                {{ $post->title or '' }}
                            </h2>
                        </a>
                        <p class="post-meta">Posted by <a href="javascript:;">{{ $post->author->username or '' }}</a>
                            on {{ $post->created_at or '' }}</p>
                    </div>
                    <hr>
                @endforeach @endif
            </div>
        </div>
    </div>
@endsection
