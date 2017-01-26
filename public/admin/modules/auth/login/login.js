$(document).ready(function(){
    $('.login-form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",  // validate all fields including form hidden input
        messages: {

        },
        rules: {
            password: {
                minlength: 5,
                required: true
            },
            username: {
                required: true,
                minlength: 5
            }
        },

        highlight: function (element) {
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        unhighlight: function (element) {
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
        }
    });
});