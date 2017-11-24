<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('usuario_model','usuario');
        $this->load->model('bitacora_model','bitacora');
    }

    public function index()
    {
        show_404();
    }

    public function do_upload($where = NULL)
    {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|png';
        if($where == 'usuario'){
            $config['file_name'] = 'perfil-'.$this->session->userdata('usuario').'-';
        }
        $config['max_size']      = 2000;
        $config['max_width']     = 1080;
        $config['max_height']    = 1080;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file'))
        {
                $data = array(
                    'error' => $this->upload->display_errors(),
                    'status' => false
                );
        }
        else
        {
                $avatar = $this->upload->data('file_name');
                $id_usu = $this->session->userdata('id_usuario');

                $this->usuario->set_avatar($id_usu,$avatar);
                $this->session->set_userdata('avatar',$avatar);

                $bitacora = array(
                    'tipo' => 'Usuario',
                    'movimiento' => 'Ha actualizado su avatar',
                    'usuario' => $this->session->userdata('id_usuario')
                );      

                $this->bitacora->set($bitacora);

                $data = array(
                    'status' => true
                );
        }
        echo json_encode($data);
    }
}