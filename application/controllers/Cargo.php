<?php
class Cargo extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('cargo_model','cargo');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE)
		{
			$data = array(
	    		'controller' => 'cargos',
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('cargos/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
        	show_404();
		}
	}
	
	public function list_cargos()
	{
		$list = $this->cargo->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $cargo)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $cargo->cargo;
			$row[] = $cargo->descripcion;
			$row[] = '<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_cargo('."'".$cargo->id_car."'".')">
						<i class="icon-pencil"></i>
					  </a>
					  <a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_cargo('."'".$cargo->id_car."'".')">
						<i class="icon-trash"></i>
					  </a>';
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->cargo->count_all(),
			"recordsFiltered" => $this->cargo->count_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_cargo()
	{
		$nombre = $this->input->get('nombre');

		if ($nombre!='')
		{
		    $nr = $this->cargo->validate_by_nombre($nombre);
		    if ($nr > 0)
			{
				$data = array(
				'type' => 'Advertencia',
				'message' => 'El nombre ya está registrado.',
				'button' => 1
				);
			}
			else if ($nr < 1)
			{
				$data = array(
				'type' => 'Aviso',
				'message' => 'El nombre está disponible.',
				'button' => 0
				);
			}
	  	}
	  	else if($nombre=='')
	  	{
		   	$data = array(
				'type' => 'Error',
				'message' => 'El nombre es requerido.',
				'button' => 1
			);
	 	}
	   	echo json_encode($data);
	}

	public function add_cargo()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('cargo', 'nombre', 'is_unique[cargos.cargo]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'cargo' => $this->input->post('cargo'),
				'descripcion' => $this->input->post('descripcion'),
				'estado' => 'Activo'
			);

			$bitacora = array(
				'tipo' => 'Cargo',
				'movimiento' => 'Se ha registrado el cargo '.$this->input->post('cargo').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->cargo->save($data);
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

	public function edit_cargo($id_car)
	{
		$data = $this->cargo->get_by_id($id_car);
		echo json_encode($data);
	}

	public function update_cargo()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'descripcion' => $this->input->post('descripcion'),
			'estado' => 'Activo'
		);

		$query = $this->cargo->get_by_id($this->input->post('id_car'));
		$cargo = $query['cargo'];

		$bitacora = array(
			'tipo' => 'Cargo',
			'movimiento' => 'Se ha actualizado el cargo '.$cargo.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->cargo->update(array('id_car' => $this->input->post('id_car')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete_cargo($id_car)
	{
		$query = $this->cargo->get_by_id($id_car);
		$cargo = $query['cargo'];

		$bitacora = array(
			'tipo' => 'Cargo',
			'movimiento' => 'Se ha eliminado el cargo '.$cargo.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->cargo->delete_by_id($id_car);
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
			if($this->input->post('cargo') == '')
			{
				$data['inputerror'][] = 'cargo';
				$data['error_string'][] = 'El nombre es requerido.';
				$data['status'] = FALSE;
			}
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}