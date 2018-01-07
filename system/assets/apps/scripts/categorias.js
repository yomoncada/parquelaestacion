var save_method;
var categorias_activas;
var categorias_inactivas;

$(document).ready(function (){
    categorias_activas = $('#categorias_activas').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/categoria/list_categorias_activas",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    categorias_inactivas = $('#categorias_inactivas').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/categoria/list_categorias_inactivas",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    /*$("#categoria_form").validate({
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

function search_categoria(){
    $('[name="categoria"]').parent().removeClass('has-error');
    $('[name="categoria"]').parent().removeClass('has-warning');
    $('[name="categoria"]').parent().removeClass('has-success');
    $('[name="categoria"]').next().empty();

    var nombre = $("#nombre_cat").val();

    $.ajax({
        url : "http://localhost/parque/index.php/categoria/search_categoria",
        type: 'GET',
        data: {'nombre':nombre},
        dataType: 'JSON',
        success: function (data){
            switch(data.type){
                case 'Advertencia':
                    $('[name="categoria"]').parent().addClass('has-warning');
                    $('[name="categoria"]').next().text(data.message);  
                break;

                case 'Aviso':
                    $('[name="categoria"]').parent().addClass('has-success');
                    $('[name="categoria"]').next().text(data.message);  
                break;

                case 'Error':
                    $('[name="categoria"]').parent().addClass('has-error');
                    $('[name="categoria"]').next().text(data.message);  
                break;
            }

            if(data.button == 1){
                $('#btnSave_cat').attr('disabled',true);
            }
            else{
                $('#btnSave_cat').attr('disabled',false);
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

function add_categoria(){
    save_method = 'add';

    $('#categoria_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#categoria-modal').modal('show');
    $('#icon').removeClass('icon-pencil');
    $('#icon').addClass('icon-plus');
    $('.categoria-modal-title').text('Nueva Categoria');
    $('#btnSave_cat').attr('disabled',true);
    $('#nombre_cat').attr('disabled',false);
}

function edit_categoria(id_cat){
    save_method = 'update';

    $('#categoria_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#btnSave_cat').attr('disabled',false);
    $('#nombre_cat').attr('disabled',true);

    $.ajax({
        url : "http://localhost/parque/index.php/categoria/edit_categoria/" + id_cat,
        type: "GET",
        dataType: "JSON",
        success: function (data){
            $('[name="id_cat"]').val(data.id_cat);
            $('[name="categoria"]').val(data.categoria);
            $('[name="descripcion"]').val(data.descripcion);
            $('#categoria-modal').modal('show');
            $('#icon').removeClass('icon-plus');
            $('#icon').addClass('icon-pencil');
            $('.categoria-modal-title').text('Actualizar Categoria');
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

function save_categoria(){
    $('#btnSave_cat').text('Guardando...');
    $('#btnSave_cat').attr('disabled',true); 
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 

    var url;

    if(save_method == 'add'){
        url = "http://localhost/parque/index.php/categoria/add_categoria";
    }
    else{
        url = "http://localhost/parque/index.php/categoria/update_categoria";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#categoria_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status){
                if(save_method == 'add'){
                    message = "¡Categoria creada!";
                    $('#categoria-modal').modal('hide');
                }
                else{
                    message = "¡Categoria actualizada!";
                    $('#categoria-modal').modal('hide');
                }

                swal({
                    title: "Éxito",
                    text: message,
                    type: "success"
                }); 
                reload_categorias();
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
                        text: data.error['categoria'],
                        type: "error"
                    }); 
                }
            }
            $('#btnSave_cat').text('Guardar');
            $('#btnSave_cat').attr('disabled',false);
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

function activate_categoria(id_cat){  
    swal({
        title: "Advertencia",
        text: "¿Deseas activar este categoria?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/categoria/activate_categoria/" + id_cat,
            type: "POST",
            dataType: "JSON",
            success: function (data){
                $('#categoria-modal').modal('hide');
                reload_categorias();
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                    title: "Error",
                    text: "¡Ha ocurrido un error!",
                    type: "error"
                });
            }
        });
        swal("Éxito", "¡La categoria fue activada!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La activación fue cancelada!", "info");
        }
    })
}

function desactivate_categoria(id_cat){  
    swal({
        title: "Advertencia",
        text: "¿Deseas desactivar este categoria?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/categoria/desactivate_categoria/" + id_cat,
            type: "POST",
            dataType: "JSON",
            success: function (data){
                $('#categoria-modal').modal('hide');
                reload_categorias();
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                    title: "Error",
                    text: "¡Ha ocurrido un error!",
                    type: "error"
                });
            }
        });
        swal("Éxito", "¡La categoria fue desactivada!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La desactivación fue cancelada!", "info");
        }
    })
}

function reload_categorias(){
    categorias_activas.ajax.reload(null,false);
    categorias_inactivas.ajax.reload(null,false);
}