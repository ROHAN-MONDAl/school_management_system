// Login toggle switch
$(document).ready(function () {
    // jQuery methods go here...
    $(".nav-link").click(function () {
        $(".nav-link").removeClass("active");
        $('.tab-pane').removeClass('active');

        $(this).addClass("active");

        // Show the corresponding content
        $($(this).data('target')).addClass('active');
    });
});


// form student validation
$("#student_form").validate({
    rules: {
        sPhone: {
            phoneUS: true,
            minlength: 10,
        },
        sPassword: {
            required: true,
            minlength: 8,
        }
    },
    messages: {
        sPhone: {
            required: "Please enter your 10 digit number",
        },
        sPassword: {
            required: "Please enter your your password",
        },
    },
});

// Form Admin validation
$("#admin_form").validate({
    rules: {
        adminusername: {
            required: true,
            minlength: 8
        },
        adminPassword: {
            required: true,
            minlength: 8,
        },
    },
    messages: {
        adminUsername: {
            required: "Please enter your username",
            minlength: jQuery.validator.format("At least 8 characters required!"),
        },
        adminPassword: {
            required: "Please enter your password",
        },
    },
});


// Department form validation
$("#departmentform").validate({
    rules: {
        departmentEmail: {
            required: true,
            email: true
        },
        adminPassword: {
            required: true,
            minlength: 8,
        },
    },
    messages: {
        departmentEmail: {
            required: "Please enter your email",
            email: "Your email address must be in the format of name@domain.com"
        },
        departmentPassword: {
            required: "Please enter your password",
        },
    },
});