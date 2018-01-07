$(document).ready(function (){
    $('#forget_form').css('display','none');
    $('#temporal_password').css('display','none');
});

function validate_usuario(){
    $('.form-group').removeClass('has-error');
    $('.help-block').empty(); 

    $.ajax({
        url : "http://localhost/parque/index.php/sistema/validate_usuario",
        type: "POST",
        data: $('#login_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status == true){
                location.href = "http://localhost/parque/index.php/home";
            }
            else
            {
                if(data.inputerror)
                {
                    for(var i = 0; i < data.inputerror.length; i++){
                        $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error');
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                    }
                }
                else if(data.swalx == 1)
                {
                    swal({
                        title: "Error",
                        text: "¡Los datos ingresados son incorrectos!",
                        type: "error"
                    });
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown){
            swal({
                title: "Error",
                text: "¡Ha ocurrido un error!",
                type: "error"
            });
        }
    });
}

function forget_form(){
    $.ajax({
        success: function (data){
            $('[name="usuario"]').val($('#usuario').val());
            //$('#forget_form')[0].reset();
            $('#forget_form').css('display','block');
            $('#login_form').css('display','none');
            $('#temporal_password').css('display','none');
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
        }
    });
}

function login_form(){
    $.ajax({
        success: function (data){
            //$('#login_form')[0].reset();
            $('[name="usuario"]').val($('#usuario').val());
            $('#forget_form').css('display','none');
            $('#login_form').css('display','block');
            $('#temporal_password').css('display','none');
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
        }
    });
}

function recover_password(){
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    $.ajax({
        url : "http://localhost/parque/index.php/sistema/recover_password",
        type: "POST",
        data: $('#forget_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status)
            {
                $('#forget_form').css('display','none');
                $('#temporal_password').css('display','block');
                $('#random_password').text(data.random_password);
            }
            else
            {
                if(data.inputerror)
                {
                    for(var i = 0; i < data.inputerror.length; i++){
                        $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error');
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                    }
                }
                else
                {
                    swal({
                        title: "Error",
                        text: "¡Los datos ingresados son incorrectos!",
                        type: "error"
                    });
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown){
            swal({
                title: "Error",
                text: "¡Ha ocurrido un error!",
                type: "error"
            });
        }
    });
}