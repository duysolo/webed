<?php
/**
 * @var array $values
 */
$values = (array)$values;
?>
@if(sizeof($values) > 1) <div class="mt-checkbox-list"> @endif
    @foreach($values as $value)
        @php
            $name = isset($value[0]) ? $value[0] : '';
            $curentValue = isset($value[1]) ? $value[1] : '';
            $label = isset($value[2]) ? $value[2] : '';
            $selected = isset($value[3]) ? (bool)$value[3] : false;
            $disabled = isset($value[4]) ? (bool)$value[4] : false;
        @endphp
        <label class="mt-checkbox mt-checkbox-outline {{ $disabled ? 'mt-checkbox-disabled' : '' }}">
            <input type="checkbox"
                   value="{{ $curentValue }}"
                   {{ $selected ? 'checked' : '' }}
                   name="{{ $name }}" {{ $disabled ? 'disabled' : '' }}> {{ $label }}
            <span></span>
        </label>
    @endforeach
@if(sizeof($values) > 1) </div> @endif
