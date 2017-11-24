<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actividad extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('actividad_model','actividad');
		$this->load->model('bitacora_model','bitacora');
	}

	public function index()
	{
		$data = array(
    		'controller' => 'actividades',
    	);
	}

	public function list_actividades()
	{
		$list = $this->actividad->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $actividad)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $actividad->accion;
			$row[] = $actividad->tipo;
			$row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="add_actividad2()">
					<i class="icon-plus"></i>
				</a>
				<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_actividad('."'".$actividad->id_act."'".')">
					<i class="icon-pencil"></i>
				</a>
				<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_actividad('."'".$actividad->id_act."'".')">
					<i class="icon-trash"></i>
				</a>';
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->actividad->count_all(),
			"recordsFiltered" => $this->actividad->count_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_actividad()
	{
		$accion = $this->input->get('accion');

		if ($accion!='')
		{
		    $nr = $this->actividad->validate_by_accion($accion);
		    if ($nr > 0)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'La acción ya está registrado.',
					'button' => 1
				);
			}
			else if ($nr < 1)
			{
				$data = array(
					'type' => 'Aviso',
					'message' => 'La acción está disponible.',
					'button' => 0
				);
			}
	  	}
	  	else if($accion=='')
	  	{
		   	$data = array(
				'type' => 'Error',
				'message' => 'La acción es requerida.',
				'button' => 1
			);
	 	}
	   	echo json_encode($data);
	}

	public function add_actividad()
	{
		$this->_validate();
   		$this->form_validation->set_rules('accion', 'acción', 'is_unique[actividades.accion]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'accion' => $this->input->post('accion'),
				'tipo' => $this->input->post('tipo'),
				'estado' => 'Activa'
			);

			$bitacora = array(
				'tipo' => 'Actividad',
				'movimiento' => 'Se ha registrado la actividad '.$this->input->post('accion').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->actividad->save($data);
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

	public function edit_actividad($id_act)
	{
		$data = $this->actividad->get_by_id($id_act);
		echo json_encode($data);
	}

	public function update_actividad()
	{
		$this->_validate();
		$data = array(
			'accion' => $this->input->post('accion'),
			'tipo' => $this->input->post('tipo'),
			'estado' => 'Activa'
		);

		$bitacora = array(
			'tipo' => 'Actividad',
			'movimiento' => 'Se ha actualizado la actividad '.$this->input->post('accion').'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->actividad->update(array('id_act' => $this->input->post('id_act')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete_actividad($id_act)
	{
		$query = $this->actividad->get_by_id($id_act);
		$actividad = $query['accion'];

		$bitacora = array(
			'tipo' => 'Actividad',
			'movimiento' => 'Se ha eliminado la actividad '.$actividad.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->actividad->delete_by_id($id_act);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('accion') == '')
		{
			$data['inputerror'][] = 'accion';
			$data['error_string'][] = 'La accion es requerida.';
			$data['status'] = FALSE;
		}

		if($this->input->post('tipo') == '')
		{
			$data['inputerror'][] = 'tipo';
			$data['error_string'][] = 'El tipo es requerido.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}