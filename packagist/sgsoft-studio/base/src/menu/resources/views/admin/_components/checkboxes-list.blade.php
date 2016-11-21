@if(isset($data) && is_array($data))
    <ul>
        @foreach($data as $row)
            <li>
                {!! Form::customCheckbox([
                    ['', array_get($row, 'id'), array_get($row, 'title')],
                ]) !!}
                @include('webed-menu::admin._components.checkboxes-list', ['data' => array_get($row, 'children')])
            </li>
        @endforeach
    </ul>
@endif
