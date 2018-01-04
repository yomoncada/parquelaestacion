<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Censo_model extends CI_Model {

	var $table = 'censos';
	var $column_order = array('cen.id_cen', 'cen.fecha_act', 'usu.usuario', 'cen.fecha_asig', 'cen.hora_asig', 'cen.estado');
	var $column_search = array('cen.id_cen', 'cen.fecha_act', 'usu.usuario', 'cen.fecha_asig', 'cen.hora_asig', 'cen.estado');
	var $order = array('cen.id_cen' => 'asc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query_pendientes()
	{
		$this->db->select('cen.id_cen, cen.fecha_act, usu.usuario, cen.fecha_asig, cen.hora_asig, cen.observacion, cen.estado');
    	$this->db->from('censos cen');
	    $this->db->join('usuarios usu','cen.usuario = usu.id_usu');
	    $this->db->where('cen.estado','Pendiente');

		$i = 0;

		foreach ($this->column_search as $item)
		{
			if($_POST['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
				}
				$i++;
			}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	private function _get_datatables_query_en_progresos()
	{
		$this->db->select('cen.id_cen, cen.fecha_act, usu.usuario, cen.fecha_asig, cen.hora_asig, cen.observacion, cen.estado');
    	$this->db->from('censos cen');
	    $this->db->join('usuarios usu','cen.usuario = usu.id_usu');
	    $this->db->where('cen.estado','En progreso');

		$i = 0;

		foreach ($this->column_search as $item)
		{
			if($_POST['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
				}
				$i++;
			}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	private function _get_datatables_query_finalizados()
	{
		$this->db->select('cen.id_cen, cen.fecha_act, usu.usuario, cen.fecha_asig, cen.hora_asig, cen.observacion, cen.estado');
    	$this->db->from('censos cen');
	    $this->db->join('usuarios usu','cen.usuario = usu.id_usu');
	    $this->db->where('cen.estado','Finalizado');

		$i = 0;

		foreach ($this->column_search as $item)
		{
			if($_POST['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
				}
				$i++;
			}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_pendientes()
	{
		$this->_get_datatables_query_pendientes();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables_en_progresos()
	{
		$this->_get_datatables_query_en_progresos();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables_finalizados()
	{
		$this->_get_datatables_query_finalizados();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_pendientes()
	{
		$this->_get_datatables_query_pendientes();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_filtered_en_progresos()
	{
		$this->_get_datatables_query_en_progresos();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_filtered_finalizados()
	{
		$this->_get_datatables_query_finalizados();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_numero()
	{
		return $this->db->count_all_results('censos');
	}

	public function get_all()
	{
      	$this->db->select('cen.id_cen, cen.fecha_act, usu.usuario, cen.fecha_asig, cen.hora_asig, cen.observacion, cen.estado');
    	$this->db->from('censos cen');
	    $this->db->join('usuarios usu','cen.usuario = usu.id_usu');
      	$this->db->order_by('cen.id_cen','DESC');
      	$query = $this->db->get();
      	return $query->result_array();
    }

    public function get_censo($id_cen)
	{
    	$this->db->select('cen.id_cen, cen.fecha_act, usu.usuario, cen.fecha_asig, cen.hora_asig, cen.observacion, cen.estado');
	    $this->db->from('censos cen');
	    $this->db->join('usuarios usu','cen.usuario = usu.id_usu');
	    $this->db->where('cen.id_cen',$id_cen);
	    $query = $this->db->get();
	    return $query->row_array();
	}

	public function get_empleados($id_cen)
	{
		$this->db->select('empcen.empleado, emp.cedula, emp.nombre');
	    $this->db->from('empleados_censo empcen');
	    $this->db->join('empleados emp','empcen.empleado = emp.id_emp');
	    $this->db->where('empcen.censo',$id_cen);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_areas($id_cen)
	{
		$this->db->select('arecen.id_are, are.codigo, are.area');
	    $this->db->from('areas_censo arecen');
	    $this->db->join('areas are','arecen.id_are = are.id_are');
	    $this->db->where('arecen.censo',$id_cen);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_especies($id_cen)
	{
		$this->db->select('espcen.especie, esp.codigo, esp.nom_cmn, espcen.poblacion');
	    $this->db->from('especies_censo espcen');
	    $this->db->join('especies esp','espcen.especie = esp.id_esp');
	    $this->db->where('espcen.censo',$id_cen);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_implementos($id_cen)
	{
		$this->db->select('impcen.implemento, imp.codigo, imp.nombre, impcen.cantidad, impcen.unidad');
	    $this->db->from('implementos_censo impcen');
	    $this->db->join('implementos imp','impcen.implemento = imp.id_imp');
	    $this->db->where('impcen.censo',$id_cen);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function get_actividades($id_cen)
	{
		$this->db->select('actcen.actividad, act.accion, actcen.encargado');
	    $this->db->from('actividades_censo actcen');
	    $this->db->join('actividades act','actcen.actividad = act.id_act');
	    $this->db->where('actcen.censo',$id_cen);
	    $query = $this->db->get();
	    return $query->result();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function set_empleados($data=array())
  	{
    	$this->db->insert('empleados_censo', $data);
  	}

  	public function set_areas($data=array())
  	{
    	$this->db->insert('areas_censo', $data);
  	}

  	public function set_especies($data=array())
  	{
    	$this->db->insert('especies_censo', $data);
  	}

  	public function set_implementos($data=array())
  	{
    	$this->db->insert('implementos_censo', $data);
  	}

  	public function set_actividades($data=array())
  	{
    	$this->db->insert('actividades_censo', $data);
  	}

  	public function get_implemento_by_id($id_imp)
  	{
    	$this->db->from('implementos');
    	$this->db->where('id_imp',$id_imp);
    	$query = $this->db->get();

    	return $query->row();
  	}

  	public function discount_empleados($id_emp)
  	{
   		$this->db->set('disponibilidad', 'Ocupado');
    	$this->db->where('id_emp', $id_emp);
    	$this->db->update('empleados');
  	}

  	public function discount_implementos($id_imp, $stock)
  	{
   		$this->db->set('stock', $stock);
    	$this->db->where('id_imp', $id_imp);
    	$this->db->update('implementos');
  	}

  	public function increment_empleados($id_emp)
  	{
   		$this->db->set('disponibilidad', 'Desocupado');
    	$this->db->where('id_emp', $id_emp);
    	$this->db->update('empleados');
  	}

  	public function increment_especies($id_esp, $cantidad)
  	{
   		$this->db->set('poblacion', $cantidad);
    	$this->db->where('id_esp', $id_esp);
    	$this->db->update('especies');
  	}

  	public function increment_implementos($id_imp, $stock)
  	{
   		$this->db->set('stock', $stock);
    	$this->db->where('id_imp', $id_imp);
    	$this->db->update('implementos');
  	}

  	public function update($where, $censo)
	{
		$this->db->update($this->table, $censo, $where);
		return $this->db->affected_rows();
	}

  	public function delete_empleados($id_cen)
  	{
    	$this->db->where('censo', $id_cen);
	    $this->db->delete('empleados_censo');
  	}

  	public function delete_areas($id_cen)
  	{
    	$this->db->where('censo', $id_cen);
	    $this->db->delete('areas_censo');
  	}

  	public function delete_especies($id_cen)
  	{
    	$this->db->where('censo', $id_cen);
	    $this->db->delete('especies_censo');
  	}

  	public function delete_implementos($id_cen)
  	{
	    $this->db->where('censo', $id_cen);
	    $this->db->delete('implementos_censo');
  	}

  	public function delete_actividades($id_cen)
  	{
    	$this->db->where('censo', $id_cen);
	    $this->db->delete('actividades_censo');
  	}
}
