<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('area_model','area');
		$this->load->model('bitacora_model','bitacora');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE)
		{
			$data = array(
	    		'controller' => 'areas',
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('areas/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
        	show_404();
		}
	}
	
	public function list_areas()
	{
		$list = $this->area->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $area)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $area->codigo;
			$row[] = $area->area;
			$row[] = $area->ubicacion;
			if($this->session->userdata('proceso') == "censo" || $this->session->userdata('proceso') == "censo_control" || $this->session->userdata('proceso') == "mantenimiento" || $this->session->userdata('proceso') == "mantenimiento_control" || $this->session->userdata('proceso') == "reforestacion" || $this->session->userdata('proceso') == "reforestacion_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_area('."'".$area->id_are."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_area('."'".$area->id_are."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_area('."'".$area->id_are."'".')">
						<i class="icon-trash"></i>
					</a>';
			}
			else{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_area('."'".$area->id_are."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_area('."'".$area->id_are."'".')">
						<i class="icon-trash"></i>
					</a>';
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->area->count_all(),
			"recordsFiltered" => $this->area->count_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_area()
	{
		$codigo = $this->input->get('codigo');

		if ($codigo!='')
		{
		    $nr = $this->area->validate_by_codigo($codigo);
		    if ($nr > 0)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'El código ya está registrado.',
					'button' => 1
				);
			}
			else if ($nr < 1)
			{
				$data = array(
					'type' => 'Aviso',
					'message' => 'El código está disponible.',
					'button' => 0
				);
			}
	  	}
	  	else if($codigo=='')
	  	{
		   	$data = array(
				'type' => 'Error',
				'message' => 'El código es requerido.',
				'button' => 1
			);
	 	}
	   	echo json_encode($data);
	}

	public function add_area()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('codigo', 'código', 'is_unique[areas.codigo]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'codigo' => $this->input->post('codigo'),
				'area' => $this->input->post('nombre'),
				'ubicacion' => $this->input->post('ubicacion'),
				'estado' => 'Activa'
			);

			$bitacora = array(
				'tipo' => 'Area',
				'movimiento' => 'Se ha registrado el area '.$this->input->post('nombre').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->area->save($data);
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

	public function edit_area($id_are)
	{
		$data = $this->area->get_by_id($id_are);
		echo json_encode($data);
	}

	public function update_area()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'area' => $this->input->post('nombre'),
			'ubicacion' => $this->input->post('ubicacion'),
			'estado' => 'Activa'
		);

		$bitacora = array(
			'tipo' => 'Area',
			'movimiento' => 'Se ha actualizado el area '.$this->input->post('nombre').'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->area->update(array('id_are' => $this->input->post('id_are')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete_area($id_are)
	{
		$query = $this->area->get_by_id($id_are);
		$area = $query['area'];

		$bitacora = array(
			'tipo' => 'Area',
			'movimiento' => 'Se ha eliminado el area '.$area.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->area->delete_by_id($id_are);
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
			if($this->input->post('codigo') == '')
			{
				$data['inputerror'][] = 'codigo';
				$data['error_string'][] = 'El código es requerido.';
				$data['status'] = FALSE;
			}
		}

		if($this->input->post('nombre') == '')
		{
			$data['inputerror'][] = 'nombre';
			$data['error_string'][] = 'El nombre es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('ubicacion') == '')
		{
			$data['inputerror'][] = 'ubicacion';
			$data['error_string'][] = 'La ubicación es requerida.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}