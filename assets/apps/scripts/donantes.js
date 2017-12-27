var save_method;
var donantes_activos;
var donantes_inactivos;

$(document).ready(function(){
	donantes_activos = $('#donantes_activos').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/donante/list_donantes_activos",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	donantes_inactivos = $('#donantes_inactivos').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/donante/list_donantes_inactivos",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

    /*$("#donante_form").validate({
        rules: {
            rif: {
                required: true
            },
            razon_social: {
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

function search_donante(){
	$('[name="rif"]').parent().removeClass('has-error');
    $('[name="rif"]').parent().removeClass('has-warning');
    $('[name="rif"]').parent().removeClass('has-success');
    $('[name="rif"]').next().empty();

	var rif = $("#rif_don").val();

	$.ajax({
		url : "http://localhost/parque/index.php/donante/search_donante",
		type: 'GET',
		data: {'rif':rif},
		dataType: 'JSON',
		success: function(data){
			switch(data.type){
                case 'Advertencia':
                    $('[name="rif"]').parent().addClass('has-warning');
                    $('[name="rif"]').next().text(data.message);  
                break;

                case 'Aviso':
                    $('[name="rif"]').parent().addClass('has-success');
                    $('[name="rif"]').next().text(data.message);  
                break;

                case 'Error':
                    $('[name="rif"]').parent().addClass('has-error');
                    $('[name="rif"]').next().text(data.message);  
                break;
            }

			if(data.button == 1){
				$('#btnSave_don').attr('disabled',true);
			}
			else{
				$('#btnSave_don').attr('disabled',false);
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

function add_donante(){
	save_method = 'add';

	$('#donante_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#donante-modal').modal('show');
	$('#icon').removeClass('icon-pencil');
	$('#icon').addClass('icon-plus');
	$('.donante-modal-title').text('Nuevo Donante');
	$('#btnSave_don').attr('disabled',true);
    $('#rif_don').attr('disabled',false);
}

function edit_donante(id_don){
	save_method = 'update';

	$('#donante_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#btnSave_don').attr('disabled',false);
    $('#rif_don').attr('disabled',true);

	$.ajax({
		url : "http://localhost/parque/index.php/donante/edit_donante/" + id_don,
		type: "GET",
		dataType: "JSON",
		success: function(data){
			$('[name="id_don"]').val(data.id_don);
			$('[name="rif"]').val(data.rif);
			$('[name="razon_social"]').val(data.razon_social);
			$('[name="telefono"]').val(data.telefono);
			$('[name="direccion"]').val(data.direccion);
			$('#donante-modal').modal('show');
			$('#icon').removeClass('icon-plus');
			$('#icon').addClass('icon-pencil');
			$('.donante-modal-title').text('Actualizar Donante');
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

function save_donante(){
	$('#btnSave_don').text('Guardando...');
	$('#btnSave_don').attr('disabled',true); 
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 
	var url;

	if(save_method == 'add'){
		url = "http://localhost/parque/index.php/donante/add_donante";
	}
	else{
		url = "http://localhost/parque/index.php/donante/update_donante";
	}

	$.ajax({
		url : url,
		type: "POST",
		data: $('#donante_form').serialize(),
		dataType: "JSON",
		success: function (data){
			if(data.status){
				if(save_method == 'add'){
					message = "¡Donante creado!";
					$('#donante-modal').modal('hide');
				}
				else{
					message = "¡Donante actualizado!";
					$('#donante-modal').modal('hide');
				}

				swal({
					title: "Éxito",
					text: message,
					type: "success"
				}); 
				reload_donantes();
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
                        text: data.error['rif'],
                        type: "error"
                    }); 
                }
			}
			$('#btnSave_don').text('Guardar');
			$('#btnSave_don').attr('disabled',false);
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

function activate_donante(id_don){  
	swal({
		title: "Advertencia",
		text: "¿Deseas activar este donante?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/donante/activate_donante/" + id_don,
			type: "POST",
			dataType: "JSON",
			success: function(data){
				$('#donante-modal').modal('hide');
				reload_donantes();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El donante fue activado!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La activación fue cancelada!", "info");
        }
    })
}

function desactivate_donante(id_don){  
	swal({
		title: "Advertencia",
		text: "¿Deseas desactivar este donante?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/donante/desactivate_donante/" + id_don,
			type: "POST",
			dataType: "JSON",
			success: function(data){
				$('#donante-modal').modal('hide');
				reload_donantes();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El donante fue desactivado!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La desactivación fue cancelada!", "info");
        }
    })
}

function reload_donantes(){
	donantes_activos.ajax.reload(null,false);
	donantes_inactivos.ajax.reload(null,false);
}