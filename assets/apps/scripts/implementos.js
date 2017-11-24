var save_method;
var implementos;

$(document).ready(function ()
{
    implementos = $('#implementos').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/implemento/list_implementos",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    /*$("#implemento_form").validate({
        rules: {
            nombre: {
                required: true
            },
            categoria: {
                required: true
            },
            stock: {
                required: true
            },
            stock_min: {
                required: true
            },
            stock_max: {
                required: true
                
            },
            unidad: {
                required: true
            }
        }
    });*/
});

function search_implemento(){
    $('[name="codigo"]').parent().removeClass('has-error');
    $('[name="codigo"]').parent().removeClass('has-warning');
    $('[name="codigo"]').parent().removeClass('has-success');
    $('[name="codigo"]').next().empty(); 

    var codigo = $("#codigo_imp").val();

    $.ajax({
        url : "http://localhost/parque/index.php/implemento/search_implemento",
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

            if(data.button == 1){
                $('#btnSave_imp').attr('disabled',true);
            }
            else{
                $('#btnSave_imp').attr('disabled',false);
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

function validate_stock()
{
    $('[name="stock"]').parent().removeClass('has-error');
    $('[name="stock"]').parent().removeClass('has-warning');
    $('[name="stock"]').parent().removeClass('has-succes');
    $('[name="stock_min"]').parent().removeClass('has-error');
    $('[name="stock_min"]').parent().removeClass('has-warning');
    $('[name="stock_min"]').parent().removeClass('has-succes');
    $('[name="stock_max"]').parent().removeClass('has-error');
    $('[name="stock_max"]').parent().removeClass('has-warning');
    $('[name="stock_max"]').parent().removeClass('has-succes');
    $('[name="stock"]').next().empty();  
    $('[name="stock_min"]').next().empty();  
    $('[name="stock_max"]').next().empty();

    var stock = $("#stock").val();
    var stock_min = $("#stock_min").val();
    var stock_max = $("#stock_max").val();
    $.ajax({
        url : "http://localhost/parque/index.php/implemento/validate_stock",
        type: 'GET',
        data: {'stock':stock,'stock_min':stock_min,'stock_max':stock_max},
        dataType: 'JSON',
        success: function(data)
        {
            switch(data.type)
            {
                case 'Advertencia':
                    if(data.input0 == true && data.input1 == false || data.input0 == true && data.input2 == false)
                    {
                        $('[name="stock"]').parent().addClass('has-warning');
                        $('[name="stock"]').next().text(data.message);  
                    }
                    else if(data.input1 == true && data.input0 == false || data.input1 == true && data.input2 == false)
                    {
                        $('[name="stock_min"]').parent().addClass('has-warning');
                        $('[name="stock_min"]').next().text(data.message);  
                    }
                    else if(data.input2 == true && data.input1 == false || data.input2 == true && data.input0 == false)
                    {
                        $('[name="stock_max"]').parent().addClass('has-warning');
                        $('[name="stock_max"]').next().text(data.message);  
                    }
                    else if(data.input0 == true && data.input1 == true)
                    {
                        $('[name="stock"]').parent().addClass('has-warning');
                        $('[name="stock_min"]').parent().addClass('has-warning');
                        $('[name="stock"]').next().text(data.message);  
                        $('[name="stock_min"]').next().text(data.message);  
                    }
                    else if(data.input0 == true && data.input2 == true)
                    {
                        $('[name="stock"]').parent().addClass('has-warning');
                        $('[name="stock_max"]').parent().addClass('has-warning');
                        $('[name="stock"]').next().text(data.message);  
                        $('[name="stock_max"]').next().text(data.message);  
                    }
                    else if(data.input1 == true && data.input2 == true)
                    {
                        $('[name="stock_min"]').parent().addClass('has-warning');
                        $('[name="stock_max"]').parent().addClass('has-warning');
                        $('[name="stock_min"]').next().text(data.message);  
                        $('[name="stock_max"]').next().text(data.message);  
                    }
                break;

                case 'Aviso':
                    $('[name="stock"]').parent().addClass('has-success');
                    $('[name="stock_min"]').parent().addClass('has-success');
                    $('[name="stock_max"]').parent().addClass('has-success');  
                break;
            }

            if(data.button == 1 || data.button == false)
            {
                $('#btnSave_imp').attr('disabled',true); //set button disable 
            }
            if(data.button == 0)
            {
                $('#btnSave_imp').attr('disabled',false); //unset button disable 
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

function add_implemento(){
    save_method = 'add';

    $('#implemento_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#implemento-modal').modal('show');
    $('.implemento-modal-title').text('Nuevo Implemento');
    $('#icon').removeClass('icon-pencil');
    $('#icon').addClass('icon-plus');
    $('#btnSave_imp').attr('disabled',true);
    $('#codigo_imp').attr('disabled',false);
}


function edit_implemento(id_imp){
    save_method = 'update';

    $('#implemento_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#btnSave_imp').attr('disabled',false);
    $('#codigo_imp').attr('disabled',true);

    $.ajax({
        url : "http://localhost/parque/index.php/implemento/edit_implemento/" + id_imp,
        type: "GET",
        dataType: "JSON",
        success: function (data){
            $('[name="id_imp"]').val(data.id_imp);
            $('[name="codigo"]').val(data.codigo);
            $('[name="nombre"]').val(data.nombre);
            $('[name="categoria"]').val(data.categoria);
            $('[name="stock"]').val(data.stock);
            $('[name="stock_min"]').val(data.stock_min);
            $('[name="stock_max"]').val(data.stock_max);
            $('[name="unidad"]').val(data.unidad);
            $('#implemento-modal').modal('show');
            $('#icon').removeClass('icon-plus');
            $('#icon').addClass('icon-pencil');
            $('.implemento-modal-title').text('Actualizar Implemento');
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

function save_implemento(){
    $('#btnSave_imp').text('Guardando...');
    $('#btnSave_imp').attr('disabled',true); 
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 

    var url;

    if(save_method == 'add'){
        url = "http://localhost/parque/index.php/implemento/add_implemento";
    }
    else{
        url = "http://localhost/parque/index.php/implemento/update_implemento";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#implemento_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status){
                if(save_method == 'add'){
                    message = "¡Implemento creado!";
                    $('#implemento-modal').modal('hide');
                }
                else{
                    message = "¡Implemento actualizado!";
                    $('#implemento-modal').modal('hide');
                }

                swal({
                    title: "Éxito",
                    text: message,
                    type: "success"
                }); 
                reload_implementos();
            }
            else{
                if(data.inputerror)
                {
                    for(var i = 0; i < data.inputerror.length; i++){
                        $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error');
                        $('[name="codigo"]').next().text(data.error_string[i]);  
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
            $('#btnSave_imp').text('Guardar');
            $('#btnSave_imp').attr('disabled',false);
        },
        error: function (jqXHR, textStatus, errorThrown){
            swal({
                title: "Error",
                text: "¡Verifica los datos ingresados!",
                type: "error"
            });
        }
    });
}

function delete_implemento(id_imp){  
    swal({
        title: "Advertencia",
        text: "¿Deseas eliminar este implemento?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/implemento/delete_implemento/" + id_imp,
            type: "POST",
            dataType: "JSON",
            success: function (data){
                $('#implemento-modal').modal('hide');
                reload_implementos();
            },
            error: function (jqXHR, textStatus, errorThrown){
                swal({
                    title: "Error",
                    text: "¡Ha ocurrido un error!",
                    type: "error"
                });
            }
        });
        swal("Éxito", "¡El implemento fue eliminado!", "success");
    }, function (dismiss){
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function reload_implementos(){
    implementos.ajax.reload(null,false);
}