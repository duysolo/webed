var TableDatatablesAjax = function () {

    var handleRecords = function (options) {

        var grid = new MyDataTable();

        grid.init({
            src: options.src || $("#datatable_ajax"),
            onSuccess: function(grid, response){
                App.initAjax();
                options.onSuccess(grid, response);
            },
            onError: function (grid) {
                options.onError(grid);
            },
            onDataLoad: function(grid) {
                App.initAjax();
                options.onDataLoad(grid);
            },
            loadingMessage: options.loadingMessage || 'Loading...',
            dataTableParams: {
                "bStateSave": options.saveOnCookie || true, // save datatable state(pagination, sort, etc) in cookie.

                "lengthMenu": options.defaultLengthMenu || [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": options.defaultPageLength || 10, // default record count per page
                "ajax": {
                    "url": options.ajaxGet || null
                },
                "order": [
                    [1, "asc"]
                ]
            }
        });

        grid.getTableWrapper().on('confirmed.bs.confirmation', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0)
            {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionValue", action.val());
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().api().ajax.reload();
                grid.clearAjaxParams();
            }
            else if (action.val() == "")
            {
                WebEd.showNotification('Please select an action', 'danger');
            }
            else if (grid.getSelectedRowsCount() === 0)
            {
                WebEd.showNotification('No record selected', 'warning');
            }
        });

        /*Quick edit data*/
        var nEditing = null;
        var nNew = false;
        var oTable = grid.getDataTable();

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }
            //oTable.api().ajax.reload();
        }

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('> td', nRow);
            if(aData == null) return;
            $.each(options.editableFields, function(index, val) {
                var spanIndex = 0;
                if(aData[val].toString().indexOf('</span>') != -1)
                {
                    spanIndex = aData[val].toString().indexOf('</span>') + 7;
                }
                jqTds[val].innerHTML = '<input type="text" class="form-control" value="' + aData[val].toString().substr(spanIndex) + '">';
            });
            jqTds[options.actionPosition].innerHTML = '<a class="quick-edit btn" title="Quick edit">Save</a><a class="cancel btn">Cancel</a>';
        }

        function saveRow(oTable, nRow) {
            var jqTds = $('> td', nRow);
            var jqInputs = $('input', nRow);
            var dataPost = {};
            $.each(jqInputs, function(index, val) {
                var currentValue = jqInputs[index].value || '';
                eval('dataPost.args_' + index + ' = "' + currentValue + '"');
            });
            $.each(options.editableFields, function(index, val) {
                oTable.fnUpdate($(jqTds[val]).find('input').val(), nRow, val, false);
            });

            oTable.fnUpdate('<a class="edit">Quick edit</a>', nRow, options.actionPosition, false);

            $.ajax({
                url: options.ajaxUrlSaveRow,
                type: 'POST',
                dataType: 'json',
                data: dataPost,
                beforeSend: function(){
                    App.blockUI({
                        message: options.loadingMessage || 'Loading...',
                        target: grid.getTableWrapper(),
                        overlayColor: 'none',
                        cenrerY: true,
                        boxed: true
                    });
                },
                complete: function(data) {
                    grid.getTableWrapper().find('.blockUI').remove();
                    if(typeof data.responseJSON != 'undefined')
                    {
                        if(data.responseJSON.error)
                        {
                            WebEd.showNotification(data.responseJSON.messages, 'danger');
                        }
                        else
                        {
                            WebEd.showNotification(data.responseJSON.messages, 'success');
                        }

                    }
                    else
                    {
                        WebEd.showNotification('Some error occurred!', 'danger');
                    }
                    oTable.api().ajax.reload();
                }
            });
        }

        /*function cancelEditRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            $.each(jqInputs, function(index, val) {
                if(index > 0) oTable.fnUpdate(jqInputs[index].value, nRow, options.editableFields[index], false);
            });
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 4, false);
            oTable.fnDraw();
        }*/

        grid.getTableWrapper().on('click', '.quick-edit', function(e){
            e.preventDefault();
            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == "Save") {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });

        grid.getTableWrapper().on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        grid.getTableWrapper().on('confirmed.bs.confirmation', '.ajax-link', function (e) {
            e.preventDefault();
            var $current = $(this);
            $.ajax({
                url: $current.attr('data-ajax'),
                type: $current.attr('data-method') || 'POST',
                dataType: 'json',
                beforeSend: function(){
                    App.blockUI({
                        message: 'Loading...',
                        target: grid.getTableWrapper(),
                        overlayColor: 'none',
                        cenrerY: true,
                        boxed: true
                    });
                },
                complete: function(data) {
                    grid.getTableWrapper().find('.blockUI').remove();
                    if(typeof data.responseJSON != 'undefined')
                    {
                        if(data.responseJSON.error)
                        {
                            WebEd.showNotification(data.responseJSON.messages, 'danger');
                        }
                        else
                        {
                            WebEd.showNotification(data.responseJSON.messages, 'success');
                        }

                    }
                    else
                    {
                        WebEd.showNotification('Some error occurred!', 'danger');
                    }
                    oTable.api().ajax.reload();
                }
            });
        });

        grid.getTableWrapper().on('keyup', '.filter input', function(event){
            if(event.which == 13) {
                grid.getTableWrapper().find('.filter .filter-submit').trigger('click');
            }
        });
    };

    return {
        init: function (options) {
            handleRecords(options);
        }
    };
}();
