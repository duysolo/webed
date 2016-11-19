WebEd.settings = function () {
    "use strict";
    var assetsPath = BASE_URL + 'admin/';

    var globalImgPath = assetsPath + 'images/global/';

    var globalPluginsPath = BASE_URL + 'admin/plugins/';

    return {
        adminTheme: {
            getAssetPath: function () {
                return assetsPath;
            },
            getGlobalImagePath: function () {
                return globalImgPath;
            },
            getPluginsPath: function () {
                return globalPluginsPath;
            },
        }
    }
}();
