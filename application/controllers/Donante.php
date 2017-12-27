<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donante extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('donante_model','donante');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('don_access') == 1)
		{
			$data = array(
	    		'controller' => 'donantes',
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('donantes/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
            show_404();
		}
	}
	
	public function list_donantes_activos()
	{
		$list = $this->donante->get_datatables_activos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $donante)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $donante->rif;
			$row[] = $donante->razon_social;
			$row[] = $donante->telefono;
			$row[] = $donante->direccion;
			if($this->session->userdata('proceso') == "donacion" || $this->session->userdata('proceso') == "donacion_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_donante('."'".$donante->id_don."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_donante('."'".$donante->id_don."'".')">
						<i class="icon-pencil"></i>
					</a>';
			}
			else{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_donante('."'".$donante->id_don."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Desactivar" onclick="desactivate_donante('."'".$donante->id_don."'".')">
						<i class="icon-ban"></i>
					</a>';
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->donante->count_all(),
			"recordsFiltered" => $this->donante->count_filtered_activos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function list_donantes_inactivos()
	{
		$list = $this->donante->get_datatables_inactivos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $donante)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $donante->rif;
			$row[] = $donante->razon_social;
			$row[] = $donante->telefono;
			$row[] = $donante->direccion;
			if($this->session->userdata('nivel') == 1)
			{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Activar" onclick="activate_donante('."'".$donante->id_don."'".')">
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
			"recordsTotal" => $this->donante->count_all(),
			"recordsFiltered" => $this->donante->count_filtered_inactivos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_donante()
	{
		$rif = $this->input->get('rif');

		if ($rif!='')
		{
		    $nr = $this->donante->validate_by_rif($rif);
		    if ($nr > 0)
			{
				$data = array(
				'type' => 'Advertencia',
				'message' => 'El rif ya está registrado.',
				'button' => 1
				);
			}
			else if ($nr < 1)
			{
				$data = array(
				'type' => 'Aviso',
				'message' => 'El rif está disponible.',
				'button' => 0
				);
			}
	  	}
	  	else if($rif=='')
	  	{
		   	$data = array(
				'type' => 'Error',
				'message' => 'El rif es requerido.',
				'button' => 1
			);
	 	}
	   	echo json_encode($data);
	}

	public function add_donante()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('rif', 'rif', 'is_unique[donantes.rif]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'rif' => $this->input->post('rif'),
				'razon_social' => $this->input->post('razon_social'),
				'telefono' => $this->input->post('telefono'),
				'direccion' => $this->input->post('direccion'),
				'estado' => 'Activo'
			);

			$bitacora = array(
				'tipo' => 'Donante',
				'movimiento' => 'Se ha registrado al donante '.$this->input->post('razon_social').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->donante->save($data);
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

	public function edit_donante($id_don)
	{
		$data = $this->donante->get_by_id($id_don);
		echo json_encode($data);
	}

	public function update_donante()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'razon_social' => $this->input->post('razon_social'),
			'telefono' => $this->input->post('telefono'),
			'direccion' => $this->input->post('direccion'),
			'estado' => 'Activo'
		);

		$bitacora = array(
			'tipo' => 'Donante',
			'movimiento' => 'Se ha actualizado al donante '.$this->input->post('razon_social').'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->donante->update(array('id_don' => $this->input->post('id_don')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function activate_donante($id_don)
	{
		$query = $this->donante->get_by_id($id_don);
		$donante = $query['razon_social'];

		$bitacora = array(
			'tipo' => 'Donante',
			'movimiento' => 'Se ha activado al donante '.$donante.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->donante->activate_by_id($id_don);
		echo json_encode(array("status" => TRUE));
	}

	public function desactivate_donante($id_don)
	{
		$query = $this->donante->get_by_id($id_don);
		$donante = $query['razon_social'];

		$bitacora = array(
			'tipo' => 'Donante',
			'movimiento' => 'Se ha desactivado al donante '.$donante.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->donante->desactivate_by_id($id_don);
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
			if($this->input->post('rif') == '')
			{
				$data['inputerror'][] = 'rif';
				$data['error_string'][] = 'El rif es requerido.';
				$data['status'] = FALSE;
			}
		}

		if($this->input->post('razon_social') == '')
		{
			$data['inputerror'][] = 'razon_social';
			$data['error_string'][] = 'La razón social es requerida.';
			$data['status'] = FALSE;
		}

		if($this->input->post('telefono') == '')
		{
			$data['inputerror'][] = 'telefono';
			$data['error_string'][] = 'El télefono es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('direccion') == '')
		{
			$data['inputerror'][] = 'direccion';
			$data['error_string'][] = 'La dirección es requerida.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}