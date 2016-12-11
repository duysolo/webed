var WebEd = WebEd || {};

WebEd.DataTableAjax = function ($) {
    "use strict";
    var the;
    var initEachItem = function ($table, options) {
        options = $.extend(true, {
            ajaxActionsSuccess: function ($btn, data) {

            }
        }, options);

        var dataTableHelper = new WebEd.DataTable();

        dataTableHelper.init($table, options);

        dataTableHelper.getTableWrapper().on('confirmed.bs.confirmation', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", dataTableHelper.getTableWrapper());
            if (action.val() != "" && dataTableHelper.getSelectedRowsCount() > 0) {
                dataTableHelper.setAjaxParam("customActionType", "group_action");
                dataTableHelper.setAjaxParam("customActionValue", action.val());
                dataTableHelper.setAjaxParam("id", dataTableHelper.getSelectedRows());
                dataTableHelper.getDataTable().ajax.reload();
                dataTableHelper.clearAjaxParams();
                dataTableHelper.getTableWrapper().find('input[name=group_checkable]').prop('checked', false);
                setTimeout(function () {
                    dataTableHelper.getDataTable().ajax.reload();
                }, 0);
            } else if (action.val() == "") {
                WebEd.showNotification('Please select an action', 'danger');
            } else if (dataTableHelper.getSelectedRowsCount() === 0) {
                WebEd.showNotification('No record selected', 'warning');
            }
        });

        /**
         * Handle ajax link
         */
        dataTableHelper.getTableWrapper().on('confirmed.bs.confirmation', '.ajax-link', function (e) {
            e.preventDefault();
            var $current = $(this);
            $.ajax({
                url: $current.attr('data-ajax'),
                type: $current.attr('data-method') || 'POST',
                dataType: 'json',
                beforeSend: function () {
                    WebEd.blockUI({
                        target: dataTableHelper.getTableWrapper()
                    });
                },
                success: function (data) {
                    if(options.ajaxActionsSuccess) {
                        options.ajaxActionsSuccess.call(undefined, $current, data);
                    }
                },
                complete: function (data) {
                    dataTableHelper.getTableWrapper().find('.blockUI').remove();
                    if (typeof data.responseJSON !== 'undefined') {
                        if (data.responseJSON.error) {
                            WebEd.showNotification(data.responseJSON.messages, 'danger');
                        }
                        else {
                            WebEd.showNotification(data.responseJSON.messages, 'success');
                        }
                    }
                    else {
                        WebEd.showNotification('Some error occurred. View console log for more information', 'danger');
                    }
                    dataTableHelper.getDataTable().ajax.reload();
                }
            });
        });

        /**
         * When user press enter on filter's inputs, call filter
         */
        dataTableHelper.getTableWrapper().on('keyup', '.filter input', function (event) {
            if (event.which == 13) {
                dataTableHelper.getDataTableHelper().submitFilter();
            }
        });
    };

    return {
        init: function ($table, options) {
            the = this;
            $table.each(function () {
                var $current = $(this);
                if(!$current.closest('.table-container').hasClass('initialized')) {
                    initEachItem($current, options);
                }
            });
        }
    }
}(jQuery);
