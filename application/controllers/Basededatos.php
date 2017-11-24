<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Basededatos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('database_model','database');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('nivel') === 'Administrador(a)')
		{
				$data = array(
		    		'controller' => 'basededatos',
		    	);
		    	
				$this->session->unset_userdata('proceso');

				$this->load->view('templates/links');
		        $this->load->view('templates/header');
		        $this->load->view('templates/sidebar');
				$this->load->view('basededatos/index',$data);
				$this->load->view('templates/quick_sidebar');
		        $this->load->view('templates/footer');
        }
        else
        {
            show_404();
		}
	}
}