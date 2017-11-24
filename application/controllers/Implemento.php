<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Implemento extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('categoria_model','categoria');
		$this->load->model('implemento_model','implemento');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE)
		{
			$data = array(
	    		'controller' => 'implementos',
				'categorias' => $this->categoria->get_all()
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('implementos/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
            show_404();
		}
	}
	
	public function list_implementos()
	{
		$list = $this->implemento->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $implemento)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $implemento->codigo;
			$row[] = $implemento->nombre;
			$row[] = $implemento->categoria;
			$row[] = $implemento->stock;
			$row[] = $implemento->unidad;
			if($this->session->userdata('proceso') == "censo" || $this->session->userdata('proceso') == "censo_control" || $this->session->userdata('proceso') == "donacion" || $this->session->userdata('proceso') == "donacion_control" || $this->session->userdata('proceso') == "mantenimiento" || $this->session->userdata('proceso') == "mantenimiento_control" || $this->session->userdata('proceso') == "reforestacion" || $this->session->userdata('proceso') == "reforestacion_control" || $this->session->userdata('proceso') == "servicio" || $this->session->userdata('proceso') == "servicio_control"){
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Agregar" onclick="assign_implemento('."'".$implemento->id_imp."','".$implemento->stock."'".')">
						<i class="icon-plus"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_implemento('."'".$implemento->id_imp."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_implemento('."'".$implemento->id_imp."'".')">
						<i class="icon-trash"></i>
					</a>';
			}
			else{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_implemento('."'".$implemento->id_imp."'".')">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_implemento('."'".$implemento->id_imp."'".')">
						<i class="icon-trash"></i>
					</a>';
			}
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->implemento->count_all(),
			"recordsFiltered" => $this->implemento->count_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_implemento()
	{
		$codigo = $this->input->get('codigo');

		if ($codigo!='')
		{
		    $nr = $this->implemento->validate_by_codigo($codigo);
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

	public function validate_stock()
	{
		$stock = $this->input->get('stock');
		$stock_min = $this->input->get('stock_min');
		$stock_max = $this->input->get('stock_max');

		if($stock < 0)
	    {
			$data = array(
				'type' => 'Advertencia',
				'message' => 'El stock no puede ser menor que 0.',
				'button' => 1,
				'input0' => TRUE,
				'input1' => FALSE,
				'input2' => FALSE
			);
	    }

	    else if($stock_min < 0)
	    {
			$data = array(
				'type' => 'Advertencia',
				'message' => 'El stock mínimo no puede ser menor que 0.',
				'button' => 1,
				'input1' => TRUE,
				'input0' => FALSE,
				'input2' => FALSE
			);
	    }

	    else if($stock_max < 0)
	    {
			$data = array(
				'type' => 'Advertencia',
				'message' => 'El stock máximo no puede ser menor que 0.',
				'button' => 1,
				'input2' => TRUE,
				'input0' => FALSE,
				'input1' => FALSE
			);
	    }
		else if ($stock!='' && $stock_min!='' && $stock_max!='')
 		{
		    if ($stock < $stock_min)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'El stock no puede ser menor al stock mínimo.',
					'button' => 1,
					'input0' => TRUE,
					'input1' => TRUE
				);
			}
			else if ($stock > $stock_max)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'El stock no puede ser mayor al stock máximo.',
					'button' => 1,
					'input0' => TRUE,
					'input2' => TRUE
				);
			}
			else if ($stock_min > $stock_max)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'El stock mínimo no puede ser mayor al stock máximo.',
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
				'type' => false
			);
		}
	   	echo json_encode($data);
	}

	public function add_implemento()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('codigo', 'código', 'is_unique[implementos.codigo]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'codigo' => $this->input->post('codigo'),
				'nombre' => $this->input->post('nombre'),
				'categoria' => $this->input->post('categoria'),
				'stock' => $this->input->post('stock'),
				'stock_min' => $this->input->post('stock_min'),
				'stock_max' => $this->input->post('stock_max'),
				'unidad' => $this->input->post('unidad'),
				'estado' => 'Activo'
			);

			$bitacora = array(
				'tipo' => 'Implemento',
				'movimiento' => 'Se ha registrado el implemento '.$this->input->post('nombre').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->implemento->save($data);
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

	public function edit_implemento($id_imp)
	{
		$data = $this->implemento->get_by_id($id_imp);
		echo json_encode($data);
	}

	public function update_implemento()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'nombre' => $this->input->post('nombre'),
			'categoria' => $this->input->post('categoria'),
			'stock' => $this->input->post('stock'),
			'stock_min' => $this->input->post('stock_min'),
			'stock_max' => $this->input->post('stock_max'),
			'unidad' => $this->input->post('unidad'),
			'estado' => 'Activo'
		);

		$bitacora = array(
			'tipo' => 'Implemento',
			'movimiento' => 'Se ha actualizado el implemento '.$this->input->post('nombre').'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->implemento->update(array('id_imp' => $this->input->post('id_imp')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete_implemento($id_imp)
	{
		$query = $this->implemento->get_by_id($id_imp);
		$implemento = $query['nombre'];

		$bitacora = array(
			'tipo' => 'Implemento',
			'movimiento' => 'Se ha eliminado el implemento '.$implemento.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->implemento->delete_by_id($id_imp);
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

		if($this->input->post('categoria') == '')
		{
			$data['inputerror'][] = 'categoria';
			$data['error_string'][] = 'La categoria es requerida.';
			$data['status'] = FALSE;
		}

		if($this->input->post('stock') == '')
		{
			$data['inputerror'][] = 'stock';
			$data['error_string'][] = 'El stock es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('stock_min') == '')
		{
			$data['inputerror'][] = 'stock_min';
			$data['error_string'][] = 'El stock mínimo es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('stock_max') == '')
		{
			$data['inputerror'][] = 'stock_max';
			$data['error_string'][] = 'El stock máximo es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('unidad') == '')
		{
			$data['inputerror'][] = 'unidad';
			$data['error_string'][] = 'La unidad es requerida.';
			$data['status'] = FALSE;
		}


		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}