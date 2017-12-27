<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edificio extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('area_model','area');
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('edificio_model','edificio');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('edi_access') == 1)
		{
			$data = array(
	    		'controller' => 'edificios',
				'areas' => $this->area->get_all()
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('edificios/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
            show_404();
		}
	}
	
	public function list_edificios_activos()
	{
		$list = $this->edificio->get_datatables_activos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $edificio)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $edificio->numero;
			$row[] = $edificio->nombre;
			$row[] = $edificio->area;
			if($this->session->userdata('proceso') == "mantenimiento" || $this->session->userdata('proceso') == "mantenimiento_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_edificio('."'".$edificio->id_edi."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_edificio('."'".$edificio->id_edi."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Desactivar" onclick="desactivate_edificio('."'".$edificio->id_edi."'".')">
						<i class="icon-ban"></i>
					</a>';
			}
			else{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_edificio('."'".$edificio->id_edi."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Desactivar" onclick="desactivate_edificio('."'".$edificio->id_edi."'".')">
						<i class="icon-ban"></i>
					</a>';
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->edificio->count_all(),
			"recordsFiltered" => $this->edificio->count_filtered_activos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function list_edificios_inactivos()
	{
		$list = $this->edificio->get_datatables_inactivos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $edificio)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $edificio->numero;
			$row[] = $edificio->nombre;
			$row[] = $edificio->area;
			if($this->session->userdata('proceso') == "mantenimiento" || $this->session->userdata('proceso') == "mantenimiento_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_edificio('."'".$edificio->id_edi."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_edificio('."'".$edificio->id_edi."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Activar" onclick="activate_edificio('."'".$edificio->id_edi."'".')">
						<i class="icon-check"></i>
					</a>';
			}
			else{
				if($this->session->userdata('nivel') == 1)
				{
					$row[] =
						'<a class="btn btn-link" href="javascript:void(0)" title="Activar" onclick="activate_edificio('."'".$edificio->id_edi."'".')">
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
			"recordsTotal" => $this->edificio->count_all(),
			"recordsFiltered" => $this->edificio->count_filtered_inactivos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_edificio()
	{
		$numero = $this->input->get('numero');

		if ($numero!='')
		{
		    $nr = $this->edificio->validate_by_numero($numero);
		    if ($nr > 0)
			{
				$data = array(
				'type' => 'Advertencia',
				'message' => 'El número ya está registrado.',
				'button' => 1
				);
			}
			else if ($nr < 1)
			{
				$data = array(
				'type' => 'Aviso',
				'message' => 'El número está disponible.',
				'button' => 0
				);
			}
	  	}
	  	else if($numero=='')
	  	{
		   	$data = array(
				'type' => 'Error',
				'message' => 'El número es requerido.',
				'button' => 1
			);
	 	}
	   	echo json_encode($data);
	}

	public function add_edificio()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('numero', 'número', 'is_unique[edificios.numero]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'numero' => $this->input->post('numero'),
				'nombre' => $this->input->post('nombre'),
				'area' => $this->input->post('area'),
				'descripcion' => $this->input->post('descripcion'),
				'estado' => 'Activo'
			);

			$bitacora = array(
				'tipo' => 'Edificio',
				'movimiento' => 'Se ha registrado el edificio '.$this->input->post('nombre').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->edificio->save($data);
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

	public function edit_edificio($id_edi)
	{
		$data = $this->edificio->get_by_id($id_edi);
		echo json_encode($data);
	}

	public function update_edificio()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'nombre' => $this->input->post('nombre'),
			'area' => $this->input->post('area'),
			'descripcion' => $this->input->post('descripcion'),
			'estado' => 'Activo'
		);

		$bitacora = array(
			'tipo' => 'Edificio',
			'movimiento' => 'Se ha actualizado al edificio '.$this->input->post('nombre').'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->edificio->update(array('id_edi' => $this->input->post('id_edi')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function activate_edificio($id_edi)
	{
		$query = $this->edificio->get_by_id($id_edi);
		$edificio = $query['nombre'];

		$bitacora = array(
			'tipo' => 'Edificio',
			'movimiento' => 'Se ha activado al edificio '.$edificio.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->edificio->activate_by_id($id_edi);
		echo json_encode(array("status" => TRUE));
	}

	public function desactivate_edificio($id_edi)
	{
		$query = $this->edificio->get_by_id($id_edi);
		$edificio = $query['nombre'];

		$bitacora = array(
			'tipo' => 'Edificio',
			'movimiento' => 'Se ha desactivado al edificio '.$edificio.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->edificio->desactivate_by_id($id_edi);
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
			if($this->input->post('numero') == '')
			{
				$data['inputerror'][] = 'numero';
				$data['error_string'][] = 'El número es requerido.';
				$data['status'] = FALSE;
			}
		}

		if($this->input->post('nombre') == '')
		{
			$data['inputerror'][] = 'nombre';
			$data['error_string'][] = 'El nombre es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('area') == '')
		{
			$data['inputerror'][] = 'area';
			$data['error_string'][] = 'El area es requerida.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}