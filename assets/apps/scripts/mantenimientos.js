var empleados_asignados;
var areas_asignadas;
var edificios_asignados;
var implementos_asignados;
var actividades_asignados;

$(document).ready(function (){
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

	count_empleados();
	count_areas();
	count_edificios();
	count_implementos();
	count_actividades();
	count_actividades_realizadas();

	mantenimientos_pendientes = $('#mantenimientos_pendientes').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/mantenimiento/list_mantenimientos_pendientes",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	mantenimientos_en_progresos = $('#mantenimientos_en_progresos').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/mantenimiento/list_mantenimientos_en_progresos",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	mantenimientos_finalizados = $('#mantenimientos_finalizados').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/mantenimiento/list_mantenimientos_finalizados",
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
			"url": "http://localhost/parque/index.php/mantenimiento/list_empleados_asignados",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	areas_asignadas = $('#areas_asignadas').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/mantenimiento/list_areas_asignadas",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	edificios_asignados = $('#edificios_asignados').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/mantenimiento/list_edificios_asignados",
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
			"url": "http://localhost/parque/index.php/mantenimiento/list_implementos_asignados",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	actividades_asignadas = $('#actividades_asignadas').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/mantenimiento/list_actividades_asignadas",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	actividades_realizadas = $('#actividades_realizadas').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/mantenimiento/list_actividades_realizadas",
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
        url : "http://localhost/parque/index.php/mantenimiento/process",
        type: "POST",
        data: $('#mantenimiento_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status == true){
            	swal({
	                title: "Éxito",
	                text: "¡Mantenimiento procesado!",
	                type: "success"
	            });

            	count_empleados();
				count_areas();
				count_edificios();
				count_implementos();
				count_actividades();
				reload_empleados();
				reload_areas();
				reload_edificios();
				reload_implementos();
				reload_actividades();
				reload_empleados_asignados();
				reload_areas_asignadas();
				reload_edificios_asignados();
				reload_implementos_asignados();
				reload_actividades_asignadas();

				$('#mantenimiento_form')[0].reset();
				location.href ="http://localhost/parque/index.php/mantenimiento";
            }
            else
            {
            	if(data.reason == "carros")
                {
	            	data.message = "¡No has asignado ningún elemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "empleados")
	            {
	            	data.message = "¡No has asignado ningún empleado!";
	            	swalx = 1;
	            }

	            if(data.reason == "areas")
	            {
	            	data.message = "¡No has asignado ninguna area!";
	            	swalx = 1;
	            }

	            if(data.reason == "edificios")
	            {
	            	data.message = "¡No has asignado ningún edificio!";
	            	swalx = 1;
	            }

	            if(data.reason == "implementos")
	            {
	            	data.message = "¡No has asignado ningún implemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "actividades")
	            {
	            	data.message = "!No has asignado ninguna actividad¡";
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

function control(id_man){
	$.ajax({
		success: function (data){
			location.href ="http://localhost/parque/index.php/mantenimiento/control/" + id_man;
		}
	});
}  

function update(id_man){
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    var swalx;
    
    $.ajax({
        url : "http://localhost/parque/index.php/mantenimiento/update/" + id_man,
        type: "POST",
        data: $('#mantenimiento_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status == true){
            	swal({
	                title: "Éxito",
	                text: "¡Mantenimiento actualizado!",
	                type: "success"
	            });

            	count_empleados();
				count_areas();
				count_edificios();
				count_implementos();
				count_actividades();
				reload_empleados();
				reload_areas();
				reload_edificios();
				reload_implementos();
				reload_actividades();
				reload_empleados_asignados();
				reload_areas_asignadas();
				reload_edificios_asignados();
				reload_implementos_asignados();
				reload_actividades_asignadas();

				$('#mantenimiento_form')[0].reset();
				location.href ="http://localhost/parque/index.php/mantenimiento";
            }
            else
            {
            	if(data.reason == "carros")
                {
	            	data.message = "¡No has asignado ningún elemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "empleados")
	            {
	            	data.message = "¡No has asignado ningún empleado!";
	            	swalx = 1;
	            }

	            if(data.reason == "areas")
	            {
	            	data.message = "¡No has asignado ninguna area!";
	            	swalx = 1;
	            }

	            if(data.reason == "edificios")
	            {
	            	data.message = "¡No has asignado ningún edificio!";
	            	swalx = 1;
	            }

	            if(data.reason == "implementos")
	            {
	            	data.message = "¡No has asignado ningún implemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "actividades")
	            {
	            	data.message = "!No has asignado ninguna actividad¡";
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

function end(id_man){
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    var swalx;

    $.ajax({
        url : "http://localhost/parque/index.php/mantenimiento/end/" + id_man,
        type: "POST",
        data: $('#mantenimiento_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status == true){
            	swal({
	                title: "Éxito",
	                text: "¡Mantenimiento finalizado!",
	                type: "success"
	            });

            	count_empleados();
				count_areas();
				count_implementos();
				count_actividades();
				count_actividades_realizadas();
				reload_empleados();
				reload_areas();
				reload_edificios();
				reload_implementos();
				reload_actividades();
				reload_empleados_asignados();
				reload_areas_asignadas();
				reload_implementos_asignados();
				reload_actividades_asignadas();
				reload_actividades_realizadas();

				$('#mantenimiento_form')[0].reset();
				location.href ="http://localhost/parque/index.php/mantenimiento";
            }
            else
            {
            	if(data.reason == "carros")
                {
	            	data.message = "¡No has asignado ningún elemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "empleados")
	            {
	            	data.message = "¡No has asignado ningún empleado!";
	            	swalx = 1;
	            }

	            if(data.reason == "areas")
	            {
	            	data.message = "¡No has asignado ningún area!";
	            	swalx = 1;
	            }

	            if(data.reason == "edificios")
	            {
	            	data.message = "¡No has asignado ningún edificio!";
	            	swalx = 1;
	            }

	            if(data.reason == "implementos")
	            {
	            	data.message = "¡No has asignado ningún implemento!";
	            	swalx = 1;
	            }

	            if(data.reason == "actividades")
	            {
	            	data.message = "¡No has asignado ninguna actividad!";
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

function count_empleados(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/count_empleados",
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
		url : "http://localhost/parque/index.php/mantenimiento/assign_empleado/" + id_emp,
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
			url : "http://localhost/parque/index.php/mantenimiento/deny_empleado/" + rowid,
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
		url : "http://localhost/parque/index.php/mantenimiento/clear_empleados",
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

function count_areas(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/count_areas",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_areas').text(data.count_areas);
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

function assign_area(id_are){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/assign_area/" + id_are,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_areas_asignadas();
			count_areas();
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

function deny_area(rowid){  
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
			url : "http://localhost/parque/index.php/mantenimiento/deny_area/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_areas_asignadas();
				count_areas();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El área fue denegada!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_areas(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/clear_areas",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_areas_asignadas();
			count_areas();
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

function reload_areas_asignadas(){
	areas_asignadas.ajax.reload(null,false);
}

function count_edificios(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/count_edificios",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_edificios').text(data.count_edificios);
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

function assign_edificio(id_edi){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/assign_edificio/" + id_edi,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_edificios_asignados();
			count_edificios();
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

function deny_edificio(rowid){  
	swal({
		title: "Advertencia",
		text: "¿Deseas denegar este edificio?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/mantenimiento/deny_edificio/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_edificios_asignados();
				count_edificios();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡El fue denegado!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_edificios(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/clear_edificios",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_edificios_asignados();
			count_edificios();
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

function reload_edificios_asignados(){
	edificios_asignados.ajax.reload(null,false);
}

function count_implementos(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/count_implementos",
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
			url : "http://localhost/parque/index.php/mantenimiento/assign_implemento/" + id_imp,
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
			url : "http://localhost/parque/index.php/mantenimiento/deny_implemento/" + rowid,
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
		url : "http://localhost/parque/index.php/mantenimiento/clear_implementos",
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

function count_actividades(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/count_actividades",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_actividades').text(data.count_actividades);
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

function assign_actividad_empleado(id_act){
    $('#actividad-empleado_form')[0].reset();
    $('#actividad-empleado-modal').modal('show');
    $('[name="id_act"]').val(id_act);
    $('.actividad-empleado-modal-title').text('Asignar actividad al empleado');
    $('#icon').addClass('icon-plus');
}

function assign_actividad(id_act){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/assign_actividad/" + id_act,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_actividades_asignadas();
			count_actividades();
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

function deny_actividad(rowid){  
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
			url : "http://localhost/parque/index.php/mantenimiento/deny_actividad/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_actividades_asignadas();
				count_actividades();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡La actividad fue denegada!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_actividades(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/clear_actividades",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_actividades_asignadas();
			count_actividades();
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

function reload_actividades_asignadas(){
	actividades_asignadas.ajax.reload(null,false);
}

function count_actividades_realizadas(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/count_actividades_realizadas",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_actividades_realizadas').text(data.count_actividades_realizadas);
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

function assign_actividad_realizada(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/assign_actividad_realizada",
		type: "POST",
        data: $('#actividad-empleado_form').serialize(),
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
    		$('#actividad-empleado-modal').modal('hide');
			reload_actividades_realizadas();
			count_actividades_realizadas();
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

function deny_actividad_realizada(rowid){  
	swal({
		title: "Advertencia",
		text: "¿Deseas denegar esta actividad?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#f8ac59",
		confirmButtonText: "Sí",
		cancelButtonText: "No"
	}).then(function (){
		$.ajax({
			url : "http://localhost/parque/index.php/mantenimiento/deny_actividad_realizada/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_actividades_realizadas();
				count_actividades_realizadas();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡La actividad fue denegada!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_actividades_realizadas(){
	$.ajax({
		url : "http://localhost/parque/index.php/mantenimiento/clear_actividades_realizadas",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_actividades_realizadas();
			count_actividades_realizadas();
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

function reload_actividades_realizadas(){
	actividades_realizadas.ajax.reload(null,false);
}