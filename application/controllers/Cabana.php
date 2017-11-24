<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabana extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('area_model','area');
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('cabana_model','cabana');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE)
		{
			$data = array(
	    		'controller' => 'cabanas',
				'areas' => $this->area->get_all()
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('cabanas/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
        	show_404();
		}
	}
	
	public function list_cabanas()
	{
		$list = $this->cabana->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $cabana)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $cabana->numero;
			$row[] = $cabana->area;
			$row[] = $cabana->capacidad;
			if($this->session->userdata('proceso') == "servicio" || $this->session->userdata('proceso') == "servicio_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_cabana('."'".$cabana->id_cab."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_cabana('."'".$cabana->id_cab."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_cabana('."'".$cabana->id_cab."'".')">
						<i class="icon-trash"></i>
					</a>';
			}
			else{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_cabana('."'".$cabana->id_cab."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_cabana('."'".$cabana->id_cab."'".')">
						<i class="icon-trash"></i>
					</a>';
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->cabana->count_all(),
			"recordsFiltered" => $this->cabana->count_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_cabana()
	{
		$numero = $this->input->get('numero');

		if ($numero!='')
		{
		    $nr = $this->cabana->validate_by_numero($numero);
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

	public function add_cabana()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('numero', 'número', 'is_unique[cabanas.numero]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'numero' => $this->input->post('numero'),
				'area' => $this->input->post('area'),
				'capacidad' => $this->input->post('capacidad'),
				'disponibilidad' => 'Desocupada',
				'estado' => 'Activa'
			);

			$bitacora = array(
				'tipo' => 'Cabaña',
				'movimiento' => 'Se ha registrado la cabaña número '.$this->input->post('numero').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->cabana->save($data);
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

	public function edit_cabana($id_cab)
	{
		$data = $this->cabana->get_by_id($id_cab);
		echo json_encode($data);
	}

	public function update_cabana()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'area' => $this->input->post('area'),
			'capacidad' => $this->input->post('capacidad'),
			'estado' => 'Activa'
		);

		$query = $this->cabana->get_by_id($this->input->post('id_cab'));
		$cabana = $query['numero'];

		$bitacora = array(
			'tipo' => 'Cabaña',
			'movimiento' => 'Se ha actualizado la cabaña número '.$cabana.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->cabana->update(array('id_cab' => $this->input->post('id_cab')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete_cabana($id_cab)
	{
		$query = $this->cabana->get_by_id($id_cab);
		$cabana = $query['numero'];

		$bitacora = array(
			'tipo' => 'Cabaña',
			'movimiento' => 'Se ha eliminado la cabaña número '.$cabana.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->cabana->delete_by_id($id_cab);
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