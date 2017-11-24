<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donacion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bitacora_model','bitacora');
        $this->load->model('donacion_model','donacion');
        $this->load->model('donante_model','donante');
        $this->load->model('implemento_model','implemento');
        $this->load->library('cart_donantes');
        $this->load->library('cart_implementos');
        $this->load->library('cart_fondos');
    }

    public function list_donaciones()
    {
        $list = $this->donacion->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $donacion)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $donacion->id_dnc;
            $row[] = $donacion->usuario;
            $row[] = $donacion->fecha_act;
            $row[] = $donacion->estado;
            $row[] = 
                '<a class="btn btn-link" href="javascript:void(0)" onclick="control('."'".$donacion->id_dnc."'".')" title="Ver">
                    <i class="icon-eye"></i>
                </a>
                <a class="btn btn-link" href="javascript:void(0)" onclick="report('."'".$donacion->id_dnc."'".')" title="Imprimir">
                    <i class="icon-printer"></i>
                </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->donacion->count_all(),
            "recordsFiltered" => $this->donacion->count_filtered(),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function index()
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('nivel') === 'Administrador(a)')
        {
            $this->cart_donantes->destroy();
            $this->cart_implementos->destroy();
            $this->cart_fondos->destroy();

            $this->session->unset_userdata('proceso');

            $session = array(
                'proceso' => 'donacion'
            );

            $this->session->set_userdata($session);

            $data = array(
                'donaciones' => $this->donacion->get_all(),
                'controller' => 'donacion'
            );

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('donaciones/index',$data);
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
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('nivel') === 'Administrador(a)')
        {
            if($this->session->userdata('proceso') != "donacion")
            {
                $this->cart_donantes->destroy();
            $this->cart_implementos->destroy();
            $this->cart_fondos->destroy();

                $this->session->unset_userdata('proceso');
            }

            $session = array(
                'proceso' => 'donacion'
            );

            $this->session->set_userdata($session);

            $data = array(
                'total_don' => $this->donacion->get_numero(),
                'controller' => 'donacion'
            );

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('donaciones/create',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
        else
        {
            show_404();
        }
    }

    public function control($id_dnc = NULL)
    {
        if($this->session->userdata('is_logued_in') === TRUE && $this->session->userdata('nivel') === 'Administrador(a)')
        {
            if($this->session->userdata('proceso') != "donacion_control" || $id_dnc != $this->session->userdata('numero'))
            {
                $this->cart_donantes->destroy();
                $this->cart_implementos->destroy();
                $this->cart_fondos->destroy();

                $this->session->unset_userdata('proceso');
                $this->session->unset_userdata('numero');
            }
            
            $session = array(
                'proceso' => 'donacion_control',
                'numero' => $id_dnc
            );

            $this->session->set_userdata($session);

            $data = array(
                'donacion'   =>    $this->donacion->get_donacion($id_dnc),
                'controller' => 'donacion'
            );

            if (empty($data['donacion']))
            {
                show_404();
            }

            $donantes = $this->donacion->get_donantes($id_dnc);

            if($donantes == TRUE)
            {
                if ($cart_donantes = $this->cart_donantes->contents() == NULL)
                {
                    foreach ($donantes as $donante):
                        $donantess = array(
                            'id' => $donante->donante,
                            'rif' => $donante->rif,
                            'razon_social' => $donante->razon_social,
                            'cantidad' => 1
                        );

                        $this->cart_donantes->insert($donantess);
                  endforeach;
                }
            }

            $implementos = $this->donacion->get_implementos($id_dnc);

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

            $fondos = $this->donacion->get_fondos($id_dnc);

            if($fondos == TRUE)
            {
                if ($cart_fondos = $this->cart_fondos->contents() == NULL)
                {
                    foreach ($fondos as $fondo):
                        $fondoss = array(
                            'id' => 1,
                            'divisa' => $fondo->divisa,
                            'cantidad' => $fondo->cantidad
                        );
                        $this->cart_fondos->insert($fondoss);
                  endforeach;
                }
            }

            $this->load->view('templates/links');
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('donaciones/control',$data);
            $this->load->view('templates/quick_sidebar');
            $this->load->view('templates/footer');
        }
    }

    public function process($id_dnc = NULL)
    {
        if($this->cart_donantes->contents() != NULL && $this->cart_implementos->contents() != NULL || $this->cart_donantes->contents() != NULL && $this->cart_fondos->contents() != NULL)
        {
            $this->_validate();

            $this->form_validation->set_rules('fecha', 'fecha', 'required');
            $this->form_validation->set_rules('hora', 'hora', 'required');

            if($this->form_validation->run() == TRUE)
            {
                $donacion = array(
                    'usuario' => $this->session->userdata('id_usuario'),
                    'observacion' => $this->input->post('observacion'),
                    'fecha_asig' => $this->input->post('fecha'),
                    'hora_asig' => $this->input->post('hora'),
                    'estado' => 'Procesada'
                );
                
                $id_dnc = $this->donacion->save($donacion);

                if ($this->cart_donantes->contents() != NULL):
                    foreach ($this->cart_donantes->contents() as $donante):
                        $donantes = array(
                            'donacion'     => $id_dnc,
                            'donante'   => $donante['id']
                        );    

                        $this->donacion->set_donantes($donantes);
                    endforeach;
                endif;

                if ($this->cart_implementos->contents() != NULL):
                    foreach ($this->cart_implementos->contents() as $implemento):
                        $implementos = array(
                            'donacion'     => $id_dnc,
                            'implemento'   => $implemento['id'],
                            'cantidad'   => $implemento['cantidad'],
                            'unidad'   => $implemento['unidad']
                        );    

                        $this->donacion->set_implementos($implementos);
                    endforeach;
                endif;

                if ($this->cart_implementos->contents() != NULL):
                    foreach ($this->cart_implementos->contents() as $implemento):
                        $id_imp = $implemento['id'];
                        $cantidad = $implemento['cantidad'];
                        $implemento_act = $this->donacion->get_implemento_by_id($id_imp);
                        if($implemento_act != false)
                        {
                            $actual = $implemento_act->stock;
                            $descuento = $actual + $cantidad;
                        }    
                      $this->donacion->increment_implementos($id_imp,$descuento);
                    endforeach;
                endif;

                if ($this->cart_fondos->contents() != NULL):
                    foreach ($this->cart_fondos->contents() as $fondo):
                        $fondos = array(
                            'donacion'     => $id_dnc,
                            'cantidad'   => $fondo['cantidad'],
                            'divisa' => $fondo['divisa']
                        );    

                        $this->donacion->set_fondos($fondos);
                    endforeach;
                endif;

                $bitacora = array(
                    'tipo' => 'donacion',
                    'movimiento' => 'Se ha registrado un donacion.',
                    'usuario' => $this->session->userdata('id_usuario')
                );      

                $this->bitacora->set($bitacora);
                $this->cart_donantes->destroy();
                $this->cart_implementos->destroy();
                $this->cart_fondos->destroy();

                echo json_encode(array("status" => true));
            }
        }
        else
        {
            if($this->cart_donantes->contents() == NULL && $this->cart_implementos->contents() == NULL && $this->cart_fondos->contents() == NULL){
                echo json_encode(array("status" => false, "reason" => "carros"));
            }
            else
            {
                if($this->cart_donantes->contents() == NULL){
                echo json_encode(array("status" => false, "reason" => "donantes"));
                }
                else if($this->cart_implementos->contents() == NULL && $this->cart_fondos->contents() == NULL){
                    echo json_encode(array("status" => false, "reason" => "donacion"));
                }
            }
        }
    }

    public function list_donantes_asignados()
    {
        $list = $this->cart_donantes->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $donante)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = $donante['rif'];
            $row[] = $donante['razon_social'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_donante('."'".$donante['rowid']."'".')">
                        <i class="icon-trash"></i>
                    </a>';
            $data[] = $row;
            $i++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cart_donantes->total_donantes(),
            "recordsFiltered" => $this->cart_donantes->total_donantes(),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function assign_donante($id_don)
    {
        $donante = $this->donante->get_by_id($id_don);
        $donantes = array(
            'id' => $id_don,
            'rif' => $donante['rif'],
            'razon_social' => $donante['razon_social'],
            'cantidad' => 1
        );

        $repeat = 0;

        foreach($this->cart_donantes->contents() as $carrito)
        {
            if($carrito['id'] == $id_don)
            {
                $repeat++;
            }
        }

        if($repeat == 0)
        {
            $this->cart_donantes->insert($donantes);

            if($this->cart_donantes->insert($donantes) === md5($id_don))
            {
                $data = array(
                    'title' => 'Éxito',
                    'text' => '¡El donante fue asignado!',
                    'type' => 'success',
                );
            }
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡No puedes asignar al mismo donante!',
                'type' => 'error',
            );
        }
        echo json_encode($data);
    }

    public function count_donantes()
    {
        $count_donantes = $this->cart_donantes->total_donantes();

        $data = array(
            'count_donantes' => $count_donantes
        );
        echo json_encode($data);
    }

    public function deny_donante($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_donantes->destroy();
        }
        else
        {
            $donantes = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_donantes->update($donantes);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡El donante fue denegado!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_donantes()
    {
        if($this->cart_donantes->contents() != NULL)
        {
            $this->cart_donantes->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de donantes fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de donantes está vacio!',
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

    public function list_fondos_asignados()
    {
        $list = $this->cart_fondos->contents();
        $data = array();
        $no = $_POST['start'];
        $i = 1;
        foreach ($list as $fondo)
        {
            $no++;
            $row = array();
            $row[] = $i;
            $row[] = number_format($fondo['cantidad'],2,',','.');
            $row[] = $fondo['divisa'];
            $row[] ='<a class="btn btn-link" href="javascript:void(0)" title="Eliminar" onclick="deny_fondo('."'".$fondo['rowid']."'".')">
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

    public function assign_fondo($cantidad)
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
            $fondos = array(
                'id' => 1,
                'divisa' => 'Bs. F',
                'cantidad' => $cantidad
            );

            $this->cart_fondos->insert($fondos);

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El fondo fue asignado!',
                'type' => 'success',
            );
        }
        echo json_encode($data);
    }

    public function count_fondos()
    {
        $count_fondos = $this->cart_fondos->total_fondos();

        $data = array(
            'count_fondos' => number_format($count_fondos,2,',','.')
        );
        echo json_encode($data);
    }

    public function deny_fondo($rowid)
    {
        if ($rowid==="all")
        {
            $this->cart_fondos->destroy();
        }
        else
        {
            $fondos = array(
                'rowid'   => $rowid,
                'cantidad' => 0
            );

            $this->cart_fondos->update($fondos);
        }

        $data = array(
            'title' => 'Éxito',
            'text' => '¡El fondo fue denegado!',
            'type' => 'success'
        );
        echo json_encode($data);
    }

    public function clear_fondos()
    {
        if($this->cart_fondos->contents() != NULL)
        {
            $this->cart_fondos->destroy();

            $data = array(
                'title' => 'Éxito',
                'text' => '¡El carrito de fondos fue vaciado!',
                'type' => 'success'
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                'title' => 'Error',
                'text' => '¡El carrito de fondos está vacio!',
                'type' => 'error'
            );
            echo json_encode($data);
        }
    }

    /*public function select_donantes_asignados()
    {
        $data = array();
        $data = $this->cart_donantes->contents();
        echo json_encode($data);
    }*/

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
