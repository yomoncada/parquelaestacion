var beneficiarios_asignados;
var cabanas_asignadas;
var canchas_asignadas;
var empleados_asignados;
var implementos_asignados;
var invitados_asignados;

$(document).ready(function (){
	$('.form-group').removeClass('has-error');
    $('.help-block').empty();

	count_beneficiarios();
	count_cabanas();
	count_canchas();
	count_empleados();
	count_implementos();
	count_invitados();

	servicios_pendientes = $('#servicios_pendientes').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/servicio/list_servicios_pendientes",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	servicios_en_progresos = $('#servicios_en_progresos').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/servicio/list_servicios_en_progresos",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	servicios_finalizados = $('#servicios_finalizados').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/servicio/list_servicios_finalizados",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	beneficiarios_asignados = $('#beneficiarios_asignados').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/servicio/list_beneficiarios_asignados",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	cabanas_asignadas = $('#cabanas_asignadas').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/servicio/list_cabanas_asignadas",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	canchas_asignadas = $('#canchas_asignadas').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/servicio/list_canchas_asignadas",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	empleados_asignados = $('#empleados_asignados').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/servicio/list_empleados_asignados",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	implementos_asignados = $('#implementos_asignados').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/servicio/list_implementos_asignados",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	invitados_asignados = $('#invitados_asignados').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/servicio/list_invitados_asignados",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});
});

function process(){
	$('.form-group').removeClass('has-error');
    $('.help-block').empty();

    var swalx;

    $.ajax({
        url : "http://localhost/parque/index.php/servicio/process",
        type: "POST",
        data: $('#servicio_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status == true){
            	swal({
	                title: "Éxito",
	                text: "¡Servicio procesado!.",
	                type: "success"
	            });

            	count_beneficiarios();
            	count_cabanas();
            	count_canchas();
            	count_empleados();
				count_implementos();
				count_invitados();
				reload_beneficiarios();
				reload_cabanas();
				reload_canchas();
				reload_empleados();
				reload_implementos();
				reload_beneficiarios_asignados();
				reload_cabanas_asignadas();
				reload_canchas_asignadas();
				reload_empleados_asignados();
				reload_implementos_asignados();
				reload_invitados_asignados();

				$('#servicio_form')[0].reset();
				location.href ="http://localhost/parque/index.php/servicio";
            }
            else
            {
            	if(data.reason == "carros")
                {
	            	data.message = "¡No has asignado ningún elemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "beneficiarios")
	            {
	            	data.message = "¡No has asignado ningún beneficiario!";
	            	swalx = 1;
	            }

	            if(data.reason == "servicio")
	            {
	            	data.message = "¡No has asignado ninguna cabaña y/o cancha deportiva!";
	            	swalx = 1;
	            }

	            if(data.reason == "canchas")
	            {
	            	data.message = "¡No has asignado ninguna cancha!";
	            	swalx = 1;
	            }

	            if(data.reason == "implementos")
	            {
	            	data.message = "¡No has asignado ningún implemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "empleados")
	            {
	            	data.message = "¡No has asignado ningún empleado!";
	            	swalx = 1;
	            }

	            if(data.reason == "invitados")
	            {
	            	data.message = "¡No has asignado ningún invitado!";
	            	swalx = 1;
	            }

	            if(swalx == 1){
	            	swal({
		                title: "Error",
		                text: data.message,
		                type: "error"
		            });
	            }

                if(data.inputerror){
	                for(var i = 0; i < data.inputerror.length; i++){
	                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
	                    $('.'+data.inputerror[i]).text(data.error_string[i]);
	                    $('.'+data.inputerror[i]).css('color','red');
	            	}
	            }
	            else if(data.error)
                {
                	if(data.error['fecha'] == null)
                	{
	                    swal({
	                        title: "Error",
	                        html: data.error['hora'],
	                        type: "error"
	                    }); 
	                }
	                if(data.error['hora'] == null)
	                {
	                	swal({
	                        title: "Error",
	                        html: data.error['fecha'],
	                        type: "error"
	                    }); 
	                }
	                if(data.error['hora'] != null && data.error['fecha'] != null)
	                {
	                	swal({
	                        title: "Error",
	                        html: data.error['fecha'] + '<br>' + data.error['hora'],
	                        type: "error"
	                    }); 
	                }
                }
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

function control(id_ser){
	$.ajax({
		success: function (data){
			location.href ="http://localhost/parque/index.php/servicio/control/" + id_ser;
		}
	});
}  

function update(id_ser){
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    var swalx;

    $.ajax({
        url : "http://localhost/parque/index.php/servicio/update/" + id_ser,
        type: "POST",
        data: $('#servicio_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status == true){
            	swal({
	                title: "Éxito",
	                text: "¡Servicio actualizado!.",
	                type: "success"
	            });

            	count_beneficiarios();
            	count_cabanas();
            	count_canchas();
            	count_empleados();
				count_implementos();
				count_invitados();
				reload_beneficiarios();
				reload_cabanas();
				reload_canchas();
				reload_empleados();
				reload_implementos();
				reload_beneficiarios_asignados();
				reload_cabanas_asignadas();
				reload_canchas_asignadas();
				reload_empleados_asignados();
				reload_implementos_asignados();
				reload_invitados_asignados();

				$('#servicio_form')[0].reset();
				location.href ="http://localhost/parque/index.php/servicio";
            }
            else
            {
            	if(data.reason == "carros")
                {
	            	data.message = "¡No has asignado ningún elemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "beneficiarios")
	            {
	            	data.message = "¡No has asignado ningún beneficiario!";
	            	swalx = 1;
	            }

	            if(data.reason == "servicio")
	            {
	            	data.message = "¡No has asignado ninguna cabañas y/o canchas deportiva!";
	            	swalx = 1;
	            }

	            if(data.reason == "implementos")
	            {
	            	data.message = "!No has asignado ningún implemento¡";
	            	swalx = 1;
	            }

	            if(data.reason == "empleados")
	            {
	            	data.message = "¡No has asignado ningún empleado!";
	            	swalx = 1;
	            }

	            if(data.reason == "invitados")
	            {
	            	data.message = "¡No has asignado ningún invitado!";
	            	swalx = 1;
	            }

	            if(swalx == 1){
	            	swal({
		                title: "Error",
		                text: data.message,
		                type: "error"
		            });
	            }

                if(data.inputerror){
	                for(var i = 0; i < data.inputerror.length; i++){
	                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
	                    $('.'+data.inputerror[i]).text(data.error_string[i]);
	                    $('.'+data.inputerror[i]).css('color','red');
	            	}
	            }
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

function update(id_ser){
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    var swalx;

    $.ajax({
        url : "http://localhost/parque/index.php/servicio/update/" + id_ser,
        type: "POST",
        data: $('#servicio_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status == true){
            	swal({
	                title: "Éxito",
	                text: "¡Servicio actualizado!.",
	                type: "success"
	            });

            	count_beneficiarios();
            	count_cabanas();
            	count_canchas();
            	count_empleados();
				count_implementos();
				count_invitados();
				reload_beneficiarios();
				reload_cabanas();
				reload_canchas();
				reload_empleados();
				reload_implementos();
				reload_beneficiarios_asignados();
				reload_cabanas_asignadas();
				reload_canchas_asignadas();
				reload_empleados_asignados();
				reload_implementos_asignados();
				reload_invitados_asignados();

				$('#servicio_form')[0].reset();
				location.href ="http://localhost/parque/index.php/servicio";
            }
            else
            {
            	if(data.reason == "carros")
                {
	            	data.message = "¡No has asignado ningún elemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "beneficiarios")
	            {
	            	data.message = "¡No has asignado ningún beneficiario!";
	            	swalx = 1;
	            }

	            if(data.reason == "servicio")
	            {
	            	data.message = "¡No has asignado ninguna cabañas y/o canchas deportiva!";
	            	swalx = 1;
	            }

	            if(data.reason == "implementos")
	            {
	            	data.message = "!No has asignado ningún implemento¡";
	            	swalx = 1;
	            }

	            if(data.reason == "empleados")
	            {
	            	data.message = "¡No has asignado ningún empleado!";
	            	swalx = 1;
	            }

	            if(data.reason == "invitados")
	            {
	            	data.message = "¡No has asignado ningún invitado!";
	            	swalx = 1;
	            }

	            if(swalx == 1){
	            	swal({
		                title: "Error",
		                text: data.message,
		                type: "error"
		            });
	            }

                if(data.inputerror){
	                for(var i = 0; i < data.inputerror.length; i++){
	                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
	                    $('.'+data.inputerror[i]).text(data.error_string[i]);
	                    $('.'+data.inputerror[i]).css('color','red');
	            	}
	            }
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

function end(id_ser){
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    var swalx;

    $.ajax({
        url : "http://localhost/parque/index.php/servicio/end/" + id_ser,
        type: "POST",
        data: $('#servicio_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status == true){
            	swal({
	                title: "Éxito",
	                text: "¡Servicio finalizado!.",
	                type: "success"
	            });

            	count_beneficiarios();
            	count_cabanas();
            	count_canchas();
            	count_empleados();
				count_implementos();
				count_invitados();
				reload_beneficiarios();
				reload_cabanas();
				reload_canchas();
				reload_empleados();
				reload_implementos();
				reload_beneficiarios_asignados();
				reload_cabanas_asignadas();
				reload_canchas_asignadas();
				reload_empleados_asignados();
				reload_implementos_asignados();
				reload_invitados_asignados();

				$('#servicio_form')[0].reset();
				location.href ="http://localhost/parque/index.php/servicio";
            }
            else
            {
            	if(data.reason == "carros")
                {
	            	data.message = "¡No has asignado ningún elemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "beneficiarios")
	            {
	            	data.message = "¡No has asignado ningún beneficiario!";
	            	swalx = 1;
	            }

	            if(data.reason == "servicio")
	            {
	            	data.message = "¡No has asignado ninguna cabañas y/o canchas deportiva!";
	            	swalx = 1;
	            }

	            if(data.reason == "implementos")
	            {
	            	data.message = "!No has asignado ningún implemento¡";
	            	swalx = 1;
	            }

	            if(data.reason == "empleados")
	            {
	            	data.message = "¡No has asignado ningún empleado!";
	            	swalx = 1;
	            }

	            if(data.reason == "invitados")
	            {
	            	data.message = "¡No has asignado ningún invitado!";
	            	swalx = 1;
	            }

	            if(swalx == 1){
	            	swal({
		                title: "Error",
		                text: data.message,
		                type: "error"
		            });
	            }

                if(data.inputerror){
	                for(var i = 0; i < data.inputerror.length; i++){
	                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
	                    $('.'+data.inputerror[i]).text(data.error_string[i]);
	                    $('.'+data.inputerror[i]).css('color','red');
	            	}
	            }
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

function report(id_ser){
	$.ajax({
		success: function (data){
			location.href ="http://localhost/parque/index.php/servicio/report/" + id_ser;
		}
	});
}

function count_beneficiarios(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/count_beneficiarios",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_beneficiarios').text(data.count_beneficiarios);
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

function assign_beneficiario(id_ben){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/assign_beneficiario/" + id_ben,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_beneficiarios_asignados();
			count_beneficiarios();
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

function deny_beneficiario(rowid){  
	swal({
		title: "Advertencia",
		text: "¿Deseas denegar este beneficiario?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/servicio/deny_beneficiario/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_beneficiarios_asignados();
				count_beneficiarios();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El beneficiario fue denegado!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_beneficiarios(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/clear_beneficiarios",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_beneficiarios_asignados();
			count_beneficiarios();
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

function reload_beneficiarios_asignados(){
	beneficiarios_asignados.ajax.reload(null,false);
}

function count_cabanas(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/count_cabanas",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_cabanas').text(data.count_cabanas);
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

function assign_cabana(id_cab){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/assign_cabana/" + id_cab,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_cabanas_asignadas();
			count_cabanas();
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

function deny_cabana(rowid){  
	swal({
		title: "Advertencia",
		text: "¿Deseas denegar esta cabana?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/servicio/deny_cabana/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_cabanas_asignadas();
				count_cabanas();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡La cabana fue denegada!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_cabanas(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/clear_cabanas",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_cabanas_asignadas();
			count_cabanas();
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

function reload_cabanas_asignadas(){
	cabanas_asignadas.ajax.reload(null,false);
}

function count_canchas(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/count_canchas",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_canchas').text(data.count_canchas);
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

function assign_cancha(id_can){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/assign_cancha/" + id_can,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_canchas_asignadas();
			count_canchas();
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

function deny_cancha(rowid){  
	swal({
		title: "Advertencia",
		text: "¿Deseas denegar esta cancha?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/servicio/deny_cancha/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_canchas_asignadas();
				count_canchas();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡La cancha fue denegada!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_canchas(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/clear_canchas",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_canchas_asignadas();
			count_canchas();
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

function reload_canchas_asignadas(){
	canchas_asignadas.ajax.reload(null,false);
}

function count_implementos(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/count_implementos",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_implementos').text(data.count_implementos);
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

function assign_implemento(id_imp, stock){
	swal({
	  	title: '¿Cuántas unidades se utilizarán?',
	  	type: 'question',
	  	input: 'range',
	  	inputAttributes: {
		    min: 0,
		    max: stock,
		    step: 1
	 	},
		inputValue: 0,
	  	showCancelButton: true,
	}).then(function (result){
	  	$.ajax({
			url : "http://localhost/parque/index.php/servicio/assign_implemento/" + id_imp,
			type: "GET",
			data: {'cantidad':result},
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_implementos_asignados();
				count_implementos();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
	})
}

function deny_implemento(rowid){  
	swal({
		title: "Advertencia",
		text: "¿Deseas denegar esta área?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/servicio/deny_implemento/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_implementos_asignados();
				count_implementos();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El implemento fue denegado!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_implementos(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/clear_implementos",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_implementos_asignados();
			count_implementos();
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

function reload_implementos_asignados(){
	implementos_asignados.ajax.reload(null,false);
}

function count_empleados(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/count_empleados",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_empleados').text(data.count_empleados);
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

function assign_empleado(id_emp){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/assign_empleado/" + id_emp,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_empleados_asignados();
			count_empleados();
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

function deny_empleado(rowid){  
	swal({
		title: "Advertencia",
		text: "¿Deseas denegar este empleado?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/servicio/deny_empleado/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_empleados_asignados();
				count_empleados();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El empleado fue denegado!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_empleados(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/clear_empleados",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_empleados_asignados();
			count_empleados();
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

function reload_empleados_asignados(){
	empleados_asignados.ajax.reload(null,false);
}

function count_invitados(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/count_invitados",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_invitados').text(data.count_invitados);
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

function add_invitado(){
    $('#invitado_form')[0].reset();
    $('#invitado-modal').modal('show');
    $('.invitado-modal-title').text('Asignar invitado');
    $('#icon').addClass('icon-plus');
}

function assign_invitado(){
	$('.form-group').removeClass('has-error');
	$('.help-block').empty();
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/assign_invitado",
		type: "POST",
		data: $('#invitado_form').serialize(),
		dataType: "JSON",
		success: function (data){
            if(data.status){
				$('#invitado-modal').modal('hide');

				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_invitados_asignados();
				count_invitados();
			}
			else
			{
				if(data.inputerror)
                {
                    for(var i = 0; i < data.inputerror.length; i++){
                        $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error');
	                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                    }
                }
                else if(data.swalx)
                {
	                swal({
						title: data.title,
						text: data.text,
						type: data.type
					});
					$('#invitado-modal').modal('hide');
	            }
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

function deny_invitado(rowid){  
	swal({
		title: "Advertencia",
		text: "¿Deseas denegar este invitado?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/servicio/deny_invitado/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_invitados_asignados();
				count_invitados();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El invitado fue denegado!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_invitados(){
	$.ajax({
		url : "http://localhost/parque/index.php/servicio/clear_invitados",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_invitados_asignados();
			count_invitados();
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

function reload_invitados_asignados(){
	invitados_asignados.ajax.reload(null,false);
}