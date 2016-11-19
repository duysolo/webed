/**
 * Works same as array_get function of Laravel
 * @param array
 * @param key
 * @param defaultValue
 * @returns {*}
 */
var array_get = function (array, key, defaultValue) {
    "use strict";

    if (typeof defaultValue === 'undefined') {
        defaultValue = null;
    }

    var result;

    try {
        result = array[key];
    } catch (err) {
        result = defaultValue;
    }

    if(result === null) {
        result = defaultValue;
    }

    return result;
};

/**
 * Get the array/object length
 * @param array
 * @returns {number}
 */
var array_length = function (array) {
    "use strict";

    return _.size(array);
};

/**
 * Get the first element.
 * Passing n will return the first n elements of the array.
 * @param array
 * @param n
 * @returns {*}
 */
var array_first = function (array, n) {
    "use strict";

    return _.first(array, n);
};

/**
 * Get the first element.
 * Passing n will return the last n elements of the array.
 * @param array
 * @param n
 * @returns {*}
 */
var array_last = function (array, n) {
    "use strict";

    return _.last(array, n);
};

