<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reforestacion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('actividad_model','actividad');
        $this->load->model('area_model','area');
        $this->load->model('bitacora_model','bitacora');
        $this->load->model('reforestacion_model','reforestacion');
        $this->load->model('empleado_model','empleado');
        $this->load->model('especie_model','especie');
        $this->load->model('implemento_model','implemento');
        $this->load->library('cart_actividades');
        $this->load->library('cart_actividades_realizadas');
        $this->load->library('cart_areas');
        $this->load->library('cart_empleados');
        $this->load->library('cart_especies');
        $this->load->library('cart_especies_censadas');
        $this->load->library('cart_implementos');
    }

    public function list_reforestaciones_pendientes()
    {
        $list = $this->reforestacion->get_datatables_pendientes();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $reforestacion)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $reforestacion->id_ref;
            $row[] = $reforestacion->usuario;
            $row[] = $reforestacion->fecha_asig;
            $row[] = $reforestacion->hora_asig;
            $row[] = $reforestacion->fecha_act;
            $row[] = $reforestacion->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$reforestacion->id_ref."'".')" title="Actualizar">
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
            "recordsTotal" => $this->reforestacion->count_all(),
            "recordsFiltered" => $this->reforestacion->count_filtered_pendientes(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function list_reforestaciones_en_progresos()
    {
        $list = $this->reforestacion->get_datatables_en_progresos();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $reforestacion)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $reforestacion->id_ref;
            $row[] = $reforestacion->usuario;
            $row[] = $reforestacion->fecha_asig;
            $row[] = $reforestacion->hora_asig;
            $row[] = $reforestacion->fecha_act;
            $row[] = $reforestacion->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$reforestacion->id_ref."'".')" title="Controlar">
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
            "recordsTotal" => $this->reforestacion->count_all(),
            "recordsFiltered" => $this->reforestacion->count_filtered_en_progresos(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function list_reforestaciones_finalizados()
    {
        $list = $this->reforestacion->get_datatables_finalizados();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $reforestacion)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $reforestacion->id_ref;
            $row[] = $reforestacion->usuario;
            $row[] = $reforestacion->fecha_asig;
            $row[] = $reforestacion->hora_asig;
            $row[] = $reforestacion->fecha_act;
            $row[] = $reforestacion->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$reforestacion->id_ref."'".')" title="Ver">
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
            "recordsTotal" => $this->reforestacion->count_all(),
            "recordsFiltered" => $this->reforestacion->count_filtered_finalizados(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function index()
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('cen_access') == 1)
        {
            $this->cart_empleados->destroy();
            $this->cart_areas->destroy();
            $this->cart_especies->destroy();
            $this->cart_implementos->destroy();
            $this->cart_actividades->destroy();

            $this->session->unset_userdata('proceso');

            $session = array(
                'proceso' => 'reforestacion'
            );

            $this->session->set_userdata($session);

            $data = array(
                'reforestaciones' => $this->reforestacion->get_all(),
                'controller' => 'reforestacion'
            );

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('reforestaciones/index',$data);
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
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('cen_access') == 1)
        {
            if($this->session->userdata('proceso') != "reforestacion")
            {
                $this->cart_empleados->destroy();
                $this->cart_areas->destroy();
                $this->cart_especies->destroy();
                $this->cart_implementos->destroy();
                $this->cart_actividades->destroy();

                $this->session->unset_userdata('proceso');
            }

            $session = array(
                'proceso' => 'reforestacion'
            );

            $this->session->set_userdata($session);

            $data = array(
                'total_ref' => $this->reforestacion->get_numero(),
                'controller' => 'reforestacion'
            );

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('reforestaciones/create',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
        else
        {
            show_404();
        }
    }

    public function control($id_ref = NULL)
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('cen_access') == 1)
        {
            if($this->session->userdata('proceso') != "reforestacion_control" || $id_ref != $this->session->userdata('numero'))
            {
                $this->cart_empleados->destroy();
                $this->cart_areas->destroy();
                $this->cart_especies->destroy();
                $this->cart_especies_censadas->destroy();
                $this->cart_implementos->destroy();
                $this->cart_actividades->destroy();
                $this->cart_actividades_realizadas->destroy();

                $this->session->unset_userdata('proceso');
                $this->session->unset_userdata('numero');
            }
            
            $session = array(
                'proceso' => 'reforestacion_control',
                'numero' => $id_ref
            );

            $this->session->set_userdata($session);

            $data = array(
                'reforestacion'   =>    $this->reforestacion->get_reforestacion($id_ref),
                'empleados' => $this->reforestacion->get_empleados($id_ref),
                'controller' => 'reforestacion'
            );

            $reforestacion = $this->reforestacion->get_reforestacion($id_ref);

            if (empty($data['reforestacion']))
            {
                show_404();
            }

            $empleados = $this->reforestacion->get_empleados($id_ref);

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

            $areas = $this->reforestacion->get_areas($id_ref);

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

            if($reforestacion['estado'] == 'Pendiente' || $reforestacion['estado'] == 'En progreso')
            {
                $especies = $this->reforestacion->get_especies($id_ref);

                if($especies == TRUE)
                {
                    if ($cart_especies = $this->cart_especies->contents() == NULL)
                    {
                        foreach ($especies as $especie):
                            $especiess = array(
                                'id' => $especie->especie,
                                'codigo' => $especie->codigo,
                                'nombre' => $especie->nom_cmn,
                                'cantidad' => 1
                            );

                            $this->cart_especies->insert($especiess);
                      endforeach;
                    }
                }
            }
            else if($reforestacion['estado'] == 'Finalizado')
            {
                $especies_reforestadas = $this->reforestacion->get_especies($id_ref);

                if($especies_reforestadas == TRUE)
                {
                    if ($cart_especies_censadas = $this->cart_especies_censadas->contents() == NULL)
                    {
                        foreach ($especies_reforestadas as $especie_reforestada):
                            $especiess_reforestadas = array(
                                'id' => $especie_reforestada->especie,
                                'codigo' => $especie_reforestada->codigo,
                                'nombre' => $especie_reforestada->nom_cmn,
                                'cantidad' => $especie_reforestada->poblacion
                            );

                            $this->cart_especies_censadas->insert($especiess_reforestadas);
                      endforeach;
                    }
                }
            }

            $implementos = $this->reforestacion->get_implementos($id_ref);

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

            if($reforestacion['estado'] == 'Pendiente' || $reforestacion['estado'] == 'En progreso')
            {
                $actividades = $this->reforestacion->get_actividades($id_ref);

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
            if($reforestacion['estado'] == 'Finalizado')
            {
                $actividades_realizadas = $this->reforestacion->get_actividades($id_ref);

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
            $this->load->view('reforestaciones/control',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
    }

    public function process($id_ref = NULL)
    {
        if($this->cart_empleados->contents() != NULL && $this->cart_areas->contents() != NULL && $this->cart_especies->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_actividades->contents() != NULL)
        {
            $this->_validate();
            $this->form_validation->set_rules('fecha', 'fecha', 'required|is_unique[reforestaciones.fecha_asig]');
            $this->form_validation->set_rules('hora', 'hora', 'required');

            if($this->form_validation->run() == TRUE)
            {
                $reforestacion = array(
                    'usuario' => $this->session->userdata('id_usuario'),
                    'fecha_asig' => $this->input->post('fecha'),
                    'hora_asig' => $this->input->post('hora'),
                    'estado' => 'Pendiente'
                );
                
                $id_ref = $this->reforestacion->save($reforestacion);

                if ($this->cart_empleados->contents() != NULL):
                    foreach ($this->cart_empleados->contents() as $empleado):
                        $empleados = array(
                            'reforestacion'     => $id_ref,
                            'empleado'   => $empleado['id']
                        );    

                        $this->reforestacion->set_empleados($empleados);
                    endforeach;
                endif;

                if ($this->cart_areas->contents() != NULL):
                    foreach ($this->cart_areas->contents() as $area):
                        $areas = array(
                            'reforestacion'     => $id_ref,
                            'id_are'   => $area['id']
                        );    

                        $this->reforestacion->set_areas($areas);
                    endforeach;
                endif;

                if ($this->cart_especies->contents() != NULL):
                    foreach ($this->cart_especies->contents() as $especie):
                        $especies = array(
                            'reforestacion'     => $id_ref,
                            'especie'   => $especie['id']
                        );    

                        $this->reforestacion->set_especies($especies);
                    endforeach;
                endif;

                if ($this->cart_implementos->contents() != NULL):
                    foreach ($this->cart_implementos->contents() as $implemento):
                        $implementos = array(
                            'reforestacion'     => $id_ref,
                            'implemento'   => $implemento['id'],
                            'cantidad'   => $implemento['cantidad'],
                            'unidad'   => $implemento['unidad']
                        );    

                        $this->reforestacion->set_implementos($implementos);
                    endforeach;
                endif;

                if ($this->cart_actividades->contents() != NULL):
                    foreach ($this->cart_actividades->contents() as $actividad):
                        $actividades = array(
                            'reforestacion'     => $id_ref,
                            'actividad'   => $actividad['id'],
                            'encargado' => $actividad['encargado']
                        );    

                        $this->reforestacion->set_actividades($actividades);
                    endforeach;
                endif;

                $bitacora = array(
                    'tipo' => 'reforestacion',
                    'movimiento' => 'Se ha registrado el reforestacion número '.$id_ref.'.',
                    'usuario' => $this->session->userdata('id_usuario')
                );      

                $this->bitacora->set($bitacora);
                $this->cart_empleados->destroy();
                $this->cart_areas->destroy();
                $this->cart_especies->destroy();
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
            if($this->cart_empleados->contents() == NULL && $this->cart_areas->contents() == NULL && $this->cart_especies->contents() == NULL && $this->cart_implementos->contents() == NULL && $this->cart_actividades->contents() == NULL)
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
                else if($this->cart_especies->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "especies"));
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

    public function update($id_ref = NULL)
    {
        if($this->cart_empleados->contents() != NULL && $this->cart_areas->contents() != NULL && $this->cart_especies->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_actividades->contents() != NULL)
        {
            $this->_validate();
                        
            $reforestacion = array(
                'usuario' => $this->session->userdata('id_usuario'),
                'fecha_asig' => $this->input->post('fecha'),
                'hora_asig' => $this->input->post('hora'),
                'estado' => 'En progreso'
            );
            
            $this->reforestacion->update(array('id_ref' => $id_ref), $reforestacion);
            $this->reforestacion->delete_empleados($id_ref);
            $this->reforestacion->delete_areas($id_ref);
            $this->reforestacion->delete_especies($id_ref);
            $this->reforestacion->delete_implementos($id_ref);
            $this->reforestacion->delete_actividades($id_ref);

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $empleados = array(
                        'reforestacion'     => $id_ref,
                        'empleado'   => $empleado['id']
                    );    

                    $this->reforestacion->set_empleados($empleados);
                endforeach;
            endif;

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $id_emp = $empleado['id'];
                  $this->reforestacion->discount_empleados($id_emp);
                endforeach;
            endif;

            if ($this->cart_areas->contents() != NULL):
                foreach ($this->cart_areas->contents() as $area):
                    $areas = array(
                        'reforestacion'     => $id_ref,
                        'id_are'   => $area['id']
                    );    

                    $this->reforestacion->set_areas($areas);
                endforeach;
            endif;

            if ($this->cart_especies->contents() != NULL):
                foreach ($this->cart_especies->contents() as $especie):
                    $especies = array(
                        'reforestacion'     => $id_ref,
                        'especie'   => $especie['id']
                    );    

                    $this->reforestacion->set_especies($especies);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $implementos = array(
                        'reforestacion'     => $id_ref,
                        'implemento'   => $implemento['id'],
                        'cantidad'   => $implemento['cantidad'],
                        'unidad'   => $implemento['unidad']
                    );    

                    $this->reforestacion->set_implementos($implementos);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $id_imp = $implemento['id'];
                    $cantidad = $implemento['cantidad'];
                    $implemento_act = $this->reforestacion->get_implemento_by_id($id_imp);
                    if($implemento_act != false)
                    {
                        $actual = $implemento_act->stock;
                        $descuento = $actual - $cantidad;
                    }    
                  $this->reforestacion->discount_implementos($id_imp,$descuento);
                endforeach;
            endif;

            if ($this->cart_actividades->contents() != NULL):
                foreach ($this->cart_actividades->contents() as $actividad):
                    $actividades = array(
                        'reforestacion'     => $id_ref,
                        'actividad'   => $actividad['id'],
                        'encargado' => $actividad['encargado']
                    );    

                    $this->reforestacion->set_actividades($actividades);
                endforeach;
            endif;

            $bitacora = array(
                    'tipo' => 'reforestacion',
                    'movimiento' => 'Se ha actualizado el estado del reforestacion número '.$id_ref.'.',
                    'usuario' => $this->session->userdata('id_usuario')
                );      

            $this->bitacora->set($bitacora);

            $this->cart_empleados->destroy();
            $this->cart_areas->destroy();
            $this->cart_especies->destroy();
            $this->cart_implementos->destroy();
            $this->cart_actividades->destroy();

            echo json_encode(array("status" => true));
        }
        else
        {
            if($this->cart_empleados->contents() == NULL && $this->cart_areas->contents() == NULL && $this->cart_especies->contents() == NULL && $this->cart_implementos->contents() == NULL && $this->cart_actividades->contents() == NULL)
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
                else if($this->cart_especies->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "especies"));
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

    public function end($id_ref = NULL)
    {
        if($this->cart_empleados->contents() != NULL && $this->cart_areas->contents() != NULL && $this->cart_especies_censadas->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_actividades_realizadas->contents() != NULL)
        {
            $reforestacion = array(
                'usuario' => $this->session->userdata('id_usuario'),
                'estado' => 'Finalizado'
            );
            
            $this->reforestacion->update(array('id_ref' => $id_ref), $reforestacion);
            $this->reforestacion->delete_empleados($id_ref);
            $this->reforestacion->delete_areas($id_ref);
            $this->reforestacion->delete_especies($id_ref);
            $this->reforestacion->delete_implementos($id_ref);
            $this->reforestacion->delete_actividades($id_ref);

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $empleados = array(
                        'reforestacion'     => $id_ref,
                        'empleado'   => $empleado['id']
                    );    

                    $this->reforestacion->set_empleados($empleados);
                endforeach;
            endif;

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $id_emp = $empleado['id'];
                  $this->reforestacion->increment_empleados($id_emp);
                endforeach;
            endif;

            if ($this->cart_areas->contents() != NULL):
                foreach ($this->cart_areas->contents() as $area):
                    $areas = array(
                        'reforestacion'     => $id_ref,
                        'id_are'   => $area['id']
                    );    

                    $this->reforestacion->set_areas($areas);
                endforeach;
            endif;

            if ($this->cart_especies_censadas->contents() != NULL):
                foreach ($this->cart_especies_censadas->contents() as $especie):
                    $especies = array(
                        'reforestacion'     => $id_ref,
                        'especie'   => $especie['id'],
                        'poblacion' => $especie['cantidad']
                    );    

                    $this->reforestacion->set_especies($especies);
                endforeach;
            endif;

            if ($this->cart_especie_censadas->contents() != NULL):
                foreach ($this->cart_especie_censadas->contents() as $especie_censada):
                    $id_esp = $especie_censada['id'];
                    $cantidad = $especie_censada['cantidad'];
                    $especie_censada_act = $this->reforestacion->get_especie_censada_by_id($id_esp);
                    if($especie_censada_act != false)
                    {
                        $actual = $especie_censada_act->stock;
                        $cantidad = $actual + $cantidad;
                    }    
                  $this->reforestacion->increment_especies_censadas($id_esp,$cantidad);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $implementos = array(
                        'reforestacion'     => $id_ref,
                        'implemento'   => $implemento['id'],
                        'cantidad'   => $implemento['cantidad'],
                        'unidad'   => $implemento['unidad']
                    );    

                    $this->reforestacion->set_implementos($implementos);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $id_imp = $implemento['id'];
                    $cantidad = $implemento['cantidad'];
                    $implemento_act = $this->reforestacion->get_implemento_by_id($id_imp);
                    if($implemento_act != false)
                    {
                        $actual = $implemento_act->stock;
                        $incremento = $actual + $cantidad;
                    }    
                  $this->reforestacion->increment_implementos($id_imp,$incremento);
                endforeach;
            endif;

            if ($this->cart_actividades_realizadas->contents() != NULL):
                foreach ($this->cart_actividades_realizadas->contents() as $actividad):
                    $actividades = array(
                        'reforestacion'     => $id_ref,
                        'actividad'   => $actividad['id'],
                        'encargado' => $actividad['encargado']
                    );    

                    $this->reforestacion->set_actividades($actividades);
                endforeach;
            endif;

            $bitacora = array(
                    'tipo' => 'reforestacion',
                    'movimiento' => 'Se ha finalizado el reforestacion número '.$id_ref.'.',
                    'usuario' => $this->session->userdata('id_usuario')
                );      

            $this->bitacora->set($bitacora);

            $this->cart_empleados->destroy();
            $this->cart_areas->destroy();
            $this->cart_especies->destroy();
            $this->cart_especies_censadas->destroy();
            $this->cart_implementos->destroy();
            $this->cart_actividades->destroy();
            $this->cart_actividades_realizadas->destroy();

            echo json_encode(array("status" => true));
        }
        else
        {
            if($this->cart_empleados->contents() == NULL && $this->cart_areas->contents() == NULL && $this->cart_especies_censadas->contents() == NULL && $this->cart_implementos->contents() == NULL && $this->cart_actividades_realizadas->contents() == NULL)
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
                else if($this->cart_especies_censadas->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "especies"));
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

    public function select_empleados_asignados()
    {
        $data = array(
            'empleados' =>   array(
                                    'Luciano Moncada' =>   array(
                                                                'cédula' => 27402258,
                                                                'edad' => 20
                                                            ),
                                    'Yonathan Moncada' =>   array(
                                                                'cédula' => 27402258,
                                                                'edad' => 20
                                                            )
                           )
        );

        echo json_encode($data);
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

    public function list_especies_asignadas()
    {
        $reforestacion = $this->reforestacion->get_reforestacion($this->session->userdata('numero'));
        $list = $this->cart_especies->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $especie)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $especie['codigo'];
            $row[] = $especie['nombre'];
            if($reforestacion['estado'] == 'En progreso')
            {
                $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Asignar" onclick="assign_especie_reforestada('."'".$especie['id']."'".')">
                            <i class="icon-plus"></i>
                        </a>';
            }
            else
            {
                $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_especie('."'".$especie['rowid']."'".')">
                            <i class="icon-trash"></i>
                        </a>';
            }
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cart_especies->total_especies(),
            "recordsFiltered" => $this->cart_especies->total_especies(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function assign_especie($id_esp)
    {
        $especie = $this->especie->get_by_id($id_esp);
        $especies = array(
            'id' => $id_esp,
            'codigo' => $especie['codigo'],
            'nombre' => $especie['nom_cmn'],
            'cantidad' => 1
        );

        $repeat = 0;

        foreach($this->cart_especies->contents() as $carrito)
        {
            if($carrito['id'] == $id_esp)
            {
                $repeat++;
            }
        }

        if($repeat == 0)
        {
            $this->cart_especies->insert($especies);

            if($this->cart_especies->insert($especies) === md5($id_esp))
            {
                $data = array(
                    'title' => 'Éxito',
                    'text' => '¡La especie fue asignada!',
                    'type' => 'success',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡No puedes asignar la misma especie!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_especies()
    {
        $count_especies = $this->cart_especies->total_especies();

        $data = array(
            'count_especies' => $count_especies
        );
        echo json_encode($data);
    }

    public function deny_especie($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_especies->destroy();
        }
        else
        {
            $especies = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_especies->update($especies);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡La especie fue denegada!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_especies()
    {
        if($this->cart_especies->contents() != NULL)
        {
            $this->cart_especies->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de especies fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de especies está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    public function list_especies_censadas()
    {
        $list = $this->cart_especies_censadas->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $especie)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $especie['codigo'];
            $row[] = $especie['nombre'];
            $row[] = $especie['cantidad'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_especie_reforestada('."'".$especie['rowid']."'".')">
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

    public function assign_especie_reforestada($id_esp)
    {
        $cantidad = $this->input->get('cantidad');

        if($cantidad <= 0)
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡Debes ingresar una cantidad mayor a 0 bolívares!',
                'type' => 'error',
            );
        }
        else
        {
            $especie = $this->especie->get_by_id($id_esp);
            $especies = array(
                'id' => $id_esp,
                'codigo' => $especie['codigo'],
                'nombre' => $especie['nom_cmn'],
                'cantidad' => $cantidad
            );

            $repeat = 0;

            foreach($this->cart_especies_censadas->contents() as $carrito)
            {
                if($carrito['id'] == $id_esp && $carrito['cantidad'] == $cantidad)
                {
                    $repeat++;
                }
            }

            if($repeat == 0)
            {
                $this->cart_especies_censadas->insert($especies);

                if($this->cart_especies_censadas->insert($especies) === md5($id_esp))
                {
                    $data = array(
                        'title' => 'Éxito',
                        'text' => '¡La especie fue asignada!',
                        'type' => 'success',
                    );
                }
            }
            else
            {
                $data = array(
                    'title' => 'Error',
                    'text' => '¡Estás asignando la misma cantidad de especies|!',
                    'type' => 'error',
                );
            }
        }
        echo json_encode($data);
    }

    public function count_especies_censadas()
    {
        $count_especies_censadas = $this->cart_especies_censadas->total_especies_censadas();

        $data = array(
            'count_especies_censadas' => $count_especies_censadas
        );
        echo json_encode($data);
    }

    public function deny_especie_reforestada($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_especies_censadas->destroy();
        }
        else
        {
            $especies = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_especies_censadas->update($especies);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡La especie fue denegada!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_especies_censadas()
    {
        if($this->cart_especies_censadas->contents() != NULL)
        {
            $this->cart_especies_censadas->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de especies fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de especies está vacio!',
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
        $reforestacion = $this->reforestacion->get_reforestacion($this->session->userdata('numero'));
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
            if($reforestacion['estado'] == 'En progreso')
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
