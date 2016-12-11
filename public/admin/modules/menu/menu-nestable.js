// Init
var MenuNestable = function () {
    /*Functions*/
    function set_data_items(target)
    {
        target.each(function(index, el) {
            var current = $(this);
            current.data('id', current.attr('data-id'));
            current.data('title', current.attr('data-title'));
            current.data('relatedid', current.attr('data-relatedid'));
            current.data('type', current.attr('data-type'));
            current.data('customurl', current.attr('data-customurl'));
            current.data('class', current.attr('data-class'));
        });
    }
    function create_serialize_obj(target)
    {
        return target.nestable('serialize');
    }
    function update_position_for_serialized_obj(arr_obj)
    {
        var result = arr_obj;
        $.each(result, function(index, val) {
            val.position = index;
            if(typeof val.children == 'undefined')
            {
                val.children = [];
            }
            update_position_for_serialized_obj(val.children);
        });
        return result;
    }
    /*Functions*/

    $body = $('body');

    return {
        //main function to initiate the module
        init: function ()
        {
            var depth = parseInt($('#nestable').attr('data-depth'));
            if(depth < 1) depth = 5;
            $('.nestable-menu').nestable({
                group: 1,
                maxDepth: depth,
                expandBtnHTML   : '',
                collapseBtnHTML : ''
            });
        },
        handleNestableMenu: function()
        {
            //Show node details
            $body.on('click', '.dd-item .dd3-content a.show-item-details', function(event){
                event.preventDefault();
                var parent = $(this).parent().parent();
                $(this).toggleClass('active');
                parent.toggleClass('active');
            });

            // Edit attr
            $body.on('change blur keyup', '.nestable-menu .item-details input[type="text"]', function(event) {
                event.preventDefault();
                var current = $(this);
                var parent = current.closest('li.dd-item');
                parent.attr('data-' + current.attr('name'), current.val());
                parent.data(current.attr('name'), current.val());
                parent.find('> .dd3-content .text[data-update="' + current.attr('name') + '"]').text(current.val());
                if(current.val().trim() == '')
                {
                    parent.find('> .dd3-content .text[data-update="' + current.attr('name') + '"]').text(current.attr('data-old'));
                }
                set_data_items($('#nestable > ol.dd-list li.dd-item'));
                //create_serialize_obj($('#nestable'));
            });

            // Add nodes
            $body.on('click', '.box-links-for-menu .btn-add-to-menu', function(event) {
                event.preventDefault();
                var current = $(this);
                var parent = current.parents('.the-box');
                var html_src = '';

                var icon_font_src = '<label class="pad-bot-5 dis-inline-block"><span class="text pad-top-5" data-update="iconfont">Icon - font</span><input type="text" name="iconfont" value="" data-old=""></label>';
                if(parent.attr('id') == 'external_link')
                {
                    var data_type = 'custom-link';
                    var data_related_id = 0;
                    var data_title = $('#node-title').val();
                    var data_url = $('#node-url').val();
                    var data_css_class = $('#node-css').val();
                    var url_html = '<label class="pad-bot-5"><span class="text pad-top-5 dis-inline-block" data-update="customurl">Url</span><input type="text" data-old="' + data_url + '" value="' + data_url + '" name="customurl"></label>';
                    html_src += '<li data-type="'+data_type+'" data-relatedid="'+data_related_id+'" data-title="'+data_title+'" data-class="'+data_css_class+'" data-id="0" data-customurl="'+data_url+'" data-iconfont="" class="dd-item dd3-item">';
                    html_src += '<div class="dd-handle dd3-handle"></div>';
                    html_src += '<div class="dd3-content">';
                    html_src += '<span class="text pull-left" data-update="title">'+data_title+'</span>';
                    html_src += '<span class="text pull-right">'+data_type+'</span>';
                    html_src += '<a href="#" title="" class="show-item-details"><i class="fa fa-angle-down"></i></a>';
                    html_src += '<div class="clearfix"></div>';
                    html_src += '</div>';
                    html_src += '<div class="item-details">';
                    html_src += '<label class="pad-bot-5">';
                    html_src += '<span class="text pad-top-5 dis-inline-block" data-update="title">Title</span>';
                    html_src += '<input type="text" data-old="'+data_title+'" value="'+data_title+'" name="title">';
                    html_src += '</label>';
                    html_src += url_html + icon_font_src;
                    html_src += '<label class="pad-bot-10">';
                    html_src += '<span class="text pad-top-5 dis-inline-block" data-update="class">CSS class</span>';
                    html_src += '<input type="text" data-old="'+data_css_class+'" value="'+data_css_class+'" name="class">';
                    html_src += '</label>';
                    html_src += '<div class="text-right">';
                    html_src += '<a class="btn red btn-remove" title="" href="#">Remove</a>';
                    html_src += '<a class="btn blue btn-cancel" title="" href="#">Cancel</a>';
                    html_src += '</div>';
                    html_src += '</div>';
                    html_src += '<div class="clearfix"></div>';
                    html_src += '</li>';
                    parent.find('input[type="text"]').val('');
                }
                else
                {
                    parent.find('.list-item > li.active').each(function(index, el) {
                        var find_in = $(this).find('> a');
                        var data_type = find_in.attr('data-type');
                        var data_related_id = find_in.attr('data-relatedid');
                        var data_title = find_in.attr('data-title');

                        var url_html = '<label class="pad-bot-5"><span class="text pad-top-5 dis-inline-block" data-update="customurl">Url</span><input type="text" data-old="" value="" name="customurl"></label>';

                        html_src += '<li data-type="'+data_type+'" data-relatedid="'+data_related_id+'" data-title="" data-class="" data-id="0" data-customurl="" data-iconfont="" class="dd-item dd3-item">';
                        html_src += '<div class="dd-handle dd3-handle"></div>';
                        html_src += '<div class="dd3-content">';
                        html_src += '<span class="text pull-left" data-update="title">'+data_title+'</span>';
                        html_src += '<span class="text pull-right">'+data_type+'</span>';
                        html_src += '<a href="#" title="" class="show-item-details"><i class="fa fa-angle-down"></i></a>';
                        html_src += '<div class="clearfix"></div>';
                        html_src += '</div>';
                        html_src += '<div class="item-details">';
                        html_src += '<label class="pad-bot-5">';
                        html_src += '<span class="text pad-top-5 dis-inline-block" data-update="title">Title</span>';
                        html_src += '<input type="text" data-old="'+data_title+'" value="" name="title">';
                        html_src += '</label>' + icon_font_src;
                        html_src += '<label class="pad-bot-10">';
                        html_src += '<span class="text pad-top-5 dis-inline-block" data-update="class">CSS class</span>';
                        html_src += '<input type="text" data-old="" value="" name="class">';
                        html_src += '</label>';
                        html_src += '<div class="text-right">';
                        html_src += '<a class="btn red btn-remove" title="" href="#">Remove</a>';
                        html_src += '<a class="btn blue btn-cancel" title="" href="#">Cancel</a>';
                        html_src += '</div>';
                        html_src += '</div>';
                        html_src += '<div class="clearfix"></div>';
                        html_src += '</li>';
                    });
                }
                // Create html
                $('.nestable-menu > ol.dd-list').append(html_src);

                // Change json
                set_data_items($('#nestable > ol.dd-list li.dd-item'));
                //create_serialize_obj($('#nestable'));
                parent.find('.list-item > li.active').removeClass('active');
            });

            // Remove nodes
            $('.form-save-menu input[name="deleted_nodes"]').val('');
            $body.on('click', '.nestable-menu .item-details .btn-remove', function(event) {
                event.preventDefault();
                var current = $(this);
                var dd_item = current.parents('.item-details').parent();

                $elm = $('.form-save-menu input[name="deleted_nodes"]');
                //add id of deleted nodes to delete in controller
                $elm.val($elm.val() + ' ' + dd_item.attr('data-id'));
                var children = dd_item.find('> .dd-list').html();
                if(children != '' && children != null)
                {
                    dd_item.before(children);
                }
                dd_item.remove();
            });

            // Cancel edit
            $body.on('click', '.nestable-menu .item-details .btn-cancel', function(event) {
                event.preventDefault();
                var current_pa = $(this);
                var parent = current_pa.parents('.item-details').parent();
                parent.find('input[type="text"]').each(function(index, el) {
                    var current = $(this);
                    current.val(current.attr('data-old'));
                });
                parent.find('input[type="text"]').trigger('change');
                parent.removeClass('active');
            });

            /**
             *
             * Add page / links to menu
             *
             **/
            $body.on('click', '.box-links-for-menu .list-item > li > a', function(event) {
                event.preventDefault();
                var parent = $(this).parent();
                parent.toggleClass('active');
            });

            // Submit
            $body.on('submit', '.form-save-menu', function(event){
                var $nestableMenu = $('#nestable');
                if($nestableMenu.length < 1) {
                    $('#nestable-output').val('[]');
                } else {
                    var nestable_obj_returned = create_serialize_obj($nestableMenu);
                    var the_obj = update_position_for_serialized_obj(nestable_obj_returned);
                    $('#nestable-output').val(JSON.stringify(the_obj));
                }
            });
        }
    };
}();