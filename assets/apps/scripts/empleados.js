var save_method;
var empleados;

$(document).ready(function (){
	empleados = $('#empleados').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/empleado/list_empleados",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

    /*$("#empleado_form").validate({
        rules: {
            cedula: {
                required: true
            },
            nombre: {
                required: true
            },
            cargo: {
                required: true
            },
            turno: {
                required: true
            },
            telefono: {
                required: true
            },
            email: {
                required: true
            },
            direccion: {
                required: true
            }
        }
    });*/
});

function search_empleado(){
	$('[name="cedula"]').parent().removeClass('has-error');
    $('[name="cedula"]').parent().removeClass('has-warning');
    $('[name="cedula"]').parent().removeClass('has-success');
    $('[name="cedula"]').next().empty();

    var cedula = $("#cedula_emp").val();

	$.ajax({
		url : "http://localhost/parque/index.php/empleado/search_empleado",
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
				$('#btnSave_emp').attr('disabled',true);
			}
			else{
				$('#btnSave_emp').attr('disabled',false);
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

function add_empleado(){
	save_method = 'add';

	$('#empleado_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#empleado-modal').modal('show');
	$('.empleado-modal-title').text('Nuevo Empleado');
	$('#icon').removeClass('icon-pencil');
	$('#icon').addClass('icon-plus');
	$('#btnSave_emp').attr('disabled',true);
    $('#cedula_emp').attr('disabled',false);
}

function edit_empleado(id_emp){
	save_method = 'update';

	$('#empleado_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#btnSave_emp').attr('disabled',false);
    $('#cedula_emp').attr('disabled',true);

	$.ajax({
		url : "http://localhost/parque/index.php/empleado/edit_empleado/" + id_emp,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('[name="id_emp"]').val(data.id_emp);
			$('[name="cedula"]').val(data.cedula);
			$('[name="nombre"]').val(data.nombre);
			$('[name="cargo"]').val(data.cargo);
			$('[name="turno"]').val(data.turno);
			$('[name="telefono"]').val(data.telefono);
			$('[name="email"]').val(data.email);
			$('[name="direccion"]').val(data.direccion);
			$('#empleado-modal').modal('show');
			$('#icon').removeClass('icon-plus');
			$('#icon').addClass('icon-pencil');
			$('.empleado-modal-title').text('Actualizar Empleado');
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

function save_empleado(){
	$('#btnSave_emp').text('Guardando...');
	$('#btnSave_emp').attr('disabled',true); 
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 

	var url;

	if(save_method == 'add'){
		url = "http://localhost/parque/index.php/empleado/add_empleado";
	}
	else{
		url = "http://localhost/parque/index.php/empleado/update_empleado";
	}

	$.ajax({
		url : url,
		type: "POST",
		data: $('#empleado_form').serialize(),
		dataType: "JSON",
		success: function (data){
			if(data.status){
				if(save_method == 'add'){
					message = "¡Empleado creado!";
					$('#empleado-modal').modal('hide');
				}
				else{
					message = "¡Empleado actualizado!";
					$('#empleado-modal').modal('hide');
				}

				swal({
					title: "Éxito",
					text: message,
					type: "success"
				}); 
				reload_empleados();
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
                    if(data.error['cedula'] == null)
                	{
	                    swal({
	                        title: "Error",
	                        html: data.error['email'],
	                        type: "error"
	                    }); 
	                }
	                if(data.error['email'] == null)
	                {
	                	swal({
	                        title: "Error",
	                        html: data.error['cedula'],
	                        type: "error"
	                    }); 
	                }
	                if(data.error['email'] != null && data.error['cedula'] != null)
	                {
	                	swal({
	                        title: "Error",
	                        html: data.error['cedula'] + '<br>' + data.error['email'],
	                        type: "error"
	                    }); 
	                }
                }
			}
			$('#btnSave_emp').text('Guardar');
			$('#btnSave_emp').attr('disabled',false);
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

function delete_empleado(id_emp){  
	swal({
		title: "Advertencia",
		text: "¿Deseas eliminar este empleado?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/empleado/delete_empleado/" + id_emp,
			type: "POST",
			dataType: "JSON",
			success: function (data){
				$('#empleado-modal').modal('hide');
				reload_empleados();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El empleado fue eliminado!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if(dismiss === 'cancel'){
          	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function reload_empleados(){
	empleados.ajax.reload(null,false);
}