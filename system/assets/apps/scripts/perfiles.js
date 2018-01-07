var save_method;

$(document).ready(function (){
	load_perfil();
    
    $('#pswd_info').hide();
    $('#contrasena1').keyup(function() {
        var pswd = $(this).val();
        var length;
        var letter;
        var capital;
        var number;

        if ( pswd.length > 8 ) {
            $('#length').hide();
            length = true;
        } else {
            $('#length').show();
            length = false;
        }

        if ( pswd.match(/[A-z]/) ) {
            $('#letter').hide();
            letter = true;
        } else {
            $('#letter').show();
            letter = false;
        }

        if ( pswd.match(/[A-Z]/) ) {
            $('#capital').hide();
            capital = true;
        } else {
            $('#capital').show();
            capital = false;
        }

        if ( pswd.match(/\d/) ) {
            $('#number').hide();
            number = true;
        } else {
            $('#number').show();
            number = false;
        }

        if(length == false || letter == false || capital == false || number == false){
            $('#btnSecurity_usu').attr('disabled',true);
            $('#pswd_info').show(); 
            $('#pswd_title').show();
        }

        if(length == true && letter == true && capital == true && number == true){
            $('#btnSecurity_usu').attr('disabled',false);
            $('#pswd_info').hide(); 
            $('#pswd_title').hide();
        }
    }).focus(function() {
        $('#pswd_info').show();
    }).blur(function() {
        $('#pswd_info').hide();
    });
}); 

function load_perfil(){

    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#btnInfo_usu').attr('disabled',true);
    $('#btnSecurity_usu').attr('disabled',true);

    $.ajax({
        url : "http://localhost/parque/index.php/perfil/load_perfil",
        type: "GET",
        dataType: "JSON",
        success: function (data){
            $('.profile_nombre').text(data.nombre);
            $('.profile_usuario').text('@'+ data.usuario);
            $('.profile_biografia').text(data.biografia);
            if(data.avatar != '')
            {
                if($('[name="profile_avatar"]').val() == 1){
                    $('.profile_avatar').attr('src','http://localhost/parque/uploads/' + data.avatar);
                }
                else
                {
                    $('.header_avatar').attr('src','http://localhost/parque/uploads/' + data.avatar)
                    $('.profile_avatar').attr('src','http://localhost/parque/uploads/' + data.avatar);
                }
            }
            if(data.direccion != '')
            {
                $('.status_direccion').text(data.direccion);
            }
            else
            {
                $('.status_direccion').text('Indefinida');
            }

            if(data.email != '')
            {
                $('.status_email').text(data.email);
            }
            else
            {
                $('.status_email').text('Indefinido');
            }

            $('.status_nivel').text(data.nivel);

            if(data.genero != '')
            {
                $('.status_genero').text(data.genero);
            }
            else
            {
                $('.status_genero').text('Indefinido');
            }
            
            if(data.telefono != '')
            {
                $('.status_telefono').text(data.telefono);
            }
            else
            {
                $('.status_telefono').text('Indefinido');
            }

            $('[name="id_usu"]').val(data.id_usu);
            $('[name="nombre"]').val(data.nombre);
            $('[name="usuario"]').val(data.usuario);
            $('[name="biografia"]').val(data.biografia);
            $('[name="telefono"]').val(data.telefono);
            $('[name="email"]').val(data.email);
            $('[name="genero"]').val(data.genero);
            $('[name="direccion"]').val(data.direccion);
            $('#file_status').removeClass('fileinput-exists');
            $('#file_status').addClass('fileinput-new');
            $('[name="file"]').val('');
            $('[name="contrasena_actual"]').val('');
            $('[name="contrasena"]').val('');
            $('[name="repetir_contrasena"]').val('');
            $('[name="pregunta"]').val(data.pregunta);
            $('[name="respuesta"]').val(data.respuesta);
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

function info_change_detected()
{
    $('#btnInfo_usu').attr('disabled',false);
}

function security_change_detected()
{
    $('#btnSecurity_usu').attr('disabled',false);
}

function validate_contrasena(usuario)
{
    $('#btnSecurity_usu').attr('disabled',true);
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    var con_act = $("#con_act").val();
    var contrasena1 = $("#contrasena1").val();
    var contrasena2 = $("#contrasena2").val();

    $.ajax({
        url : "http://localhost/parque/index.php/perfil/validate_contrasena",
        type: 'GET',
        data: {'usuario':usuario,'con_act':con_act,'contrasena1':contrasena1,'contrasena2':contrasena2},
        dataType: 'JSON',
        success: function(data)
        {
            switch(data.type)
            {
                case 'Advertencia':
                    if(data.input0 == true && data.rule0 == false)
                    {
                        $('[name="contrasena_actual"]').parent().addClass('has-warning');
                        $('[name="contrasena_actual"]').next().text(data.message);
                    }
                    else if(data.input0 == true && data.input1 == true && data.rule1 == false)
                    {
                        $('[name="contrasena_actual"]').parent().addClass('has-warning');
                        $('[name="contrasena_actual"]').next().text(data.message);
                        $('[name="contrasena"]').parent().addClass('has-warning');
                        $('[name="contrasena"]').next().text(data.message);
                    }
                    else if(data.input0 == true && data.input2 == true && data.rule1 == false)
                    {
                        $('[name="contrasena_actual"]').parent().addClass('has-warning');
                        $('[name="contrasena_actual"]').next().text(data.message);
                        $('[name="repetir_contrasena"]').parent().addClass('has-warning');
                        $('[name="repetir_contrasena"]').next().text(data.message);
                    }
                    else if(data.input0 == true && data.input1 == true && data.input2 == true && data.rule1 == false)
                    {
                        $('[name="contrasena_actual"]').parent().addClass('has-warning');
                        $('[name="contrasena_actual"]').next().text(data.message);
                        $('[name="contrasena"]').parent().addClass('has-warning');
                        $('[name="contrasena"]').next().text(data.message);
                        $('[name="repetir_contrasena"]').parent().addClass('has-warning');
                        $('[name="repetir_contrasena"]').next().text(data.message);
                    }
                    else if(data.rule2 == false)
                    {
                        $('[name="contrasena"]').parent().addClass('has-warning');
                        $('[name="repetir_contrasena"]').parent().addClass('has-warning');
                        $('[name="contrasena"]').next().text(data.message);
                        $('[name="repetir_contrasena"]').next().text(data.message);
                    }
                break;

                case 'Aviso':
                    $('[name="contrasena_actual"]').parent().addClass('has-success');
                    $('[name="contrasena"]').parent().addClass('has-success');
                    $('[name="repetir_contrasena"]').parent().addClass('has-success');
                    $('[name="repetir_contrasena"]').next().text(data.message);
                    $('[name="repetir_contrasena"]').next().text(data.message);
                    $('[name="repetir_contrasena"]').next().text(data.message);
                break;
            }

            if(data.rule0 == true || data.rule1 == true || data.rule2 == true)
            {
                $('#btnSecurity_usu').attr('disabled',false); 
            }
            else
            {
                $('#btnSecurity_usu').attr('disabled',true);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
                title: "Error",
                text: "¡Ha ocurrido un error!",
                type: "error"
            });
        }
    });
}

function update_info(){
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 
    $('#btnInfo_usu').text('Guardando...');
    $('#btnInfo_usu').attr('disabled',true);

    $.ajax({
        url : "http://localhost/parque/index.php/perfil/update_info",
        type: "POST",
        data: $('#info-usuario_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status){
                swal({
                    title: "Éxito",
                    text: "¡Tu información personal fue actualizada!",
                    type: "success"
                });
                $('.form-group').removeClass('has-error');
                $('.help-block').empty();
                load_perfil();
            }
            else
            {
                if(data.inputerror){
                    for(var i = 0; i < data.inputerror.length; i++){
                        $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error');
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                    }
                }
                else if(data.error)
                {
                    swal({
                        title: "Error",
                        text: data.error['email'],
                        type: "error"
                    }); 
                }
            }
            $('#btnInfo_usu').text('Guardar');
            $('#btnInfo_usu').attr('disabled',true);
        },
        error: function (jqXHR, textStatus, errorThrown){
            $('#btnInfo_usu').text('Guardar');
            $('#btnInfo_usu').attr('disabled',true);

            swal({
                title: "Error",
                text: "¡Algunos campos requeridos no han sido llenados o no cumplen con las reglas!",
                type: "error"
            });
        }
    });
}

function update_avatar(){
    var inputFile = $('input[name=file]');
    var where = 'usuario';
    var fileToUpload = inputFile[0].files[0];
        // make sure there is file to upload
    if (fileToUpload != 'undefined') {
        // provide the form data
        // that would be sent to sever through ajax
        var formData = new FormData();
        formData.append("file", fileToUpload);

        // now upload the file using $.ajax
        $.ajax({
            url: "http://localhost/parque/index.php/upload/do_upload/" + where,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(data) {
                if(data.status)
                {
                    swal({
                        title: "Éxito",
                        text: "¡Tu avatar fue actualizado!",
                        type: "success"
                    });
                    load_perfil();
                }
                else if(data.error)
                {
                    swal({
                        title: "Error",
                        text: data.error,
                        type: "error"
                    });
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
}

function update_security(){
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 
    $('#btnSecurity_usu').text('Guardando...');
    $('#btnSecurity_usu').attr('disabled',true);

    $.ajax({
        url : "http://localhost/parque/index.php/perfil/update_security",
        type: "POST",
        data: $('#security-usuario_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status){
                swal({
                    title: "Éxito",
                    text: "¡Tu seguridad fue reforzada!",
                    type: "success"
                });
                $('.form-group').removeClass('has-error');
                $('.help-block').empty();

                load_perfil();
            }
            else{
                if(data.inputerror)
                {
                    for(var i = 0; i < data.inputerror.length; i++){
                        $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error');
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                    }
                }
                else if(data.error)
                {
                    if(data.error['contrasena'] == null && data.error['email'] == null)
                    {
                        swal({
                            title: "Error",
                            html: data.error['usuario'],
                            type: "error"
                        }); 
                    }
                    if(data.error['usuario'] == null && data.error['email'] == null)
                    {
                        swal({
                            title: "Error",
                            html: data.error['contrasena'],
                            type: "error"
                        }); 
                    }
                    if(data.error['usuario'] == null && data.error['contrasena'] == null)
                    {
                        swal({
                            title: "Error",
                            html: data.error['email'],
                            type: "error"
                        }); 
                    }
                    if(data.error['usuario'] != null && data.error['contrasena'] != null && data.error['email'] == null)
                    {
                        swal({
                            title: "Error",
                            html: data.error['usuario'] + '<br>' + data.error['contrasena'],
                            type: "error"
                        }); 
                    }
                    if(data.error['usuario'] == null && data.error['contrasena'] != null && data.error['email'] != null)
                    {
                        swal({
                            title: "Error",
                            html: data.error['contrasena'] + '<br>' + data.error['email'],
                            type: "error"
                        }); 
                    }
                    if(data.error['usuario'] != null && data.error['contrasena'] == null && data.error['email'] != null)
                    {
                        swal({
                            title: "Error",
                            html: data.error['usuario'] + '<br>' + data.error['email'],
                            type: "error"
                        }); 
                    }
                    if(data.error['usuario'] != null && data.error['contrasena'] != null && data.error['email'] != null)
                    {
                        swal({
                            title: "Error",
                            html: data.error['usuario'] + '<br>' + data.error['contrasena'] + '<br>' + data.error['email'],
                            type: "error"
                        }); 
                    }
                }
            }

            $('#btnSecurity_usu').text('Guardar');
            $('#btnSecurity_usu').attr('disabled',true);
        },
        error: function (jqXHR, textStatus, errorThrown){
            $('#btnSecurity_usu').text('Guardar');
            $('#btnSecurity_usu').attr('disabled',true);

            swal({
                title: "Error",
                text: "¡Ha ocurrido un error!",
                type: "error"
            });
        }
    });
}