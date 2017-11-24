var save_method;
var actividades;

$(document).ready(function (){
    actividades = $('#actividades').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/actividad/list_actividades",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    /*("#actividad_form").validate({
        rules: {
            accion: {
                required: true
            },
            tipo: {
                required: true
            }
        }
    });*/
});

function search_actividad(){
    $('[name="accion"]').parent().removeClass('has-error');
    $('[name="accion"]').parent().removeClass('has-warning');
    $('[name="accion"]').parent().removeClass('has-success');
    $('[name="accion"]').next().empty();
    
    var accion = $("#accion_act").val();

    $.ajax({
        url : "http://localhost/parque/index.php/actividad/search_actividad",
        type: 'GET',
        data: {'accion':accion},
        dataType: 'JSON',
        success: function (data){
            switch(data.type){
                case 'Advertencia':
                    $('[name="accion"]').parent().addClass('has-warning');
                    $('[name="accion"]').next().text(data.message);  
                break;

                case 'Aviso':
                    $('[name="accion"]').parent().addClass('has-success');
                    $('[name="accion"]').next().text(data.message);  
                break;

                case 'Error':
                    $('[name="accion"]').parent().addClass('has-error');
                    $('[name="accion"]').next().text(data.message);  
                break;
            }

            if(data.button == 1 || data.button == false)
            {
                $('#btnSave_act').attr('disabled',true); //set button disable 
            }
            if(data.button == 0)
            {
                $('#btnSave_act').attr('disabled',false); //unset button disable 
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

function add_actividad(){
    save_method = 'add';

    $('#actividad_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-success');
    $('.form-group').removeClass('has-warning');
    $('.help-block').empty();
    $('#actividad-modal').modal('show');
    $('#icon').removeClass('icon-pencil');
    $('#icon').addClass('icon-plus');
    $('.actividad-modal-title').text('Nueva Actividad');
    $('#btnSave_act').attr('disabled',true);
}

function edit_actividad(id_act){
    save_method = 'update';

    $('#actividad_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-success');
    $('.form-group').removeClass('has-warning');
    $('.help-block').empty();
    $('#btnSave_act').attr('disabled',false);

    $.ajax({
        url : "http://localhost/parque/index.php/actividad/edit_actividad/" + id_act,
        type: "GET",
        dataType: "JSON",
        success: function (data){
            $('[name="id_act"]').val(data.id_act);
            $('[name="accion"]').val(data.accion);
            $('[name="tipo"]').val(data.tipo);
            $('#actividad-modal').modal('show');
            $('#icon').removeClass('icon-plus');
            $('#icon').addClass('icon-pencil');
            $('.actividad-modal-title').text('Actualizar actividad');
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

function save_actividad(){
    $('#btnSave_act').text('Guardando...');
    $('#btnSave_act').attr('disabled',true); 
    var url;

    if(save_method == 'add'){
        url = "http://localhost/parque/index.php/actividad/add_actividad";
    }
    else{
        url = "http://localhost/parque/index.php/actividad/update_actividad";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#actividad_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status){
                if(save_method == 'add'){
                    message = "¡Actividad creada!";
                    $('#actividad-modal').modal('hide');
                }
                else{
                    message = "¡Actividad actualizada!";
                    $('#actividad-modal').modal('hide');
                }

                swal({
                    title: "Éxito",
                    text: message,
                    type: "success"
                }); 
                reload_actividades();
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
                    swal({
                        title: "Error",
                        text: data.error['accion'],
                        type: "error"
                    });
                }
            }
            $('#btnSave_act').text('Guardar');
            $('#btnSave_act').attr('disabled',false);
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

function delete_actividad(id_act){  
    swal({
        title: "Advertencia",
        text: "¿Deseas eliminar este actividad?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/actividad/delete_actividad/" + id_act,
            type: "POST",
            dataType: "JSON",
            success: function (data){
                $('#actividad-modal').modal('hide');
                reload_actividades();
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                    title: "Error",
                    text: "¡Ha ocurrido un error!",
                    type: "error"
                });
            }
        });
        swal("Éxito", "¡El actividad fue eliminada!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function reload_actividades(){
    actividades.ajax.reload(null,false);
}