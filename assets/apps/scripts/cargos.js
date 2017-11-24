var save_method;
var cargos;

$(document).ready(function (){
    cargos = $('#cargos').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/cargo/list_cargos",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    /*$("#cargo_form").validate({
        rules: {
            nombre: {
                required: true
            },
            descripcion: {
                required: true
            }
        }
    });*/
});

function search_cargo(){
    $('[name="cargo"]').parent().removeClass('has-error');
    $('[name="cargo"]').parent().removeClass('has-warning');
    $('[name="cargo"]').parent().removeClass('has-success');
    $('[name="cargo"]').next().empty();

    var nombre = $("#nombre_car").val();

    $.ajax({
        url : "http://localhost/parque/index.php/cargo/search_cargo",
        type: 'GET',
        data: {'nombre':nombre},
        dataType: 'JSON',
        success: function (data){
            switch(data.type){
                case 'Advertencia':
                    $('[name="cargo"]').parent().addClass('has-warning');
                    $('[name="cargo"]').next().text(data.message);  
                break;

                case 'Aviso':
                    $('[name="cargo"]').parent().addClass('has-success');
                    $('[name="cargo"]').next().text(data.message);  
                break;

                case 'Error':
                    $('[name="cargo"]').parent().addClass('has-error');
                    $('[name="cargo"]').next().text(data.message);  
                break;
            }

            if(data.button == 1){
                $('#btnSave_car').attr('disabled',true);
            }
            else{
                $('#btnSave_car').attr('disabled',false);
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

function add_cargo(){
    save_method = 'add';

    $('#cargo_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#cargo-modal').modal('show');
    $('#icon').removeClass('icon-pencil');
    $('#icon').addClass('icon-plus');
    $('.cargo-modal-title').text('Nuevo cargo');
    $('#btnSave_car').attr('disabled',true);
    $('#nombre_car').attr('disabled',false);
}

function edit_cargo(id_car){
    save_method = 'update';

    $('#cargo_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#btnSave_car').attr('disabled',false);
    $('#nombre_car').attr('disabled',true);

    $.ajax({
        url : "http://localhost/parque/index.php/cargo/edit_cargo/" + id_car,
        type: "GET",
        dataType: "JSON",
        success: function (data){
            $('[name="id_car"]').val(data.id_car);
            $('[name="cargo"]').val(data.cargo);
            $('[name="descripcion"]').val(data.descripcion);
            $('#cargo-modal').modal('show');
            $('#icon').removeClass('icon-plus');
            $('#icon').addClass('icon-pencil');
            $('.cargo-modal-title').text('Actualizar cargo');
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

function save_cargo(){
    $('#btnSave_car').text('Guardando...');
    $('#btnSave_car').attr('disabled',true); 
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 

    var url;

    if(save_method == 'add'){
        url = "http://localhost/parque/index.php/cargo/add_cargo";
    }
    else{
        url = "http://localhost/parque/index.php/cargo/update_cargo";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#cargo_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status){
                if(save_method == 'add'){
                    message = "¡Cargo creado!";
                    $('#cargo-modal').modal('hide');
                }
                else{
                    message = "¡Cargo actualizado!";
                    $('#cargo-modal').modal('hide');
                }

                swal({
                    title: "Éxito",
                    text: message,
                    type: "success"
                }); 
                reload_cargos();
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
                        text: data.error['cargo'],
                        type: "error"
                    }); 
                }
            }
            $('#btnSave_car').text('Guardar');
            $('#btnSave_car').attr('disabled',false);
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

function delete_cargo(id_car){  
    swal({
        title: "Advertencia",
        text: "¿Deseas eliminar este cargo?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/cargo/delete_cargo/" + id_car,
            type: "POST",
            dataType: "JSON",
            success: function (data){
                $('#cargo-modal').modal('hide');
                reload_cargos();
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                    title: "Error",
                    text: "¡Ha ocurrido un error!",
                    type: "error"
                });
            }
        });
        swal("Éxito", "¡La cargo fue eliminada!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function reload_cargos(){
    cargos.ajax.reload(null,false);
}