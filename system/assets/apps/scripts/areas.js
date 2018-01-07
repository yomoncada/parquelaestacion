var save_method;
var areas_activas;
var areas_inactivas;

$(document).ready(function (){
    areas_activas = $('#areas_activas').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/area/list_areas_activas",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    areas_inactivas = $('#areas_inactivas').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/area/list_areas_inactivas",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    /*$("#area_form").validate({
        rules: {
            codigo: {
                required: true
               
            },
            nombre: {
                required: true
               
            }
        }
    });*/
});

function search_area(){
    $('[name="codigo"]').parent().removeClass('has-error');
    $('[name="codigo"]').parent().removeClass('has-warning');
    $('[name="codigo"]').parent().removeClass('has-success');
    $('[name="codigo"]').next().empty();
    
    var codigo = $("#codigo_are").val();

    $.ajax({
        url : "http://localhost/parque/index.php/area/search_area",
        type: 'GET',
        data: {'codigo':codigo},
        dataType: 'JSON',
        success: function (data){
            switch(data.type){
                case 'Advertencia':
                    $('[name="codigo"]').parent().addClass('has-warning');
                    $('[name="codigo"]').next().text(data.message);  
                break;

                case 'Aviso':
                    $('[name="codigo"]').parent().addClass('has-success');
                    $('[name="codigo"]').next().text(data.message);  
                break;

                case 'Error':
                    $('[name="codigo"]').parent().addClass('has-error');
                    $('[name="codigo"]').next().text(data.message);  
                break;
            }

            if(data.button == 1 || data.button == false)
            {
                $('#btnSave_are').attr('disabled',true); //set button disable 
            }
            if(data.button == 0)
            {
                $('#btnSave_are').attr('disabled',false); //unset button disable 
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

function add_area(){
    save_method = 'add';

    $('#area_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#area-modal').modal('show');
    $('#icon').removeClass('icon-pencil');
    $('#icon').addClass('icon-plus');
    $('.area-modal-title').text('Nueva area');
    $('#btnSave_are').attr('disabled',true);
    $('#codigo_are').attr('disabled',false);
}

function edit_area(id_are){
    save_method = 'update';

    $('#area_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#btnSave_are').attr('disabled',false);
    $('#codigo_are').attr('disabled',true);

    $.ajax({
        url : "http://localhost/parque/index.php/area/edit_area/" + id_are,
        type: "GET",
        dataType: "JSON",
        success: function (data){
            $('[name="id_are"]').val(data.id_are);
            $('[name="codigo"]').val(data.codigo);
            $('[name="nombre"]').val(data.area);
            $('[name="ubicacion"]').val(data.ubicacion);
            $('#area-modal').modal('show');
            $('#icon').removeClass('icon-plus');
            $('#icon').addClass('icon-pencil');
            $('.area-modal-title').text('Actualizar Area');
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

function save_area(){
    $('#btnSave_are').text('Guardando...');
    $('#btnSave_are').attr('disabled',true);
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 
 
    var url;

    if(save_method == 'add'){
        url = "http://localhost/parque/index.php/area/add_area";
    }
    else{
        url = "http://localhost/parque/index.php/area/update_area";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#area_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status){
                if(save_method == 'add'){
                    message = "¡Area creada!";
                    $('#area-modal').modal('hide');
                }
                else{
                    message = "¡Area actualizada!";
                    $('#area-modal').modal('hide');
                }

                swal({
                    title: "Éxito",
                    text: message,
                    type: "success"
                }); 
                reload_areas();
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
                        text: data.error['codigo'],
                        type: "error"
                    });
                }
            }
            $('#btnSave_are').text('Guardar');
            $('#btnSave_are').attr('disabled',false);
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

function activate_area(id_are){  
    swal({
        title: "Advertencia",
        text: "¿Deseas activar esta area?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/area/activate_area/" + id_are,
            type: "POST",
            dataType: "JSON",
            success: function (data){
                $('#area-modal').modal('hide');
                reload_areas();
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                    title: "Error",
                    text: "¡Ha ocurrido un error!",
                    type: "error"
                });
            }
        });
        swal("Éxito", "¡El area fue activada!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La activación fue cancelada!", "info");
        }
    })
}

function desactivate_area(id_are){  
    swal({
        title: "Advertencia",
        text: "¿Deseas desactivar este area?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/area/desactivate_area/" + id_are,
            type: "POST",
            dataType: "JSON",
            success: function (data){
                $('#area-modal').modal('hide');
                reload_areas();
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                    title: "Error",
                    text: "¡Ha ocurrido un error!",
                    type: "error"
                });
            }
        });
        swal("Éxito", "¡El area fue desactivada!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La desactivación fue cancelada!", "info");
        }
    })
}

function reload_areas(){
    areas_activas.ajax.reload(null,false);
    areas_inactivas.ajax.reload(null,false);
}