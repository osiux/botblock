$(document).ready(function() {
    /*var options = {
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
    $('form').ajaxForm(options);*/

    $('#login-button').click(function() {
        _gaq.push(['_trackEvent', 'Link', 'Click', 'Login']);
        return true;
    });

    $('#submitForm').click(function() {
        _gaq.push(['_trackEvent', 'Link', 'Click', 'Submit form']);
        /*$(this).addClass('disabled').attr('disabled', 'disabled');*/

        $.ajax({
            dataType: 'json',
            url: $('form').attr('action'),
            data: $('form').serialize(),
            cache: false,
            type: 'POST',
            success: function(data) {
                if ($.isEmptyObject(data.errors)) {
                    $('.alert-error').hide();
                    var _length = data.userlist.length;
                    $('form, .row').remove();
                    var _hu = $('.hero-unit');
                    $('<h4>Resultado:</h4>').appendTo(_hu);
                    var _ul = $('<ul>');
                    _ul.appendTo(_hu);

                    $.each(data.userlist, function (index, value) {
                        $.ajax({
                            cache: false,
                            url: '/report',
                            data: {user: value, last: (index == (_length - 1) ? true : false)},
                            async: true,
                            type: 'POST',
                            success: function (response) {
                                response = $.parseJSON(response);
                                if ($.isEmptyObject(response.errors)) {
                                    $('<li>').html(response.user + ': ' + (response.result == true ? '<i class="icon-ok"></i>' : '<i class="icon-remove"></i>')).appendTo(_ul);
                                }else{
                                    $('.alert-error').show().prepend('<p>' + response.errors + '</p>');
                                    return false;
                                }
                            }
                        });

                        if (index == (_length - 1)) {
                            $('<p class="center hideMe"><a class="btn" href="/">Volver al inicio</a></p>').appendTo(_hu);
                        }
                    });
                }else{
                    $.each(data.errors, function(index, value){
                        $('.alert-error').show().prepend('<p>' + value + '</p>');
                    });
                    Recaptcha.reload();
                }
            }
        });
        return false;
    });
});