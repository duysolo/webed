WebEd.showNotification = function ($message, $type) {
    "use strict";
    switch ($type) {
        case 'success': {
            $type = 'lime';
        }
            break;
        case 'info': {
            $type = 'teal';
        }
            break;
        case 'warning': {
            $type = 'tangerine';
        }
            break;
        case 'danger': {
            $type = 'ruby';
        }
            break;
        case 'error': {
            $type = 'ruby';
        }
            break;
        default: {
            $type = 'ebony';
        }
            break;
    }
    $.notific8('zindex', 11500);

    var settings = {
        theme: $type,
        sticky: false,
        horizontalEdge: 'bottom',
        verticalEdge: 'right'
    };

    if ($message instanceof Array) {
        $message.forEach(function (value) {
            $.notific8($.trim(value), settings);
        });
    }
    else {
        $.notific8($.trim($message), settings);
    }
};
