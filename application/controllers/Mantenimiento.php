<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mantenimiento extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('actividad_model','actividad');
        $this->load->model('area_model','area');
        $this->load->model('bitacora_model','bitacora');
        $this->load->model('mantenimiento_model','mantenimiento');
        $this->load->model('empleado_model','empleado');
        $this->load->model('edificio_model','edificio');
        $this->load->model('implemento_model','implemento');
        $this->load->library('cart_actividades');
        $this->load->library('cart_actividades_realizadas');
        $this->load->library('cart_areas');
        $this->load->library('cart_empleados');
        $this->load->library('cart_edificios');
        $this->load->library('cart_implementos');
	}

    public function list_mantenimientos_pendientes()
    {
        $list = $this->mantenimiento->get_datatables_pendientes();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $mantenimiento)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $mantenimiento->id_man;
            $row[] = $mantenimiento->usuario;
            $row[] = $mantenimiento->fecha_asig;
            $row[] = $mantenimiento->hora_asig;
            $row[] = $mantenimiento->fecha_act;
            $row[] = $mantenimiento->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$mantenimiento->id_man."'".')" title="Actualizar">
                    <i class="icon-pencil"></i>
                </a>
                <a class="btn btn-link" href="javascript:void(0)" title="Imprimir">
                    <i class="icon-printer"></i>
                </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mantenimiento->count_all(),
            "recordsFiltered" => $this->mantenimiento->count_filtered_pendientes(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function list_mantenimientos_en_progresos()
    {
        $list = $this->mantenimiento->get_datatables_en_progresos();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $mantenimiento)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $mantenimiento->id_man;
            $row[] = $mantenimiento->usuario;
            $row[] = $mantenimiento->fecha_asig;
            $row[] = $mantenimiento->hora_asig;
            $row[] = $mantenimiento->fecha_act;
            $row[] = $mantenimiento->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$mantenimiento->id_man."'".')" title="Controlar">
                    <i class="icon-note"></i>
                </a>
                <a class="btn btn-link" href="javascript:void(0)" title="Imprimir">
                    <i class="icon-printer"></i>
                </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mantenimiento->count_all(),
            "recordsFiltered" => $this->mantenimiento->count_filtered_en_progresos(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function list_mantenimientos_finalizados()
    {
        $list = $this->mantenimiento->get_datatables_finalizados();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $mantenimiento)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $mantenimiento->id_man;
            $row[] = $mantenimiento->usuario;
            $row[] = $mantenimiento->fecha_asig;
            $row[] = $mantenimiento->hora_asig;
            $row[] = $mantenimiento->fecha_act;
            $row[] = $mantenimiento->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$mantenimiento->id_man."'".')" title="Ver">
                    <i class="icon-eye"></i>
                </a>
                <a class="btn btn-link" href="javascript:void(0)" title="Imprimir">
                    <i class="icon-printer"></i>
                </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mantenimiento->count_all(),
            "recordsFiltered" => $this->mantenimiento->count_filtered_finalizados(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function index()
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('man_access') == 1)
        {
            $this->cart_empleados->destroy();
            $this->cart_areas->destroy();
            $this->cart_edificios->destroy();
            $this->cart_implementos->destroy();
            $this->cart_actividades->destroy();

            $this->session->unset_userdata('proceso');

            $session = array(
                'proceso' => 'mantenimiento'
            );

            $this->session->set_userdata($session);

            $data = array(
                'mantenimientos' => $this->mantenimiento->get_all(),
                'controller' => 'mantenimiento'
            );

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('mantenimientos/index',$data);
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
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('man_access') == 1)
        {
            if($this->session->userdata('proceso') != "mantenimiento")
            {
                $this->cart_empleados->destroy();
                $this->cart_areas->destroy();
                $this->cart_edificios->destroy();
                $this->cart_implementos->destroy();
                $this->cart_actividades->destroy();

                $this->session->unset_userdata('proceso');
            }

            $session = array(
                'proceso' => 'mantenimiento'
            );

            $this->session->set_userdata($session);

            $data = array(
                'total_man' => $this->mantenimiento->get_numero(),
                'controller' => 'mantenimiento'
            );

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('mantenimientos/create',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
        else
        {
            show_404();
        }
    }

    public function control($id_man = NULL)
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('man_access') == 1)
        {
            if($this->session->userdata('proceso') != "mantenimiento_control" || $id_man != $this->session->userdata('numero'))
            {
                $this->cart_empleados->destroy();
                $this->cart_areas->destroy();
                $this->cart_edificios->destroy();
                $this->cart_implementos->destroy();
                $this->cart_actividades->destroy();
                $this->cart_actividades_realizadas->destroy();

                $this->session->unset_userdata('proceso');
                $this->session->unset_userdata('numero');
            }
            
            $session = array(
                'proceso' => 'mantenimiento_control',
                'numero' => $id_man
            );

            $this->session->set_userdata($session);

            $data = array(
                'mantenimiento'   =>    $this->mantenimiento->get_mantenimiento($id_man),
                'empleados' => $this->mantenimiento->get_empleados($id_man),
                'controller' => 'mantenimiento'
            );
            
            $mantenimiento = $this->mantenimiento->get_mantenimiento($id_man);

            if (empty($data['mantenimiento']))
            {
                show_404();
            }

            $empleados = $this->mantenimiento->get_empleados($id_man);

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

            $areas = $this->mantenimiento->get_areas($id_man);

            if($areas == TRUE)
            {
                if ($cart_areas = $this->cart_areas->contents() == NULL)
                {
                    foreach ($areas as $area):
                        $areass = array(
                            'id' => $area->id_are,
                            'codigo' => $area->codigo,
                            'nombre' => $area->area,
                            'cantidad' => 1
                        );

                        $this->cart_areas->insert($areass);
                  endforeach;
                }
            }

            $edificios = $this->mantenimiento->get_edificios($id_man);

            if($edificios == TRUE)
            {
                if ($cart_edificios = $this->cart_edificios->contents() == NULL)
                {
                    foreach ($edificios as $edificio):
                        $edificioss = array(
                            'id' => $edificio->edificio,
                            'numero' => $edificio->numero,
                            'nombre' => $edificio->nombre,
                            'cantidad' => 1
                        );

                        $this->cart_edificios->insert($edificioss);
                  endforeach;
                }
            }

            $implementos = $this->mantenimiento->get_implementos($id_man);

            if($implementos == TRUE)
            {
                if ($cart_implementos = $this->cart_implementos->contents() == NULL)
                {
                    foreach ($implementos as $implemento):
                        $implementoss = array(
                            'id' => $implemento->implemento,
                            'codigo' => $implemento->codigo,
                            'nombre' => $implemento->nombre,
                            'cantidad' => $implemento->cantidad,
                            'unidad' => $implemento->unidad
                        );
                        $this->cart_implementos->insert($implementoss);
                  endforeach;
                }
            }

            if($mantenimiento['estado'] == 'Pendiente' || $mantenimiento['estado'] == 'En progreso')
            {
                $actividades = $this->mantenimiento->get_actividades($id_man);

                if($actividades == TRUE)
                {
                    if ($cart_actividades = $this->cart_actividades->contents() == NULL)
                    {
                        foreach ($actividades as $actividad):
                            $actividadess = array(
                                'id' => $actividad->actividad,
                                'accion' => $actividad->accion,
                                'encargado' => $actividad->encargado,
                                'cantidad' => 1
                            );

                            $this->cart_actividades->insert($actividadess);
                      endforeach;
                    }
                }
            }
            if($mantenimiento['estado'] == 'Finalizado')
            {
                $actividades_realizadas = $this->mantenimiento->get_actividades($id_man);

                if($actividades_realizadas == TRUE)
                {
                    if ($cart_actividades_realizadas = $this->cart_actividades_realizadas->contents() == NULL)
                    {
                        foreach ($actividades_realizadas as $actividad_realizada):
                            $actividadess_realizadas = array(
                                'id' => $actividad_realizada->actividad,
                                'accion' => $actividad_realizada->accion,
                                'encargado' => $actividad_realizada->encargado,
                                'cantidad' => 1
                            );

                            $this->cart_actividades_realizadas->insert($actividadess_realizadas);
                      endforeach;
                    }
                }
            }

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('mantenimientos/control',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
    }

    public function process($id_man = NULL)
    {
        if($this->cart_empleados->contents() != NULL && $this->cart_empleados->contents() != NULL && $this->cart_areas->contents() != NULL && $this->cart_edificios->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_actividades->contents() != NULL)
        {
            $this->_validate();
            $this->form_validation->set_rules('fecha', 'fecha', 'is_unique[mantenimientos.fecha_asig]');

            if($this->form_validation->run() == TRUE)
            {           
                $mantenimiento = array(
                    'usuario' => $this->session->userdata('id_usuario'),
                    'fecha_asig' => $this->input->post('fecha'),
                    'hora_asig' => $this->input->post('hora'),
                    'estado' => 'Pendiente'
                );
                
                $id_man = $this->mantenimiento->save($mantenimiento);

                if ($this->cart_empleados->contents() != NULL):
                    foreach ($this->cart_empleados->contents() as $empleado):
                        $empleados = array(
                            'mantenimiento'     => $id_man,
                            'empleado'   => $empleado['id']
                        );    

                        $this->mantenimiento->set_empleados($empleados);
                    endforeach;
                endif;

                if ($this->cart_areas->contents() != NULL):
                    foreach ($this->cart_areas->contents() as $area):
                        $areas = array(
                            'mantenimiento'     => $id_man,
                            'id_are'   => $area['id']
                        );    

                        $this->mantenimiento->set_areas($areas);
                    endforeach;
                endif;

                if ($this->cart_edificios->contents() != NULL):
                    foreach ($this->cart_edificios->contents() as $edificio):
                        $edificios = array(
                            'mantenimiento'     => $id_man,
                            'edificio'   => $edificio['id']
                        );    

                        $this->mantenimiento->set_edificios($edificios);
                    endforeach;
                endif;

                if ($this->cart_implementos->contents() != NULL):
                    foreach ($this->cart_implementos->contents() as $implemento):
                        $implementos = array(
                            'mantenimiento'     => $id_man,
                            'implemento'   => $implemento['id'],
                            'cantidad'   => $implemento['cantidad'],
                            'unidad'   => $implemento['unidad']
                        );    

                        $this->mantenimiento->set_implementos($implementos);
                    endforeach;
                endif;

                if ($this->cart_actividades->contents() != NULL):
                    foreach ($this->cart_actividades->contents() as $actividad):
                        $actividades = array(
                            'mantenimiento'     => $id_man,
                            'actividad'   => $actividad['id'],
                            'encargado' => $actividad['encargado']
                        );    

                        $this->mantenimiento->set_actividades($actividades);
                    endforeach;
                endif;

                $bitacora = array(
                    'tipo' => 'mantenimiento',
                    'movimiento' => 'Se ha registrado un mantenimiento.',
                    'usuario' => $this->session->userdata('id_usuario')
                );      

                $this->bitacora->set($bitacora);
                $this->cart_empleados->destroy();
                $this->cart_areas->destroy();
                $this->cart_edificios->destroy();
                $this->cart_implementos->destroy();
                $this->cart_actividades->destroy();

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
            if($this->cart_empleados->contents() == NULL && $this->cart_areas->contents() == NULL && $this->cart_edificios->contents() == NULL && $this->cart_implementos->contents() == NULL && $this->cart_actividades->contents() == NULL)
            {
                echo json_encode(array("status" => false, "reason" => "carros"));
            }
            else
            {
                if($this->cart_empleados->contents() == NULL){
                echo json_encode(array("status" => false, "reason" => "empleados"));
                }
                else if($this->cart_areas->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "areas"));
                }
                else if($this->cart_edificios->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "edificios"));
                }
                else if($this->cart_implementos->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "implementos"));
                }
                else if($this->cart_actividades->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "actividades"));
                }
            }
        }
    }

    public function update($id_man = NULL)
    {
        if($this->cart_empleados->contents() != NULL && $this->cart_areas->contents() != NULL && $this->cart_edificios->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_actividades->contents() != NULL)
        {
            $this->_validate();
                        
            $mantenimiento = array(
                'usuario' => $this->session->userdata('id_usuario'),
                'fecha_asig' => $this->input->post('fecha'),
                'hora_asig' => $this->input->post('hora'),
                'estado' => 'En progreso'
            );
            
            $this->mantenimiento->update(array('id_man' => $id_man), $mantenimiento);

            $this->mantenimiento->delete_empleados($id_man);
            $this->mantenimiento->delete_areas($id_man);
            $this->mantenimiento->delete_edificios($id_man);
            $this->mantenimiento->delete_implementos($id_man);
            $this->mantenimiento->delete_actividades($id_man);

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $empleados = array(
                        'mantenimiento'     => $id_man,
                        'empleado'   => $empleado['id']
                    );    

                    $this->mantenimiento->set_empleados($empleados);
                endforeach;
            endif;

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $id_emp = $empleado['id'];
                  $this->mantenimiento->discount_empleados($id_emp);
                endforeach;
            endif;

            if ($this->cart_areas->contents() != NULL):
                foreach ($this->cart_areas->contents() as $area):
                    $areas = array(
                        'mantenimiento'     => $id_man,
                        'id_are'   => $area['id']
                    );    

                    $this->mantenimiento->set_areas($areas);
                endforeach;
            endif;

            if ($this->cart_edificios->contents() != NULL):
                foreach ($this->cart_edificios->contents() as $edificio):
                    $edificios = array(
                        'mantenimiento'     => $id_man,
                        'edificio'   => $edificio['id']
                    );    

                    $this->mantenimiento->set_edificios($edificios);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $implementos = array(
                        'mantenimiento'     => $id_man,
                        'implemento'   => $implemento['id'],
                        'cantidad'   => $implemento['cantidad'],
                        'unidad'   => $implemento['unidad']
                    );    

                    $this->mantenimiento->set_implementos($implementos);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $id_imp = $implemento['id'];
                    $cantidad = $implemento['cantidad'];
                    $implemento_act = $this->mantenimiento->get_implemento_by_id($id_imp);
                    if($implemento_act != false)
                    {
                        $actual = $implemento_act->stock;
                        $descuento = $actual - $cantidad;
                    }    
                  $this->mantenimiento->discount_implementos($id_imp,$descuento);
                endforeach;
            endif;

            if ($this->cart_actividades->contents() != NULL):
                foreach ($this->cart_actividades->contents() as $actividad):
                    $actividades = array(
                        'mantenimiento'     => $id_man,
                        'actividad'   => $actividad['id'],
                        'encargado' => $actividad['encargado']
                    );    

                    $this->mantenimiento->set_actividades($actividades);
                endforeach;
            endif;

            $bitacora = array(
                    'tipo' => 'mantenimiento',
                    'movimiento' => 'Se ha actualizado el estado del mantenimiento '.$id_man.'.',
                    'usuario' => $this->session->userdata('id_usuario')
                );      

            $this->bitacora->set($bitacora);

            $this->cart_empleados->destroy();
            $this->cart_areas->destroy();
            $this->cart_edificios->destroy();
            $this->cart_implementos->destroy();
            $this->cart_actividades->destroy();

            echo json_encode(array("status" => true));
        }
        else
        {
            if($this->cart_empleados->contents() == NULL && $this->cart_areas->contents() == NULL && $this->cart_edificios->contents() == NULL && $this->cart_implementos->contents() == NULL && $this->cart_actividades->contents() == NULL)
            {
                echo json_encode(array("status" => false, "reason" => "carros"));
            }
            else
            {
                if($this->cart_empleados->contents() == NULL){
                echo json_encode(array("status" => false, "reason" => "empleados"));
                }
                else if($this->cart_areas->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "areas"));
                }
                else if($this->cart_edificios->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "edificios"));
                }
                else if($this->cart_implementos->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "implementos"));
                }
                else if($this->cart_actividades->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "actividades"));
                }
            }
        }
    }

    public function end($id_man = NULL)
    {
        if($this->cart_empleados->contents() != NULL && $this->cart_areas->contents() != NULL && $this->cart_edificios->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_actividades_realizadas->contents() != NULL)
        {
            $mantenimiento = array(
                'usuario' => $this->session->userdata('id_usuario'),
                'estado' => 'Finalizado'
            );
            
            $this->mantenimiento->update(array('id_man' => $id_man), $mantenimiento);
            $this->mantenimiento->delete_empleados($id_man);
            $this->mantenimiento->delete_areas($id_man);
            $this->mantenimiento->delete_edificios($id_man);
            $this->mantenimiento->delete_implementos($id_man);
            $this->mantenimiento->delete_actividades($id_man);

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $empleados = array(
                        'mantenimiento'     => $id_man,
                        'empleado'   => $empleado['id']
                    );    

                    $this->mantenimiento->set_empleados($empleados);
                endforeach;
            endif;

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $id_emp = $empleado['id'];
                  $this->mantenimiento->increment_empleados($id_emp);
                endforeach;
            endif;

            if ($this->cart_areas->contents() != NULL):
                foreach ($this->cart_areas->contents() as $area):
                    $areas = array(
                        'mantenimiento'     => $id_man,
                        'id_are'   => $area['id']
                    );    
                    $this->mantenimiento->set_areas($areas);
                endforeach;
            endif;

            if ($this->cart_edificios->contents() != NULL):
                foreach ($this->cart_edificios->contents() as $edificio):
                    $edificios = array(
                        'mantenimiento'     => $id_man,
                        'edificio'   => $edificio['id']
                    );    

                    $this->mantenimiento->set_edificios($edificios);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $implementos = array(
                        'mantenimiento'     => $id_man,
                        'implemento'   => $implemento['id'],
                        'cantidad'   => $implemento['cantidad'],
                        'unidad'   => $implemento['unidad']
                    );    

                    $this->mantenimiento->set_implementos($implementos);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $id_imp = $implemento['id'];
                    $cantidad = $implemento['cantidad'];
                    $implemento_act = $this->mantenimiento->get_implemento_by_id($id_imp);
                    if($implemento_act != false)
                    {
                        $actual = $implemento_act->stock;
                        $incremento = $actual + $cantidad;
                    }    
                  $this->mantenimiento->increment_implementos($id_imp,$incremento);
                endforeach;
            endif;

            if ($this->cart_actividades_realizadas->contents() != NULL):
                foreach ($this->cart_actividades_realizadas->contents() as $actividad):
                    $actividades = array(
                        'mantenimiento'     => $id_man,
                        'actividad'   => $actividad['id'],
                        'encargado' => $actividad['encargado']
                    );    

                    $this->mantenimiento->set_actividades($actividades);
                endforeach;
            endif;

            $bitacora = array(
                    'tipo' => 'mantenimiento',
                    'movimiento' => 'Se ha finalizado el mantenimiento número '.$id_man.'.',
                    'usuario' => $this->session->userdata('id_usuario')
                );      

            $this->bitacora->set($bitacora);

            $this->cart_empleados->destroy();
            $this->cart_areas->destroy();
            $this->cart_edificios->destroy();
            $this->cart_implementos->destroy();
            $this->cart_actividades->destroy();
            $this->cart_actividades_realizadas->destroy();

            echo json_encode(array("status" => true));
        }
        else
        {
            if($this->cart_empleados->contents() == NULL && $this->cart_areas->contents() == NULL && $this->cart_edificios->contents() == NULL && $this->cart_implementos->contents() == NULL && $this->cart_actividades_realizadas->contents() == NULL)
            {
                echo json_encode(array("status" => false, "reason" => "carros"));
            }
            else
            {
                if($this->cart_empleados->contents() == NULL){
                echo json_encode(array("status" => false, "reason" => "empleados"));
                }
                else if($this->cart_areas->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "areas"));
                }
                else if($this->cart_edificios->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "edificios"));
                }
                else if($this->cart_implementos->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "implementos"));
                }
                else if($this->cart_actividades_realizadas->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "actividades"));
                }
            }
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

    public function list_areas_asignadas()
    {
        $list = $this->cart_areas->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $area)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $area['codigo'];
            $row[] = $area['nombre'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_area('."'".$area['rowid']."'".')">
                        <i class="icon-trash"></i>
                    </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cart_areas->total_areas(),
            "recordsFiltered" => $this->cart_areas->total_areas(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function assign_area($id_are)
    {
        $area = $this->area->get_by_id($id_are);
        $areas = array(
            'id' => $id_are,
            'codigo' => $area['codigo'],
            'nombre' => $area['area'],
            'cantidad' => 1
        );

        $repeat = 0;

        foreach($this->cart_areas->contents() as $carrito)
        {
            if($carrito['id'] == $id_are)
            {
                $repeat++;
            }
        }

        if($repeat == 0)
        {
            $this->cart_areas->insert($areas);

            if($this->cart_areas->insert($areas) === md5($id_are))
            {
                $data = array(
                    'title' => 'Éxito',
                    'text' => '¡El area fue asignada!',
                    'type' => 'success',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡No puedes asignar la misma área!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_areas()
    {
        $count_areas = $this->cart_areas->total_areas();

        $data = array(
            'count_areas' => $count_areas
        );
        echo json_encode($data);
    }

    public function deny_area($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_areas->destroy();
        }
        else
        {
            $areas = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_areas->update($areas);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡El área fue denegada!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_areas()
    {
        if($this->cart_areas->contents() != NULL)
        {
            $this->cart_areas->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de áreas fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de áreas está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    public function list_edificios_asignados()
    {
        $list = $this->cart_edificios->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $edificio)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $edificio['numero'];
            $row[] = $edificio['nombre'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_edificio('."'".$edificio['rowid']."'".')">
                        <i class="icon-trash"></i>
                    </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cart_edificios->total_edificios(),
            "recordsFiltered" => $this->cart_edificios->total_edificios(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function assign_edificio($id_edi)
    {
        $edificio = $this->edificio->get_by_id($id_edi);
        $edificios = array(
            'id' => $id_edi,
            'numero' => $edificio['numero'],
            'nombre' => $edificio['nombre'],
            'cantidad' => 1
        );

        $repeat = 0;

        foreach($this->cart_edificios->contents() as $carrito)
        {
            if($carrito['id'] == $id_edi)
            {
                $repeat++;
            }
        }

        if($repeat == 0)
        {
            $this->cart_edificios->insert($edificios);

            if($this->cart_edificios->insert($edificios) === md5($id_edi))
            {
                $data = array(
                    'title' => 'Éxito',
                    'text' => '¡La edificio fue asignada!',
                    'type' => 'success',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡No puedes asignar la misma edificio!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_edificios()
    {
        $count_edificios = $this->cart_edificios->total_edificios();

        $data = array(
            'count_edificios' => $count_edificios
        );
        echo json_encode($data);
    }

    public function deny_edificio($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_edificios->destroy();
        }
        else
        {
            $edificios = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_edificios->update($edificios);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡La edificio fue denegada!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_edificios()
    {
        if($this->cart_edificios->contents() != NULL)
        {
            $this->cart_edificios->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de edificios fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de edificios está vacio!',
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

    public function list_actividades_asignadas()
    {
        $mantenimiento = $this->mantenimiento->get_mantenimiento($this->session->userdata('numero'));
        $list = $this->cart_actividades->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $actividad)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $actividad['accion'];
            if($mantenimiento['estado'] == 'En progreso')
            {
                $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Asignar" onclick="assign_actividad_empleado('."'".$actividad['id']."'".')">
                            <i class="icon-plus"></i>
                        </a>';
            }
            else
            {
                $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_actividad('."'".$actividad['rowid']."'".')">
                            <i class="icon-trash"></i>
                        </a>';
            }
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

    public function assign_actividad($id_act)
    {
        $actividad = $this->actividad->get_by_id($id_act);
        $actividades = array(
            'id' => $id_act,
            'accion' => $actividad['accion'],
            'encargado' => 'Ninguno',
            'cantidad' => 1
        );

        $repeat = 0;

        foreach($this->cart_actividades->contents() as $carrito)
        {
            if($carrito['id'] == $id_act)
            {
                $repeat++;
            }
        }

        if($repeat == 0)
        {
            $this->cart_actividades->insert($actividades);

            if($this->cart_actividades->insert($actividades) === md5($id_act))
            {
                $data = array(
                    'title' => 'Éxito',
                    'text' => '¡La actividad fue asignada!',
                    'type' => 'success',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡No puedes asignar la misma actividad!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_actividades()
    {
        $count_actividades = $this->cart_actividades->total_actividades();

        $data = array(
            'count_actividades' => $count_actividades
        );
        echo json_encode($data);
    }

    public function deny_actividad($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_actividades->destroy();
        }
        else
        {
            $actividades = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_actividades->update($actividades);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡La actividad fue denegada!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_actividades()
    {
        if($this->cart_actividades->contents() != NULL)
        {
            $this->cart_actividades->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de actividades fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de actividades está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    public function list_actividades_realizadas()
    {
        $list = $this->cart_actividades_realizadas->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $actividad_realizada)
        {
            $encargado = $this->empleado->get_by_id($actividad_realizada['encargado']);
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $actividad_realizada['accion'];
            $row[] = $encargado['nombre'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_actividad_realizada('."'".$actividad_realizada['rowid']."'".')">
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

    public function assign_actividad_realizada()
    {
        $id_emp = $this->input->post('empleado_actividad');
        $id_act = $this->input->post('id_act');

        if($this->input->post('empleado_actividad') != '')
        {
            $actividad = $this->actividad->get_by_id($id_act);
            $actividades = array(
                'id' => $id_act,
                'accion' => $actividad['accion'],
                'encargado' => $id_emp,
                'cantidad' => 1
            );

            $repeat = 0;

            foreach($this->cart_actividades_realizadas->contents() as $carrito)
            {
                if($carrito['id'] == $id_act)
                {
                    $repeat++;
                }
            }

            if($repeat == 0)
            {
                $this->cart_actividades_realizadas->insert($actividades);

                if($this->cart_actividades_realizadas->insert($actividades) === md5($id_act))
                {
                    $data = array(
                        'title' => 'Éxito',
                        'text' => '¡La actividad fue asignada!',
                        'type' => 'success',
                    );
                }
            }
            else
            {
                $data = array(
                    'title' => 'Error',
                    'text' => '¡No puedes asignar la misma actividad!',
                    'type' => 'error',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡Debes seleccionar un empleado para asignar una actividad!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_actividades_realizadas()
    {
        $count_actividades_realizadas = $this->cart_actividades_realizadas->total_actividades_realizadas();

        $data = array(
            'count_actividades_realizadas' => $count_actividades_realizadas
        );
        echo json_encode($data);
    }

    public function deny_actividad_realizada($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_actividades_realizadas->destroy();
        }
        else
        {
            $actividades = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_actividades_realizadas->update($actividades);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡La actividad fue denegada!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_actividades_realizadas()
    {
        if($this->cart_actividades_realizadas->contents() != NULL)
        {
            $this->cart_actividades_realizadas->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de actividades fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de actividades está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

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

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}
