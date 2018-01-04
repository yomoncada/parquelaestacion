<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Censo extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('actividad_model','actividad');
        $this->load->model('area_model','area');
        $this->load->model('bitacora_model','bitacora');
        $this->load->model('categoria_model','categoria');
        $this->load->model('cargo_model','cargo');
        $this->load->model('censo_model','censo');
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

    public function list_censos_pendientes()
    {
        $list = $this->censo->get_datatables_pendientes();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $censo)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $censo->id_cen;
            $row[] = $censo->usuario;
            $row[] = $censo->fecha_asig;
            $row[] = $censo->hora_asig;
            $row[] = $censo->fecha_act;
            $row[] = $censo->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$censo->id_cen."'".')" title="Actualizar">
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
            "recordsTotal" => $this->censo->count_all(),
            "recordsFiltered" => $this->censo->count_filtered_pendientes(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function list_censos_en_progresos()
    {
        $list = $this->censo->get_datatables_en_progresos();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $censo)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $censo->id_cen;
            $row[] = $censo->usuario;
            $row[] = $censo->fecha_asig;
            $row[] = $censo->hora_asig;
            $row[] = $censo->fecha_act;
            $row[] = $censo->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$censo->id_cen."'".')" title="Controlar">
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
            "recordsTotal" => $this->censo->count_all(),
            "recordsFiltered" => $this->censo->count_filtered_en_progresos(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function list_censos_finalizados()
    {
        $list = $this->censo->get_datatables_finalizados();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $censo)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $censo->id_cen;
            $row[] = $censo->usuario;
            $row[] = $censo->fecha_asig;
            $row[] = $censo->hora_asig;
            $row[] = $censo->fecha_act;
            $row[] = $censo->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$censo->id_cen."'".')" title="Ver">
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
            "recordsTotal" => $this->censo->count_all(),
            "recordsFiltered" => $this->censo->count_filtered_finalizados(),
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
                'proceso' => 'censo'
            );

            $this->session->set_userdata($session);

            $data = array(
                'censos' => $this->censo->get_all(),
                'controller' => 'censo'
            );

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('censos/index',$data);
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
            if($this->session->userdata('proceso') != "censo")
            {
                $this->cart_empleados->destroy();
                $this->cart_areas->destroy();
                $this->cart_especies->destroy();
                $this->cart_implementos->destroy();
                $this->cart_actividades->destroy();

                $this->session->unset_userdata('proceso');
            }

            $session = array(
                'proceso' => 'censo'
            );

            $this->session->set_userdata($session);

            $data = array(
                'total_cen' => $this->censo->get_numero(),
                'categorias' => $this->categoria->get_all(),
                'cargos' => $this->cargo->get_all(),
                'controller' => 'censo'
            );

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('censos/create',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
        else
        {
            show_404();
        }
    }

    public function control($id_cen = NULL)
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('cen_access') == 1)
        {
            if($this->session->userdata('proceso') != "censo_control" || $id_cen != $this->session->userdata('numero'))
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
                'proceso' => 'censo_control',
                'numero' => $id_cen
            );

            $this->session->set_userdata($session);

            $data = array(
                'censo'   =>    $this->censo->get_censo($id_cen),
                'empleados' => $this->censo->get_empleados($id_cen),
                'categorias' => $this->categoria->get_all(),
                'cargos' => $this->cargo->get_all(),
                'controller' => 'censo'
            );

            $censo = $this->censo->get_censo($id_cen);

            if (empty($data['censo']))
            {
                show_404();
            }

            $empleados = $this->censo->get_empleados($id_cen);

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

            $areas = $this->censo->get_areas($id_cen);

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

            if($censo['estado'] == 'Pendiente' || $censo['estado'] == 'En progreso')
            {
                $especies = $this->censo->get_especies($id_cen);

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
            else if($censo['estado'] == 'Finalizado')
            {
                $especies_censadas = $this->censo->get_especies($id_cen);

                if($especies_censadas == TRUE)
                {
                    if ($cart_especies_censadas = $this->cart_especies_censadas->contents() == NULL)
                    {
                        foreach ($especies_censadas as $especie_censada):
                            $especiess_censadas = array(
                                'id' => $especie_censada->especie,
                                'codigo' => $especie_censada->codigo,
                                'nombre' => $especie_censada->nom_cmn,
                                'cantidad' => $especie_censada->poblacion
                            );

                            $this->cart_especies_censadas->insert($especiess_censadas);
                      endforeach;
                    }
                }
            }

            $implementos = $this->censo->get_implementos($id_cen);

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

            if($censo['estado'] == 'Pendiente' || $censo['estado'] == 'En progreso')
            {
                $actividades = $this->censo->get_actividades($id_cen);

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
            if($censo['estado'] == 'Finalizado')
            {
                $actividades_realizadas = $this->censo->get_actividades($id_cen);

                if($actividades_realizadas == TRUE)
                {
                    if ($cart_actividades_realizadas = $this->cart_actividades_realizadas->contents() == NULL)
                    {
                        foreach ($actividades_realizadas as $actividad_realizada):
                            $id = rand(0,99999);
                            $actividadess_realizadas = array(
                                'id' => $id,
                                'actividad' => $actividad_realizada->actividad,
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
            $this->load->view('censos/control',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
    }

    public function process($id_cen = NULL)
    {
        if($this->cart_empleados->contents() != NULL && $this->cart_areas->contents() != NULL && $this->cart_especies->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_actividades->contents() != NULL)
        {
            $this->_validate();
            $this->form_validation->set_rules('fecha', 'fecha', 'required|is_unique[censos.fecha_asig]');
            $this->form_validation->set_rules('hora', 'hora', 'required');

            if($this->form_validation->run() == TRUE)
            {
                $censo = array(
                    'usuario' => $this->session->userdata('id_usuario'),
                    'fecha_asig' => $this->input->post('fecha'),
                    'hora_asig' => $this->input->post('hora'),
                    'estado' => 'Pendiente'
                );
                
                $id_cen = $this->censo->save($censo);

                if ($this->cart_empleados->contents() != NULL):
                    foreach ($this->cart_empleados->contents() as $empleado):
                        $empleados = array(
                            'censo'     => $id_cen,
                            'empleado'   => $empleado['id']
                        );    

                        $this->censo->set_empleados($empleados);
                    endforeach;
                endif;

                if ($this->cart_empleados->contents() != NULL):
                    foreach ($this->cart_empleados->contents() as $empleado):
                        $id_emp = $empleado['id'];
                      $this->censo->discount_empleados($id_emp);
                    endforeach;
                endif;

                if ($this->cart_areas->contents() != NULL):
                    foreach ($this->cart_areas->contents() as $area):
                        $areas = array(
                            'censo'     => $id_cen,
                            'id_are'   => $area['id']
                        );    

                        $this->censo->set_areas($areas);
                    endforeach;
                endif;

                if ($this->cart_especies->contents() != NULL):
                    foreach ($this->cart_especies->contents() as $especie):
                        $especies = array(
                            'censo'     => $id_cen,
                            'especie'   => $especie['id']
                        );    

                        $this->censo->set_especies($especies);
                    endforeach;
                endif;

                if ($this->cart_implementos->contents() != NULL):
                    foreach ($this->cart_implementos->contents() as $implemento):
                        $implementos = array(
                            'censo'     => $id_cen,
                            'implemento'   => $implemento['id'],
                            'cantidad'   => $implemento['cantidad'],
                            'unidad'   => $implemento['unidad']
                        );    

                        $this->censo->set_implementos($implementos);
                    endforeach;
                endif;

                if ($this->cart_implementos->contents() != NULL):
                    foreach ($this->cart_implementos->contents() as $implemento):
                        $id_imp = $implemento['id'];
                        $cantidad = $implemento['cantidad'];
                        $implemento_act = $this->censo->get_implemento_by_id($id_imp);
                        if($implemento_act != false)
                        {
                            $actual = $implemento_act->stock;
                            $descuento = $actual - $cantidad;
                        }    
                      $this->censo->discount_implementos($id_imp,$descuento);
                    endforeach;
                endif;

                if ($this->cart_actividades->contents() != NULL):
                    foreach ($this->cart_actividades->contents() as $actividad):
                        $actividades = array(
                            'censo'     => $id_cen,
                            'actividad'   => $actividad['id'],
                            'encargado' => $actividad['encargado']
                        );    

                        $this->censo->set_actividades($actividades);
                    endforeach;
                endif;

                $bitacora = array(
                    'tipo' => 'Censo',
                    'movimiento' => 'Se ha registrado el censo número '.$id_cen.'.',
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

    public function update($id_cen = NULL)
    {
        if($this->cart_empleados->contents() != NULL && $this->cart_areas->contents() != NULL && $this->cart_especies->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_actividades->contents() != NULL)
        {
            $this->_validate();
                        
            $censo = array(
                'usuario' => $this->session->userdata('id_usuario'),
                'fecha_asig' => $this->input->post('fecha'),
                'hora_asig' => $this->input->post('hora'),
                'estado' => 'En progreso'
            );
            
            $this->censo->update(array('id_cen' => $id_cen), $censo);

            $empleados = $this->censo->get_empleados($id_cen);

            if($empleados == TRUE)
            {
                foreach ($empleados as $empleado):
                    $this->censo->increment_empleados($empleado->empleado);
                endforeach;
            }

            $implementos = $this->censo->get_implementos($id_cen);

            if($implementos == TRUE)
            {
                foreach ($implementos as $implemento):
                    $implemento_act = $this->censo->get_implemento_by_id($implemento->implemento);
                    if($implemento_act == TRUE)
                    {
                        $actual = $implemento_act->stock;
                        $incremento = $actual + $implemento->cantidad;
                    }    
                    $this->censo->increment_implementos($implemento->implemento,$incremento);
                endforeach;
            }

            $this->censo->delete_empleados($id_cen);
            $this->censo->delete_areas($id_cen);
            $this->censo->delete_especies($id_cen);
            $this->censo->delete_implementos($id_cen);
            $this->censo->delete_actividades($id_cen);

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $empleados = array(
                        'censo'     => $id_cen,
                        'empleado'   => $empleado['id']
                    );    

                    $this->censo->set_empleados($empleados);
                endforeach;
            endif;

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $id_emp = $empleado['id'];
                  $this->censo->discount_empleados($id_emp);
                endforeach;
            endif;

            if ($this->cart_areas->contents() != NULL):
                foreach ($this->cart_areas->contents() as $area):
                    $areas = array(
                        'censo'     => $id_cen,
                        'id_are'   => $area['id']
                    );    

                    $this->censo->set_areas($areas);
                endforeach;
            endif;

            if ($this->cart_especies->contents() != NULL):
                foreach ($this->cart_especies->contents() as $especie):
                    $especies = array(
                        'censo'     => $id_cen,
                        'especie'   => $especie['id']
                    );    

                    $this->censo->set_especies($especies);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $implementos = array(
                        'censo'     => $id_cen,
                        'implemento'   => $implemento['id'],
                        'cantidad'   => $implemento['cantidad'],
                        'unidad'   => $implemento['unidad']
                    );    

                    $this->censo->set_implementos($implementos);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $id_imp = $implemento['id'];
                    $cantidad = $implemento['cantidad'];
                    $implemento_act = $this->censo->get_implemento_by_id($id_imp);
                    if($implemento_act != false)
                    {
                        $actual = $implemento_act->stock;
                        $descuento = $actual - $cantidad;
                    }    
                  $this->censo->discount_implementos($id_imp,$descuento);
                endforeach;
            endif;

            if ($this->cart_actividades->contents() != NULL):
                foreach ($this->cart_actividades->contents() as $actividad):
                    $actividades = array(
                        'censo'     => $id_cen,
                        'actividad'   => $actividad['id'],
                        'encargado' => $actividad['encargado']
                    );    

                    $this->censo->set_actividades($actividades);
                endforeach;
            endif;

            $bitacora = array(
                    'tipo' => 'Censo',
                    'movimiento' => 'Se ha actualizado el estado del censo número '.$id_cen.'.',
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

    public function end($id_cen = NULL)
    {
        if($this->cart_empleados->contents() != NULL && $this->cart_areas->contents() != NULL && $this->cart_especies_censadas->contents() != NULL && $this->cart_implementos->contents() != NULL && $this->cart_actividades_realizadas->contents() != NULL)
        {
            $censo = array(
                'usuario' => $this->session->userdata('id_usuario'),
                'observacion' => $this->input->post('observacion'),
                'estado' => 'Finalizado'
            );
            
            $this->censo->update(array('id_cen' => $id_cen), $censo);
            $this->censo->delete_especies($id_cen);
            $this->censo->delete_actividades($id_cen);

            if ($this->cart_empleados->contents() != NULL):
                foreach ($this->cart_empleados->contents() as $empleado):
                    $id_emp = $empleado['id'];
                  $this->censo->increment_empleados($id_emp);
                endforeach;
            endif;

            if ($this->cart_especies_censadas->contents() != NULL):
                foreach ($this->cart_especies_censadas->contents() as $especie):
                    $especies = array(
                        'censo'     => $id_cen,
                        'especie'   => $especie['id'],
                        'poblacion' => $especie['cantidad']
                    );    

                    $this->censo->set_especies($especies);
                endforeach;
            endif;

            if ($this->cart_especies_censadas->contents() != NULL):
                foreach ($this->cart_especies_censadas->contents() as $especie_censada):
                    $id_esp = $especie_censada['id'];
                    $cantidad = $especie_censada['cantidad'];
                  $this->censo->increment_especies($id_esp,$cantidad);
                endforeach;
            endif;

            if ($this->cart_implementos->contents() != NULL):
                foreach ($this->cart_implementos->contents() as $implemento):
                    $id_imp = $implemento['id'];
                    $cantidad = $implemento['cantidad'];
                    $implemento_act = $this->censo->get_implemento_by_id($id_imp);
                    if($implemento_act != false)
                    {
                        $actual = $implemento_act->stock;
                        $incremento = $actual + $cantidad;
                    }    
                  $this->censo->increment_implementos($id_imp,$incremento);
                endforeach;
            endif;

            if ($this->cart_actividades_realizadas->contents() != NULL):
                foreach ($this->cart_actividades_realizadas->contents() as $actividad):
                    $actividades = array(
                        'censo'     => $id_cen,
                        'actividad'   => $actividad['actividad'],
                        'encargado' => $actividad['encargado']
                    );    

                    $this->censo->set_actividades($actividades);
                endforeach;
            endif;

            $bitacora = array(
                    'tipo' => 'Censo',
                    'movimiento' => 'Se ha finalizado el censo número '.$id_cen.'.',
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
        $censo = $this->censo->get_censo($this->session->userdata('numero'));
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
            if($censo['estado'] == 'En progreso')
            {
                $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Asignar" onclick="assign_especie_censada('."'".$especie['id']."'".')">
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
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_especie_censada('."'".$especie['rowid']."'".')">
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

    public function assign_especie_censada($id_esp)
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

    public function deny_especie_censada($rowid)
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
        $censo = $this->censo->get_censo($this->session->userdata('numero'));
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
            if($censo['estado'] == 'En progreso')
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
            $id = rand(0,99999);
            $actividades = array(
                'id' => $id,
                'actividad' => $id_act,
                'accion' => $actividad['accion'],
                'encargado' => $id_emp,
                'cantidad' => 1
            );

            $repeat = 0;

            foreach($this->cart_actividades_realizadas->contents() as $carrito)
            {
                if($carrito['actividad'] == $id_act && $carrito['encargado'] == $id_emp)
                {
                    $repeat++;
                }
            }

            if($repeat == 0)
            {
                $this->cart_actividades_realizadas->insert($actividades);

                if($this->cart_actividades_realizadas->insert($actividades) === md5($id))
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
                    'text' => '¡No puedes asignar la misma actividad al mismo empleado!',
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
