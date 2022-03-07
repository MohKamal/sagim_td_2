// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict'

    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation')

        // Loop over them and prevent submission
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    }, false)
})()


$(document).ready(function() {
    payementChange();

    $('#save-info').on('change', function() {
        if (this.checked) {
            $('#username').prop('required', true);
            $('#email').prop('required', true);
            $('#username-label').html(`Username`);
            $('#email-label').html(`Email`);
        } else {
            $('#username').prop('required', false);
            $('#email').prop('required', false);
            $('#username-label').html(`Username <span class="text-muted">(Optional)</span>`);
            $('#email-label').html(`Email <span class="text-muted">(Optional)</span>`);
        }
    });

    $('#credit').on('change', function() {
        payementChange();
    });

    $('#cash').on('change', function() {
        payementChange();
    });

    $('#paypal').on('change', function() {
        payementChange();
    });
});

function payementChange() {
    const credit = $('#credit').is(":checked");
    const cash = $('#cash').is(":checked");
    const paypal = $('#paypal').is(":checked");
    if (credit) {
        $('.credit-form').show();
        $('#cc-name').prop('required', true);
        $('#cc-number').prop('required', true);
        $('#cc-expiration').prop('required', true);
        $('#cc-cvv').prop('required', true);
    } else {
        $('.credit-form').hide();
        $('#cc-name').prop('required', false);
        $('#cc-number').prop('required', false);
        $('#cc-expiration').prop('required', false);
        $('#cc-cvv').prop('required', false);
    }

    if (paypal) {
        $('.paypal-form').show();
    } else {
        $('.paypal-form').hide();
    }
}