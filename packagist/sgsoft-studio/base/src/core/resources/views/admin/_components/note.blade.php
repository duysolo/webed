<div class="alert note note-{{ $type }} {{ $dismissable === true ? 'alert-dismissible' : '' }}">
    <p>{!! $text !!}</p>
    @if($dismissable === true)
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    @endif
</div>
