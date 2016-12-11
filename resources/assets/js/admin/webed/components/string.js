WebEd.stringToSlug = function (text, separator) {
    "use strict";
    separator = separator || '-';
    return text.toString()
        /*To lower case*/
        .toLowerCase()
        /*Vietnamese string*/
        .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
        .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
        .replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
        .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
        .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
        .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
        .replace(/đ/gi, 'd')
        /*Replace spaces with -*/
        .replace(/\s+/g, separator)
        /*Remove all non-word chars*/
        .replace(/[^\w\-]+/g, '')
        /*Replace multiple - with single -*/
        .replace(/\-\-+/g, separator)
        /*Trim - from start of text*/
        .replace(/^-+/, '')
        /*Trim - from end of text*/
        .replace(/-+$/, '');
};
