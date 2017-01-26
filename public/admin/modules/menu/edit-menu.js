// Init
var WebEdManageMenu = function () {
    "use strict";

    var $body = $('body');

    var $_TARGET = $('.nestable-menu');

    var $_UPDATE_TO = $('#menu_structure');

    var $_DELETED_NODES = $('#deleted_nodes');

    var DELETED_NODES = [];

    var handleItems = function () {
        /**
         * The templates
         */
        var MENU_NESTABLE_TEMPLATES = {
            listGroup: $('#menus_template_list_group').html(),
            listItem: $('#menus_template_list_item').html(),
        };

        var MENU_DATA = json_decode($_UPDATE_TO.val(), []);

        var initNestable = function () {
            /**
             * Init nestable
             */
            $_TARGET.nestable({
                group: 1,
                maxDepth: 10,
                expandBtnHTML: '',
                collapseBtnHTML: ''
            });
        };

        var handleDetails = function () {
            /**
             * Toggle item details
             */
            $body.on('click', '.dd-item .dd3-content a.show-item-details', function (event) {
                event.preventDefault();
                $(this).toggleClass('active');
                $(this).closest('.dd-item').toggleClass('active');
            });

            /**
             * Change details value
             */
            $body.on('change keyup', '.dd-item .item-details .fields input[type=text], .dd-item .item-details .fields select', function (event) {
                event.preventDefault();
                var $current = $(this);
                var $label = $current.closest('label'),
                    $currentItem = $current.closest('.dd-item');
                $currentItem.data($label.attr('data-field'), $current.val());
            });
        };

        var renderListGroup = function (data) {
            var $listGroup = $(MENU_NESTABLE_TEMPLATES.listGroup);
            data.forEach(function (value, index) {
                $listGroup.append(renderListItem(value));
            });
            return $listGroup;
        };

        var renderListItem = function (data) {
            var listItem = MENU_NESTABLE_TEMPLATES.listItem;
            var itemType = array_get(data, 'type', '');

            var title = array_get(data, 'title');
            if (!array_length(title)) {
                title = array_get(data, 'model_title', '');
            }

            listItem = listItem.replace(/__title__/gi, title);
            listItem = listItem.replace(/__type__/gi, itemType);
            var $listItem = $(listItem);

            $listItem.find('[data-field=title] input[type=text]').val(array_get(data, 'title', ''));
            $listItem.find('[data-field=icon_font] input[type=text]').val(array_get(data, 'icon_font', ''));
            $listItem.find('[data-field=css_class] input[type=text]').val(array_get(data, 'css_class', ''));
            $listItem.find('[data-field=target] select').val(array_get(data, 'target', ''));

            if (itemType !== 'custom-link') {
                $listItem.find('[data-field=url]').remove();
                $listItem.data('url', null);
            } else {
                $listItem.find('[data-field=url] input[type=text]').val(array_get(data, 'url', ''));
                $listItem.data('url', array_get(data, 'url', null));
            }

            $listItem.data('id', array_get(data, 'id', ''));
            $listItem.data('related_id', array_get(data, 'related_id', ''));
            $listItem.data('type', array_get(data, 'type', ''));
            $listItem.data('title', array_get(data, 'title', ''));
            $listItem.data('model_title', array_get(data, 'model_title', ''));
            $listItem.data('icon_font', array_get(data, 'icon_font', ''));
            $listItem.data('css_class', array_get(data, 'css_class', ''));
            $listItem.data('target', array_get(data, 'target', ''));

            if (array_get(data, 'children', [])) {
                $listItem.append(renderListGroup(array_get(data, 'children')));
            }
            return $listItem;
        };

        var renderMenu = function () {
            $_TARGET.append(renderListGroup(MENU_DATA));
        };

        var handleAddNew = function () {
            /**
             * Determine when the list group exists
             * If not exists, create new
             */
            if (!array_length($_TARGET.find('> .dd-list'))) {
                $_TARGET.append($(MENU_NESTABLE_TEMPLATES.listGroup));
            }

            /**
             * Handle click button add item
             */
            $body.on('click', '.box-link-menus .add-item', function (event) {
                event.preventDefault();
                var $box = $(this).closest('.box-link-menus');

                switch ($box.data('type')) {
                    case 'custom-link':
                        $_TARGET.find('> .dd-list').append(addCustomLink($box));
                        break;
                    default:
                        $_TARGET.find('> .dd-list').append(addOtherLinks($box));
                        break;
                }
            });

            var addCustomLink = function ($_box) {
                var data = {
                    id: null,
                    related_id: null,
                    type: $_box.data('type'),
                    title: $_box.find('input[type=text][data-field=title]').val(),
                    model_title: null,
                    url: $_box.find('input[type=text][data-field=url]').val(),
                    css_class: $_box.find('input[type=text][data-field=css_class]').val(),
                    icon_font: $_box.find('input[type=text][data-field=icon_font]').val(),
                    target: $_box.find('select[data-field=target]').val(),
                };

                if (!data.title || !data.url) {
                    return;
                }

                $_box.find('input[type=text]').val('');

                return renderListItem(data);
            };

            var addOtherLinks = function ($_box) {
                var globalData = {
                    id: null,
                    type: $_box.data('type'),
                };
                var data = [];
                $_box.find('input[type=checkbox]:checked').each(function () {
                    var $current = $(this);
                    var $label = $current.closest('label');
                    var currentData = $.extend(true, {
                        related_id: $current.val(),
                        title: null,
                        model_title: $label.text().trim(),
                        url: '',
                        css_class: '',
                        icon_font: '',
                    }, globalData);
                    data.push(renderListItem(currentData));
                });

                $_box.find('input[type=checkbox]').prop('checked', false);

                return data;
            }
        };

        var handleRemove = function () {
            /**
             * Remove node
             */
            $body.on('click', '.dd-item .item-details .btn-remove', function (event) {
                event.preventDefault();
                var $parent = $(this).closest('.dd-item');
                var $childs = $parent.find('> .dd-list > .dd-item');
                if (array_length($childs)) {
                    $parent.after($childs);
                }
                DELETED_NODES.push($parent.data('id'));
                $parent.remove();
            });
        };

        /**
         * Render
         */
        renderMenu();
        initNestable();
        handleDetails();
        handleAddNew();
        handleRemove();
    };

    var exportData = function () {
        /**
         * Serialize data from nestable
         */
        var serializeData = function () {
            return $_TARGET.nestable('serialize');
        };

        /**
         * Submit the form
         */
        $body.on('submit', $_TARGET.closest('form'), function (event) {
            //event.preventDefault();
            $_UPDATE_TO.val(json_encode(serializeData()));
            $_DELETED_NODES.val(json_encode(DELETED_NODES));
        });
    };

    return {
        /**
         * Init the module
         */
        init: function () {
            handleItems();
            exportData();
        }
    };
}();

(function ($) {
    $(window).load(function () {
        WebEdManageMenu.init();
    });
})(jQuery);
