var empleados_asignados;
var areas_asignadas;
var especies_asignadas;
var implementos_asignados;
var actividades_asignados;

$(document).ready(function (){
	$('.form-group').removeClass('has-error');
    $('.help-block').empty();

	count_empleados();
	count_areas();
	count_especies();
	count_implementos();
	count_actividades();

	censos = $('#censos').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/censo/list_censos",
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
			"url": "http://localhost/parque/index.php/censo/list_empleados_asignados",
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
			"url": "http://localhost/parque/index.php/censo/list_areas_asignadas",
			"type": "POST"
		},

		"columnDefs": [
		{ 
			"targets": [ -1 ],
			"orderable": false,
		},
		],
	});

	especies_asignadas = $('#especies_asignadas').DataTable({ 
		"processing": true,
		"serverSide": true,
		"order": [],

		"ajax":{
			"url": "http://localhost/parque/index.php/censo/list_especies_asignadas",
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
			"url": "http://localhost/parque/index.php/censo/list_implementos_asignados",
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
			"url": "http://localhost/parque/index.php/censo/list_actividades_asignadas",
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
        url : "http://localhost/parque/index.php/censo/process",
        type: "POST",
        data: $('#censo_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status == true){
            	swal({
	                title: "Éxito",
	                text: "¡Censo procesado!",
	                type: "success"
	            });

            	count_empleados();
				count_areas();
				count_especies();
				count_implementos();
				count_actividades();
				reload_empleados();
				reload_areas();
				reload_especies();
				reload_implementos();
				reload_actividades();
				reload_empleados_asignados();
				reload_areas_asignadas();
				reload_especies_asignadas();
				reload_implementos_asignados();
				reload_actividades_asignadas();

				$('#censo_form')[0].reset();
				location.href ="http://localhost/parque/index.php/censo";
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

	            if(data.reason == "especies")
	            {
	            	data.message = "¡No has asignado ninguna especie!";
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

                if(data.inputerror |= false){
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

function control(id_cen){
	$.ajax({
		success: function (data){
			location.href ="http://localhost/parque/index.php/censo/control/" + id_cen;
		}
	});
}  

function update(id_cen){
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    var swalx;

    $.ajax({
        url : "http://localhost/parque/index.php/censo/update/" + id_cen,
        type: "POST",
        data: $('#censo_form').serialize(),
        dataType: "JSON",
        success: function (data){
            if(data.status == true){
            	swal({
	                title: "Éxito",
	                text: "¡Censo actualizado!",
	                type: "success"
	            });

            	count_empleados();
				count_areas();
				count_especies();
				count_implementos();
				count_actividades();
				reload_empleados();
				reload_areas();
				reload_especies();
				reload_implementos();
				reload_actividades();
				reload_empleados_asignados();
				reload_areas_asignadas();
				reload_especies_asignadas();
				reload_implementos_asignados();
				reload_actividades_asignadas();

				$('#censo_form')[0].reset();
				location.href ="http://localhost/parque/index.php/censo";
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

	            if(data.reason == "especies")
	            {
	            	data.message = "¡No has asignado ninguna especie!";
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
		url : "http://localhost/parque/index.php/censo/count_empleados",
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
		url : "http://localhost/parque/index.php/censo/assign_empleado/" + id_emp,
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
			url : "http://localhost/parque/index.php/censo/deny_empleado/" + rowid,
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
		url : "http://localhost/parque/index.php/censo/clear_empleados",
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
		url : "http://localhost/parque/index.php/censo/count_areas",
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
		url : "http://localhost/parque/index.php/censo/assign_area/" + id_are,
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
			url : "http://localhost/parque/index.php/censo/deny_area/" + rowid,
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
		url : "http://localhost/parque/index.php/censo/clear_areas",
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

function count_especies(){
	$.ajax({
		url : "http://localhost/parque/index.php/censo/count_especies",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			$('#count_especies').text(data.count_especies);
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

function assign_especie(id_esp){
	$.ajax({
		url : "http://localhost/parque/index.php/censo/assign_especie/" + id_esp,
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_especies_asignadas();
			count_especies();
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

function deny_especie(rowid){  
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
			url : "http://localhost/parque/index.php/censo/deny_especie/" + rowid,
			type: "GET",
			dataType: "JSON",
			success: function (data){
				swal({
					title: data.title,
					text: data.text,
					type: data.type
				});
				reload_especies_asignadas();
				count_especies();
			},
			error: function (jqXHR, textStatus, errorThrown){
				swal({
					title: "Error",
					text: "¡Ha ocurrido un error!",
					type: "error"
				});
			}
		});
		swal("Éxito", "¡La especie fue denegada!", "success");
	}, function (dismiss){
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
        	swal("Aviso", "¡La eliminación fue cancelada!", "info");
        }
    })
}

function clear_especies(){
	$.ajax({
		url : "http://localhost/parque/index.php/censo/clear_especies",
		type: "GET",
		dataType: "JSON",
		success: function (data){
			swal({
				title: data.title,
				text: data.text,
				type: data.type
			});
			reload_especies_asignadas();
			count_especies();
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

function reload_especies_asignadas(){
	especies_asignadas.ajax.reload(null,false);
}

function count_implementos(){
	$.ajax({
		url : "http://localhost/parque/index.php/censo/count_implementos",
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
		    min: 1,
		    max: stock,
		    step: 1
	 	},
		inputValue: 1,
	  	showCancelButton: true,
	}).then(function (result){
	  	$.ajax({
			url : "http://localhost/parque/index.php/censo/assign_implemento/" + id_imp,
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
			url : "http://localhost/parque/index.php/censo/deny_implemento/" + rowid,
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
		url : "http://localhost/parque/index.php/censo/clear_implementos",
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
		url : "http://localhost/parque/index.php/censo/count_actividades",
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

function add_actividad2(){
    $('#actividad_form2')[0].reset();
    $('#actividad-modal2').modal('show');
    $('.actividad-modal-title2').text('Asignar actividad');
    $('#icon').addClass('icon-plus');

    $.ajax({
		url : "http://localhost/parque/index.php/censo/select_empleados_asignados",
		type: "GET",
		dataType: "JSON",
		success: function (data){ 
			$.each(data.empleados, function(i, empleado) {
	            $('#select_empleados_asignados').append('<option value="'+ i + empleado +'">' + data.empleados['nombre'] + '<option/>');
	        });
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

function assign_actividad(id_act){
	swal({
	  	title: '¿Quién se encargará de esta actividad?',
  		input: 'select',
  		inputOptions: {
    		'Esmeralda Navarro': 'Esmeralda Navarro',
    		'Luciano Moncada': 'Luciano Moncada',
    		'Yonathan Moncada': 'Yonathan Moncada'
		},
		type: "question",
		inputPlaceholder: 'Selecciona un empleado',
		inputValue: false,
  		showCancelButton: true,
		}).then(function (result){
	  	$.ajax({
			url : "http://localhost/parque/index.php/censo/assign_actividad/" + id_act,
			type: "GET",
			data: {'encargado':result},
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
	})
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
			url : "http://localhost/parque/index.php/censo/deny_actividad/" + rowid,
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
		url : "http://localhost/parque/index.php/censo/clear_actividades",
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