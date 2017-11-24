var save_method;
var cabanas;

$(document).ready(function (){
	cabanas = $('#cabanas').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/cabana/list_cabanas",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

    /*$("#cabana_form").validate({
        rules: {
            numero: {
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

function search_cabana(){
	$('[name="numero"]').parent().removeClass('has-error');
    $('[name="numero"]').parent().removeClass('has-warning');
    $('[name="numero"]').parent().removeClass('has-success');
    $('[name="numero"]').next().empty();

	var numero = $("#numero_cab").val();

	$.ajax({
		url : "http://localhost/parque/index.php/cabana/search_cabana",
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
				$('#btnSave_cab').attr('disabled',true);
			}
			else{
				$('#btnSave_cab').attr('disabled',false);
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

function add_cabana(){
	save_method = 'add';

	$('#cabana_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#cabana-modal').modal('show');
	$('#icon').removeClass('icon-pencil');
	$('#icon').addClass('icon-plus');
	$('.cabana-modal-title').text('Nueva Cabaña');
	$('#btnSave_cab').attr('disabled',true);
    $('#numero_cab').attr('disabled',false);
}

function edit_cabana(id_cab){
	save_method = 'update';

	$('#cabana_form')[0].reset();
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
	$('.help-block').empty();
	$('#btnSave_cab').attr('disabled',false);
    $('#numero_cab').attr('disabled',true);

	$.ajax({
		url : "http://localhost/parque/index.php/cabana/edit_cabana/" + id_cab,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('[name="id_cab"]').val(data.id_cab);
			$('[name="numero"]').val(data.numero);
			$('[name="area"]').val(data.area);
			$('[name="capacidad"]').val(data.capacidad);
			$('#cabana-modal').modal('show');
			$('#icon').removeClass('icon-plus');
			$('#icon').addClass('icon-pencil');
			$('.cabana-modal-title').text('Actualizar Cabaña');
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

function save_cabana(){
	$('#btnSave_cab').text('Guardando...');
	$('#btnSave_cab').attr('disabled',true);
	$('.form-group').removeClass('has-error');
    $('.form-group').removeClass('has-warning');
    $('.form-group').removeClass('has-success');
    $('.help-block').empty(); 

	var url;

	if(save_method == 'add'){
		url = "http://localhost/parque/index.php/cabana/add_cabana";
	}
	else{
		url = "http://localhost/parque/index.php/cabana/update_cabana";
	}

	$.ajax({
		url : url,
		type: "POST",
		data: $('#cabana_form').serialize(),
		dataType: "JSON",
		success: function (data){
			if(data.status){
				if(save_method == 'add'){
					message = "¡Cabaña creada!";
					$('#cabana-modal').modal('hide');
				}
				else{
					message = "¡Cabaña actualizada!";
					$('#cabana-modal').modal('hide');
				}

				swal({
					title: "Éxito",
					text: message,
					type: "success"
				}); 
				reload_cabanas();
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
			$('#btnSave_cab').text('Guardar');
			$('#btnSave_cab').attr('disabled',false);
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

function delete_cabana(id_cab){  
	swal({
		title: "Advertencia",
		text: "¿Deseas eliminar este cabana?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/cabana/delete_cabana/" + id_cab,
			type: "POST",
			dataType: "JSON",
			success: function (data){
				$('#cabana-modal').modal('hide');
				reload_cabanas();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El cabana fue eliminada!", "success");
	}, function (dismiss){
	    // dismiss can be 'cancel', 'overlay',
	    // 'close', and 'timer'
	    if(dismiss === 'cancel'){
	      	swal("Aviso", "¡La eliminación fue cancelada!", "info");
	    }
	})
}

function reload_cabanas(){
cabanas.ajax.reload(null,false);
}