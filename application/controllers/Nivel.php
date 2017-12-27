<?php
class Nivel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('nivel_model','nivel');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('niv_access') == 1)
		{
			$data = array(
	    		'controller' => 'niveles',
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('niveles/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
        	show_404();
		}
	}
	
	public function list_niveles_activos()
	{
		$list = $this->nivel->get_datatables_activos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $nivel)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $nivel->nivel;
			$row[] = '<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_nivel('."'".$nivel->id_niv."'".')">
						<i class="icon-pencil"></i>
					  </a>
					  <a class="btn btn-link" href="javascript:void(0)" title="Desactivar" onclick="desactivate_nivel('."'".$nivel->id_niv."'".')">
						<i class="icon-ban"></i>
					  </a>';
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->nivel->count_all(),
			"recordsFiltered" => $this->nivel->count_filtered_activos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function list_niveles_inactivos()
	{
		$list = $this->nivel->get_datatables_inactivos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $nivel)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $nivel->nivel;
			if($this->session->userdata('nivel') == 1)
			{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Activar" onclick="activate_nivel('."'".$nivel->id_niv."'".')">
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
			"recordsTotal" => $this->nivel->count_all(),
			"recordsFiltered" => $this->nivel->count_filtered_inactivos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_nivel()
	{
		$nombre = $this->input->get('nombre');

		if ($nombre!='')
		{
		    $nr = $this->nivel->validate_by_nombre($nombre);
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

	public function add_nivel()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('nivel', 'nombre', 'is_unique[niveles.nivel]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'nivel' => $this->input->post('nivel'),
				'are_access' => $this->input->post('are_access'),
				'ben_access' => $this->input->post('ben_access'),
				'cab_access' => $this->input->post('cab_access'),
				'can_access' => $this->input->post('can_access'),
				'car_access' => $this->input->post('car_access'),
				'cat_access' => $this->input->post('cat_access'),
				'don_access' => $this->input->post('don_access'),
				'edi_access' => $this->input->post('edi_access'),
				'emp_access' => $this->input->post('emp_access'),
				'esp_access' => $this->input->post('esp_access'),
				'imp_access' => $this->input->post('imp_access'),
				'cen_access' => $this->input->post('cen_access'),
				'dnc_access' => $this->input->post('dnc_access'),
				'man_access' => $this->input->post('man_access'),
				'ref_access' => $this->input->post('ref_access'),
				'ser_access' => $this->input->post('ser_access'),
				'bd_access' => $this->input->post('bd_access'),
				'bit_access' => $this->input->post('bit_access'),
				'niv_access' => $this->input->post('niv_access'),
				'usu_access' => $this->input->post('usu_access'),
				'descripcion' => $this->input->post('descripcion'),
				'estado' => 'Activo'
			);

			$bitacora = array(
				'tipo' => 'Nivel',
				'movimiento' => 'Se ha registrado el nivel '.$this->input->post('nivel').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->nivel->save($data);
			echo json_encode(array("status" => TRUE));
			echo json_encode($data);
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

	public function edit_nivel($id_niv)
	{
		$data = $this->nivel->get_by_id($id_niv);
		echo json_encode($data);
	}

	public function update_nivel()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'are_access' => $this->input->post('are_access'),
			'ben_access' => $this->input->post('ben_access'),
			'cab_access' => $this->input->post('cab_access'),
			'can_access' => $this->input->post('can_access'),
			'car_access' => $this->input->post('car_access'),
			'cat_access' => $this->input->post('cat_access'),
			'don_access' => $this->input->post('don_access'),
			'edi_access' => $this->input->post('edi_access'),
			'emp_access' => $this->input->post('emp_access'),
			'esp_access' => $this->input->post('esp_access'),
			'imp_access' => $this->input->post('imp_access'),
			'cen_access' => $this->input->post('cen_access'),
			'dnc_access' => $this->input->post('dnc_access'),
			'man_access' => $this->input->post('man_access'),
			'ref_access' => $this->input->post('ref_access'),
			'ser_access' => $this->input->post('niv_access'),
			'bd_access' => $this->input->post('bd_access'),
			'bit_access' => $this->input->post('bit_access'),
			'niv_access' => $this->input->post('niv_access'),
			'usu_access' => $this->input->post('usu_access'),
			'descripcion' => $this->input->post('descripcion'),
			'estado' => 'Activo'
		);

		$query = $this->nivel->get_by_id($this->input->post('id_niv'));

		$bitacora = array(
			'tipo' => 'Nivel',
			'movimiento' => 'Se ha actualizado el nivel '.$query->nivel.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->nivel->update(array('id_niv' => $this->input->post('id_niv')), $data);
		echo json_encode(array("status" => TRUE));

		if($this->session->userdata('nivel') == $this->input->post('id_niv'))
		{
			$this->session->sess_destroy();
			$this->db->truncate('ci_sessions');
		}
	}

	public function activate_nivel($id_niv)
	{
		$query = $this->nivel->get_by_id($id_niv);

		$bitacora = array(
			'tipo' => 'Nivel',
			'movimiento' => 'Se ha activado el nivel '.$query->nivel.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->nivel->activate_by_id($id_niv);
		echo json_encode(array("status" => TRUE));
	}

	public function desactivate_nivel($id_niv)
	{
		$query = $this->nivel->get_by_id($id_niv);

		$bitacora = array(
			'tipo' => 'Nivel',
			'movimiento' => 'Se ha desactivado el nivel '.$query->nivel.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->nivel->desactivate_by_id($id_niv);
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
			if($this->input->post('nivel') == '')
			{
				$data['inputerror'][] = 'nivel';
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