var WebEd = WebEd || {};

WebEd.ecommerce = function () {

    function handlePrice() {
        /**
         * Change sale type
         */
        $('body').on('change', '#tab_price table .mt-radio input[type=radio]', function (event) {
            var $group = $(this).closest('.mt-radio-list');
            var value = $group.find('input[type=radio]:checked').val();
            if(value == 'always') {
                $group.find('~ .datetime-range').addClass('hidden');
            } else {
                $group.find('~ .datetime-range').removeClass('hidden');
            }
        });
        $('#tab_price table .mt-radio input[type=radio]').trigger('change');

        /**
         * Init the datetime picker
         */
        $(".form-date-time").datetimepicker({
            autoclose: false,
            format: "yyyy-mm-dd hh:ii:ss",
            pickerPosition: "bottom-right",
            todayBtn: true,
            todayHighlight: true,
            minuteStep: 1
        });
    }

    return {
        init: function () {
            handlePrice();
        }
    }
}();

$(document).ready(function () {
    WebEd.ecommerce.init();
});
