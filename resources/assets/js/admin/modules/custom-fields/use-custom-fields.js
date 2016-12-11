var UseCustomFields = function ($) {
    var $body = $('body'),
        $window = $(window),
        $document = $(document);
    /**
     * Where to show the custom field elements
     */
    var $_UPDATE_TO = $('#custom_fields_container');
    /**
     * Where to export json data when submit form
     */
    var $_EXPORT_TO = $('#custom_fields_json');

    /**
     * Current field data
     */
    var CURRENT_DATA = json_decode($_EXPORT_TO.val(), []);

    var handleCustomFields = function () {
        var repeaterFieldAdded = 0;
        /**
         * The html template of custom fields
         */
        var fieldTemplate = {
            fieldGroup: $('#_render_customfield_field_group_template').html(),
            globalSkeleton: $('#_render_customfield_global_skeleton_template').html(),
            text: $('#_render_customfield_text_template').html(),
            number: $('#_render_customfield_number_template').html(),
            email: $('#_render_customfield_email_template').html(),
            password: $('#_render_customfield_password_template').html(),
            textarea: $('#_render_customfield_textarea_template').html(),
            checkbox: $('#_render_customfield_checkbox_template').html(),
            radio: $('#_render_customfield_radio_template').html(),
            select: $('#_render_customfield_select_template').html(),
            image: $('#_render_customfield_image_template').html(),
            file: $('#_render_customfield_file_template').html(),
            wysiwyg: $('#_render_customfield_wysiswg_template').html(),
            repeater: $('#_render_customfield_repeater_template').html(),
            repeaterItem: $('#_render_customfield_repeater_item_template').html(),
            repeaterFieldLine: $('#_render_customfield_repeater_line_template').html()
        };

        var initWYSIWYG = function ($element, type) {
            "use strict";
            var toolbar = type === 'basic' ? {
                toolbar: [['mode', 'Source', 'Image', 'TextColor', 'BGColor', 'Styles', 'Format', 'Font', 'FontSize', 'CreateDiv', 'PageBreak', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'RemoveFormat']]
            } : {};
            $element.ckeditor(toolbar);

            return $element;
        };

        var initCustomFieldsBoxes = function (boxes, $appendTo) {
            boxes.forEach(function (box, indexBox) {
                var skeleton = fieldTemplate.globalSkeleton;
                skeleton = skeleton.replace(/__type__/gi, box.type || '');
                skeleton = skeleton.replace(/__title__/gi, box.title || '');
                skeleton = skeleton.replace(/__instructions__/gi, box.instructions || '');

                var $skeleton = $(skeleton);
                $skeleton.find('.meta-box-wrap').append(registerLine(box));
                $skeleton.data('lcf-registered-data', box);
                $appendTo.append($skeleton);
            });
        };

        var registerLine = function (box) {
            var result = fieldTemplate[box.type],
                $wrapper = $('<div class="lcf-' + box.type + '-wrapper"></div>');
            $wrapper.data('lcf-registered-data', box);
            switch (box.type) {
                case 'text':
                case 'number':
                case 'email':
                case 'password':
                    result = result.replace(/__placeholderText__/gi, box.options.placeholderText || '');
                    result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
                    break;
                case 'textarea':
                    result = result.replace(/__rows__/gi, box.options.rows || 3);
                    result = result.replace(/__placeholderText__/gi, box.options.placeholderText || '');
                    result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
                    break;
                case 'image':
                    result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
                    if (!box.value) {
                        var defaultImage = $(result).find('img').attr('data-default');
                        result = result.replace(/__image__/gi, defaultImage || box.options.defaultValue || '');
                    } else {
                        result = result.replace(/__image__/gi, box.value || box.options.defaultValue || '');
                    }
                    break;
                case 'file':
                    result = result.replace(/__value__/gi, box.value || box.options.defaultValue || '');
                    break;
                case 'select':
                    var $result = $(result);
                    var choices = parseChoices(box.options.selectChoices);
                    choices.forEach(function (choice, index) {
                        $result.append('<option value="' + choice[0] + '">' + choice[1] + '</option>');
                    });
                    $result.val(array_get(box, 'value', box.options.defaultValue));
                    $wrapper.append($result);
                    return $wrapper;
                    break;
                case 'checkbox':
                    var choices = parseChoices(box.options.selectChoices);
                    var boxValue = json_decode(box.value);
                    choices.forEach(function (choice, index) {
                        var template = result.replace(/__value__/gi, choice[0] || '');
                        template = template.replace(/__title__/gi, choice[1] || '');
                        template = template.replace(/__checked__/gi, ($.inArray(choice[0], boxValue) != -1) ? 'checked' : '');
                        $wrapper.append($(template));
                    });
                    return $wrapper;
                    break;
                case 'radio':
                    var choices = parseChoices(box.options.selectChoices);
                    var isChecked = false;
                    choices.forEach(function (choice, index) {
                        var template = result.replace(/__value__/gi, choice[0] || '');
                        template = template.replace(/__id__/gi, box.id + box.slug + repeaterFieldAdded);
                        template = template.replace(/__title__/gi, choice[1] || '');
                        template = template.replace(/__checked__/gi, (box.value === choice[0]) ? 'checked' : '');
                        $wrapper.append($(template));

                        if (box.value === choice[0]) {
                            isChecked = true;
                        }
                    });
                    if (isChecked === false) {
                        $wrapper.find('input[type=radio]:first').prop('checked', true);
                    }
                    return $wrapper;
                    break;
                case 'repeater':
                    var $result = $(result);
                    $result.data('lcf-registered-data', box);

                    $result.find('> .repeater-add-new-field').html(box.options.buttonLabel || 'Add new item');
                    $result.find('> .sortable-wrapper').sortable();
                    registerRepeaterItem(box.items, box.value || [], $result.find('> .field-group-items'));
                    return $result;
                    break;
                case 'wysiwyg':
                    result = result.replace(/__value__/gi, box.value || '');
                    var $result = $(result);
                    return initWYSIWYG($result, box.options.wysiwygToolbar || 'basic');
                    break;
            }
            $wrapper.append($(result));
            return $wrapper;
        };

        var registerRepeaterItem = function (items, data, $appendTo) {
            $appendTo.data('lcf-registered-data', items);
            data.forEach(function (dataItem, indexData) {
                var indexCss = $appendTo.find('> .ui-sortable-handle').length + 1;
                var result = fieldTemplate.repeaterItem;
                result = result.replace(/__position__/gi, indexCss);

                var $result = $(result);
                $result.data('lcf-registered-data', items);

                registerRepeaterFieldLine(items, dataItem, $result.find('> .field-line-wrapper > .field-group'));

                $appendTo.append($result);
            });
            return $appendTo;
        };

        var registerRepeaterFieldLine = function (items, data, $appendTo) {
            data.forEach(function (item, index) {
                repeaterFieldAdded++;

                var result = fieldTemplate.repeaterFieldLine;
                result = result.replace(/__title__/gi, item.title || '');
                result = result.replace(/__instructions__/gi, item.instructions || '');

                var $result = $(result);
                $result.data('lcf-registered-data', item);
                $result.find('> .repeater-item-input').append(registerLine(item));

                $appendTo.append($result);
            });
            return $appendTo;
        };

        var parseChoices = function (choiceString) {
            var choices = [];
            choiceString.split('\n').forEach(function (item, index) {
                var currentChoice = item.split(':');
                if (currentChoice[0] && currentChoice[1]) {
                    currentChoice[0] = currentChoice[0].trim();
                    currentChoice[1] = currentChoice[1].trim();
                }
                choices.push(currentChoice);
            });
            return choices;
        };

        /**
         * Remove field item
         */
        $body.on('click', '.remove-field-line', function (event) {
            event.preventDefault();
            var current = $(this);
            current.parent().animate({
                    opacity: 0.1
                },
                300, function () {
                    current.parent().remove();
                });
        });

        /**
         * Collapse field item
         */
        $body.on('click', '.collapse-field-line', function (event) {
            event.preventDefault();
            var current = $(this);
            current.toggleClass('collapsed-line');
        });

        /**
         * Add new repeater line
         */
        $body.on('click', '.repeater-add-new-field', function (event) {
            event.preventDefault();
            var $groupWrapper = $.extend(true, {}, $(this).prev('.field-group-items'));
            var registeredData = $groupWrapper.data('lcf-registered-data');

            repeaterFieldAdded++;

            registerRepeaterItem(registeredData, [registeredData], $groupWrapper);
        });

        /**
         * Init data when page loaded
         */
        CURRENT_DATA.forEach(function (group, indexGroup) {
            var groupTemplate = fieldTemplate.fieldGroup;
            groupTemplate = groupTemplate.replace(/__title__/gi, group.title || '');

            var $groupTemplate = $(groupTemplate);

            initCustomFieldsBoxes(group.items, $groupTemplate.find('.meta-boxes-body'));

            $groupTemplate.data('lcf-field-group', group);

            $_UPDATE_TO.append($groupTemplate);
        });
    };

    var exportData = function () {
        var getFieldGroups = function () {
            var fieldGroups = [];

            $('#custom_fields_container').find('> .meta-boxes').each(function () {
                var $current = $(this);
                var currentData = $current.data('lcf-field-group');
                var $items = $current.find('> .meta-boxes-body > .meta-box');
                currentData.items = getFieldItems($items);
                fieldGroups.push(currentData);
            });
            return fieldGroups;
        };

        var getFieldItems = function ($items) {
            var items = [];
            $items.each(function () {
                items.push(getFieldItemValue($(this)));
            });
            return items;
        };

        var getFieldItemValue = function ($item) {
            var customFieldData = $.extend(true, {}, $item.data('lcf-registered-data'));
            switch (customFieldData.type) {
                case 'text':
                case 'number':
                case 'email':
                case 'password':
                case 'image':
                case 'file':
                    customFieldData.value = $item.find('> .meta-box-wrap input').val();
                    break;
                case 'wysiwyg':
                case 'textarea':
                    customFieldData.value = $item.find('> .meta-box-wrap textarea').val();
                    break;
                case 'checkbox':
                    customFieldData.value = [];
                    $item.find('> .meta-box-wrap input:checked').each(function () {
                        customFieldData.value.push($(this).val());
                    });
                    break;
                case 'radio':
                    customFieldData.value = $item.find('> .meta-box-wrap input:checked').val();
                    break;
                case 'select':
                    customFieldData.value = $item.find('> .meta-box-wrap select').val();
                    break;
                case 'repeater':
                    customFieldData.value = [];
                    var $repeaterItems = $item.find('> .meta-box-wrap > .lcf-repeater > .field-group-items > li');
                    $repeaterItems.each(function () {
                        var $current = $(this);
                        var fieldGroup = $current.find('> .field-line-wrapper > .field-group');
                        customFieldData.value.push(getRepeaterItemData(fieldGroup.find('> li')));
                    });
                    break;
                default:
                    customFieldData = null;
                    break;
            }
            return customFieldData;
        };

        var getRepeaterItemData = function ($where) {
            var data = [];
            $where.each(function () {
                var $current = $(this);
                data.push(getRepeaterItemValue($current));
            });
            return data;
        };

        var getRepeaterItemValue = function ($item) {
            var customFieldData = $.extend(true, {}, $item.data('lcf-registered-data'));
            switch (customFieldData.type) {
                case 'text':
                case 'number':
                case 'email':
                case 'password':
                case 'image':
                case 'file':
                    customFieldData.value = $item.find('> .repeater-item-input input').val();
                    break;
                case 'wysiwyg':
                case 'textarea':
                    customFieldData.value = $item.find('> .repeater-item-input textarea').val();
                    break;
                case 'checkbox':
                    customFieldData.value = [];
                    $item.find('> .repeater-item-input input:checked').each(function () {
                        customFieldData.value.push($(this).val());
                    });
                    break;
                case 'radio':
                    customFieldData.value = $item.find('> .repeater-item-input input:checked').val();
                    break;
                case 'select':
                    customFieldData.value = $item.find('> .repeater-item-input select').val();
                    break;
                case 'repeater':
                    customFieldData.value = [];
                    var $repeaterItems = $item.find('> .repeater-item-input > .lcf-repeater > .field-group-items > li');
                    $repeaterItems.each(function () {
                        var $current = $(this);
                        var fieldGroup = $current.find('> .field-line-wrapper > .field-group');
                        customFieldData.value.push(getRepeaterItemData(fieldGroup.find('> li')));
                    });
                    break;
                default:
                    customFieldData = null;
                    break;
            }
            return customFieldData;
        };

        $_EXPORT_TO.closest('form').on('submit', function (event) {
            $_EXPORT_TO.val(JSON.stringify(getFieldGroups()));
        });
    };

    return {
        init: function () {
            if (typeof CURRENT_DATA === 'undefined') {
                return;
            }
            handleCustomFields();
            exportData();
        }
    }
}(jQuery);

(function ($) {
    $(document).ready(function () {
        UseCustomFields.init();
    });
})(jQuery);
