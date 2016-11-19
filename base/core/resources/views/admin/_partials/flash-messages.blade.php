@php
    $customErrors = session('errorMessages');
    $customMessages = session('successMessages');
    $customInfos = session('infoMessages');
    $customWarnings = session('warningMessages');
@endphp
@if(isset($errors)) @foreach($errors->all() as $key => $row)
    <div class="note note-danger">
        <p>{!! $row !!}</p>
    </div>
@endforeach @endif
@if($customErrors) @foreach($customErrors as $key => $row)
    <div class="note note-danger">
        <p>{!! $row !!}</p>
    </div>
@endforeach @endif
@if($customMessages) @foreach($customMessages as $key => $row)
    <div class="note note-success">
        <p>{!! $row !!}</p>
    </div>
@endforeach @endif
@if($customInfos) @foreach($customInfos as $key => $row)
    <div class="note note-info">
        <p>{!! $row !!}</p>
    </div>
@endforeach @endif
@if($customWarnings) @foreach($customWarnings as $key => $row)
    <div class="note note-warning">
        <p>{!! $row !!}</p>
    </div>
@endforeach @endif
@php do_action('flash_messages') @endphp
