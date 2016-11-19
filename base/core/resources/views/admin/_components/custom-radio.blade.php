<?php
/**
 * @var string $name
 * @var array $values
 * @var string $selected
 */
$values = (array)$values;
?>
@if(sizeof($values) > 1) <div class="mt-radio-list"> @endif
    @foreach($values as $line)
        @php
            $value = isset($line[0]) ? $line[0] : '';
            $label = isset($line[1]) ? $line[1] : '';
            $disabled = isset($line[2]) ? $line[2] : '';
        @endphp
        <label class="mt-radio mt-radio-outline {{ $disabled ? 'mt-radio-disabled' : '' }}">
            <input type="radio"
                   value="{{ $value }}"
                   {{ (string)$selected === (string)$value ? 'checked' : '' }}
                   name="{{ $name }}" {{ $disabled ? 'disabled' : '' }}> {{ $label }}
            <span></span>
        </label>
    @endforeach
@if(sizeof($values) > 1) </div> @endif
