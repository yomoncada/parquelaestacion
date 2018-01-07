var save_method;
var niveles;

$(document).ready(function (){
    niveles_activos = $('#niveles_activos').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/nivel/list_niveles_activos",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    niveles_inactivos = $('#niveles_inactivos').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/nivel/list_niveles_inactivos",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    /*$("#nivel_form").validate({
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

function search_nivel(){
    $('[name="nivel"]').parent().removeClass('has-error');
    $('[name="nivel"]').parent().removeClass('has-warning');
    $('[name="nivel"]').parent().removeClass('has-success');
    $('[name="nivel"]').next().empty();

    var nombre = $("#nombre_niv").val();

    $.ajax({
        url : "http://localhost/parque/index.php/nivel/search_nivel",
        type: 'GET',
        data: {'nombre':nombre},
        dataType: 'JSON',
        success: function (data){
            switch(data.type){
                case 'Advertencia':
                    $('[name="nivel"]').parent().addClass('has-warning');
                    $('[name="nivel"]').next().text(data.message);  
                break;

                case 'Aviso':
                    $('[name="nivel"]').parent().addClass('has-success');
                    $('[name="nivel"]').next().text(data.message);  
                break;

                case 'Error':
                    $('[name="nivel"]').parent().addClass('has-error');
                    $('[name="nivel"]').next().text(data.message);  
                break;
            }

            if(data.button == 1){
                $('#btnSave_niv').attr('disabled',true);
            }
            else{
                $('#btnSave_niv').attr('disabled',false);
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

function add_nivel(){
    save_method = 'add';

    $('#nivel_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#nivel-modal').modal('show');
    $('#icon').removeClass('icon-pencil');
    $('#icon').addClass('icon-plus');
    $('.nivel-modal-title').text('Nuevo nivel');
    $('#btnSave_niv').attr('disabled',true);
    $('#nombre_niv').attr('disabled',false);
}

function edit_nivel(id_niv){
    save_method = 'update';

    $('#nivel_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#btnSave_niv').attr('disabled',false);
    $('#nombre_niv').attr('disabled',true);

    $.ajax({
        url : "http://localhost/parque/index.php/nivel/edit_nivel/" + id_niv,
        type: "GET",
        dataType: "JSON",
        success: function (data){
            $('[name="id_niv"]').val(data.id_niv);
            $('[name="nivel"]').val(data.nivel);
            $('[name="descripcion"]').val(data.descripcion);
            $('[name="are_access"]').val(data.are_access);
            $('[name="ben_access"]').val(data.ben_access);
            $('[name="cab_access"]').val(data.cab_access);
            $('[name="can_access"]').val(data.can_access);
            $('[name="car_access"]').val(data.car_access);
            $('[name="cat_access"]').val(data.cat_access);
            $('[name="edi_access"]').val(data.edi_access);
            $('[name="don_access"]').val(data.don_access);
            $('[name="edi_access"]').val(data.edi_access);
            $('[name="emp_access"]').val(data.emp_access);
            $('[name="esp_access"]').val(data.esp_access);
            $('[name="imp_access"]').val(data.imp_access);
            $('[name="cen_access"]').val(data.cen_access);
            $('[name="dnc_access"]').val(data.dnc_access);
            $('[name="man_access"]').val(data.man_access);
            $('[name="ref_access"]').val(data.ref_access);
            $('[name="ser_access"]').val(data.ser_access);
            $('[name="bd_access"]').val(data.bd_access);
            $('[name="bit_access"]').val(data.bit_access);
            $('[name="niv_access"]').val(data.niv_access);
            $('[name="usu_access"]').val(data.usu_access);
            $('#nivel-modal').modal('show');
            $('#icon').removeClass('icon-plus');
            $('#icon').addClass('icon-pencil');
            $('.nivel-modal-title').text('Actualizar nivel');
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

function save_nivel(){
    $('#btnSave_niv').text('Guardando...');
    $('#btnSave_niv').attr('disabled',true); 
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 

    var url;

    if(save_method == 'add'){
        url = "http://localhost/parque/index.php/nivel/add_nivel";
    }
    else{
        url = "http://localhost/parque/index.php/nivel/update_nivel";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#nivel_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status){
                if(save_method == 'add'){
                    message = "¡Nivel creado!";
                    $('#nivel-modal').modal('hide');
                }
                else{
                    message = "¡Nivel actualizado!";
                    $('#nivel-modal').modal('hide');
                }

                swal({
                    title: "Éxito",
                    text: message,
                    type: "success"
                }); 
                reload_niveles();
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
                        text: data.error['nivel'],
                        type: "error"
                    }); 
                }
            }
            $('#btnSave_niv').text('Guardar');
            $('#btnSave_niv').attr('disabled',false);
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

function activate_nivel(id_niv){  
    swal({
        title: "Advertencia",
        text: "¿Deseas activar este nivel?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/nivel/activate_nivel/" + id_niv,
            type: "POST",
            dataType: "JSON",
            success: function (data){
                $('#nivel-modal').modal('hide');
                reload_niveles();
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                    title: "Error",
                    text: "¡Ha ocurrido un error!",
                    type: "error"
                });
            }
        });
        swal("Éxito", "¡El nivel fue activado!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La activación fue cancelada!", "info");
        }
    })
}

function desactivate_nivel(id_niv){  
    swal({
        title: "Advertencia",
        text: "¿Deseas desactivar este nivel?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/nivel/desactivate_nivel/" + id_niv,
            type: "POST",
            dataType: "JSON",
            success: function (data){
                $('#nivel-modal').modal('hide');
                reload_niveles();
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                    title: "Error",
                    text: "¡Ha ocurrido un error!",
                    type: "error"
                });
            }
        });
        swal("Éxito", "¡El nivel fue desactivado!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La desactivación fue cancelada!", "info");
        }
    })
}

function reload_niveles(){
    niveles_activos.ajax.reload(null,false);
    niveles_inactivos.ajax.reload(null,false);
}