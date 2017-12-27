<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beneficiario extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('beneficiario_model','beneficiario');
		$this->load->model('bitacora_model','bitacora');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE)
		{
			$data = array(
	    		'controller' => 'beneficiarios',
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('beneficiarios/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
        	show_404();
		}
	}
	
	public function list_beneficiarios_activos()
	{
		$list = $this->beneficiario->get_datatables_activos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $beneficiario)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $beneficiario->cedula;
			$row[] = $beneficiario->nombre;
			$row[] = $beneficiario->telefono;
			$row[] = $beneficiario->direccion;
			if($this->session->userdata('proceso') == "servicio" || $this->session->userdata('proceso') == "servicio_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_beneficiario('."'".$beneficiario->id_ben."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_beneficiario('."'".$beneficiario->id_ben."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Desactivar" onclick="desactivate_beneficiario('."'".$beneficiario->id_ben."'".')">
						<i class="icon-ban"></i>
					</a>';
			}
			else{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_beneficiario('."'".$beneficiario->id_ben."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Desactivar" onclick="desactivate_beneficiario('."'".$beneficiario->id_ben."'".')">
						<i class="icon-ban"></i>
					</a>';
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->beneficiario->count_all(),
			"recordsFiltered" => $this->beneficiario->count_filtered_activos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function list_beneficiarios_inactivos()
	{
		$list = $this->beneficiario->get_datatables_inactivos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $beneficiario)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $beneficiario->cedula;
			$row[] = $beneficiario->nombre;
			$row[] = $beneficiario->telefono;
			$row[] = $beneficiario->direccion;
			if($this->session->userdata('proceso') == "servicio" || $this->session->userdata('proceso') == "servicio_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_beneficiario('."'".$beneficiario->id_ben."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_beneficiario('."'".$beneficiario->id_ben."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Activar" onclick="activate_beneficiario('."'".$beneficiario->id_ben."'".')">
						<i class="icon-check"></i>
					</a>';
			}
			else{
				if($this->session->userdata('nivel') == 1)
				{
					$row[] =
						'<a class="btn btn-link" href="javascript:void(0)" title="Activar" onclick="activate_beneficiario('."'".$beneficiario->id_ben."'".')">
							<i class="icon-check"></i>
						</a>';
				}
				else
				{
					$row[] = 'No puedes realizar ninguna acción.';
				}
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->beneficiario->count_all(),
			"recordsFiltered" => $this->beneficiario->count_filtered_inactivos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_beneficiario()
	{
		$cedula = $this->input->get('cedula');

		if ($cedula!='')
		{
		    $nr = $this->beneficiario->validate_by_cedula($cedula);
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

	public function add_beneficiario()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('cedula', 'cédula', 'is_unique[beneficiarios.cedula]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'cedula' => $this->input->post('cedula'),
				'nombre' => $this->input->post('nombre'),
				'telefono' => $this->input->post('telefono'),
				'direccion' => $this->input->post('direccion'),
				'estado' => 'Activo'
			);

			$bitacora = array(
				'tipo' => 'Beneficiario',
				'movimiento' => 'Se ha registrado al beneficiario '.$this->input->post('nombre').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->beneficiario->save($data);
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

	public function edit_beneficiario($id_ben)
	{
		$data = $this->beneficiario->get_by_id($id_ben);
		echo json_encode($data);
	}

	public function update_beneficiario()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'nombre' => $this->input->post('nombre'),
			'telefono' => $this->input->post('telefono'),
			'direccion' => $this->input->post('direccion'),
			'estado' => 'Activo'
		);

		$bitacora = array(
			'tipo' => 'Beneficiario',
			'movimiento' => 'Se ha actualizado al beneficiario '.$this->input->post('nombre').'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->beneficiario->update(array('id_ben' => $this->input->post('id_ben')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function activate_beneficiario($id_ben)
	{
		$query = $this->beneficiario->get_by_id($id_ben);
		$beneficiario = $query['nombre'];

		$bitacora = array(
			'tipo' => 'Beneficiario',
			'movimiento' => 'Se ha activado al beneficiario '.$beneficiario.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->beneficiario->activate_by_id($id_ben);
		echo json_encode(array("status" => TRUE));
	}

	public function desactivate_beneficiario($id_ben)
	{
		$query = $this->beneficiario->get_by_id($id_ben);
		$beneficiario = $query['nombre'];

		$bitacora = array(
			'tipo' => 'Beneficiario',
			'movimiento' => 'Se ha desactivate al beneficiario '.$beneficiario.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->beneficiario->desactivate_by_id($id_ben);
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

		if($this->input->post('telefono') == '')
		{
			$data['inputerror'][] = 'telefono';
			$data['error_string'][] = 'La telefono es requerida.';
			$data['status'] = FALSE;
		}

		if($this->input->post('direccion') == '')
		{
			$data['inputerror'][] = 'direccion';
			$data['error_string'][] = 'El direccion es requerido.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}