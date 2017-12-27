var save_method;
var especies_activas;
var especies_inactivas;

$(document).ready(function ()
{
    especies_activas = $('#especies_activas').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/especie/list_especies_activas",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    especies_inactivas = $('#especies_inactivas').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax":{
            "url": "http://localhost/parque/index.php/especie/list_especies_inactivas",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });

    /*$("#especie_form").validate({
        rules: {
            codigo_esp: {
                required: true,
                minlength: 3
            },
            nom_cmn: {
                required: true,
                minlength: 4,
            },
            nom_cntfc: {
                required: true,
                minlength: 4
            },
            flia: {
                required: true,
                minlength: 4
            },
            tipo: {
                required: true,
                minlength: 4
            },
            poblacion: {
                required: true,
                min: 1
            },
            riesgo: {
                required: true,
                min: 1
            },
            extincion: {
                required: true,
                min: 1
            }
        }
    });*/
});

function search_especie(){
    $('[name="codigo"]').parent().removeClass('has-error');
    $('[name="codigo"]').parent().removeClass('has-warning');
    $('[name="codigo"]').parent().removeClass('has-success');
    $('[name="codigo"]').next().empty();  

    var codigo = $("#codigo_esp").val();

    $.ajax({
        url : "http://localhost/parque/index.php/especie/search_especie",
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
                $('#btnSave_esp').attr('disabled',true);
            }
            else{
                $('#btnSave_esp').attr('disabled',false);
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

function validate_poblacion()
{
    $('[name="poblacion"]').parent().removeClass('has-error');
    $('[name="poblacion"]').parent().removeClass('has-warning');
    $('[name="poblacion"]').parent().removeClass('has-succes');
    $('[name="riesgo"]').parent().removeClass('has-error');
    $('[name="riesgo"]').parent().removeClass('has-warning');
    $('[name="riesgo"]').parent().removeClass('has-succes');
    $('[name="extincion"]').parent().removeClass('has-error');
    $('[name="extincion"]').parent().removeClass('has-warning');
    $('[name="extincion"]').parent().removeClass('has-succes');
    $('[name="poblacion"]').next().empty();  
    $('[name="riesgo"]').next().empty();  
    $('[name="extincion"]').next().empty();  

    var poblacion = $("#poblacion").val();
    var riesgo = $("#riesgo").val();
    var extincion = $("#extincion").val();

    $.ajax({
        url : "http://localhost/parque/index.php/especie/validate_poblacion",
        type: 'GET',
        data: {'poblacion':poblacion,'riesgo':riesgo,'extincion':extincion},
        dataType: 'JSON',
        success: function(data)
        {
            switch(data.type)
            {
                case 'Advertencia':
                    if(data.input0 == true && data.input1 == false || data.input0 == true && data.input2 == false)
                    {
                        $('[name="poblacion"]').parent().addClass('has-warning');
                        $('[name="poblacion"]').next().text(data.message);  
                    }
                    else if(data.input1 == true && data.input0 == false || data.input1 == true && data.input2 == false)
                    {
                        $('[name="riesgo"]').parent().addClass('has-warning');
                        $('[name="riesgo"]').next().text(data.message);  
                    }
                    else if(data.input2 == true && data.input1 == false || data.input2 == true && data.input0 == false)
                    {
                        $('[name="extincion"]').parent().addClass('has-warning');
                        $('[name="extincion"]').next().text(data.message);  
                    }
                    else if(data.input0 == true && data.input1 == true)
                    {
                        $('[name="poblacion"]').parent().addClass('has-warning');
                        $('[name="riesgo"]').parent().addClass('has-warning');
                        $('[name="poblacion"]').next().text(data.message);  
                        $('[name="riesgo"]').next().text(data.message);  
                    }
                    else if(data.input0 == true && data.input2 == true)
                    {
                        $('[name="poblacion"]').parent().addClass('has-warning');
                        $('[name="extincion"]').parent().addClass('has-warning');
                        $('[name="poblacion"]').next().text(data.message);  
                        $('[name="extincion"]').next().text(data.message);  
                    }
                    else if(data.input1 == true && data.input2 == true)
                    {
                        $('[name="riesgo"]').parent().addClass('has-warning');
                        $('[name="extincion"]').parent().addClass('has-warning');
                        $('[name="riesgo"]').next().text(data.message);  
                        $('[name="extincion"]').next().text(data.message);  
                    }
                break;

                case 'Aviso':
                    $('[name="poblacion"]').parent().addClass('has-success');
                    $('[name="riesgo"]').parent().addClass('has-success');
                    $('[name="extincion"]').parent().addClass('has-success');  
                break;
            }

            if(data.button == 1 || data.button == false)
            {
                $('#btnSave_esp').attr('disabled',true); //set button disable 
            }
            if(data.button == 0)
            {
                $('#btnSave_esp').attr('disabled',false); //unset button disable 
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

function add_especie(){
    save_method = 'add';

    $('#especie_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#especie-modal').modal('show');
    $('.especie-modal-title').text('Nueva especie');
    $('#icon').removeClass('icon-pencil');
    $('#icon').addClass('icon-plus');
    $('#btnSave_esp').attr('disabled',true);
    $('#codigo_esp').attr('disabled',false);
}

function edit_especie(id_esp){
    save_method = 'update';

    $('#especie_form')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty();
    $('#btnSave_esp').attr('disabled',false);
    $('#codigo_esp').attr('disabled',true);

    $.ajax({
        url : "http://localhost/parque/index.php/especie/edit_especie/" + id_esp,
        type: "GET",
        dataType: "JSON",
        success: function (data){
            $('[name="id_esp"]').val(data.id_esp);
            $('[name="codigo"]').val(data.codigo);
            $('[name="nom_cmn"]').val(data.nom_cmn);
            $('[name="nom_cntfc"]').val(data.nom_cntfc);
            $('[name="flia"]').val(data.flia);
            $('[name="tipo"]').val(data.tipo);
            $('[name="poblacion"]').val(data.poblacion);
            $('[name="riesgo"]').val(data.riesgo);
            $('[name="extincion"]').val(data.extincion);
            $('#especie-modal').modal('show');
            $('#icon').removeClass('icon-plus');
            $('#icon').addClass('icon-pencil');
            $('.especie-modal-title').text('Actualizar especie');
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

function save_especie(){
    $('#btnSave_esp').text('Guardando...');
    $('#btnSave_esp').attr('disabled',true);
    $('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 

    var url;

    if(save_method == 'add'){
        url = "http://localhost/parque/index.php/especie/add_especie";
    }
    else{
        url = "http://localhost/parque/index.php/especie/update_especie";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#especie_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status){
                if(save_method == 'add'){
                    message = "¡Especie creado!";
                    $('#especie-modal').modal('hide');
                }
                else{
                    message = "¡Especie actualizado!";
                    $('#especie-modal').modal('hide');
                }

                swal({
                    title: "Éxito",
                    text: message,
                    type: "success"
                }); 
                reload_especies();
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
                        html: data.error['codigo'],
                        type: "error"
                    });

                }
            }
            $('#btnSave_esp').text('Guardar');
            $('#btnSave_esp').attr('disabled',false);
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

function activate_especie(id_esp){  
    swal({
        title: "Advertencia",
        text: "¿Deseas activar este especie?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/especie/activate_especie/" + id_esp,
            type: "POST",
            dataType: "JSON",
            success: function (data)
            {
                $('#especie-modal').modal('hide');
                reload_especies();
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
        swal("Éxito", "¡La especie fue activada!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La activación fue cancelada!", "info");
        }
    })
}

function desactivate_especie(id_esp){  
    swal({
        title: "Advertencia",
        text: "¿Deseas desactivar este especie?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#f8ac59",
        confirmButtonText: "Sí",
        cancelButtonText: "No"
    }).then(function (){
        $.ajax({
            url : "http://localhost/parque/index.php/especie/desactivate_especie/" + id_esp,
            type: "POST",
            dataType: "JSON",
            success: function (data)
            {
                $('#especie-modal').modal('hide');
                reload_especies();
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
        swal("Éxito", "¡La especie fue desactivada!", "success");
    }, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La desactivación fue cancelada!", "info");
        }
    })
}

function reload_especies(){
    especies_activas.ajax.reload(null,false);
    especies_inactivas.ajax.reload(null,false);
}