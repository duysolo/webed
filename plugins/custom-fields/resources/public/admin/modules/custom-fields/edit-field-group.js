// Init
var ManageCustomFields = function () {

    var $body = $('body');

    var RULES_GROUP_TEMPLATE_HTML = $('#rules_group_template').html();

    /**
     * Handle actions for update rules
     */
    var handleRules = function () {
        var CURRENT_RULES = $.parseJSON($('#custom_fields_rules').val());
        var $globalTemplate = $(RULES_GROUP_TEMPLATE_HTML),
            $groupContainer = $('.line-group-container');

        /**
         * Add new rule
         */
        $body.on('click', '.location-add-rule', function (event) {
            event.preventDefault();
            var $current = $(this);
            var $template = $globalTemplate.clone();

            if ($current.hasClass('location-add-rule-and')) {
                $current.closest('.line-group').append($template);
            } else {
                var $group = $('<div class="line-group"></div>');

                $group.append($template);
                $groupContainer.append($group);
            }
            $template.find('.rule-a').trigger('change');
        });

        /**
         * Change the rule-a
         */
        $body.on('change', '.rule-a', function (event) {
            event.preventDefault();
            var $current = $(this);
            var $parent = $current.closest('.rule-line');
            $parent.find('.rules-b-group select').addClass('hidden');
            $parent.find('.rules-b-group select[data-rel="' + $current.val() + '"]').removeClass('hidden');
        });

        /**
         * Remove rule
         */
        $body.on('click', '.remove-rule-line', function (event) {
            event.preventDefault();
            var $current = $(this);
            var $parent = $current.closest('.rule-line');
            var $lineGroup = $current.closest('.line-group');
            if ($lineGroup.find('.rule-line').length < 2) {
                $lineGroup.remove();
            } else {
                $parent.remove();
            }
        });

        /**
         * Init data when page loaded
         */
        if (CURRENT_RULES.length < 1) {
            $('.location-add-rule').trigger('click');
        } else {
            CURRENT_RULES.forEach(function (rules, indexRule) {
                var $group = $('<div class="line-group"></div>');
                rules.forEach(function (item, index) {
                    var $template = $globalTemplate.clone();
                    $template.find('.rule-a').val(item.name);
                    $template.find('.rule-type').val(item.type);
                    $template.find('.rule-b:not([data-rel="' + item.name + '"])').addClass('hidden');
                    $template.find('.rule-b[data-rel="' + item.name + '"]').val(item.value);
                    $group.append($template);
                });
                $groupContainer.append($group);
            });
        }
    };

    /**
     * Handle actions for update fields
     */
    var handleFieldGroups = function () {

        var totalAdded = 0;

        var CUSTOM_FIELDS_DATA = $.parseJSON($('#custom_fields').val());

        /**
         * Deleted fields
         * @type {Array}
         */
        var DELETED_FIELDS = [];

        /**
         * Template of new field item
         * @type {any}
         */
        var NEW_FIELD_TEMPLATE = $('#_new-field-source_template').html();

        /**
         * Get all option templates
         * @type {{repeater: (any), defaultValue: (any), defaultValueTextarea: (any), placeholderText: (any), wysiwygToolbar: (any), selectChoices: (any), buttonLabel: (any)}}
         */
        var fieldOptions = {
            repeater: $('#_options-repeater_template').html(),
            defaultValue: $('#_options-defaultvalue_template').html(),
            defaultValueTextarea: $('#_options-defaultvaluetextarea_template').html(),
            placeholderText: $('#_options-placeholdertext_template').html(),
            wysiwygToolbar: $('#_options-wysiwygtoolbar_template').html(),
            selectChoices: $('#_options-selectchoices_template').html(),
            buttonLabel: $('#_options-buttonlabel_template').html(),
            rows: $('#_options-rows_template').html()
        };

        /**
         * Get related options of current field type
         * @param value
         * @returns {string}
         */
        var getOptions = function (value) {
            var htmlSrc = '';
            switch (value) {
                case 'text':
                case 'email':
                case 'password':
                case 'number':
                    htmlSrc += fieldOptions.defaultValue + fieldOptions.placeholderText;
                    break;
                case 'image':
                case 'file':
                    return '';
                    break;
                case 'textarea':
                    htmlSrc += fieldOptions.defaultValueTextarea + fieldOptions.placeholderText + fieldOptions.rows;
                    break;
                case 'wysiwyg':
                    htmlSrc += fieldOptions.defaultValueTextarea + fieldOptions.wysiwygToolbar;
                    break;
                case 'select':
                    htmlSrc += fieldOptions.selectChoices + fieldOptions.defaultValue;
                    break;
                case 'checkbox':
                    htmlSrc += fieldOptions.selectChoices;
                    break;
                case 'radio':
                    htmlSrc += fieldOptions.selectChoices;
                    break;
                case 'repeater':
                    htmlSrc += fieldOptions.repeater + fieldOptions.buttonLabel;
                    break;
                default:

                    break;
            }

            return htmlSrc;
        };

        /**
         * @param target
         */
        var reloadOrderNumber = function (target) {
            target.each(function (index, el) {
                var current = $(this);
                var index_css = index + 1;
                current.attr('data-position', index_css);
            });
        };

        var setOrderNumber = function (target, number) {
            target.attr('data-position', number || target.index() + 1);
        };

        var getNewFieldTemplate = function (optionType) {
            return NEW_FIELD_TEMPLATE.replace(/___options___/gi, getOptions(optionType || 'text'));
        };

        /**
         * Toggle show/hide content
         */
        $body.on('click', '.show-item-details', function (event) {
            event.preventDefault();
            var parent = $(this).closest('li');
            $(this).toggleClass('active');
            parent.toggleClass('active');
        });
        $body.on('click', '.btn-close-field', function (event) {
            event.preventDefault();
            var parent = $(this).closest('li');
            parent.toggleClass('active');
            parent.find('> .field-column .show-item-details').toggleClass('active');
        });

        /**
         * Add field
         */
        $body.on('click', '.btn-add-field', function (event) {
            event.preventDefault();
            var $current = $(this);

            totalAdded++;

            var target = $current.closest('.add-new-field').find('> .sortable-wrapper');

            var $template = $(getNewFieldTemplate());

            target.append($template);

            $template.find('.line[data-option=title] input[type=text]').focus();

            setOrderNumber($template);

            //reloadOrderNumber(target.find('> li'));
            $template.find('.sortable-wrapper').sortable();
        });

        /**
         * Change field type
         */
        $body.on('change', '.change-field-type', function (event) {
            event.preventDefault();
            var $current = $(this);
            var parent = $current.closest('.item-details');
            var target = parent.find('> .options');

            target.html(getOptions($current.val()));
        });

        /**
         * Change the related columns title
         */
        $body.on('change blur', '.line[data-option=slug] input[type=text]', function (event) {
            var $current = $(this);
            var text = WebEd.stringToSlug($current.val(), '_');
            var $parent = $current.closest('.line');

            $parent.closest('.ui-sortable-handle').find('> .field-column .field-slug').text(text);

            $current.val(text);
        });
        $body.on('change blur', '.line[data-option=type] select', function (event) {
            var $current = $(this);
            var text = WebEd.stringToSlug($current.val(), '_');
            var $parent = $current.closest('.line');

            $parent.closest('.ui-sortable-handle').find('> .field-column .field-type').text(text);

            $current.val(text);
        });
        $body.on('change blur', '.line[data-option=title] input[type=text]', function (event) {
            var $current = $(this);
            var $parent = $current.closest('.line');
            var $nameSlugField = $parent.find('~ .line[data-option=slug] input[type=text]');
            var text = $current.val();

            /**
             * Change the line title
             */
            $parent.closest('.ui-sortable-handle').find('> .field-column .field-label').text(text);

            /**
             * Change field name
             */
            if (!$nameSlugField.val()) {
                $nameSlugField.val(WebEd.stringToSlug(text, '_')).trigger('change');
            }
        });

        /**
         * Delete field
         */
        $('#deleted_items').val('');
        $body.on('click', '.btn-remove', function (event) {
            event.preventDefault();
            var $parent = $(this).closest('.ui-sortable-handle');
            var $grandParent = $parent.parent();
            DELETED_FIELDS.push($parent.data('id'));
            $parent.animate({
                    top: -60,
                    left: 60,
                    opacity: 0.3
                },
                300,
                function () {
                    $parent.remove();
                    reloadOrderNumber($grandParent.find('> li'));
                });
            $('#deleted_items').val(JSON.stringify(DELETED_FIELDS));
        });

        /**
         *
         * @param fields
         * @param $appendTo
         */
        var initFields = function (fields, $appendTo) {
            /**
             * Enable sortable
             */
            $appendTo.sortable();

            fields.forEach(function (field, indexField) {
                var $template = $(getNewFieldTemplate(field.type || 'text'));
                $template.data('id', field.id || 0);
                $template.find('.line[data-option=type] select').val(array_get(field, 'type', 'text'));
                $template.find('.line[data-option=title] input').val(array_get(field, 'title', ''));
                $template.find('.line[data-option=slug] input').val(array_get(field, 'slug', ''));
                $template.find('.line[data-option=instructions] textarea').val(array_get(field, 'instructions', ''));

                $template.find('.line[data-option=defaultvalue] input').val(array_get(field.options, 'defaultValue', ''));
                $template.find('.line[data-option=defaultvaluetextarea] textarea').val(array_get(field.options, 'defaultValueTextarea', ''));
                $template.find('.line[data-option=placeholdertext] input').val(array_get(field.options, 'placeholderText', ''));
                $template.find('.line[data-option=wysiwygtoolbar] select').val(array_get(field.options, 'wysiwygToolbar', 'basic'));
                $template.find('.line[data-option=selectchoices] textarea').val(array_get(field.options, 'selectChoices', ''));
                $template.find('.line[data-option=buttonlabel] input').val(array_get(field.options, 'buttonLabel', ''));
                $template.find('.line[data-option=rows] input').val(array_get(field.options, 'rows', ''));

                $template.find('.field-label').html(array_get(field, 'title', 'Text'));
                $template.find('.field-slug').html(array_get(field, 'slug', 'text'));
                $template.find('.field-type').html(array_get(field, 'type', 'text'));

                $template.removeClass('active');
                $template.attr('data-position', (indexField + 1));

                initFields(field.items, $template.find('.sortable-wrapper'));

                $appendTo.append($template);
            });
        };
        initFields(CUSTOM_FIELDS_DATA, $('.sortable-wrapper'));
    };

    /**
     * Export data
     * @type {{exportRulesToJson, exportFieldsToJson}}
     */
    var exportData = function () {
        return {
            exportRulesToJson: function () {
                var result = [];

                $('.custom-fields-rules .line-group-container .line-group').each(function () {
                    var $current = $(this);
                    var lineGroupData = [];
                    $current.find('.rule-line').each(function (index, element) {
                        var $currentLine = $(this);

                        var data = {
                            name: $currentLine.find('.rule-a').val(),
                            type: $currentLine.find('.rule-type').val(),
                            value: $currentLine.find('.rule-b:not(.hidden)').val()
                        };
                        lineGroupData.push(data);
                    });
                    if (lineGroupData.length > 0) {
                        result.push(lineGroupData);
                    }
                });

                return result;
            },
            exportFieldsToJson: function () {
                var result = [];

                var getAllFields = function ($from, $pushTo) {
                    $from.each(function (index, element) {
                        var object = {};
                        var $current = $(this);

                        object.id = $current.data('id') || 0;
                        object.title = $current.find('> .item-details > .line[data-option=title] input[type=text]').val() || null;
                        object.slug = $current.find('> .item-details > .line[data-option=slug] input[type=text]').val() || null;
                        object.instructions = $current.find('> .item-details > .line[data-option=instructions] textarea').val() || null;
                        object.type = $current.find('> .item-details > .line[data-option=type] select').val() || null;
                        object.options = {
                            defaultValue: $current.find('> .item-details > .options > .line[data-option=defaultvalue] input[type=text]').val() || null,
                            defaultValueTextarea: $current.find('> .item-details > .options > .line[data-option=defaultvaluetextarea] textarea').val() || null,
                            placeholderText: $current.find('> .item-details > .options > .line[data-option=placeholdertext] input[type=text]').val() || null,
                            wysiwygToolbar: $current.find('> .item-details > .options > .line[data-option=wysiwygtoolbar] select').val() || null,
                            selectChoices: $current.find('> .item-details > .options > .line[data-option=selectchoices] textarea').val() || null,
                            buttonLabel: $current.find('> .item-details > .options > .line[data-option=buttonlabel] input[type=text]').val() || null,
                            rows: $current.find('> .item-details > .options > .line[data-option=rows] input[type=number]').val() || null
                        };
                        object.items = [];

                        getAllFields($current.find('> .item-details > .options > .line[data-option=repeater] > .col-xs-9 > .add-new-field > .sortable-wrapper > .ui-sortable-handle'), object.items);

                        $pushTo.push(object);
                    });
                };

                getAllFields($('#custom_field_group_items > .ui-sortable-handle'), result);

                return result;
            }
        }
    }();

    return {
        /**
         * Init the module
         */
        init: function () {
            handleRules();

            handleFieldGroups();

            /**
             * Pass data to form when submit
             */
            $body.on('submit', '.form-update-field-group', function (event) {
                // event.preventDefault();
                var dataRules = JSON.stringify(exportData.exportRulesToJson());
                var dataFields = JSON.stringify(exportData.exportFieldsToJson());
                $('#custom_fields_rules').html(dataRules).val(dataRules);
                $('#custom_fields').html(dataFields).val(dataFields);
            });
        }
    };

}();

(function ($) {
    $(window).load(function () {
        ManageCustomFields.init();
    });
})(jQuery);
