var save_method;
var beneficiarios;

$(document).ready(function (){
	beneficiarios = $('#beneficiarios').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/beneficiario/list_beneficiarios",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

    /*$("#beneficiario_form").validate({
        rules: {
            cedula: {
                required: true
            },
            nombre: {
                required: true
            },
            telefono: {
                required: true
            },
            direccion: {
                required: true
            }
        }
    });*/
});

function search_beneficiario(){
	$('[name="cedula"]').parent().removeClass('has-error');
    $('[name="cedula"]').parent().removeClass('has-warning');
    $('[name="cedula"]').parent().removeClass('has-success');
    $('[name="cedula"]').next().empty();

	var cedula = $("#cedula_ben").val();

	$.ajax({
		url : "http://localhost/parque/index.php/beneficiario/search_beneficiario",
		type: 'GET',
		data: {'cedula':cedula},
		dataType: 'JSON',
		success: function (data){
			switch(data.type){
                case 'Advertencia':
                    $('[name="cedula"]').parent().addClass('has-warning');
                    $('[name="cedula"]').next().text(data.message);  
                break;

                case 'Aviso':
                    $('[name="cedula"]').parent().addClass('has-success');
                    $('[name="cedula"]').next().text(data.message);  
                break;

                case 'Error':
                    $('[name="cedula"]').parent().addClass('has-error');
                    $('[name="cedula"]').next().text(data.message);  
                break;
            }

			if(data.button == 1){
				$('#btnSave_ben').attr('disabled',true);
			}
			else{
				$('#btnSave_ben').attr('disabled',false);
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

function add_beneficiario(){
	save_method = 'add';

	$('#beneficiario_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#beneficiario-modal').modal('show');
	$('#icon').removeClass('icon-pencil');
	$('#icon').addClass('icon-plus');
	$('.beneficiario-modal-title').text('Nuevo Beneficiario');
	$('#btnSave_ben').attr('disabled',true);
    $('#cedula_ben').attr('disabled',false);
}

function edit_beneficiario(id_ben){
	save_method = 'update';

	$('#beneficiario_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#btnSave_ben').attr('disabled',false);
    $('#cedula_ben').attr('disabled',true);

	$.ajax({
		url : "http://localhost/parque/index.php/beneficiario/edit_beneficiario/" + id_ben,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('[name="id_ben"]').val(data.id_ben);
			$('[name="cedula"]').val(data.cedula);
			$('[name="nombre"]').val(data.nombre);
			$('[name="telefono"]').val(data.telefono);
			$('[name="direccion"]').val(data.direccion);
			$('#beneficiario-modal').modal('show');
			$('#icon').removeClass('icon-plus');
			$('#icon').addClass('icon-pencil');
			$('.beneficiario-modal-title').text('Actualizar Beneficiario');
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

function save_beneficiario(){
	$('#btnSave_ben').text('Guardando...');
	$('#btnSave_ben').attr('disabled',true); 
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 
    
	var url;

	if(save_method == 'add'){
		url = "http://localhost/parque/index.php/beneficiario/add_beneficiario";
	}
	else{
		url = "http://localhost/parque/index.php/beneficiario/update_beneficiario";
	}

	$.ajax({
		url : url,
		type: "POST",
		data: $('#beneficiario_form').serialize(),
		dataType: "JSON",
		success: function (data){

			if(data.status){
				if(save_method == 'add'){
					message = "¡Beneficiario creado!";
					$('#beneficiario-modal').modal('hide');
				}
				else{
					message = "¡Beneficiario actualizado!";
					$('#beneficiario-modal').modal('hide');
				}

				swal({
					title: "Éxito",
					text: message,
					type: "success"
				}); 
				reload_beneficiarios();
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
                        text: data.error['cedula'],
                        type: "error"
                    }); 
                }
			}
			$('#btnSave_ben').text('Guardar');
			$('#btnSave_ben').attr('disabled',false);
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

function delete_beneficiario(id_ben){  
	swal({
		title: "Advertencia",
		text: "¿Deseas eliminar este beneficiario?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/beneficiario/delete_beneficiario/" + id_ben,
			type: "POST",
			dataType: "JSON",
			success: function (data){
				$('#beneficiario-modal').modal('hide');
				reload_beneficiarios();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El beneficiario fue eliminado!", "success");
	}, function (dismiss){
       	// dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
            swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function reload_beneficiarios(){
	beneficiarios.ajax.reload(null,false);
}