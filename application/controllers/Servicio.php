<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicio extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->library('cart_beneficiarios');
        $this->load->library('cart_cabanas');
        $this->load->library('cart_canchas');
        $this->load->library('cart_empleados');
        $this->load->library('cart_implementos');
        $this->load->library('cart_invitados');
        $this->load->model('area_model','area');
        $this->load->model('beneficiario_model','beneficiario');
        $this->load->model('bitacora_model','bitacora');
        $this->load->model('cabana_model','cabana');
        $this->load->model('cancha_model','cancha');
        $this->load->model('empleado_model','empleado');
        $this->load->model('implemento_model','implemento');
        $this->load->model('servicio_model','servicio');
	}

    public function list_servicios_pendientes()
    {
        $list = $this->servicio->get_datatables_pendientes();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $servicio)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $servicio->id_ser;
            $row[] = $servicio->usuario;
            $row[] = $servicio->fecha_asig;
            $row[] = $servicio->hora_asig;
            $row[] = $servicio->fecha_act;
            $row[] = $servicio->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$servicio->id_ser."'".')" title="Controlar">
                    <i class="icon-note"></i>
                </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->servicio->count_all(),
            "recordsFiltered" => $this->servicio->count_filtered_pendientes(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function list_servicios_en_progresos()
    {
        $list = $this->servicio->get_datatables_en_progresos();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $servicio)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $servicio->id_ser;
            $row[] = $servicio->usuario;
            $row[] = $servicio->fecha_asig;
            $row[] = $servicio->hora_asig;
            $row[] = $servicio->fecha_act;
            $row[] = $servicio->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$servicio->id_ser."'".')" title="Controlar">
                    <i class="icon-note"></i>
                </a>
                <a class="btn btn-link" href="javascript:void(0)" onclick="report('."'".$servicio->id_ser."'".')" title="Imprimir">
                    <i class="icon-printer"></i>
                </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->servicio->count_all(),
            "recordsFiltered" => $this->servicio->count_filtered_en_progresos(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function list_servicios_finalizados()
    {
        $list = $this->servicio->get_datatables_finalizados();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $servicio)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $servicio->id_ser;
            $row[] = $servicio->usuario;
            $row[] = $servicio->fecha_asig;
            $row[] = $servicio->hora_asig;
            $row[] = $servicio->fecha_act;
            $row[] = $servicio->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$servicio->id_ser."'".')" title="Ver">
                    <i class="icon-eye"></i>
                </a>
                <a class="btn btn-link" href="javascript:void(0)" onclick="report('."'".$servicio->id_ser."'".')" title="Imprimir">
                    <i class="icon-printer"></i>
                </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->servicio->count_all(),
            "recordsFiltered" => $this->servicio->count_filtered_finalizados(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function index()
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('ser_access') == 1)
        {
            $this->cart_beneficiarios->destroy();
            $this->cart_cabanas->destroy();
            $this->cart_canchas->destroy();
            $this->cart_empleados->destroy();
            $this->cart_implementos->destroy();
            $this->cart_invitados->destroy();

            $this->session->unset_userdata('proceso');

            $session = array(
                'proceso' => 'servicio'
            );

            $this->session->set_userdata($session);

            $data = array(
                'servicios' => $this->servicio->get_all(),
                'controller' => 'servicio'
            );

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('servicios/index',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
        else
        {
            show_404();
        }
    }

    public function create()
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('ser_access') == 1)
        {
            if($this->session->userdata('proceso') != "servicio")
            {
                $this->cart_beneficiarios->destroy();
                $this->cart_cabanas->destroy();
                $this->cart_canchas->destroy();
                $this->cart_empleados->destroy();
                $this->cart_implementos->destroy();
                $this->cart_invitados->destroy();

                $this->session->unset_userdata('proceso');
            }

            $session = array(
                'proceso' => 'servicio'
            );

            $this->session->set_userdata($session);

            $data = array(
                'total_ser' => $this->servicio->get_numero(),
                'controller' => 'servicio',
                'areas' => $this->area->get_all()
            );

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('servicios/create',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
        else
        {
            show_404();
        }
    }

    public function control($id_ser = NULL)
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('ser_access') == 1)
        {
            if($this->session->userdata('proceso') != "servicio_control")
            {
                $this->cart_beneficiarios->destroy();
                $this->cart_cabanas->destroy();
                $this->cart_canchas->destroy();
                $this->cart_empleados->destroy();
                $this->cart_implementos->destroy();
                $this->cart_invitados->destroy();

                $this->session->unset_userdata('proceso');
            }
            
            $session = array(
                'proceso' => 'servicio_control'
            );

            $this->session->set_userdata($session);

            $data = array(
                'servicio'   =>    $this->servicio->get_servicio($id_ser),
                'controller' => 'servicio'
            );

            if (empty($data['servicio']))
            {
                show_404();
            }

            $beneficiarios = $this->servicio->get_beneficiarios($id_ser);

            if($beneficiarios == TRUE)
            {
                if ($cart_beneficiarios = $this->cart_beneficiarios->contents() == NULL)
                {
                    foreach ($beneficiarios as $beneficiario){
                        $beneficiarioss = array(
                            'id' => $beneficiario->beneficiario,
                            'cedula' => $beneficiario->cedula,
                            'nombre' => $beneficiario->nombre,
                            'cantidad' => 1
                        );

                        $this->cart_beneficiarios->insert($beneficiarioss);
                  }
                }
            }

            $cabanas = $this->servicio->get_cabanas($id_ser);

            if($cabanas == TRUE)
            {
                if ($cart_cabanas = $this->cart_cabanas->contents() == NULL)
                {
                    foreach ($cabanas as $cabana){
                        $cabanass = array(
                            'id' => $cabana->cabana,
                            'numero' => $cabana->numero,
                            'capacidad' => $cabana->capacidad,
                            'cantidad' => 1
                        );

                        $this->cart_cabanas->insert($cabanass);
                  }
                }
            }

            $canchas = $this->servicio->get_canchas($id_ser);

            if($canchas == TRUE)
            {
                if ($cart_canchas = $this->cart_canchas->contents() == NULL)
                {
                    foreach ($canchas as $cancha){
                        $canchass = array(
                            'id' => $cancha->cancha,
                            'numero' => $cancha->numero,
                            'capacidad' => $cancha->capacidad,
                            'cantidad' => 1
                        );

                        $this->cart_canchas->insert($canchass);
                  }
                }
            }

            $empleados = $this->servicio->get_empleados($id_ser);

            if($empleados == TRUE)
            {
                if ($cart_empleados = $this->cart_empleados->contents() == NULL)
                {
                    foreach ($empleados as $empleado):
                        $empleadoss = array(
                            'id' => $empleado->empleado,
                            'cedula' => $empleado->cedula,
                            'nombre' => $empleado->nombre,
                            'cantidad' => 1
                        );

                        $this->cart_empleados->insert($empleadoss);
                  endforeach;
                }
            }

            $implementos = $this->servicio->get_implementos($id_ser);

            if($implementos == TRUE)
            {
                if ($cart_implementos = $this->cart_implementos->contents() == NULL)
                {
                    foreach ($implementos as $implemento){
                        $implementoss = array(
                            'id' => $implemento->implemento,
                            'codigo' => $implemento->codigo,
                            'nombre' => $implemento->nombre,
                            'cantidad' => $implemento->cantidad,
                            'unidad' => $implemento->unidad
                        );
                        $this->cart_implementos->insert($implementoss);
                  }
                }
            }

            $invitados = $this->servicio->get_invitados($id_ser);

            if($invitados == TRUE)
            {
                if ($cart_invitados = $this->cart_invitados->contents() == NULL)
                {
                    $id = rand(1,100000000000000000);

                    foreach ($invitados as $invitado){
                        $invitadoss = array(
                            'id' => $id,
                            'cedula' => $invitado->cedula,
                            'nombre' => $invitado->nombre,
                            'cantidad' => 1
                        );
                        $this->cart_invitados->insert($invitadoss);
                  }
                }
            }

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('servicios/control',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
    }

    public function process()
    {
        if($this->cart_beneficiarios->contents() != NULL && $this->cart_cabanas->contents() != NULL && $this->cart_canchas->contents() == NULL && $this->cart_implementos->contents() != NULL && $this->cart_empleados->contents() != NULL && $this->cart_invitados->contents() != NULL || $this->cart_beneficiarios->contents() != NULL && $this->cart_cabanas->contents() == NULL && $this->cart_canchas->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_empleados->contents() != NULL && $this->cart_invitados->contents() != NULL || $this->cart_beneficiarios->contents() != NULL && $this->cart_cabanas->contents() != NULL && $this->cart_canchas->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_empleados->contents() != NULL && $this->cart_invitados->contents() != NULL)
        {
            $this->_validate();
                      
            $this->form_validation->set_rules('fecha', 'fecha', 'is_unique[servicios.fecha_asig]');

            if($this->form_validation->run() == TRUE)
            {  
                $servicio = array(
                    'usuario' => $this->session->userdata('id_usuario'),
                    'fecha_asig' => $this->input->post('fecha'),
                    'hora_asig' => $this->input->post('hora'),
                    'estado' => 'Pendiente'
                );
                
                $id_ser = $this->servicio->save($servicio);

                if ($this->cart_beneficiarios->contents() != NULL){
                    foreach ($this->cart_beneficiarios->contents() as $beneficiario){
                        $beneficiarios = array(
                            'servicio'     => $id_ser,
                            'beneficiario'   => $beneficiario['id']
                        );    

                        $this->servicio->set_beneficiarios($beneficiarios);
                    }
                }

                if ($this->cart_cabanas->contents() != NULL){
                    foreach ($this->cart_cabanas->contents() as $cabana){
                        $cabanas = array(
                            'servicio'     => $id_ser,
                            'cabana'   => $cabana['id']
                        );    

                        $this->servicio->set_cabanas($cabanas);
                    }
                }

                if ($this->cart_cabanas->contents() != NULL){
                    foreach ($this->cart_cabanas->contents() as $cabana){
                        $id_cab = $cabana['id'];
                      $this->servicio->discount_cabanas($id_cab);
                    }
                }

                if ($this->cart_canchas->contents() != NULL){
                    foreach ($this->cart_canchas->contents() as $cancha){
                        $canchas = array(
                            'servicio'     => $id_ser,
                            'cancha'   => $cancha['id']
                        );    

                        $this->servicio->set_canchas($canchas);
                    }
                }

                if ($this->cart_canchas->contents() != NULL){
                    foreach ($this->cart_canchas->contents() as $cancha){
                        $id_can = $cancha['id'];
                      $this->servicio->discount_canchas($id_can);
                    }
                }

                if ($this->cart_empleados->contents() != NULL){
                    foreach ($this->cart_empleados->contents() as $empleado){
                        $empleados = array(
                            'servicio'     => $id_ser,
                            'empleado'   => $empleado['id']
                        );    

                        $this->servicio->set_empleados($empleados);
                    }
                }

                if ($this->cart_empleados->contents() != NULL):
                    foreach ($this->cart_empleados->contents() as $empleado):
                        $id_emp = $empleado['id'];
                      $this->servicio->discount_empleados($id_emp);
                    endforeach;
                endif;

                if ($this->cart_implementos->contents() != NULL){
                    foreach ($this->cart_implementos->contents() as $implemento){
                        $implementos = array(
                            'servicio'     => $id_ser,
                            'implemento'   => $implemento['id'],
                            'cantidad'   => $implemento['cantidad'],
                            'unidad'   => $implemento['unidad']
                        );    

                        $this->servicio->set_implementos($implementos);
                    }
                }

                if ($this->cart_implementos->contents() != NULL):
                    foreach ($this->cart_implementos->contents() as $implemento):
                        $id_imp = $implemento['id'];
                        $cantidad = $implemento['cantidad'];
                        $implemento_act = $this->servicio->get_implemento_by_id($id_imp);
                        if($implemento_act != false)
                        {
                            $actual = $implemento_act->stock;
                            $descuento = $actual - $cantidad;
                        }    
                      $this->servicio->discount_implementos($id_imp,$descuento);
                    endforeach;
                endif;

                if ($this->cart_invitados->contents() != NULL){
                    foreach ($this->cart_invitados->contents() as $invitado){
                        $invitados = array(
                            'servicio'     => $id_ser,
                            'cedula'    => $invitado['cedula'],
                            'nombre'    => $invitado['nombre']
                        );

                        $this->servicio->set_invitados($invitados);
                    }
                }

                $bitacora = array(
                    'tipo' => 'servicio',
                    'movimiento' => 'Se ha registrado un servicio.',
                    'usuario' => $this->session->userdata('id_usuario')
                );      

                $this->bitacora->set($bitacora);
                $this->cart_beneficiarios->destroy();
                $this->cart_cabanas->destroy();
                $this->cart_canchas->destroy();
                $this->cart_empleados->destroy();
                $this->cart_implementos->destroy();
                $this->cart_invitados->destroy();

                echo json_encode(array("status" => true));
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
        else
        {
            if($this->cart_beneficiarios->contents() == NULL && $this->cart_cabanas->contents() == NULL && $this->cart_canchas->contents() == NULL && $this->cart_implementos->contents() == NULL && $this->cart_empleados->contents() == NULL && $this->cart_invitados->contents() == NULL)
            {
                echo json_encode(array("status" => false, "reason" => "carros"));
            }
            else
            {
                if($this->cart_beneficiarios->contents() == NULL){
                echo json_encode(array("status" => false, "reason" => "beneficiarios"));
                }
                else if($this->cart_cabanas->contents() == NULL && $this->cart_canchas->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "servicio"));
                }
                else if($this->cart_implementos->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "implementos"));
                }
                else if($this->cart_empleados->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "empleados"));
                }
                else if($this->cart_invitados->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "invitados"));
                }
            }
        }
    }

    public function update($id_ser = NULL)
    {
        if($this->cart_beneficiarios->contents() != NULL && $this->cart_cabanas->contents() != NULL && $this->cart_canchas->contents() == NULL && $this->cart_implementos->contents() != NULL && $this->cart_empleados->contents() != NULL && $this->cart_invitados->contents() != NULL || $this->cart_beneficiarios->contents() != NULL && $this->cart_cabanas->contents() == NULL && $this->cart_canchas->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_empleados->contents() != NULL && $this->cart_invitados->contents() != NULL || $this->cart_beneficiarios->contents() != NULL && $this->cart_cabanas->contents() != NULL && $this->cart_canchas->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_empleados->contents() != NULL && $this->cart_invitados->contents() != NULL)
        {
            $this->_validate();
                        
            $servicio = array(
                'usuario' => $this->session->userdata('id_usuario'),
                'fecha_asig' => $this->input->post('fecha'),
                'hora_asig' => $this->input->post('hora'),
                'estado' => 'En progreso'
            );
            
            $this->servicio->update(array('id_ser' => $id_ser), $servicio);

            $cabanas = $this->servicio->get_cabanas($id_ser);

            if($cabanas == TRUE)
            {
                foreach ($cabanas as $cabana):
                    $this->servicio->increment_cabanas($cabana->cabana);
                endforeach;
            }

            $canchas = $this->servicio->get_canchas($id_ser);

            if($canchas == TRUE)
            {
                foreach ($canchas as $cancha):
                    $this->servicio->increment_canchas($cancha->cancha);
                endforeach;
            }

            $empleados = $this->servicio->get_empleados($id_ser);

            if($empleados == TRUE)
            {
                foreach ($empleados as $empleado):
                    $this->servicio->increment_empleados($empleado->empleado);
                endforeach;
            }

            $implementos = $this->servicio->get_implementos($id_ser);

            if($implementos == TRUE)
            {
                foreach ($implementos as $implemento):
                    $implemento_act = $this->servicio->get_implemento_by_id($implemento->implemento);
                    if($implemento_act == TRUE)
                    {
                        $actual = $implemento_act->stock;
                        $incremento = $actual + $implemento->cantidad;
                    }    
                    $this->servicio->increment_implementos($implemento->implemento,$incremento);
                endforeach;
            }

            $this->servicio->delete_beneficiarios($id_ser);
            $this->servicio->delete_cabanas($id_ser);
            $this->servicio->delete_canchas($id_ser);
            $this->servicio->delete_empleados($id_ser);
            $this->servicio->delete_implementos($id_ser);
            $this->servicio->delete_invitados($id_ser);

            if ($this->cart_beneficiarios->contents() != NULL){
                foreach ($this->cart_beneficiarios->contents() as $beneficiario){
                    $beneficiarios = array(
                        'servicio'     => $id_ser,
                        'beneficiario'   => $beneficiario['id']
                    );    

                    $this->servicio->set_beneficiarios($beneficiarios);
                }
            }

            if ($this->cart_cabanas->contents() != NULL){
                foreach ($this->cart_cabanas->contents() as $cabana){
                    $cabanas = array(
                        'servicio'     => $id_ser,
                        'cabana'   => $cabana['id']
                    );    

                    $this->servicio->set_cabanas($cabanas);
                }
            }

            if ($this->cart_cabanas->contents() != NULL){
                foreach ($this->cart_cabanas->contents() as $cabana){
                    $id_cab = $cabana['id'];
                  $this->servicio->discount_cabanas($id_cab);
                }
            }

            if ($this->cart_canchas->contents() != NULL){
                foreach ($this->cart_canchas->contents() as $cancha){
                    $canchas = array(
                        'servicio'     => $id_ser,
                        'cancha'   => $cancha['id']
                    );    

                    $this->servicio->set_canchas($canchas);
                }
            }

            if ($this->cart_canchas->contents() != NULL){
                foreach ($this->cart_canchas->contents() as $cancha){
                    $id_can = $cancha['id'];
                  $this->servicio->discount_canchas($id_can);
                }
            }

            if ($this->cart_empleados->contents() != NULL){
                foreach ($this->cart_empleados->contents() as $empleado){
                    $empleados = array(
                        'servicio'     => $id_ser,
                        'empleado'   => $empleado['id']
                    );    

                    $this->servicio->set_empleados($empleados);
                }
            }

            if ($this->cart_empleados->contents() != NULL){
                foreach ($this->cart_empleados->contents() as $empleado){
                    $id_emp = $empleado['id'];
                  $this->servicio->discount_empleados($id_emp);
                }
            }

            if ($this->cart_implementos->contents() != NULL){
                foreach ($this->cart_implementos->contents() as $implemento){
                    $implementos = array(
                        'servicio'     => $id_ser,
                        'implemento'   => $implemento['id'],
                        'cantidad'   => $implemento['cantidad'],
                        'unidad'   => $implemento['unidad']
                    );    

                    $this->servicio->set_implementos($implementos);
                }
            }

            if ($this->cart_implementos->contents() != NULL){
                foreach ($this->cart_implementos->contents() as $implemento){
                    $id_imp = $implemento['id'];
                    $cantidad = $implemento['cantidad'];
                    $implemento_act = $this->servicio->get_implemento_by_id($id_imp);
                    if($implemento_act != false)
                    {
                        $actual = $implemento_act->stock;
                        $descuento = $actual - $cantidad;
                    }    
                  $this->servicio->discount_implementos($id_imp,$descuento);
                }
            }

            if ($this->cart_invitados->contents() != NULL){
                foreach ($this->cart_invitados->contents() as $invitado){
                    $invitados = array(
                        'servicio'     => $id_ser,
                        'cedula'    => $invitado['cedula'],
                        'nombre'    => $invitado['nombre']
                    );

                    $this->servicio->set_invitados($invitados);
                }
            }

            $bitacora = array(
                'tipo' => 'servicio',
                'movimiento' => 'Se ha actualizado el estado del servicio '.$id_ser.'.',
                'usuario' => $this->session->userdata('id_usuario')
            );      

            $this->bitacora->set($bitacora);

            $this->cart_beneficiarios->destroy();
            $this->cart_cabanas->destroy();
            $this->cart_canchas->destroy();
            $this->cart_empleados->destroy();
            $this->cart_implementos->destroy();
            $this->cart_invitados->destroy();

            echo json_encode(array("status" => true));
        }
        else
        {
            if($this->cart_beneficiarios->contents() == NULL && $this->cart_cabanas->contents() == NULL && $this->cart_canchas->contents() == NULL && $this->cart_implementos->contents() == NULL && $this->cart_empleados->contents() == NULL && $this->cart_invitados->contents() == NULL)
            {
                echo json_encode(array("status" => false, "reason" => "carros"));
            }
            else
            {
                if($this->cart_beneficiarios->contents() == NULL){
                echo json_encode(array("status" => false, "reason" => "beneficiarios"));
                }
                else if($this->cart_cabanas->contents() == NULL && $this->cart_canchas->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "servicio"));
                }
                else if($this->cart_implementos->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "implementos"));
                }
                else if($this->cart_empleados->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "empleados"));
                }
                else if($this->cart_invitados->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "invitados"));
                }
            }
        }
    }

    public function end($id_ser = NULL)
    {
        if($this->cart_beneficiarios->contents() != NULL && $this->cart_cabanas->contents() != NULL && $this->cart_canchas->contents() == NULL && $this->cart_implementos->contents() != NULL && $this->cart_empleados->contents() != NULL && $this->cart_invitados->contents() != NULL || $this->cart_beneficiarios->contents() != NULL && $this->cart_cabanas->contents() == NULL && $this->cart_canchas->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_empleados->contents() != NULL && $this->cart_invitados->contents() != NULL || $this->cart_beneficiarios->contents() != NULL && $this->cart_cabanas->contents() != NULL && $this->cart_canchas->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_empleados->contents() != NULL && $this->cart_invitados->contents() != NULL)
        {
            $servicio = array(
                'usuario' => $this->session->userdata('id_usuario'),
                'observacion' => $this->input->post('observacion'),
                'estado' => 'Finalizado'
            );
            
            $this->servicio->update(array('id_ser' => $id_ser), $servicio);

            if ($this->cart_cabanas->contents() != NULL):
                foreach ($this->cart_cabanas->contents() as $cabana):
                    $id_cab = $cabana['id'];
                  $this->servicio->increment_cabanas($id_cab);
                endforeach;
            endif;

            if ($this->cart_canchas->contents() != NULL):
                foreach ($this->cart_canchas->contents() as $cancha):
                    $id_can = $cancha['id'];
                  $this->servicio->increment_canchas($id_can);
                endforeach;
            endif;

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $id_emp = $empleado['id'];
                  $this->servicio->increment_empleados($id_emp);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $id_imp = $implemento['id'];
                    $cantidad = $implemento['cantidad'];
                    $implemento_act = $this->servicio->get_implemento_by_id($id_imp);
                    if($implemento_act != false)
                    {
                        $actual = $implemento_act->stock;
                        $incremento = $actual + $cantidad;
                    }    
                  $this->servicio->increment_implementos($id_imp,$incremento);
                endforeach;
            endif;

            $bitacora = array(
                'tipo' => 'servicio',
                'movimiento' => 'Se ha finalizado el servicio número '.$id_ser.'.',
                'usuario' => $this->session->userdata('id_usuario')
            );      

            $this->bitacora->set($bitacora);

            $this->cart_beneficiarios->destroy();
            $this->cart_cabanas->destroy();
            $this->cart_canchas->destroy();
            $this->cart_empleados->destroy();
            $this->cart_implementos->destroy();
            $this->cart_invitados->destroy();

            echo json_encode(array("status" => true));
        }
        else
        {
            if($this->cart_beneficiarios->contents() == NULL && $this->cart_cabanas->contents() == NULL && $this->cart_canchas->contents() == NULL && $this->cart_implementos->contents() == NULL && $this->cart_empleados->contents() == NULL && $this->cart_invitados->contents() == NULL)
            {
                echo json_encode(array("status" => false, "reason" => "carros"));
            }
            else
            {
                if($this->cart_beneficiarios->contents() == NULL){
                echo json_encode(array("status" => false, "reason" => "beneficiarios"));
                }
                else if($this->cart_cabanas->contents() == NULL && $this->cart_canchas->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "servicio"));
                }
                else if($this->cart_implementos->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "implementos"));
                }
                else if($this->cart_empleados->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "empleados"));
                }
                else if($this->cart_invitados->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "invitados"));
                }
            }
        }
    }

    public function report($id_ser = NULL)
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('ser_access') == 1)
        {
            $session = array(
                'proceso' => 'servicio_report',
                'numero' => $id_ser
            );

            $this->session->set_userdata($session);

            $data = array(
                'servicio'   =>    $this->servicio->get_servicio($id_ser),
                'beneficiarios'   =>    $this->servicio->get_beneficiarios($id_ser),
                'empleados'   =>    $this->servicio->get_empleados($id_ser),
                'cabanas'   =>    $this->servicio->get_cabanas($id_ser),
                'canchas'   =>    $this->servicio->get_canchas($id_ser),
                'implementos'   =>    $this->servicio->get_implementos($id_ser),
                'invitados'   =>    $this->servicio->get_invitados($id_ser),
                'controller' => 'servicio'
            );

            if (empty($data['servicio']))
            {
                show_404();
            }

            $this->load->view('templates/links');
            $this->load->view('servicios/report',$data);
        }
    }

    public function list_beneficiarios_asignados()
    {
        $list = $this->cart_beneficiarios->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $beneficiario)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $beneficiario['cedula'];
            $row[] = $beneficiario['nombre'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_beneficiario('."'".$beneficiario['rowid']."'".')">
                        <i class="icon-trash"></i>
                    </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cart_beneficiarios->total_beneficiarios(),
            "recordsFiltered" => $this->cart_beneficiarios->total_beneficiarios(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function assign_beneficiario($id_ben)
    {
        $beneficiario = $this->beneficiario->get_by_id($id_ben);
        $beneficiarios = array(
            'id' => $id_ben,
            'cedula' => $beneficiario['cedula'],
            'nombre' => $beneficiario['nombre'],
            'cantidad' => 1
        );

        $repeat = 0;

        foreach($this->cart_beneficiarios->contents() as $carrito)
        {
            if($carrito['id'] == $id_ben)
            {
                $repeat++;
            }
        }

        if($repeat == 0)
        {
            $this->cart_beneficiarios->insert($beneficiarios);

            if($this->cart_beneficiarios->insert($beneficiarios) === md5($id_ben))
            {
                $data = array(
                    'title' => 'Éxito',
                    'text' => '¡El beneficiario fue asignado!',
                    'type' => 'success',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡No puedes asignar al mismo beneficiario!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_beneficiarios()
    {
        $count_beneficiarios = $this->cart_beneficiarios->total_beneficiarios();

        $data = array(
            'count_beneficiarios' => $count_beneficiarios
        );
        echo json_encode($data);
    }

    public function deny_beneficiario($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_beneficiarios->destroy();
        }
        else
        {
            $beneficiarios = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_beneficiarios->update($beneficiarios);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡El beneficiario fue denegado!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_beneficiarios()
    {
        if($this->cart_beneficiarios->contents() != NULL)
        {
            $this->cart_beneficiarios->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de beneficiarios fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de beneficiarios está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    public function list_cabanas_asignadas()
    {
        $list = $this->cart_cabanas->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $cabana)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $cabana['numero'];
            $row[] = $cabana['capacidad'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_cabana('."'".$cabana['rowid']."'".')">
                        <i class="icon-trash"></i>
                    </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cart_cabanas->total_cabanas(),
            "recordsFiltered" => $this->cart_cabanas->total_cabanas(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function assign_cabana($id_cab)
    {
        $cabana = $this->cabana->get_by_id($id_cab);
        $cabanas = array(
            'id' => $id_cab,
            'numero' => $cabana['numero'],
            'capacidad' => $cabana['capacidad'],
            'cantidad' => 1
        );

        $repeat = 0;

        foreach($this->cart_cabanas->contents() as $carrito)
        {
            if($carrito['id'] == $id_cab)
            {
                $repeat++;
            }
        }

        if($repeat == 0)
        {
            $this->cart_cabanas->insert($cabanas);

            if($this->cart_cabanas->insert($cabanas) === md5($id_cab))
            {
                $data = array(
                    'title' => 'Éxito',
                    'text' => '¡La cabaña fue asignado!',
                    'type' => 'success',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡No puedes asignar al mismo cabana!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_cabanas()
    {
        $count_cabanas = $this->cart_cabanas->total_cabanas();

        $data = array(
            'count_cabanas' => $count_cabanas
        );
        echo json_encode($data);
    }

    public function deny_cabana($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_cabanas->destroy();
        }
        else
        {
            $cabanas = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_cabanas->update($cabanas);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡La cabaña fue denegado!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_cabanas()
    {
        if($this->cart_cabanas->contents() != NULL)
        {
            $this->cart_cabanas->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de cabañas fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de cabañas está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    public function list_canchas_asignadas()
    {
        $list = $this->cart_canchas->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $cancha)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $cancha['numero'];
            $row[] = $cancha['capacidad'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_cancha('."'".$cancha['rowid']."'".')">
                        <i class="icon-trash"></i>
                    </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cart_canchas->total_canchas(),
            "recordsFiltered" => $this->cart_canchas->total_canchas(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function assign_cancha($id_can)
    {
        $cancha = $this->cancha->get_by_id($id_can);
        $canchas = array(
            'id' => $id_can,
            'numero' => $cancha['numero'],
            'capacidad' => $cancha['capacidad'],
            'cantidad' => 1
        );

        $repeat = 0;

        foreach($this->cart_canchas->contents() as $carrito)
        {
            if($carrito['id'] == $id_can)
            {
                $repeat++;
            }
        }

        if($repeat == 0)
        {
            $this->cart_canchas->insert($canchas);

            if($this->cart_canchas->insert($canchas) === md5($id_can))
            {
                $data = array(
                    'title' => 'Éxito',
                    'text' => '¡La cabaña fue asignado!',
                    'type' => 'success',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡No puedes asignar al mismo cancha!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_canchas()
    {
        $count_canchas = $this->cart_canchas->total_canchas();

        $data = array(
            'count_canchas' => $count_canchas
        );
        echo json_encode($data);
    }

    public function deny_cancha($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_canchas->destroy();
        }
        else
        {
            $canchas = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_canchas->update($canchas);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡La cabaña fue denegado!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_canchas()
    {
        if($this->cart_canchas->contents() != NULL)
        {
            $this->cart_canchas->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de canchas fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de canchas está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    public function list_empleados_asignados()
    {
        $list = $this->cart_empleados->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $empleado)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $empleado['cedula'];
            $row[] = $empleado['nombre'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_empleado('."'".$empleado['rowid']."'".')">
                        <i class="icon-trash"></i>
                    </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cart_empleados->total_empleados(),
            "recordsFiltered" => $this->cart_empleados->total_empleados(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function assign_empleado($id_emp)
    {
        $empleado = $this->empleado->get_by_id($id_emp);
        $empleados = array(
            'id' => $id_emp,
            'cedula' => $empleado['cedula'],
            'nombre' => $empleado['nombre'],
            'cantidad' => 1
        );

        $repeat = 0;

        foreach($this->cart_empleados->contents() as $carrito)
        {
            if($carrito['id'] == $id_emp)
            {
                $repeat++;
            }
        }

        if($repeat == 0)
        {
            $this->cart_empleados->insert($empleados);

            if($this->cart_empleados->insert($empleados) === md5($id_emp))
            {
                $data = array(
                    'title' => 'Éxito',
                    'text' => '¡El empleado fue asignado!',
                    'type' => 'success',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡No puedes asignar al mismo empleado!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_empleados()
    {
        $count_empleados = $this->cart_empleados->total_empleados();

        $data = array(
            'count_empleados' => $count_empleados
        );
        echo json_encode($data);
    }

    public function deny_empleado($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_empleados->destroy();
        }
        else
        {
            $empleados = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_empleados->update($empleados);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡El empleado fue denegado!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_empleados()
    {
        if($this->cart_empleados->contents() != NULL)
        {
            $this->cart_empleados->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de empleados fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de empleados está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    public function list_implementos_asignados()
    {
        $list = $this->cart_implementos->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $implemento)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $implemento['codigo'];
            $row[] = $implemento['nombre'];
            $row[] = $implemento['cantidad'];
            $row[] = $implemento['unidad'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_implemento('."'".$implemento['rowid']."'".')">
                        <i class="icon-trash"></i>
                    </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $i-1,
            "recordsFiltered" => $i-1,
            "data" => $data
        );
        echo json_encode($output);
    }

    public function assign_implemento($id_imp)
    {
        $cantidad = $this->input->get('cantidad');
        if($cantidad > 0)
        {
            $implemento = $this->implemento->get_by_id($id_imp);
            $implementos = array(
                'id' => $id_imp,
                'codigo' => $implemento['codigo'],
                'nombre' => $implemento['nombre'],
                'unidad' => $implemento['unidad'],
                'cantidad' => $cantidad
            );

            $this->cart_implementos->insert($implementos);

            if($this->cart_implementos->insert($implementos) === md5($id_imp))
            {
                $data = array(
                    'title' => 'Éxito',
                    'text' => '¡El implemento fue asignado!',
                    'type' => 'success',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡No has asignado ningún implemento!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_implementos()
    {
        $count_implementos = $this->cart_implementos->total_implementos();

        $data = array(
            'count_implementos' => $count_implementos
        );
        echo json_encode($data);
    }

    public function deny_implemento($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_implementos->destroy();
        }
        else
        {
            $implementos = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_implementos->update($implementos);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡El implemento fue denegado!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_implementos()
    {
        if($this->cart_implementos->contents() != NULL)
        {
            $this->cart_implementos->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de implementos fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de implementos está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    /*public function select_empleados_asignados()
    {
        $data = array();
        $data = $this->cart_empleados->contents();
        echo json_encode($data);
    }*/

    public function list_invitados_asignados()
    {
        $list = $this->cart_invitados->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $invitado)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $invitado['cedula'];
            $row[] = $invitado['nombre'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_invitado('."'".$invitado['rowid']."'".')">
                        <i class="icon-trash"></i>
                    </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $i-1,
            "recordsFiltered" => $i-1,
            "data" => $data
        );
        echo json_encode($output);
    }

    public function assign_invitado()
    {
        $validate_method = "invitado";

        $this->_validate($validate_method);

        $cedula = $this->input->post('cedula');
        $nombre = $this->input->post('nombre');

        if($cedula!='' && $nombre!='')
        {

            $id = rand(1,100000000000000000);

            $invitados = array(
                'id' => $id,
                'cedula' => $this->input->post('cedula'),
                'nombre' => $this->input->post('nombre'),
                'cantidad' => 1
            );

            $repeat = 0;

            foreach($this->cart_invitados->contents() as $carrito)
            {
                if($carrito['cedula'] == $this->input->post('cedula'))
                {
                    $repeat++;
                }
            }

            if($repeat == 0)
            {
                $this->cart_invitados->insert($invitados);

                if($this->cart_invitados->insert($invitados) === md5($id))
                {
                    $data = array(
                        'title' => 'Éxito',
                        'text' => '¡El invitado fue asignado!',
                        'type' => 'success',
                        'status' => TRUE
                    );
                }
            }
            else
            {
                $data = array(
                    'title' => 'Error',
                    'text' => '¡No puedes asignar al mismo invitado!',
                    'type' => 'error',
                    'swalx' => TRUE
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡La cédula y el nombre del invitado son campos requeridos!',
                'type' => 'error',
                'swalx' => TRUE,
                'status' => FALSE
            ); 
        }
        echo json_encode($data);
    }

     public function count_invitados()
    {
        $count_invitados = $this->cart_invitados->total_invitados();

        $data = array(
            'count_invitados' => $count_invitados
        );
        echo json_encode($data);
    }

    public function deny_invitado($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_invitados->destroy();
        }
        else
        {
            $invitados = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_invitados->update($invitados);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡El invitado fue denegado!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_invitados()
    {
        if($this->cart_invitados->contents() != NULL)
        {
            $this->cart_invitados->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de invitados fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de invitados está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    private function _validate($validate_method = NULL)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($validate_method == 'invitado')
        {
            if($this->input->post('cedula') == '')
            {
                $data['inputerror'][] = 'cedula';
                $data['error_string'][] = 'La cedula es requerida.';
                $data['status'] = FALSE;
            }

            if($this->input->post('nombre') == '')
            {
                $data['inputerror'][] = 'nombre';
                $data['error_string'][] = 'El nombre es requerido.';
                $data['status'] = FALSE;
            }
        }
        else
        {
            if($this->input->post('fecha') == '')
            {
                $data['inputerror'][] = 'fecha';
                $data['error_string'][] = 'La fecha es requerida.';
                $data['status'] = FALSE;
            }

            if($this->input->post('hora') == '')
            {
                $data['inputerror'][] = 'hora';
                $data['error_string'][] = 'La hora es requerida.';
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
