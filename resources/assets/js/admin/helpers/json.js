/**
 * Json encode
 * @param object
 */
var json_encode = function (object) {
    "use strict";
    if (typeof object === 'undefined') {
        object = null;
    }
    return JSON.stringify(object);
};

/**
 * Json decode
 * @param jsonString
 * @param defaultValue
 * @returns {*}
 */
var json_decode = function (jsonString, defaultValue) {
    "use strict";
    if (typeof jsonString === 'string') {
        var result;
        try {
            result = $.parseJSON(jsonString);
        } catch (err) {
            result = defaultValue;
        }
        return result;
    }
    return jsonString;
};
