<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleado extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('empleado_model','empleado');
		$this->load->model('cargo_model','cargo');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('emp_access') == 1)
		{
			$data = array(
	    		'controller' => 'empleados',
				'cargos' => $this->cargo->get_all()
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('empleados/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
            show_404();
		}
	}
	
	public function list_empleados_activos()
	{
		$list = $this->empleado->get_datatables_activos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $empleado)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $empleado->cedula;
			$row[] = $empleado->nombre;
			$row[] = $empleado->cargo;
			$row[] = $empleado->turno;
			if($this->session->userdata('proceso') == "censo" || $this->session->userdata('proceso') == "censo_control" || $this->session->userdata('proceso') == "mantenimiento" || $this->session->userdata('proceso') == "mantenimiento_control" || $this->session->userdata('proceso') == "reforestacion" || $this->session->userdata('proceso') == "reforestacion_control" || $this->session->userdata('proceso') == "servicio" || $this->session->userdata('proceso') == "servicio_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_empleado('."'".$empleado->id_emp."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_empleado('."'".$empleado->id_emp."'".')">
						<i class="icon-pencil"></i>
					</a>';
			}
			else{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_empleado('."'".$empleado->id_emp."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Desactivar" onclick="desactivate_empleado('."'".$empleado->id_emp."'".')">
						<i class="icon-ban"></i>
					</a>';
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->empleado->count_all(),
			"recordsFiltered" => $this->empleado->count_filtered_activos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function list_empleados_inactivos()
	{
		$list = $this->empleado->get_datatables_inactivos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $empleado)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $empleado->cedula;
			$row[] = $empleado->nombre;
			$row[] = $empleado->cargo;
			$row[] = $empleado->turno;
			if($this->session->userdata('nivel') == 1)
			{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Activar" onclick="activate_empleado('."'".$empleado->id_emp."'".')">
						<i class="icon-check"></i>
					</a>';
			}
			else
			{
				$row[] = 'No puedes realizar ninguna acción.';
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->empleado->count_all(),
			"recordsFiltered" => $this->empleado->count_filtered_inactivos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_empleado()
	{
		$cedula = $this->input->get('cedula');

		if ($cedula!='')
		{
		    $nr = $this->empleado->validate_by_cedula($cedula);
		    if ($nr > 0)
			{
				$data = array(
				'type' => 'Advertencia',
				'message' => 'La cédula ya está registrado.',
				'button' => 1
				);
			}
			else if ($nr < 1)
			{
				$data = array(
				'type' => 'Aviso',
				'message' => 'La cédula está disponible.',
				'button' => 0
				);
			}
	  	}
	  	else if($cedula=='')
	  	{
		   	$data = array(
				'type' => 'Error',
				'message' => 'La cédula es requerida.',
				'button' => 1
			);
	 	}
	   	echo json_encode($data);
	}

	public function add_empleado()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('cedula', 'cédula', 'is_unique[empleados.cedula]');
   		$this->form_validation->set_rules('email', 'email', 'valid_email');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'cedula' => $this->input->post('cedula'),
				'nombre' => $this->input->post('nombre'),
				'cargo' => $this->input->post('cargo'),
				'turno' => $this->input->post('turno'),
				'telefono' => $this->input->post('telefono'),
				'email' => $this->input->post('email'),
				'direccion' => $this->input->post('direccion'),
				'disponibilidad' => 'Desocupado',
				'estado' => 'Activo'
			);

			$bitacora = array(
				'tipo' => 'Empleado',
				'movimiento' => 'Se ha registrado al empleado '.$this->input->post('nombre').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->empleado->save($data);
			echo json_encode(array("status" => TRUE));
	    }
	    else
	    {
	    	$data = array(
                'error' => $this->form_validation->error_array(),
                'status' => false
            );
            echo json_encode($data);
	    }
	}

	public function edit_empleado($id_emp)
	{
		$data = $this->empleado->get_by_id($id_emp);
		echo json_encode($data);
	}

	public function update_empleado()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'nombre' => $this->input->post('nombre'),
			'cargo' => $this->input->post('cargo'),
			'turno' => $this->input->post('turno'),
			'telefono' => $this->input->post('telefono'),
			'email' => $this->input->post('email'),
			'direccion' => $this->input->post('direccion'),
			'estado' => 'Activo'
		);

		$bitacora = array(
			'tipo' => 'Empleado',
			'movimiento' => 'Se ha actualizado al empleado '.$this->input->post('nombre').'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->empleado->update(array('id_emp' => $this->input->post('id_emp')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function activate_empleado($id_emp)
	{
		$query = $this->empleado->get_by_id($id_emp);
		$empleado = $query['nombre'];

		$bitacora = array(
			'tipo' => 'Empleado',
			'movimiento' => 'Se ha activado el empleado '.$empleado.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->empleado->activate_by_id($id_emp);
		echo json_encode(array("status" => TRUE));
	}

	public function desactivate_empleado($id_emp)
	{
		$query = $this->empleado->get_by_id($id_emp);
		$empleado = $query['nombre'];

		$bitacora = array(
			'tipo' => 'Empleado',
			'movimiento' => 'Se ha desactivado el empleado '.$empleado.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->empleado->desactivate_by_id($id_emp);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate($save_method)
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($save_method == 'add')
		{
			if($this->input->post('cedula') == '')
			{
				$data['inputerror'][] = 'cedula';
				$data['error_string'][] = 'La cédula es requerido.';
				$data['status'] = FALSE;
			}
		}

		if($this->input->post('nombre') == '')
		{
			$data['inputerror'][] = 'nombre';
			$data['error_string'][] = 'El nombre es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('cargo') == '')
		{
			$data['inputerror'][] = 'cargo';
			$data['error_string'][] = 'El cargo es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('turno') == '')
		{
			$data['inputerror'][] = 'turno';
			$data['error_string'][] = 'El turno es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('telefono') == '')
		{
			$data['inputerror'][] = 'telefono';
			$data['error_string'][] = 'El telefono es requerido.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}