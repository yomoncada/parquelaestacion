<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('categoria_model','categoria');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE)
		{
			$data = array(
	    		'controller' => 'categorias',
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('categorias/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
        	show_404();
		}
	}
	
	public function list_categorias()
	{
		$list = $this->categoria->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $categoria)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $categoria->categoria;
			$row[] = $categoria->descripcion;
			$row[] = '<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_categoria('."'".$categoria->id_cat."'".')">
						<i class="icon-pencil"></i>
					  </a>
					  <a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="delete_categoria('."'".$categoria->id_cat."'".')">
						<i class="icon-trash"></i>
					  </a>';
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->categoria->count_all(),
			"recordsFiltered" => $this->categoria->count_filtered(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_categoria()
	{
		$nombre = $this->input->get('nombre');

		if ($nombre!='')
		{
		    $nr = $this->categoria->validate_by_nombre($nombre);
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

	public function add_categoria()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('categoria', 'nombre', 'is_unique[categorias.categoria]');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'categoria' => $this->input->post('categoria'),
				'descripcion' => $this->input->post('descripcion'),
				'estado' => 'Activa'
			);

			$bitacora = array(
				'tipo' => 'Categoría',
				'movimiento' => 'Se ha registrado la categoría '.$this->input->post('categoria').'.',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->categoria->save($data);
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

	public function edit_categoria($id_cat)
	{
		$data = $this->categoria->get_by_id($id_cat);
		echo json_encode($data);
	}

	public function update_categoria()
	{
		$save_method = "update";
		$this->_validate($save_method);
		$data = array(
			'descripcion' => $this->input->post('descripcion'),
			'estado' => 'Activa'
		);

		$query = $this->categoria->get_by_id($this->input->post('id_cat'));
		$categoria = $query['categoria'];

		$bitacora = array(
			'tipo' => 'Categoría',
			'movimiento' => 'Se ha actualizado la categoría '.$categoria.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->categoria->update(array('id_cat' => $this->input->post('id_cat')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete_categoria($id_cat)
	{
		$query = $this->categoria->get_by_id($id_cat);
		$categoria = $query['categoria'];

		$bitacora = array(
			'tipo' => 'Categoría',
			'movimiento' => 'Se ha eliminado la categoría '.$categoria.'.',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->categoria->delete_by_id($id_cat);
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
			if($this->input->post('categoria') == '')
			{
				$data['inputerror'][] = 'categoria';
				$data['error_string'][] = 'El nombre es requerido.';
				$data['status'] = FALSE;
			}
		}

		if($this->input->post('descripcion') == '')
		{
			$data['inputerror'][] = 'descripcion';
			$data['error_string'][] = 'La descripción es requerida.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}