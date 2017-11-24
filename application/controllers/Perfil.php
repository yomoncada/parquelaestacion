<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bitacora_model','bitacora');
		$this->load->model('usuario_model','usuario');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE)
		{
			$data = array(
	    		'controller' => 'perfil',
	    		'usuario' => $this->usuario->get_by_usuario($this->session->userdata('usuario'))
	    	);
	    	
			$this->session->unset_userdata('proceso');
			$this->session->unset_userdata('perfil');
			$this->session->unset_userdata('view_user');
	        $this->session->set_userdata('perfil','index');

			$this->load->view('templates/links');
	       	$this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('perfiles/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
            show_404();
		}
	}

	public function load_perfil()
	{
		if($this->session->userdata('perfil') == 'view'){
			$data = $this->usuario->get_by_usuario($this->session->userdata('view_user'));
		}
		else
		{
			$data = $this->usuario->get_by_id($this->session->userdata('id_usuario'));
		}
		echo json_encode($data);
	}

	public function view($usuario = NULL)
    {
        if($this->session->userdata('is_logued_in') === TRUE)
        {
        	if($this->session->userdata('usuario') != $usuario){
	            $data = array(
	                'usuario'   =>    $this->usuario->get_by_usuario($usuario),
	                'profile_avatar' => 1
	            );

	            if (empty($data['usuario']))
	            {
	                show_404();
	            }

				$this->session->unset_userdata('proceso');
	            $this->session->unset_userdata('perfil');
	            $this->session->unset_userdata('view_user');
	            $this->session->set_userdata('perfil','view');
	            $this->session->set_userdata('view_user',$usuario);

	            $this->load->view('templates/links');
	            $this->load->view('templates/header');
	            $this->load->view('templates/sidebar');
	            $this->load->view('perfiles/view',$data);
	            $this->load->view('templates/quick_sidebar');
	            $this->load->view('templates/footer');
	        }
	        else
	        {
	        	redirect('perfil');
	        }
        }
    }

	public function validate_contrasena()
	{
		$data = array(
			'type' => false,
			'message' => false,
			'rule0' => false,
			'rule1' => false,
			'rule2' => false,
			'input0' => false,
			'input1' => false,
			'input2' => false
		);

		$usuario = $this->input->get('usuario');
		$con_act = $this->input->get('con_act');
		$contrasena1 = $this->input->get('contrasena1');
		$contrasena2 = $this->input->get('contrasena2');

		if ($con_act!='')
		{
		    $validacion = $this->usuario->validate($usuario,sha1($con_act));
		    if($validacion > 0)
			{
				$data = array(
					'type' => 'Aviso',					
					'rule0' => TRUE,
					'input0' => TRUE
				);
			}
			if($validacion < 1)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'La contraseña ingresada no es la actual.',
					'rule0' => FALSE,
					'input0' => TRUE
				);
			}

			if($con_act == $contrasena1)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'La nueva contraseña no puede ser la misma que la actual.',
					'input0' => TRUE,
					'input1' => TRUE,
					'rule1' => FALSE,
				);
			}
			if($con_act == $contrasena2)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'La nueva contraseña no puede ser la misma que la actual.',
					'input0' => TRUE,
					'input2' => TRUE,
					'rule1' => FALSE
				);
			}
			if($con_act == $contrasena1 && $con_act == $contrasena2)
			{
				$data = array(
					'type' => 'Advertencia',
					'message' => 'La nueva contraseña no puede ser la misma que la actual.',
					'input0' => TRUE,
					'input1' => TRUE,
					'input2' => TRUE,
					'rule1' => FALSE
				);
			}

			else
			{
				if($contrasena1!='' && $contrasena2!='' && $validacion > 0)
				{
					if($contrasena1 != $contrasena2)
					{
						$data = array(
							'type' => 'Advertencia',
							'message' => 'Las contraseñas ingresadas no coinciden.',
							'rule2' => FALSE
						);
					}
					else
					{
						$data = array(
							'type' => 'Aviso',
							'rule2' => TRUE,
							'input1' => TRUE,
							'input2' => TRUE
						);	
					}
				}
			}
	  	}
	  	else
	  	{
	  		if($contrasena1!='' && $contrasena2!='')
			{
				if($contrasena1 != $contrasena2)
				{
					$data = array(
						'type' => 'Advertencia',
						'message' => 'Las contraseñas ingresadas no coinciden.',
						'rule2' => FALSE
					);
				}
				else
				{
					$data = array(
						'type' => 'Aviso',
						'rule2' => TRUE,
						'input1' => TRUE,
						'input2' => TRUE
					);	
				}
			}
	  	}
	   	echo json_encode($data);
	}

	public function update_info()
	{
		$validate_form = "info";
		$this->_validate($validate_form);
		$this->form_validation->set_rules('nombre', 'nombre', 'required');
   		$this->form_validation->set_rules('telefono', 'telefono', 'required');
   		$this->form_validation->set_rules('email', 'email', 'required|valid_email');

		if($this->form_validation->run() == TRUE)
   		{
   			$data = array(
				'nombre' => $this->input->post('nombre'),
				'biografia' => $this->input->post('biografia'),
				'telefono' => $this->input->post('telefono'),
				'email' => $this->input->post('email'),
				'genero' => $this->input->post('genero'),
				'direccion' => $this->input->post('direccion')
			);

   			$bitacora = array(
                'tipo' => 'Usuario',
                'movimiento' => 'Ha actualizado su información personal.',
                'usuario' => $this->session->userdata('id_usuario')
            );      

            $this->bitacora->set($bitacora);
   			$this->usuario->update(array('id_usu' => $this->input->post('id_usu')), $data);
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

	public function update_security()
	{
		$validate_form = "security";
		$this->_validate($validate_form);
   		$this->form_validation->set_rules('contrasena_actual', 'contrasena actual', 'required|differs[contrasena]|min_length[8]');
   		$this->form_validation->set_rules('contrasena', 'nueva contrasena', 'required|matches[repetir_contrasena]|differs[contrasena_actual]|min_length[8]');
   		$this->form_validation->set_rules('repetir_contrasena', 'repetir contrasena', 'required|matches[contrasena]|differs[contrasena_actual]|min_length[8]');
   		$this->form_validation->set_rules('pregunta', 'pregunta', 'required');
   		$this->form_validation->set_rules('respuesta', 'respuesta', 'required');

		if($this->form_validation->run() == TRUE)
   		{
   			$data = array(
				'contrasena' => sha1($this->input->post('contrasena')),
				'pregunta' => $this->input->post('pregunta'),
				'respuesta' => $this->input->post('respuesta')
			);

   			$bitacora = array(
                'tipo' => 'Usuario',
                'movimiento' => 'Ha reforzado su seguridad.',
                'usuario' => $this->session->userdata('id_usuario')
            );      

            $this->bitacora->set($bitacora);
			$this->usuario->update(array('id_usu' => $this->input->post('id_usu')), $data);
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

	private function _validate($validate_form)
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($validate_form == "info")
		{
			if($this->input->post('nombre') == '')
			{
				$data['inputerror'][] = 'nombre';
				$data['error_string'][] = 'El nombre es requerido.';
				$data['status'] = FALSE;
			}

			if($this->input->post('telefono') == '')
			{
				$data['inputerror'][] = 'telefono';
				$data['error_string'][] = 'El teléfono es requerido.';
				$data['status'] = FALSE;
			}
		}

		if($validate_form == "security")
		{
			if($this->input->post('contrasena_actual') == '')
			{
				$data['inputerror'][] = 'contrasena_actual';
				$data['error_string'][] = 'La contraseña actual es requerida.';
				$data['status'] = FALSE;
			}

			if($this->input->post('contrasena') == '')
			{
				$data['inputerror'][] = 'contrasena';
				$data['error_string'][] = 'La contraseña es requerida.';
				$data['status'] = FALSE;
			}

			if($this->input->post('repetir_contrasena') == '')
			{
				$data['inputerror'][] = 'repetir_contrasena';
				$data['error_string'][] = 'La repetición de la contraseña es requerida.';
				$data['status'] = FALSE;
			}

			if($this->input->post('pregunta') == '')
			{
				$data['inputerror'][] = 'pregunta';
				$data['error_string'][] = 'La pregunta secreta es requerida.';
				$data['status'] = FALSE;
			}

			if($this->input->post('respuesta') == '')
			{
				$data['inputerror'][] = 'respuesta';
				$data['error_string'][] = 'La respuesta es requerida.';
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