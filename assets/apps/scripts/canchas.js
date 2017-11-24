var save_method;
var canchas;

$(document).ready(function (){
	canchas = $('#canchas').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/cancha/list_canchas",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

    /*$("#cancha_form").validate({
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
          	capacidad: {
                required: true
            }
        }
    });*/
});

function search_cancha(){
	$('[name="numero"]').parent().removeClass('has-error');
    $('[name="numero"]').parent().removeClass('has-warning');
    $('[name="numero"]').parent().removeClass('has-success');
    $('[name="numero"]').next().empty();

	var numero = $("#numero_can").val();

	$.ajax({
		url : "http://localhost/parque/index.php/cancha/search_cancha",
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
				$('#btnSave_can').attr('disabled',true);
			}
			else{
				$('#btnSave_can').attr('disabled',false);
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

function add_cancha(){
	save_method = 'add';

	$('#cancha_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#cancha-modal').modal('show');
	$('#icon').removeClass('icon-pencil');
	$('#icon').addClass('icon-plus');
	$('.cancha-modal-title').text('Nueva Cancha');
	$('#btnSave_can').attr('disabled',true);
    $('#numero_can').attr('disabled',false);
}

function edit_cancha(id_can){
	save_method = 'update';

	$('#cancha_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#btnSave_can').attr('disabled',false);
    $('#numero_can').attr('disabled',true);

	$.ajax({
		url : "http://localhost/parque/index.php/cancha/edit_cancha/" + id_can,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('[name="id_can"]').val(data.id_can);
			$('[name="numero"]').val(data.numero);
			$('[name="nombre"]').val(data.nombre);
			$('[name="area"]').val(data.area);
			$('[name="capacidad"]').val(data.capacidad);
			$('#cancha-modal').modal('show');
			$('#icon').removeClass('icon-plus');
			$('#icon').addClass('icon-pencil');
			$('.cancha-modal-title').text('Actualizar Cancha');
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

function save_cancha(){
	$('#btnSave_can').text('Guardando...');
	$('#btnSave_can').attr('disabled',true);
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 

	var url;

	if(save_method == 'add'){
		url = "http://localhost/parque/index.php/cancha/add_cancha";
	}
	else{
		url = "http://localhost/parque/index.php/cancha/update_cancha";
	}

	$.ajax({
		url : url,
		type: "POST",
		data: $('#cancha_form').serialize(),
		dataType: "JSON",
		success: function (data){
			if(data.status){
				if(save_method == 'add'){
					message = "¡Cancha creada!";
					$('#cancha-modal').modal('hide');
				}
				else{
					message = "¡Cancha actualizada!";
					$('#cancha-modal').modal('hide');
				}

				swal({
					title: "Éxito",
					text: message,
					type: "success"
				}); 
				reload_canchas();
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
			$('#btnSave_can').text('Guardar');
			$('#btnSave_can').attr('disabled',false);
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

function delete_cancha(id_can){  
	swal({
		title: "Advertencia",
		text: "¿Deseas eliminar este cancha?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/cancha/delete_cancha/" + id_can,
			type: "POST",
			dataType: "JSON",
			success: function (data){
				$('#cancha-modal').modal('hide');
				reload_canchas();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡La cancha fue eliminada!", "success");
	}, function (dismiss){
      	// dismiss can be 'cancel', 'overlay',
      	// 'close', and 'timer'
      	if(dismiss === 'cancel'){
      		swal("Aviso", "¡La eliminación fue cancelada!", "info");
      	}
    })
}

function reload_canchas(){
	canchas.ajax.reload(null,false);
}