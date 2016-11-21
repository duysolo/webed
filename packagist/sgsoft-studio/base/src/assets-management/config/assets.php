<?php
/**
 * @author sangnm <sang.nguyenminh@elinext.com>
 * @since 22/07/2015 11:25 PM
 * @modified Tedozi Manson <duyphan.developer@gmail.com> <github.com/duyphan2502>
 */
return [
    /**
     * If true, we will get resources from cdn first
     * If false, we will always get resources from local
     */
    'always_use_local' => true,
    /**
     * These assets will be loaded automatically
     */
    'default' => [
        /**
         * For admin dashboard
         */
        'admin' => [
            'js' => [
                'underscore',
                'jquery',
                'bootstrap',
                'fastclick',
                'jquery-cookie',
                'jquery-sortable',
                'modernizr',
                'bootstrap-hover-dropdown',
                'jquery-slimscroll',
                'jquery-blockui',
                'jquery-notific8',
                'bootstrap-confirmation',
                'jquery-validate',
                'bootstrap-tagsinput',
            ],
            'css' => [
                'bootstrap',
                'jquery-notific8',
                'bootstrap-tagsinput',
            ],
            'fonts' => [
                'open-sans',
                'font-awesome',
                'simple-line-icons',
            ],
        ],
        /**
         * For front site
         */
        'front' => [
            'js' => [
                'jquery',
            ],
            'css' => [
                'bootstrap',
            ],
            'fonts' => [

            ],
        ],
    ],
    'resources' => [
        'js' => [
            /**
             * Jquery extensions
             */
            'jquery' => [
                'use_cdn' => true,
                'location' => 'top',
                'src' => [
                    'local' => asset('admin/plugins/jquery.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js',
                ],
            ],
            'jquery-cookie' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/js.cookie.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js',
                ],
            ],
            'jquery-slimscroll' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/jquery-slimscroll/jquery.slimscroll.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js',
                ],
            ],
            'jquery-blockui' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/jquery.blockui.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js',
                ],
            ],
            'jquery-validate' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => [
                        asset('admin/plugins/jquery-validate/js/jquery.validate.min.js'),
                        asset('admin/plugins/jquery-validate/js/additional-methods.min.js'),
                    ],
                    'cdn' => [
                        '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js',
                        '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/additional-methods.min.js',
                    ],
                ],
            ],
            'jquery-datatables' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => [
                        asset('admin/plugins/datatables/datatables.min.js'),
                        asset('admin/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
                        asset('admin/modules/datatables/webed.datatable.js'),
                        asset('admin/modules/datatables/webed.datatable.ajax.js'),
                    ],
                    'cdn' => [
                        '//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js',
                        '//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js',
                        asset('admin/modules/datatables/webed.datatable.js'),
                        asset('admin/modules/datatables/webed.datatable.ajax.js'),
                    ]
                ],
            ],
            'jquery-sortable' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => [
                        asset('admin/plugins/sortable/sortable.min.js'),
                        asset('admin/plugins/sortable/jquery.binding.js'),
                    ],
                    'cdn' => [
                        '//cdnjs.cloudflare.com/ajax/libs/Sortable/1.4.2/Sortable.min.js',
                        asset('admin/plugins/sortable/jquery.binding.js'),
                    ],
                ],
            ],
            'jquery-nestable' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/jquery-nestable/jquery.nestable.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.js',
                ],
            ],
            'jquery-select2' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/select2/js/select2.full.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js',
                ],
            ],
            'jquery-ui' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => [
                        asset('admin/plugins/jquery-ui/jquery-ui.min.js'),
                        asset('admin/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js'),
                    ],
                    'cdn' => [
                        '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js',
                        '//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js',
                    ],
                ],
            ],
            'jquery-easing' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/jquery.easing.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js',
                ],
            ],
            'jquery-notific8' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/jquery-notific8/jquery.notific8.min.js'),
                    'cdn' => null,
                ],
            ],
            'jquery-ckeditor' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => [
                        asset('admin/plugins/ckeditor/ckeditor.js'),
                        asset('admin/plugins/ckeditor/config.js'),
                        asset('admin/plugins/ckeditor/adapters/jquery.js'),
                    ],
                    'cdn' => null,
                ],
            ],
            'fastclick' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => [
                        asset('admin/plugins/fastclick/fastclick.min.js'),
                    ],
                    'cdn' => null,
                ],
            ],
            /**
             * Bootstrap extensions
             */
            'bootstrap' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/bootstrap/js/bootstrap.min.js'),
                    'cdn' => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
                ],
            ],
            'bootstrap-switch' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js',
                ],
            ],
            'bootstrap-confirmation' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js',
                ],
            ],
            'bootstrap-datepicker' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js',
                ],
            ],
            'bootstrap-datetimepicker' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js',
                ],
            ],
            'bootstrap-markdown' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-markdown/js/bootstrap-markdown.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js',
                ],
            ],
            'bootstrap-tagsinput' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js',
                ],
            ],
            'bootstrap-modal' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => [
                        asset('admin/plugins/bootstrap-modal/js/bootstrap-modalmanager.js'),
                        asset('admin/plugins/bootstrap-modal/js/bootstrap-modal.js'),
                    ],
                    'cdn' => [
                        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js',
                        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js',
                    ],
                ],
            ],
            'bootstrap-pwstrength' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js'),
                    'cdn' => null,
                ],
            ],
            'bootstrap-hover-dropdown' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.2.1/bootstrap-hover-dropdown.min.js',
                ],
            ],
            /**
             * Other javascript extensions
             */
            'respond' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/respond.min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js',
                ],
            ],
            'excanvas' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/excanvas.min.js'),
                    'cdn' => null,
                ],
            ],
            'modernizr' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/modernizr.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
                ],
            ],
            'underscore' => [
                'use_cdn' => true,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/underscore/underscore-min.js'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js'
                ]
            ]
        ],
        'css' => [
            /**
             * Jquery extensions
             */
            'jquery-nestable' => [
                'use_cdn' => false,
                'src' => [
                    'local' => asset('admin/plugins/jquery-nestable/jquery.nestable.css'),
                    'cdn' => null,
                ],
            ],
            'jquery-select2' => [
                'use_cdn' => true,
                'src' => [
                    'local' => [
                        asset('admin/plugins/select2/css/select2.min.css'),
                        asset('admin/plugins/select2/css/select2-bootstrap.min.css'),
                    ],
                    'cdn' => [
                        '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css',
                        '//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css',
                    ],
                ],
            ],
            'jquery-ui' => [
                'use_cdn' => true,
                'src' => [
                    'local' => 'admin/plugins/jquery-ui/jquery-ui.min.css',
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css',
                ],
            ],
            'jquery-notific8' => [
                'use_cdn' => false,
                'location' => 'bottom',
                'src' => [
                    'local' => asset('admin/plugins/jquery-notific8/jquery.notific8.min.css'),
                    'cdn' => null,
                ],
            ],
            /**
             * Bootstrap extensions
             */
            'bootstrap' => [
                'use_cdn' => true,
                'src' => [
                    'local' => asset('admin/plugins/bootstrap/css/bootstrap.min.css'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css',
                ],
            ],
            'bootstrap-switch' => [
                'use_cdn' => true,
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-switch/css/bootstrap-switch.min.css'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css',
                ],
            ],
            'bootstrap-datepicker' => [
                'use_cdn' => true,
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.min.css',
                ],
            ],
            'bootstrap-datetimepicker' => [
                'use_cdn' => true,
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css',
                ],
            ],
            'bootstrap-markdown' => [
                'use_cdn' => true,
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-markdown/2.10.0/css/bootstrap-markdown.min.css',
                ],
            ],
            'bootstrap-tagsinput' => [
                'use_cdn' => true,
                'src' => [
                    'local' => asset('admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'),
                    'cdn' => '//cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css',
                ],
            ],
            'bootstrap-modal' => [
                'use_cdn' => true,
                'src' => [
                    'local' => [
                        asset('admin/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'),
                        asset('admin/plugins/bootstrap-modal/css/bootstrap-modal.css'),
                    ],
                    'cdn' => [
                        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal-bs3patch.min.css',
                        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal.min.css',
                    ],
                ],
            ],
            /**
             * Other extensions
             */
        ],
        'fonts' => [
            'open-sans' => [
                'use_cdn' => true,
                'src' => [
                    'local' => '//fonts.googleapis.com/css?family=Open+Sans:400,300,700&subset=latin,vietnamese',
                    'cdn' => '//fonts.googleapis.com/css?family=Open+Sans:400,300,700&subset=latin,vietnamese',
                ],
            ],
            'font-awesome' => [
                'use_cdn' => true,
                'src' => [
                    'local' => asset('admin/plugins/font-awesome/css/font-awesome.min.css'),
                    'cdn' => '//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css',
                ],
            ],
            'simple-line-icons' => [
                'use_cdn' => false,
                'src' => [
                    'local' => asset('admin/plugins/simple-line-icons/simple-line-icons.min.css'),
                    'cdn' => null,
                ],
            ],
        ],
    ],
];
