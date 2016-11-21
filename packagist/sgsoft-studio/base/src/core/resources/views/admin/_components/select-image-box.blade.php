<?php
/**
 * @var string $name
 * @var string $value
 * @var string $thumbnail
 * @var string $label
 */
$label = isset($label) ? $label : 'Choose image';
$value = isset($value) ? $value : '';
$thumbnail = isset($thumbnail) ? $thumbnail : '/admin/images/no-image.png';
?>
<div class="select-media-box">
    <button type="button" class="btn blue show-add-media-popup">
        {{ $label }}
    </button>
    <div class="clearfix"></div>
    <a title="" class="show-add-media-popup" href="javascript:;">
        <img src="{{ $value ?: $thumbnail }}" alt="{{ $value }}" class="img-responsive">
    </a>
    <input type="hidden" name="{{ $name }}" value="{{ $value or '' }}" class="input-file">
    <a title="" class="remove-image" href="javascript:;">
        <span>&nbsp;</span>
    </a>
</div>
