/**
 * Created by tedozimanson on 10/21/16.
 */
var WebEd = WebEd || {};
WebEd.DataTable = function () {
    "use strict";
    var datatable;
    var tableOptions = {
        loadingMessage: 'Loading...'
    };
    var $table,
        $tableContainer,
        $tableWrapper;
    var ajaxParams = {};
    var the;

    var countSelectedRows = function () {
        var selected = $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', $table).size();
        var text = tableOptions.dataTableParams.language.metronicGroupActions;

        if (selected > 0) {
            $('.table-group-actions > span', $tableWrapper).text(text.replace("_TOTAL_", selected));
        } else {
            $('.table-group-actions > span', $tableWrapper).text("");
        }

        return selected;
    };

    var getColumnInputValue = function ($column) {
        // get all typeable inputs
        var value = '';
        $('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', $column).each(function () {
            value = $(this).val();
        });

        // get all checkboxes
        $('input.form-filter[type="checkbox"]:checked', $column).each(function () {
            value = $(this).val();
        });

        // get all radio buttons
        $('input.form-filter[type="radio"]:checked', $column).each(function () {
            value = $(this).val();
        });

        return value;
    };

    return {
        init: function ($table, options) {
            if (!$().DataTable) {
                return null;
            }

            the = this;

            the.initTable($table, options);
            the.otherActions();
        },
        initTable: function (table, options) {
            options = $.extend(true, {
                onSuccess: function (grid, response) {
                    WebEd.initAjax();
                },
                onError: function (grid) {

                },
                onDataLoad: function (grid) {
                    WebEd.initAjax();
                },
                dataTableParams: {
                    dom: "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r><'table-responsive't><'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>", // datatable layout
                    pageLength: 10, // default records per page
                    language: { // language settings
                        // metronic spesific
                        metronicGroupActions: "_TOTAL_ records selected:  ",
                        metronicAjaxRequestGeneralError: "Could not complete request. Please check your internet connection",

                        // data tables spesific
                        lengthMenu: "<span class='seperator'>|</span>View _MENU_ records",
                        info: "<span class='seperator'>|</span>Found total _TOTAL_ records",
                        infoEmpty: "No records found to show",
                        emptyTable: "No data available in table",
                        zeroRecords: "No matching records found",
                        paginate: {
                            previous: "Prev",
                            next: "Next",
                            last: "Last",
                            first: "First",
                            page: "Page",
                            pageOf: "of"
                        }
                    },

                    orderCellsTop: true,
                    columnDefs: [{ // define columns sorting options(by default all columns are sortable extept the first checkbox column)
                        orderable: false,
                        targets: 0
                    }],

                    // save datatable state(pagination, sort, etc) in cookie.
                    bStateSave: true,

                    pagingType: "bootstrap_extended", // pagination type(bootstrap, bootstrap_full_number or bootstrap_extended)
                    autoWidth: false, // disable fixed width and enable fluid table
                    processing: false, // enable/disable display message box on record load
                    serverSide: true, // enable/disable server side ajax loading

                    ajax: { // define ajax settings
                        url: "", // ajax URL
                        type: "POST", // request type
                        timeout: 20000,
                        data: function (data) { // add request parameters before submit
                            $.each(ajaxParams, function (key, value) {
                                data[key] = value;
                            });
                            WebEd.blockUI({
                                message: tableOptions.loadingMessage,
                                target: $tableContainer,
                                overlayColor: 'none',
                                boxed: true
                            });
                        },
                        dataSrc: function (res) { // Manipulate the data returned from the server
                            if (res.customActionMessage) {
                                WebEd.showNotification(res.customActionMessage, res.customActionStatus);
                            }

                            if (res.customActionStatus) {
                                if (tableOptions.resetGroupActionInputOnSuccess) {
                                    $('.table-group-action-input', $tableWrapper).val("");
                                }
                            }

                            if ($('.group-checkable', $table).size() === 1) {
                                $('.group-checkable', $table).attr("checked", false);
                            }

                            if (tableOptions.onSuccess) {
                                tableOptions.onSuccess.call(undefined, the, res);
                            }

                            WebEd.unblockUI($tableContainer);

                            return res.data;
                        },
                        error: function () { // handle general connection errors
                            if (tableOptions.onError) {
                                tableOptions.onError.call(undefined, the);
                            }
                            WebEd.showNotification(tableOptions.dataTableParams.language.metronicAjaxRequestGeneralError, 'danger');

                            WebEd.unblockUI($tableContainer);
                        }
                    },

                    drawCallback: function (settings) {
                        WebEd.initAjax();
                    }
                }
            }, options);

            tableOptions = $.extend(true, tableOptions, options);

            $table = table;

            tableOptions.language = options.language;

            $.fn.dataTableExt.oStdClasses.sWrapper = $.fn.dataTableExt.oStdClasses.sWrapper + " dataTables_extended_wrapper";
            $.fn.dataTableExt.oStdClasses.sFilterInput = "form-control input-xs input-sm input-inline";
            $.fn.dataTableExt.oStdClasses.sLengthSelect = "form-control input-xs input-sm input-inline";

            datatable = $table.DataTable(options.dataTableParams);

            $tableContainer = $table.closest(".table-container");
            $tableWrapper = $table.closest('.dataTables_wrapper');

            $tableContainer.addClass('initialized');

            /**
             * Build table group actions panel
             */
            if ($('.table-actions-wrapper', $tableContainer).size() === 1) {
                $('.table-group-actions', $tableWrapper).html($('.table-actions-wrapper', $tableContainer).html()); // place the panel inside the wrapper
                $('.table-actions-wrapper', $tableContainer).remove(); // remove the template container
            }

            /**
             * Submit filter
             */
            $table.on('click', '.filter-submit', function (e) {
                e.preventDefault();
                the.submitFilter();
            });

            /**
             * Cancel filter
             */
            $table.on('click', '.filter-cancel', function (e) {
                e.preventDefault();
                the.resetFilter();
            });
        },
        otherActions: function () {
            // handle group checkboxes check/uncheck
            $('[type=checkbox][name=group_checkable]', $table).change(function () {
                var set = $table.find('tbody > tr > td:nth-child(1) input[type="checkbox"]');
                var checked = $(this).prop("checked");
                $(set).each(function () {
                    $(this).prop("checked", checked);
                });
                countSelectedRows();
            });

            // handle row's checkbox click
            $table.on('change', 'tbody > tr > td:nth-child(1) input[type="checkbox"]', function () {
                countSelectedRows();
            });
        },
        getDataTableHelper: function () {
            return the;
        },
        getTable: function () {
            return $table;
        },
        getTableContainer: function () {
            return $tableContainer;
        },
        getTableWrapper: function () {
            return $tableWrapper;
        },
        getDataTable: function () {
            return datatable;
        },
        getSelectedRowsCount: function() {
            return $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', $table).size();
        },
        getSelectedRows: function() {
            var rows = [];
            $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', $table).each(function() {
                rows.push($(this).val());
            });

            return rows;
        },
        setAjaxParam: function (name, value) {
            ajaxParams[name] = value;
        },
        addAjaxParam: function (name, value) {
            if (!ajaxParams[name]) {
                ajaxParams[name] = [];
            }

            var skip = false;
            for (var i = 0; i < (ajaxParams[name]).length; i++) { // check for duplicates
                if (ajaxParams[name][i] === value) {
                    skip = true;
                }
            }

            if (skip === false) {
                ajaxParams[name].push(value);
            }
        },
        clearAjaxParams: function () {
            ajaxParams = {};
        },
        submitFilter: function () {
            var $columns = $table.find('thead tr.filter > *');
            var totalColumnsIndex = $columns.length - 1;

            for(var i = 0; i < totalColumnsIndex; i++) {
                var value = getColumnInputValue($($columns[i]));
                datatable.columns(i).search(value);
            }
            datatable.ajax.reload();
        },
        resetFilter: function () {
            $('textarea.form-filter, select.form-filter, input.form-filter', $table).each(function () {
                $(this).val("");
            });
            $('input.form-filter[type="checkbox"]', $table).each(function () {
                $(this).attr("checked", false);
            });
            the.submitFilter();
        }
    }
};
