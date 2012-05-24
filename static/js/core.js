$(document).ready(function() {
    var options = {
        success: function(response) {
            $.each(response.errors,function(index,value){
                $('.alert-error').show().prepend('<p>'+value+'</p>');
            });
            $('#myModal').modal('toggle');
            if(jQuery.isEmptyObject(response.errors)){
                location.reload();
            }else{
                Recaptcha.reload();
            }
            $('#submitForm').removeClass('disabled').removeAttr('disabled');
        },
        beforeSubmit: function() {
            $('.alert-error').hide().html('');
            $('#submitForm').addClass('disabled').attr('disabled', 'disabled');
            $('#myModal').modal('toggle');
            return true;
        },
        dataType: 'json'
    };

    $('#myModal').modal({keyboard: false,show:false,backdrop:'static'});
    $('form').ajaxForm(options);

    $('#login-button').click(function() {
        _gaq.push(['_trackEvent', 'Link', 'Click', 'Login']);
        return true;
    });

    $('#submitForm').click(function() {
        _gaq.push(['_trackEvent', 'Link', 'Click', 'Submit form']);
        return true;
    });
});