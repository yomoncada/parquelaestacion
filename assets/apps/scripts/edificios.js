var save_method;
var edificios;

$(document).ready(function (){
	edificios = $('#edificios').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/edificio/list_edificios",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

    /*$("#edificio_form").validate({
        rules: {
            numero: {
                required: true
            },
            nombre: {
                required: true   
            },
            area: {
                required: true
            },
            descripcion: {
                required: true
            }
        }
    });*/
});

function search_edificio(){
	$('[name="numero"]').parent().removeClass('has-error');
    $('[name="numero"]').parent().removeClass('has-warning');
    $('[name="numero"]').parent().removeClass('has-success');
    $('[name="numero"]').next().empty();

    var numero = $("#numero_edi").val();

	$.ajax({
		url : "http://localhost/parque/index.php/edificio/search_edificio",
		type: 'GET',
		data: {'numero':numero},
		dataType: 'JSON',
		success: function (data){
			switch(data.type){
                case 'Advertencia':
                    $('[name="numero"]').parent().addClass('has-warning');
                    $('[name="numero"]').next().text(data.message);  
                break;

                case 'Aviso':
                    $('[name="numero"]').parent().addClass('has-success');
                    $('[name="numero"]').next().text(data.message);  
                break;

                case 'Error':
                    $('[name="numero"]').parent().addClass('has-error');
                    $('[name="numero"]').next().text(data.message);  
                break;
            }

			if(data.button == 1){
				$('#btnSave_edi').attr('disabled',true);
			}
			else{
				$('#btnSave_edi').attr('disabled',false);
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

function add_edificio(){
	save_method = 'add';

	$('#edificio_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#edificio-modal').modal('show');
	$('.edificio-modal-title').text('Nuevo Edificio');
	$('#icon').removeClass('icon-pencil');
	$('#icon').addClass('icon-plus');
	$('#btnSave_edi').attr('disabled',true);
    $('#numero_edi').attr('disabled',false);
}

function edit_edificio(id_edi){
	save_method = 'update';

	$('#edificio_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#btnSave_edi').attr('disabled',false);
    $('#numero_edi').attr('disabled',true);

	$.ajax({
		url : "http://localhost/parque/index.php/edificio/edit_edificio/" + id_edi,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('[name="id_edi"]').val(data.id_edi);
			$('[name="numero"]').val(data.numero);
			$('[name="nombre"]').val(data.nombre);
			$('[name="area"]').val(data.area);
			$('[name="descripcion"]').val(data.descripcion);
			$('#edificio-modal').modal('show');
			$('#icon').removeClass('icon-plus');
			$('#icon').addClass('icon-pencil');
			$('.edificio-modal-title').text('Actualizar Edificio');
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

function save_edificio(){
	$('#btnSave_edi').text('Guardando...');
	$('#btnSave_edi').attr('disabled',true); 
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 

	var url;

	if(save_method == 'add'){
		url = "http://localhost/parque/index.php/edificio/add_edificio";
	}
	else{
		url = "http://localhost/parque/index.php/edificio/update_edificio";
	}

	$.ajax({
		url : url,
		type: "POST",
		data: $('#edificio_form').serialize(),
		dataType: "JSON",
		success: function (data){
			if(data.status){
				if(save_method == 'add'){
					message = "¡Edificio creado!";
					$('#edificio-modal').modal('hide');
				}
				else{
					message = "¡Edificio actualizado!";
					$('#edificio-modal').modal('hide');
				}

				swal({
					title: "Éxito",
					text: message,
					type: "success"
				}); 
				reload_edificio();
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
                        text: data.error['numero'],
                        type: "error"
                    }); 
                }
			}
			$('#btnSave_edi').text('Guardar');
			$('#btnSave_edi').attr('disabled',false);
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

function delete_edificio(id_edi){  
	swal({
		title: "Advertencia",
		text: "¿Deseas eliminar este edificio?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/edificio/delete_edificio/" + id_edi,
			type: "POST",
			dataType: "JSON",
			success: function (data)
			{
				$('#edificio-modal').modal('hide');
				reload_edificio();
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
		swal("Éxito", "¡El edificio fue eliminado!", "success");
	}, function (dismiss){
	    // dismiss can be 'cancel', 'overlay',
	    // 'close', and 'timer'
	    if(dismiss === 'cancel'){
	    	swal("Aviso", "¡La eliminación fue cancelada!", "info");
	    }
	})
}

function reload_edificios(){
	edificios.ajax.reload(null,false);
}