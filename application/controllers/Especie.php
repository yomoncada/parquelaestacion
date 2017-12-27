<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Especie extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('especie_model','especie');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('esp_access') == 1)
		{
			$data = array(
	    		'controller' => 'especies',
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('especies/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
			$this->load->view('errors/html/error_404');
		}
	}

	public function list_especies_activas()
	{
		$list = $this->especie->get_datatables_activas();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $especie)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $especie->codigo;
			$row[] = $especie->nom_cmn;
			$row[] = $especie->tipo;
			$row[] = $especie->poblacion;
			if($this->session->userdata('proceso') == "censo" || $this->session->userdata('proceso') == "censo_control" || $this->session->userdata('proceso') == "reforestacion" || $this->session->userdata('proceso') == "reforestacion_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_especie('."'".$especie->id_esp."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_especie('."'".$especie->id_esp."'".')">
						<i class="icon-pencil"></i>
					</a>';
			}
			else{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_especie('."'".$especie->id_esp."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Desactivar" onclick="desactivate_especie('."'".$especie->id_esp."'".')">
						<i class="icon-ban"></i>
					</a>';
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->especie->count_all(),
			"recordsFiltered" => $this->especie->count_filtered_activas(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function list_especies_inactivas()
	{
		$list = $this->especie->get_datatables_inactivas();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $especie)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $especie->codigo;
			$row[] = $especie->nom_cmn;
			$row[] = $especie->tipo;
			$row[] = $especie->poblacion;
			if($this->session->userdata('nivel') == 1)
			{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Activar" onclick="activate_especie('."'".$especie->id_esp."'".')">
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
			"recordsTotal" => $this->especie->count_all(),
			"recordsFiltered" => $this->especie->count_filtered_inactivas(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_especie()
	{
		$codigo = $this->input->get('codigo');

		if ($codigo!='')
		{
		    $nr = $this->especie->validate_by_codigo($codigo);
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

	public function validate_poblacion()
	{
		$poblacion = $this->input->get('poblacion');
		$riesgo = $this->input->get('riesgo');
		$extincion = $this->input->get('extincion');

		if($poblacion == ' ' || $riesgo == ' ' || $extincion == ' ')
		{
			$data = array(
				'button' => 1
			);
		}
		else if($poblacion < 0)
	    {
			$data = array(
				'type' => 'Advertencia',
				'message' => 'La población no puede ser menor que 0.',
				'button' => 1,
				'input0' => TRUE,
				'input1' => FALSE,
				'input2' => FALSE
			);
	    }

	    else if($riesgo < 0)
	    {
			$data = array(
				'type' => 'Advertencia',
				'message' => 'El riesgo no puede ser menor que 0.',
				'button' => 1,
				'input1' => TRUE,
				'input0' => FALSE,
				'input2' => FALSE
			);
	    }

	    else if($extincion < 0)
	    {
			$data = array(
				'type' => 'Advertencia',
				'message' => 'La extinción no puede ser menor que 0.',
				'button' => 1,
				'input2' => TRUE,
				'input0' => FALSE,
				'input1' => FALSE
			);
	    }
	    else if($poblacion!='' && $riesgo!='' || $riesgo!='' && $extincion!='' || $poblacion!='' && $extincion!='')
	   	{
	   		if ($poblacion == $riesgo)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'La población no puede ser igual que el riesgo.',
					'button' => 1,
					'input0' => TRUE,
					'input1' => TRUE
				);
			}
			else if ($poblacion == $extincion)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'La población no puede ser igual que la extincion.',
					'button' => 1,
					'input0' => TRUE,
					'input2' => TRUE
				);
			}
			else if ($riesgo == $extincion)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'El riesgo no puede ser igual que la extincion.',
					'button' => 1,
					'input1' => TRUE,
					'input2' => TRUE
				);
			}
			else
			{
				$data = array(
					'type' => 'Aviso',
					'button' => 0
				);
			}
	   	}
		else if ($poblacion!='' && $riesgo!='' && $extincion!='')
 		{
		    if ($poblacion < $extincion)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'La población no puede ser menor que la extincion.',
					'button' => 1,
					'input0' => TRUE,
					'input1' => TRUE
				);
			}
			else if($riesgo > $poblacion)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'El riesgo no puede ser mayor que la población.',
					'button' => 1,
					'input1' => TRUE,
					'input2' => TRUE
				);
			}
			else if($riesgo < $extincion)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'El riesgo no puede ser menor que la extinción.',
					'button' => 1,
					'input1' => TRUE,
					'input2' => TRUE
				);
			}
			else
			{
				$data = array(
					'type' => 'Aviso',
					'button' => 0
				);
			}
	  	}
	  	else
	  	{
			$data = array(
				'type' => FALSE
			);
		}
	   	echo json_encode($data);
	}

	public function add_especie()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('codigo', 'código', 'is_unique[especies.codigo]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'codigo' => $this->input->post('codigo'),
				'nom_cmn' => $this->input->post('nom_cmn'),
				'nom_cntfc' => $this->input->post('nom_cntfc'),
				'flia' => $this->input->post('flia'),
				'tipo' => $this->input->post('tipo'),
				'poblacion' => $this->input->post('poblacion'),
				'riesgo' => $this->input->post('riesgo'),
				'extincion' => $this->input->post('extincion'),
				'estado' => 'Activa',
			);

			$bitacora = array(
				'tipo' => 'Especie',
				'movimiento' => 'Se ha registrado el especie '.$this->input->post('nom_cmn').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->especie->save($data);
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

	public function edit_especie($id_esp)
	{
		$data = $this->especie->get_by_id($id_esp);
		echo json_encode($data);
	}

	public function update_especie()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'nom_cmn' => $this->input->post('nom_cmn'),
			'nom_cntfc' => $this->input->post('nom_cntfc'),
			'flia' => $this->input->post('flia'),
			'tipo' => $this->input->post('tipo'),
			'poblacion' => $this->input->post('poblacion'),
			'riesgo' => $this->input->post('riesgo'),
			'extincion' => $this->input->post('extincion'),
			'estado' => 'Activa',
		);

		$bitacora = array(
			'tipo' => 'Especie',
			'movimiento' => 'Se ha actualizado el especie '.$this->input->post('nom_cmn').'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->especie->update(array('id_esp' => $this->input->post('id_esp')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function activate_especie($id_esp)
	{
		$query = $this->especie->get_by_id($id_esp);
		$especie = $query['nom_cmn'];

		$bitacora = array(
			'tipo' => 'Especie',
			'movimiento' => 'Se ha activado el especie '.$especie.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->especie->activate_by_id($id_esp);
		echo json_encode(array("status" => TRUE));
	}

	public function desactivate_especie($id_esp)
	{
		$query = $this->especie->get_by_id($id_esp);
		$especie = $query['nom_cmn'];

		$bitacora = array(
			'tipo' => 'Especie',
			'movimiento' => 'Se ha desactivado el especie '.$especie.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->especie->desactivate_by_id($id_esp);
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

		if($this->input->post('nom_cmn') == '')
		{
			$data['inputerror'][] = 'nom_cmn';
			$data['error_string'][] = 'El nombre común es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('nom_cntfc') == '')
		{
			$data['inputerror'][] = 'nom_cntfc';
			$data['error_string'][] = 'El nombre cientifico es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('flia') == '')
		{
			$data['inputerror'][] = 'flia';
			$data['error_string'][] = 'El nombre de la familia cientifica es requerida.';
			$data['status'] = FALSE;
		}

		if($this->input->post('tipo') == '')
		{
			$data['inputerror'][] = 'tipo';
			$data['error_string'][] = 'El tipo es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('poblacion') == '')
		{
			$data['inputerror'][] = 'poblacion';
			$data['error_string'][] = 'El rango de población es requerida.';
			$data['status'] = FALSE;
		}

		if($this->input->post('riesgo') == '')
		{
			$data['inputerror'][] = 'riesgo';
			$data['error_string'][] = 'El rango de riesgo es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('extincion') == '')
		{
			$data['inputerror'][] = 'extincion';
			$data['error_string'][] = 'El rango de extincion es requerido.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}