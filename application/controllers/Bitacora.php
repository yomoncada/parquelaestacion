<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bitacora_model','bitacora');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('bd_access') == 1)
		{
			$data = array(
	    		'controller' => 'bitacoras',
	    	);
	    	
			$this->session->unset_userdata('proceso');

			$this->load->view('templates/links');
	        $this->load->view('templates/header');
	        $this->load->view('templates/sidebar');
			$this->load->view('bitacoras/index',$data);
			$this->load->view('templates/quick_sidebar');
	        $this->load->view('templates/footer');
        }
        else
        {
        	show_404();
		}
	}
	public function list_bitacoras()
    {
        $list = $this->bitacora->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $bitacora)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $bitacora->tipo;
            $row[] = $bitacora->movimiento;
            $row[] = '<a href="http://localhost/parque/index.php/perfil/view/'.$bitacora->usuario.'">'.$bitacora->usuario.'</a>';
            $row[] = $bitacora->tiempo;
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->bitacora->count_all(),
            "recordsFiltered" => $this->bitacora->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

	public function truncate_bitacoras()
	{
		$this->bitacora->truncate_bitacoras();
		echo json_encode(array("status" => TRUE));
	}
}
