<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sistema extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('area_model','area');
		$this->load->model('beneficiario_model','beneficiario');
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('cabana_model','cabana');
		$this->load->model('cancha_model','cancha');
		$this->load->model('categoria_model','categoria');
		$this->load->model('censo_model','censo');
		$this->load->model('donacion_model','donacion');
		$this->load->model('donacion_model','donacion');
		$this->load->model('donante_model','donante');
		$this->load->model('edificio_model','edificio');
		$this->load->model('empleado_model','empleado');
		$this->load->model('especie_model','especie');
		$this->load->model('implemento_model','implemento');
		$this->load->model('mantenimiento_model','mantenimiento');
		$this->load->model('reforestacion_model','reforestacion');
		$this->load->model('usuario_model','usuario');
	}
		
	public function login($error = null)
	{
		if($this->session->userdata('is_logued_in') == FALSE)
		{
			$data['token'] = $this->token();
			$this->load->view('templates/links');
			$this->load->view('pages/login',$data);
		}
		else
		{
			redirect('home');
		}
	}

	public function validate_usuario()
	{
		$this->_validate();
		$this->form_validation->set_rules('usuario', 'nombre de usuario', 'required');
		$this->form_validation->set_rules('contrasena', 'contrasena', 'required');

		if($this->form_validation->run() == TRUE)
		{
			$usuario = $this->input->post('usuario');
			$contrasena = sha1($this->input->post('contrasena'));
			$validacion = $this->usuario->validate($usuario,$contrasena);

			if($validacion > 0)
			{
				$datos = $this->usuario->get($usuario,$contrasena);

				$data = array(
					'is_logued_in' 	=> 		TRUE,
					'id_usuario' 	=> 		$datos->id_usu,
					'nivel'		=>		$datos->nivel,
					'usuario' 		=> 		$datos->usuario,
					'avatar' => $datos->avatar
				);
				$this->session->set_userdata($data);

				$bitacora = array(
			        'tipo' => 'Usuario',
			        'movimiento' => 'Ha ingresado al sistema.',
			        'usuario' => $this->session->userdata('id_usuario')
		        );		

      			$this->bitacora->set($bitacora);
				echo json_encode(array("status" => TRUE));
			}
			else
			{
				echo json_encode(array("empty" => FALSE));
			}
		}
	}

	public function token()
	{
		$token = sha1(uniqid(rand(),true));

		$this->session->set_userdata('token',$token);
		return $token;
	}

	public function home($page = 'home')
  	{ 
	    if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
	    {
	      show_404();
	    }
	    else
	    {
		    if($this->session->userdata('is_logued_in') === TRUE)
		    {
		       	$data = array(
		          'areas' => $this->area->count_all(),
		          'beneficiarios' => $this->beneficiario->count_all(),
		          'cabanas' => $this->cabana->count_all(),
		          'canchas' => $this->cancha->count_all(),
		          'categorias' => $this->categoria->count_all(),
		          'censos' => $this->censo->count_all(),
		          'donaciones' => $this->donacion->count_all(),
		          'donaciones' => $this->donacion->count_all(),
		          'donantes' => $this->donante->count_all(),
		          'edificios' => $this->edificio->count_all(),
		          'empleados' => $this->empleado->count_all(),
		          'especies' => $this->especie->count_all(),
		          'implementos' => $this->implemento->count_all(),
		          'mantenimientos' => $this->mantenimiento->count_all(),
		          'reforestaciones' => $this->reforestacion->count_all()
	        	);

		        $this->load->view('templates/links');
		        $this->load->view('templates/header');
		        $this->load->view('templates/sidebar');
		        $this->load->view('pages/'.$page,$data);
		        $this->load->view('templates/quick_sidebar');
		        $this->load->view('templates/footer');
		    }
		    else
		    {
		      	redirect('login');
		    }
	    }
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		$this->db->truncate('ci_sessions');

		$bitacora = array(
	        'tipo' => 'Usuario',
	        'movimiento' => 'Ha salido del sistema.',
	        'usuario' => $this->session->userdata('id_usuario')
        );		

		$this->bitacora->set($bitacora);
		
		redirect('login');
	}

	public function recover_password()
	{
		$validate_method = 'recovery';
		$this->_validate($validate_method);

		$usuario = $this->input->post('usuario');
		$pregunta = $this->input->post('pregunta');
		$respuesta = $this->input->post('respuesta');

		$validacion = $this->usuario->recover_password($usuario,$pregunta,$respuesta);

		if($validacion > 0)
		{
			$data = array(
				'random_password' => rand(10000000,99999999),
				'status' => TRUE
			);

			$this->usuario->set_temporal_password($usuario,sha1($data['random_password']));
		}
		else
		{
			$data = array(
				'random_password' => FALSE,
				'status' => FALSE
			);
		}
		echo json_encode($data);
	}

	private function _validate($validate_method = NULL)
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		if($validate_method == 'recovery')
		{
			if($this->input->post('usuario') == '')
			{
				$data['inputerror'][] = 'usuario';
				$data['error_string'][] = 'El usuario es requerido.';
				$data['status'] = FALSE;
			}
			if($this->input->post('pregunta') == '')
			{
				$data['inputerror'][] = 'pregunta';
				$data['error_string'][] = 'La pregunta es requerida.';
				$data['status'] = FALSE;
			}
			if($this->input->post('respuesta') == '')
			{
				$data['inputerror'][] = 'respuesta';
				$data['error_string'][] = 'La respuesta es requerida.';
				$data['status'] = FALSE;
			}
		}
		else
		{
			if($this->input->post('usuario') == '')
			{
				$data['inputerror'][] = 'usuario';
				$data['error_string'][] = 'El usuario es requerido.';
				$data['status'] = FALSE;
			}

			if($this->input->post('contrasena') == '')
			{
				$data['inputerror'][] = 'contrasena';
				$data['error_string'][] = 'La contraseña es requerida.';
				$data['status'] = FALSE;
			}
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}