var save_method;
var usuarios;

$(document).ready(function (){
    usuarios = $('#usuarios').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/usuario/list_usuarios",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    $('#pswd_info').hide();
    $('#contrasena').keyup(function() {
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
            $('#btnSave_usu').attr('disabled',true);
            $('#pswd_info').show(); 
            $('#pswd_title').show();
        }

        if(length == true && letter == true && capital == true && number == true){
            $('#btnSave_usu').attr('disabled',false);
            $('#pswd_info').hide(); 
            $('#pswd_title').hide();
        }
    }).focus(function() {
        $('#pswd_info').show();
    }).blur(function() {
        $('#pswd_info').hide();
    });

    /*$("#usuario_form").validate({
        rules: {
            usuario: {
                required: true
            },
            contraseña: {
                required: true
            },
            email: {
                required: true
            },
            pregunta: {
                required: true
            },
            respuesta: {
                required: true
            }
        }
    });*/
});

function search_usuario(){
    $('[name="usuario"]').parent().removeClass('has-error');
    $('[name="usuario"]').parent().removeClass('has-warning');
    $('[name="usuario"]').parent().removeClass('has-success');
    $('[name="usuario"]').next().empty(); 

    var usuario = $("#usuario").val();

    $.ajax({
        url : "http://localhost/parque/index.php/usuario/search_usuario",
        type: 'GET',
        data: {'usuario':usuario},
        dataType: 'JSON',
        success: function (data){
            switch(data.type){
                case 'Advertencia':
                    $('[name="usuario"]').parent().addClass('has-warning');
                    $('[name="usuario"]').next().text(data.message);  
                break;

                case 'Aviso':
                    $('[name="usuario"]').parent().addClass('has-success');
                    $('[name="usuario"]').next().text(data.message);  
                break;

                case 'Error':
                    $('[name="usuario"]').parent().addClass('has-error');
                    $('[name="usuario"]').next().text(data.message);  
                break;
            }

            if(data.button == 1){
                $('#btnSave_usu').attr('disabled',true);
            }
            else{
                $('#btnSave_usu').attr('disabled',false);
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

function add_usuario(){
    save_method = 'add';

    $('#usuario_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#usuario-modal').modal('show');
    $('.usuario-modal-title').text('Nuevo usuario');
    $('#icon').removeClass('icon-pencil');
    $('#icon').addClass('icon-plus');
    $('#keyInput_usu').addClass('input-group');
    $('#nombre_usu').attr('disabled',false);
}

function edit_usuario(id_usu){
    save_method = 'update';

    $('#usuario_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#btnSave_usu').attr('disabled',false);
    $('#nombre_usu').attr('disabled',true);

    $.ajax({
        url : "http://localhost/parque/index.php/usuario/edit_usuario/" + id_usu,
        type: "GET",
        dataType: "JSON",
        success: function (data){
            $('[name="id_usu"]').val(data.id_usu);
            $('[name="usuario"]').val(data.usuario);
            $('[name="contrasena"]').val(data.contrasena);
            $('[name="nivel"]').val(data.nivel);
            $('[name="email"]').val(data.email);
            $('[name="pregunta"]').val(data.pregunta);
            $('[name="respuesta"]').val(data.respuesta);
            $('#usuario-modal').modal('show');
            $('#icon').removeClass('icon-plus');
            $('#icon').addClass('icon-pencil');
            $('.usuario-modal-title').text('Actualizar Usuario');
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

function save_usuario(){
    $('#btnSave_usu').text('Guardando...');
    $('#btnSave_usu').attr('disabled',true);
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();  
    var url;

    if(save_method == 'add'){
        url = "http://localhost/parque/index.php/usuario/add_usuario";
    }
    else{
        url = "http://localhost/parque/index.php/usuario/update_usuario";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#usuario_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status){
                if(save_method == 'add'){
                    message = "¡Usuario creado!";
                    $('#usuario-modal').modal('hide');
                }
                else{
                    message = "¡Usuario actualizado!";
                    $('#usuario-modal').modal('hide');
                }

                swal({
                    title: "Éxito",
                    text: message,
                    type: "success"
                }); 
                reload_usuarios();
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
            $('#btnSave_usu').text('Guardar');
            $('#btnSave_usu').attr('disabled',false);
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



function delete_usuario(id_usu){  
    swal({
        title: "Advertencia",
        text: "¿Deseas eliminar este usuario?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/usuario/delete_usuario/" + id_usu,
            type: "POST",
            dataType: "JSON",
            success: function (data)
            {
                $('#usuario-modal').modal('hide');
                reload_usuarios();
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
        swal("Éxito", "¡El usuario fue eliminado!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function reload_usuarios(){
    usuarios.ajax.reload(null,false);
}