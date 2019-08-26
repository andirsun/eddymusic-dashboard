$(function () {
    autenticar();
    console.log(666);
});

function autenticar() {
    $('#formLogin').submit(function (e) {
        e.preventDefault();
        var form = this;
        var data = $(this).serialize();
        var btn = $(this).find('button');
        $.ajax({
            url: base_url + 'login/makeLogin',
            type: 'GET',
            dataType: 'json',
            data: data,
            beforeSend: function () {
                $(btn).prop('disabled', true);
                $(btn).html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function (r) {
                if (r.response == 2) {
                    window.location.replace(base_url + 'admin');
                    // $(loader).html('<i class="fa fa-check success"></i>');
                    // checkDocument_ = true;
                } else {
                    // alert('Datos incorrectos');
                    checkDocument_ = false;
                    $(form).find("#txt-login-msg").text('Datos incorrectos');
                    $(form).find("#msg-login").fadeIn('fast', function () {
                        setTimeout(function () {
                            $(form).find("#msg-login").fadeOut('fast');
                        }, 1800);
                    });
                    // $(loader).html('<i class="fa fa-times danger"></i> Documento ya existe');
                }
                $(btn).html('Login');
                console.log(r);
            },
            error: function (xhr, status, msg) {
                console.log(xhr.responseText);
            },
            complete: function () {
                /* body... */
                $(btn).html('Login');
                $(btn).prop('disabled', false);
            }
        });
    });
}