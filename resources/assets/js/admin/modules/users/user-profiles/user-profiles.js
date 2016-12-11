$(document).ready(function () {
    "use strict";
    $('.js-date-picker').datepicker({
        orientation: "left",
        autoclose: true
    });
    var $rules = {
        username: {
            minlength: 3,
            maxlength: 100,
            required: true
        },
        email: {
            minlength: 5,
            maxlength: 255,
            required: true,
            email: true
        },
        display_name: {
            minlength: 1,
            maxlength: 150
        },
        first_name: {
            minlength: 1,
            maxlength: 100,
            required: true
        },
        last_name: {
            minlength: 1,
            maxlength: 100
        },
        phone: {
            maxlength: 20
        },
        mobile_phone: {
            maxlength: 20
        },
        description: {
            maxlength: 1000
        }
    };
    $('.js-validate-form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        errorPlacement: function (error, element) {
            if (element.closest('.input-group').length > 0) {
                error.insertAfter(element.closest('.input-group'));
            }
            else {
                element.closest('.form-group').append(error);
            }
        },
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",  // validate all fields including form hidden input
        messages: {},
        rules: $rules,

        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label.closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
        }
    });
    $('.js-validate-form-change-password').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        errorPlacement: function (error, element) {
            if (element.closest('.input-group').length > 0) {
                error.insertAfter(element.closest('.input-group'));
            }
        },
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",  // validate all fields including form hidden input
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            }
        },

        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label.closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
        }
    });
});
