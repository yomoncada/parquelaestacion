<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('usuario_model','usuario');
	}
	
	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('usu_access') == 1)
		{
			$data = array(
	    		'controller' => 'usuarios',
	    	);

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('usuarios/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
	    }
	    else
	    {
        	show_404();
	    }
	}

	public function list_usuarios_activos()
	{
		$list = $this->usuario->get_datatables_activos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $usuario)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $usuario->usuario;
			$row[] = $usuario->nivel;
			$row[] = '	<a class="btn btn-link" href="http://localhost/parque/index.php/perfil/view/'.$usuario->usuario.'" title="Ver">
							<i class="icon-eye"></i>
						</a>
						<a class="btn btn-link" href="javascript:void(0)" title="Actualizar" onclick="edit_usuario('."'".$usuario->id_usu."'".')">
							<i class="icon-pencil"></i>
					  	</a>
					  	<a class="btn btn-link" href="javascript:void(0)" title="Desactivar" onclick="desactivate_usuario('."'".$usuario->id_usu."'".')">
							<i class="icon-ban"></i>
					  	</a>';
			$data[] = $row;
			$i++;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->usuario->count_all(),
			"recordsFiltered" => $this->usuario->count_filtered_activos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function list_usuarios_inactivos()
	{
		$list = $this->usuario->get_datatables_inactivos();
		$data = array();
		$no = $_POST['start'];
		$i = 1;
		foreach ($list as $usuario)
		{
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $usuario->usuario;
			$row[] = $usuario->nivel;
			if($this->session->userdata('nivel') == 1)
			{
				$row[] =
					'<a class="btn btn-link" href="javascript:void(0)" title="Activar" onclick="activate_usuario('."'".$usuario->id_usu."'".')">
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
			"recordsTotal" => $this->usuario->count_all(),
			"recordsFiltered" => $this->usuario->count_filtered_inactivos(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function search_usuario()
	{
		$usuario = $this->input->get('usuario');

		if ($usuario!='')
		{
		    $nr = $this->usuario->validate_by_usuario($usuario);
		    if ($nr > 0)
			{
				$data = array(
				'type' => 'Advertencia',
				'message' => 'El usuario ya está registrado.',
				'button' => 1
				);
			}
			else if ($nr < 1)
			{
				$data = array(
				'type' => 'Aviso',
				'message' => 'El usuario está disponible.',
				'button' => 0
				);
			}
	  	}
	  	else if($usuario=='')
	  	{
		   	$data = array(
				'type' => 'Error',
				'message' => 'El usuario es requerido.',
				'button' => 1
			);
	 	}
	   	echo json_encode($data);
	}

	public function add_usuario()
	{
		$save_method = "add";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('usuario', 'usuario', 'required|is_unique[usuarios.usuario]');
   		$this->form_validation->set_rules('contrasena', 'contraseña', 'required|min_length[8]');
   		$this->form_validation->set_rules('nivel', 'nivel', 'required');

   		if($this->form_validation->run() == TRUE)
   		{
			$data = array(
				'usuario' => $this->input->post('usuario'),
				'contrasena' => sha1($this->input->post('contrasena')),
				'nivel' => $this->input->post('nivel'),
				'estado' => 'Activo'
			);

			$bitacora = array(
				'tipo' => 'Usuario',
				'movimiento' => 'Se ha registrado al usuario <a href="http://localhost/parque/index.php/perfil/view/'.$this->input->post('usuario').'">'.$this->input->post('usuario').'</a>',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$insert = $this->usuario->save($data);
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

	public function edit_usuario($id_usu)
	{
		$data = $this->usuario->get_by_id($id_usu);
		echo json_encode($data);
	}

	public function load_profile($id_usu)
	{
		$data = $this->usuario->get_by_id($id_usu);
		echo json_encode($data);
	}

	public function update_usuario()
	{
		$save_method = "update";
		$this->_validate($save_method);
   		$this->form_validation->set_rules('contrasena', 'contraseña', 'required|min_length[8]');
   		$this->form_validation->set_rules('nivel', 'nivel', 'required');
   		
   		if($this->form_validation->run() == TRUE)
   		{
   		
			$data = array(
				'contrasena' => sha1($this->input->post('contrasena')),
				'nivel' => $this->input->post('nivel'),
				'estado' => 'Activo'
			);

			$query = $this->usuario->get_by_id($this->input->post('id_usu'));
			$usuario = $query['usuario'];

			$bitacora = array(
				'tipo' => 'Usuario',
				'movimiento' => 'Se ha actualizado al usuario <a href="http://localhost/parque/index.php/perfil/view/'.$usuario.'">'.$usuario.'</a>',
				'usuario' => $this->session->userdata('id_usuario')
			);		

			$this->bitacora->set($bitacora);
			$this->usuario->update(array('id_usu' => $this->input->post('id_usu')), $data);
			echo json_encode(array("status" => TRUE));
		}
	}

	public function activate_usuario($id_usu)
	{
		$query = $this->usuario->get_by_id($id_usu);
		$usuario = $query['usuario'];

		$bitacora = array(
			'tipo' => 'Usuario',
			'movimiento' => 'Se ha activado la usuario <a href="http://localhost/parque/index.php/perfil/view/'.$usuario.'">'.$usuario.'</a>',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->usuario->activate_by_id($id_usu);
		echo json_encode(array("status" => TRUE));
	}

	public function desactivate_usuario($id_usu)
	{
		$query = $this->usuario->get_by_id($id_usu);
		$usuario = $query['usuario'];

		$bitacora = array(
			'tipo' => 'Usuario',
			'movimiento' => 'Se ha desactivado la usuario <a href="http://localhost/parque/index.php/perfil/view/'.$usuario.'">'.$usuario.'</a>',
			'usuario' => $this->session->userdata('id_usuario')
		);		

		$this->bitacora->set($bitacora);
		$this->usuario->desactivate_by_id($id_usu);
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
			if($this->input->post('usuario') == '')
			{
				$data['inputerror'][] = 'usuario';
				$data['error_string'][] = 'El usuario es requerido.';
				$data['status'] = FALSE;
			}
		}

		if($this->input->post('contrasena') == '')
		{
			$data['inputerror'][] = 'contrasena';
			$data['error_string'][] = 'La contrasena es requerida.';
			$data['status'] = FALSE;
		}

		if($this->input->post('nivel') == '')
		{
			$data['inputerror'][] = 'nivel';
			$data['error_string'][] = 'El nivel es requerido.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}