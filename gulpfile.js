const elixir = require('laravel-elixir');

elixir.config.sourcemaps = true;
elixir.inProduction = true;

const publicPath = 'public/';

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix
    /*Core stylesheets*/
        .sass('./core/base/resources/assets/sass/style.scss', publicPath + 'admin/css')
        .sass('./core/base/resources/assets/sass/admin-bar.scss', publicPath + 'admin/css')

        /*Core scripts*/
        .rollup('./core/base/resources/assets/js/webed-core.js', publicPath + 'admin/js')
        .rollup('./core/base/resources/assets/js/script.js', publicPath + 'admin/js')

        /*Datatables*/
        .rollup('./core/base/resources/assets/js/Components/DataTables/DataTable.js', publicPath + 'admin/modules/datatables/webed.datatable.js')
        .rollup('./core/base/resources/assets/js/Components/DataTables/DataTableAjax.js', publicPath + 'admin/modules/datatables/webed.datatable.ajax.js')

        .copy('./' + publicPath + 'admin/modules/auth', 'core/base/resources/public/admin/modules/auth')
        .copy('./' + publicPath + 'admin/modules/datatables', 'core/base/resources/public/admin/modules/datatables')
        .copy('./' + publicPath + 'admin/css', 'core/base/resources/public/admin/css')
        .copy('./' + publicPath + 'admin/js', 'core/base/resources/public/admin/js')

        /*Menus*/
        .sass('./core/menu/resources/assets/sass/admin/modules/menu/menu-nestable.scss', publicPath + 'admin/modules/menu')
        .rollup('./core/menu/resources/assets/js/admin/modules/menu/edit-menu.js', publicPath + 'admin/modules/menu')
        .copy('./' + publicPath + 'admin/modules/menu', 'core/menu/resources/public/admin/modules/menu')

        /*Custom fields*/
        .sass('./core/custom-fields/resources/assets/sass/admin/modules/custom-fields/edit-field-group.scss', publicPath + 'admin/modules/custom-fields')
        .rollup('./core/custom-fields/resources/assets/js/admin/modules/custom-fields/edit-field-group.js', publicPath + 'admin/modules/custom-fields')
        .rollup('./core/custom-fields/resources/assets/js/admin/modules/custom-fields/import-field-group.js', publicPath + 'admin/modules/custom-fields')
        .rollup('./core/custom-fields/resources/assets/js/admin/modules/custom-fields/use-custom-fields.js', publicPath + 'admin/modules/custom-fields')
        .copy('./' + publicPath + 'admin/modules/custom-fields', 'core/custom-fields/resources/public/admin/modules/custom-fields')
    ;
});
