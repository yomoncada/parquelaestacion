<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cancha extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('area_model','area');
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('cancha_model','cancha');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE)
		{
			$data = array(
	    		'controller' => 'canchas',
				'areas' => $this->area->get_all()
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('canchas/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
        	show_404();
		}
	}
	
	public function list_canchas()
	{
		$list = $this->cancha->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $cancha)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $cancha->numero;
			$row[] = $cancha->nombre;
			$row[] = $cancha->area;
			$row[] = $cancha->capacidad;
			if($this->session->userdata('proceso') == "servicio" || $this->session->userdata('proceso') == "servicio_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_cancha('."'".$cancha->id_can."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_cancha('."'".$cancha->id_can."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_cancha('."'".$cancha->id_can."'".')">
						<i class="icon-trash"></i>
					</a>';
			}
			else{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_cancha('."'".$cancha->id_can."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_cancha('."'".$cancha->id_can."'".')">
						<i class="icon-trash"></i>
					</a>';
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->cancha->count_all(),
			"recordsFiltered" => $this->cancha->count_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_cancha()
	{
		$numero = $this->input->get('numero');

		if ($numero!='')
		{
		    $nr = $this->cancha->validate_by_numero($numero);
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

	public function add_cancha()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('numero', 'número', 'is_unique[canchas.numero]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'numero' => $this->input->post('numero'),
				'nombre' => $this->input->post('nombre'),
				'area' => $this->input->post('area'),
				'capacidad' => $this->input->post('capacidad'),
				'disponibilidad' => 'Desocupada',
				'estado' => 'Activa'
			);

			$bitacora = array(
				'tipo' => 'Cancha',
				'movimiento' => 'Se ha registrado la cancha número '.$this->input->post('numero').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->cancha->save($data);
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

	public function edit_cancha($id_can)
	{
		$data = $this->cancha->get_by_id($id_can);
		echo json_encode($data);
	}

	public function update_cancha()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'nombre' => $this->input->post('nombre'),
			'area' => $this->input->post('area'),
			'capacidad' => $this->input->post('capacidad'),
			'estado' => 'Activa'
		);

		$query = $this->cancha->get_by_id($this->input->post('id_can'));
		$cancha = $query['numero'];

		$bitacora = array(
			'tipo' => 'Cancha',
			'movimiento' => 'Se ha actualizado la cancha número '.$cancha.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->cancha->update(array('id_can' => $this->input->post('id_can')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete_cancha($id_can)
	{
		$query = $this->cancha->get_by_id($id_can);
		$cancha = $query['numero'];

		$bitacora = array(
			'tipo' => 'Cancha',
			'movimiento' => 'Se ha eliminado el cancha número '.$cancha.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->cancha->delete_by_id($id_can);
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

		if($this->input->post('capacidad') == '')
		{
			$data['inputerror'][] = 'capacidad';
			$data['error_string'][] = 'La capacidad es requerida.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}